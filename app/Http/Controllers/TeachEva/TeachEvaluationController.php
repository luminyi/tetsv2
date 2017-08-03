<?php

namespace App\Http\Controllers\TeachEva;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Help\HelpController;
use Illuminate\Support\Facades\Log;

class TeachEvaluationController extends Controller
{
    public function index(){
        return view('acsystem.Evaluation.index');
    }

    public function index1(){
        return view('acsystem1.Evaluation.index');
    }
    /**
     * @param Request $request
     * 在设计数据库时被评价教师不是主键之一，为防止重名教师的问题
     * 所以在被评价教师查询评价内容时，查询过程如下：
     * 1、三张评价表中通过姓名检索出评价内容。
     * 2、从课程表中查询该教师本学期所教授的课程
     * 3、剔除三张评价表中多余的课程。
     */
    public function evaluationData(Request $request){
        $help = new HelpController;

        $year1 = $request->get('year1');
        $year2 = $request->get('year2');
        $year = $year1.'-'.$year2;
        $semester = $request->get('semester');
        $userId = $request->get('userId');
        $userName = $request->get('userName');

        $year = '2016-2017';
        $semester = '1';
        $userId = '19740208';
        $userName = '于春战';


        $TableFlag = $year."-".$semester;//使用表版本的标识
        //学年学期 得到 该学年学期所属的时间段
        $YearSemesterTime = $help->GetTimeByYearSemester($TableFlag);
        $TableName = $help->GetCurrentTableName($TableFlag);


        //三张评价表中获得该教师的评价数据
        $table1 = "back_theory_evaluation".$TableName;
        $table2 = "back_practice_evaluation".$TableName;
        $table3 = "back_physical_evaluation".$TableName;

        $data = array();

        $DataArr1 = DB::table($table1)
            ->where('评价状态','=','已完成')
            ->where('任课教师','=',$userName)
            ->whereBetween('听课时间', [$YearSemesterTime['time1'], $YearSemesterTime['time2']])
            ->get();
        for ($l=0;$l<count($DataArr1);$l++)
            array_push($data,$DataArr1[$l]);

        $DataArr2 = DB::table($table2)
            ->where('评价状态','=','已完成')
            ->where('任课教师','=',$userName)
            ->whereBetween('听课时间', [$YearSemesterTime['time1'], $YearSemesterTime['time2']])
            ->get();;
        for ($l=0;$l<count($DataArr2);$l++)
            array_push($data,$DataArr2[$l]);

        $DataArr3 = DB::table($table3)
            ->where('评价状态','=','已完成')
            ->where('任课教师','=',$userName)
            ->whereBetween('听课时间', [$YearSemesterTime['time1'], $YearSemesterTime['time2']])
            ->get();;
        for ($l=0;$l<count($DataArr3);$l++)
            array_push($data,$DataArr3[$l]);


        //从课程表中获取该教师所教授的课程
        $LessonArr = DB::table('lessons')
            ->select('lesson_name','lesson_teacher_name','lesson_room','lesson_class')
            ->where('lesson_teacher_id','=',$userId)
            ->where('lesson_year','=',$year)
            ->where('lesson_semester','=',$semester)
            ->get();


        //对评价课程进行剔除
        $Result = array();
        for($i=0;$i<count($data);$i++)
        {
            for($j=0;$j<count($LessonArr);$j++)
            {
                if($data[$i]->上课班级==$LessonArr[$j]->lesson_class
                    &&$data[$i]->上课地点==$LessonArr[$j]->lesson_room
                    &&$data[$i]->课程名称==$LessonArr[$j]->lesson_name)
                {
                    array_push($Result,$data[$i]);
                }
            }
        }
//        Log::write('info',$Result);
        return $Result;
    }
}
