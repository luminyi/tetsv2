<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Help\HelpController;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Log;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only',['Statistics']]);
    }
    public function Statistics()
    {
        return view('Statistics');
    }

    public function GroupEvaluationInfo(Request $request)
    {
        $help = new HelpController;
        $version = new HelpController;
        $year1 = $request->year1;
        $year2 = $request->year2;
        $semester = $request->semester;
        //确定三个评价表版本号
        $year = $year1."-".$year2;
        $TableFlag = $year."-".$semester[0];
//        $TableFlag='2016-2017-2';
        $VersionNum = $version->GetCurrentTableName($TableFlag);

        $timeInterval = $help->GetTimeByYearSemester($TableFlag);
        $table1 = 'front_theory_evaluation'.$VersionNum;
        $table2 = 'front_practice_evaluation'.$VersionNum;
        $table3 = 'front_physical_evaluation'.$VersionNum;


        $ids = array('"第一组"', '"第二组"', '"第三组"', '"第四组"');
        $ids_ordered = implode(',', $ids);

        $GroupData = Role::find(4)//在roles表中，4号对应的小组长
            ->users()->select('users.user_id','users.name','users.group')
            ->where( 'supervise_time' ,'=' ,$TableFlag )
            ->orderByRaw(DB::raw("FIELD(users.group, $ids_ordered)"))
            ->get();
        $GroupAdmin =[];
        foreach($GroupData as $user)
            array_push($GroupAdmin, $user['attributes']);

//        dd($GroupAdmin);
        $GroupNum = [];
        for ($i=0;$i<count($GroupAdmin);$i++)
        {

            $GroupNum[$i] = Role::find(5)//在roles表中，4号对应的小组长
            ->users()->select('users.user_id','users.name','users.group','users.status')
                ->where( 'supervise_time' ,'=' ,$TableFlag )
                ->where( 'users.group' ,'=' ,$GroupAdmin[$i]['group'] )
                ->where('status','=','活跃')
                ->get();


            //合并同一个人的职务

            for($k=0;$k<count($GroupNum[$i]);$k++)
            {
                for($j=$k+1;$j<count($GroupNum[$i]);$j++)
                {
                    if ($GroupNum[$i][$k]->user_id == $GroupNum[$i][$j]->user_id
                        && $GroupNum[$i][$k]->supervise_time == $GroupNum[$i][$j]->supervise_time )
                    {
                        $GroupNum[$i][$k]->level = $GroupNum[$i][$k]->level.'/'.$GroupNum[$i][$j]->level;
                        array_splice($GroupNum[$i],$j,1);
                        $j--;
                    }
                }
            }
        }

        //遍历三张表，获取各督导保存的课程评价数目
        for ($i=0;$i<count($GroupAdmin);$i++)
        {
            for ($j=0;$j<count($GroupNum[$i]);$j++)
            {
                //待提交次数
                $a = DB::table($table1)
                    ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                    ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                    ->where('评价状态','like','待提交%')->count();
                $a = $a+DB::table($table2)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','like','待提交%')->count();
                $a = $a+DB::table($table3)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','like','待提交%')->count();

                $GroupNum[$i][$j]->save=$a;

                //已完成次数
                $b = DB::table($table1)
                    ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                    ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                    ->where('评价状态','=','已完成')->count();
                $b = $b+DB::table($table2)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','=','已完成')->count();
                $b = $b+DB::table($table3)
                        ->where('督导id','=',$GroupNum[$i][$j]->user_id)
                        ->whereBetween('听课时间', [$timeInterval['time1'], $timeInterval['time2']])
                        ->where('评价状态','=','已完成')->count();

                $GroupNum[$i][$j]->finish=$b;
                //已完成的（多节课程）课程节数

                $timesA1=$help->Evalued_LessonTimes($table1,$GroupNum[$i][$j]->user_id,'已完成',$timeInterval);//挺多节课的情况;
                $timesA2=$help->Evalued_LessonTimes($table2,$GroupNum[$i][$j]->user_id,'已完成', $timeInterval);//挺多节课的情况
                $timesA3=$help->Evalued_LessonTimes($table3,$GroupNum[$i][$j]->user_id,'已完成', $timeInterval);//挺多节课的情况

                $GroupNum[$i][$j]->listened=$timesA1['num']+$timesA2['num']+$timesA3['num']+$b;//多节课计算总数
                $GroupNum[$i][$j]->listened_two=$timesA1['two']+$timesA2['two']+$timesA3['two'];//连听两节课的数量
                $GroupNum[$i][$j]->listened_three=$timesA1['three']+$timesA2['three']+$timesA3['three'];//连听三节课的数量
                $GroupNum[$i][$j]->listened_four=$timesA1['four']+$timesA2['four']+$timesA3['four'];//连听四节课的数量
                $GroupNum[$i][$j]->listened_one=$b
                    -$GroupNum[$i][$j]->listened_two
                    -$GroupNum[$i][$j]->listened_three
                    -$GroupNum[$i][$j]->listened_four;//只听一节课的数量

            }
        }

        if($GroupAdmin !=null && $GroupNum!=null)
            return $data=[
                '1'=>$GroupAdmin,
                '2'=>$GroupNum
            ];
        else
            return '无记录';
    }

    public function GetEvalutedLessonArr(Request $request)
    {
        $key = $request->get('dataIn');
        $year1 = $request->year1;
        $year2 = $request->year2;
        $semester = $request->semester;
        $year = $year1."-".$year2;

//        $key = '水';
//        $semester = array('0'=>1);
//        $year ="2016-2017";
        $InputValue = DB::select('select DISTINCT lesson_name,lesson_teacher_name from lessons
                  where lesson_name like "' . $key . '%"
                  and lesson_year="'.$year.'"
                  and lesson_semester="'.$semester[0].'"
                  and lesson_state="已完成" limit 10 ');
        $data = [];
        for ($i = 0; $i < count($InputValue); $i++) {
            $data[$i] = array(
                '1' => $InputValue[$i]->lesson_name,
                '2' => $InputValue[$i]->lesson_teacher_name,
            );
        }

        return $data;
    }

//    public function GetEvalutedLessonContent(Request $request)
//    {
//        $HomeControl = new HelpController;
//        $year1 = $request->year1;
//        $year2 = $request->year2;
//        $semester = $request->semester;
//        $year = $year1."-".$year2;
//
////        $year='2016-2017';
////        $semester=array('0'=>1);
//
//        $TableFlag = $year."-".$semester[0];//使用表版本的标识
//
//        $teacher = $request->Teacher;
//        $lesson_name = $request->Lesson_name;
//
////        $teacher='马岚';
////        $lesson_name = "工程水文计算";
//
//        $LessonList = $HomeControl->GetCurrentTableName1($lesson_name,$teacher,$TableFlag);//确定该课程所在的表
//        //把该表的字段返回
//
//        $tableF = DB::select('select COLUMN_NAME from information_schema.COLUMNS where table_name = "'.$LessonList[0].'" and table_schema = \'tets\';');
//        $tableB = DB::select('select COLUMN_NAME from information_schema.COLUMNS where table_name = "'.$LessonList[1].'" and table_schema = \'tets\';');
//
//
////        Log::write('info',$LessonList);
//        //查表返回表的评价内容
//        $frontContent = DB::table($LessonList[0])
//            ->where('课程名称','=',$lesson_name)
//            ->where('任课教师','=',$teacher)
//            ->get();
//        $backContent = DB::table($LessonList[1])
//            ->where('课程名称','=',$lesson_name)
//            ->where('任课教师','=',$teacher)
//            ->get();
//
//        $data=[
//            '1'=>$frontContent,
////            '2'=>$backContent,
//            '3'=>$tableF,
//            '4'=>$tableB
//        ];
//        return $data;
//    }
}
