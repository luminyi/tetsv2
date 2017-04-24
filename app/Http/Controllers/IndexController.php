<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Help\HelpController;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only',['index']]);
    }

    /***************************************校级登录首页**********************************/
    public function index()
    {
        return view ('home');
    }
    public function Schoolindex(Request $request)
    {
        $data = [
            'SupervisorNum' => $this->SupervisorNum($request),
            'NecessaryTask' => $this->NecessaryTask(),//学期关注任务
            'FinishedNecess' => $this->FineshedNecess(),//关注任务已评价
            'Finished' => $this->Fineshed(),//全校已完成评价任务
        ];
        return $data;
    }
    public function Unitindex(Request $request)
    {
        $data = [
            'SupervisorNum' => $this->UnitSupervisorNumber($request),
            'NecessaryTask' => $this->UnitNeceNumber($request),
            'FinishedNecess' => $this->UnitNeceFinishedNumber($request),
            'Finished' => $this->UnitFinishedNumber($request),
        ];
        return $data;
    }
    public function Groupindex(Request $request)
    {
        $data = [
            'SupervisorNum' => $this->GroupSupervisorNumber($request),
            'NecessaryTask' => $this->GroupNeceNumber($request),
            'FinishedNecess' => $this->GroupNeceFinishedNumber($request),
            'Finished' => $this->GroupFinishedNumber($request),
        ];
        return $data;
    }



    protected function SupervisorNum(Request $request)
    {
//        $evaluationTime = $request->get('evaluationTime');
//        $help = new HelpController;
//        $Time = $help->GetYearSemester($evaluationTime);
//        Log::write('info',$Time);



        $num = DB::table("users")
            ->select('users.user_id')
//            ->leftjoin('role_user','role_user.user_id','=', 'users.id' )
            ->where('name','not like','%负责人')
            ->where('name','not like','%管理员')
//            ->where('supervise_time','=',$Time['YearSemester'])
            ->where('status','=','活跃')
            ->distinct()
            ->get();

        return count($num);
    }
    protected function  UnitSupervisorNumber(Request $request)//每个学院/小组 的 督导人数具体信息
    {
        $unit = $request->get('unit');
//        $evaluationTime = $request->get('evaluationTime');
//        $help = new HelpController;
//        $Time = $help->GetYearSemester($evaluationTime);
        $SupervisorNum = DB::table('users')
            ->select('users.user_id')
            ->where('unit','=',$unit)
            ->where('status','=','活跃')
            ->where('name','not like','%负责人')
            ->where('name','not like','%管理员')
            //            ->where('supervise_time','=',$Time['YearSemester'])
            ->distinct()
            ->get();
        return count($SupervisorNum);
    }
    protected function  GroupSupervisorNumber(Request $request)//每个学院/小组 的 督导人数具体信息
    {
        $group = $request->get('group');
//        $evaluationTime = $request->get('evaluationTime');
//        $help = new HelpController;
//        $Time = $help->GetYearSemester($evaluationTime);
        $SupervisorNum = DB::table('users')
            ->select('users.user_id')
            ->where('group','=',$group)
            ->where('status','=','活跃')
            ->where('name','not like','%负责人')
            ->where('name','not like','%管理员')

            //            ->where('supervise_time','=',$Time['YearSemester'])
            ->distinct()
            ->get();
        return count($SupervisorNum);
    }


    //校级+大组长
    protected function NecessaryTask()//当前学期必听任务总数
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->distinct()->get();
        return count($num);
    }
    protected function GroupNeceNumber(Request $request)//当前学期某一小组必听任务总数
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $group = $request->group;
//        选出属于改组的老师和课程数组
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('assign_group','=',$group)
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->distinct()->get();
//        Log::write('info',count($num));
        return count($num);
    }
    protected function UnitNeceNumber(Request $request)//当前学期某一学院必听任务总数
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $unit = $request->unit;
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_teacher_unit','=',$unit)
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->distinct()
            ->get();
        return count($num);
    }

    protected function FineshedNecess()//当前学期已经完成必听任务总数
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','已完成')
            ->distinct()
            ->get();
        return count($num);
    }
    protected function UnitNeceFinishedNumber(Request $request)//获取某一学院的当前学期已完成评价的关注课程
    {
        $unit = $request->unit;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_teacher_unit','=',$unit)
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','已完成')->distinct()->get();
        return count($num);
    }
    protected function GroupNeceFinishedNumber(Request $request)//获取某一小组的当前学期已完成评价的关注课程
    {
        $group = $request->group;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('assign_group','=',$group)
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','=','已完成')->distinct()->get();
        return count($num);
    }

    protected function Fineshed()//当前学期所有已完成听课的总数
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','已完成')
            ->distinct()
            ->get();
        return count($num);

    }
    protected function UnitFinishedNumber(Request $request)//获取某一学院的当前学期的已完成评价的课程
    {
        $unit = $request->unit;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_teacher_unit','=',$unit)
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','已完成')
            ->distinct()
            ->get();
        return count($num);
    }
    protected function GroupFinishedNumber(Request $request)//获取某一小组的当前学期的已完成评价的课程
    {
//        $group = $request->group;
//        $time = date("Y-m-d");
//        $YearSemester=new HelpController;
//        $version = $YearSemester->GetYearSemester($time);
//
//
//        $num = DB::table("lessons")
//            ->where('lesson_year','=',$version['Year'])
//            ->where('lesson_semester','=',$version['Semester'])
//            ->where('lesson_state','已完成')->distinct()->count('lesson_name','lesson_teacher_id');
        $group = $request->group;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $ys = $YearSemester->GetYearSemester($time);
        $time = $YearSemester->GetTimeByYearSemester($ys['YearSemester']);
        $Version = $YearSemester->GetCurrentTableName($ys['YearSemester']);

        $table1 = "front_theory_evaluation".$Version;
        $table2 = "front_practice_evaluation".$Version;
        $table3 = "front_physical_evaluation".$Version;

        $num1 = DB::select('select count(*) as num from '.$table1.'
where `督导id` = any(
	SELECT user_id from users where users.`group`="'.$group.'"
)
and `听课时间` between "'.$time["time1"].'" and "'.$time["time2"].'"
ORDER BY 听课时间 ');
        $num2 = DB::select('select count(*) as num from '.$table2.'
where `督导id` = any(
	SELECT user_id from users where users.`group`="'.$group.'"
)
and `听课时间` between "'.$time["time1"].'" and "'.$time["time2"].'"
ORDER BY 听课时间');
        $num3 = DB::select('select count(*) as num from '.$table3.'
where `督导id` = any(
	SELECT user_id from users where users.`group`="'.$group.'"
)
and `听课时间` between "'.$time["time1"].'" and "'.$time["time2"].'"
ORDER BY 听课时间 ');


        return $num=$num1[0]->num+$num2[0]->num+$num3[0]->num;
    }

    protected function SavedNecess()//当前学期以保存的必听任务的评价总数
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','like','待提交%')
            ->distinct()
            ->get();
        return count($num);
    }
    protected function UnitNeceSavedNumber(Request $request)//获取某一学院的当前学期以保存评价的关注课程
    {
        $unit = $request->unit;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('lesson_teacher_unit','=',$unit)
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','like','待提交%')->distinct()->get();
        return count($num);
    }
    protected function GroupNeceSavedNumber(Request $request)//获取某一小组的当前学期以保存评价的关注课程
    {
        $group = $request->group;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
            ->where('lesson_level','=','关注课程')
            ->where('lesson_year','=',$version['Year'])
            ->where('assign_group','=',$group)
            ->where('lesson_semester','=',$version['Semester'])
            ->where('lesson_state','like','待提交%')->distinct()->get();
        return count($num);
    }
    //关注课程完成情况饼状图
    //校级+大组长
    public function NecessaryState()
    {
        $data=[
            'Do' => $this->FineshedNecess(),
            'Save'=> $this->SavedNecess(),
            'Undo' => $this->NecessaryTask() - $this->FineshedNecess() - $this->SavedNecess(),
        ];
//        Log::write('info',$data);
        return $data;
    }
    //院级
    public function UnitNecessaryState(Request $request)
    {
        $data=[
            'Do' => $this->UnitNeceFinishedNumber($request),
            'Save'=> $this->UnitNeceSavedNumber($request),
            'Undo' => $this->UnitNeceNumber($request) - $this->UnitNeceFinishedNumber($request) - $this->UnitNeceSavedNumber($request)
        ];
        return $data;
    }
    //小组长
    public function GroupNecessaryState(Request $request)
    {
        $data=[
            'Do' => $this->GroupNeceFinishedNumber($request),
            'Save'=> $this->GroupNeceSavedNumber($request),
            'Undo' => $this->GroupNeceNumber($request) - $this->GroupNeceFinishedNumber($request) -$this->GroupNeceSavedNumber($request),
        ];
        return $data;
    }


    //获取当前学年内每个学院的已评价课程的情况柱状图所需数据
    //校级+大组长
    public function EvaluatedInUnit()//统计每个学院完成听课的数量
    {
        $help = new HelpController;
        $UnitArr = json_decode($help->UnitName(),true);
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);//转化格式为2016-2017-1
        $UnitData = Array();
        for ($i=0;$i<count($UnitArr);$i++)
        {
            $num = DB::table("lessons")->select('lesson_name','lesson_teacher_id')
                ->where('lesson_unit',$UnitArr[$i])
                ->where('lesson_state','已完成')
                ->where('lesson_year','=',$version['Year'])
                ->where('lesson_semester','=',$version['Semester'])
                ->distinct()
                ->get();
            $UnitData[$i] = count($num);
        }
        $data = [];
        for ($i=0;$i<count($UnitArr);$i++)
        {
            $obj=[
                'name'=>$UnitArr[$i]['lesson_unit'],
                'value'=>$UnitData[$i]
            ];
            array_push($data,$obj);
        }
        return $data;
    }

    //全校+全院+全组 兼职/全职 督导人数
    public function  TimeSupervisorNumber(Request $request)//全校/每个学院/小组 的 兼职/全职 督导人数
    {
        $level = $request->get('level');
//        $evaluationTime = $request->get('evaluationTime');
//        $help = new HelpController;
//        $Time = $help->GetYearSemester($evaluationTime);
        $PNum=0;
        $FNum=0;
        if ($level =='校级' || $level=='大组长')
        {
            $PNum = DB::table('users')
                ->where('workstate','=','兼职')
                ->where('status','=','活跃')
//                ->where('supervise_time','=',$Time['YearSemester'])
                ->distinct()
                ->count('user_id');
            $FNum = DB::table('users')
                ->where('workstate','=','专职')
                ->where('status','=','活跃')
//                ->where('supervise_time','=',$Time['YearSemester'])
                ->distinct()
                ->count('user_id');
        }
        if ($level=='小组长')
        {
            $group = $request->get('unit');

            $PNum = DB::table('users')
                ->where('workstate','=','兼职')
                ->where('status','=','活跃')
                ->where('group','=',$group)
//                ->where('supervise_time','=',$Time['YearSemester'])
                ->distinct()
                ->count('user_id');
            $FNum = DB::table('users')
                ->where('workstate','=','专职')
                ->where('status','=','活跃')
                ->where('group','=',$group)
//                ->where('supervise_time','=',$Time['YearSemester'])
                ->distinct()
                ->count('user_id');
        }
        if ($level=='院级')
        {
            $unit = $request->get('unit');

            $PNum = DB::table('users')
                ->where('workstate','=','兼职')
                ->where('status','=','活跃')
                ->where('unit','=',$unit)
//                ->where('supervise_time','=',$Time['YearSemester'])
                ->distinct()
                ->count();
            $FNum = DB::table('users')
                ->where('workstate','=','专职')
                ->where('status','=','活跃')
                ->where('unit','=',$unit)
//                ->where('supervise_time','=',$Time['YearSemester'])
                ->distinct()
                ->count();
        }

        return $Num=[
            'P'=>$PNum,
            'F'=>$FNum
        ];
    }

//    首页的最近评价表，选取最近评价的三个评价表
    public function GetNewList()
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $ys = $YearSemester->GetYearSemester($time);
        $Version = $YearSemester->GetCurrentTableName($ys['YearSemester']);
//        $Version = "_2016_08";
//        设置时间节点，新学期的开始时间
        $NewTermTime = $YearSemester->GetTimeByYearSemester($ys['YearSemester']);

//        Log::write('info',$NewTermTime);
        $table1 = "front_theory_evaluation".$Version;
        $table2 = "front_practice_evaluation".$Version;
        $table3 = "front_physical_evaluation".$Version;

        $DataArr1 = DB::select('select `督导姓名`,`任课教师`,`课程名称`,`听课时间` from '.$table1.'
                        where `听课时间` > "'.$NewTermTime['time1'].'" ORDER BY 听课时间 DESC limit 3');

        $DataArr2 = DB::select('select `督导姓名`,`任课教师`,`课程名称`,`听课时间` from '.$table2.'
                        where `听课时间` > "'.$NewTermTime['time1'].'" ORDER BY 听课时间 DESC limit 3');

        $DataArr3 = DB::select('select `督导姓名`,`任课教师`,`课程名称`,`听课时间` from '.$table3.'
                        where `听课时间` > "'.$NewTermTime['time1'].'" ORDER BY 听课时间 DESC limit 3');
        $DataArr = [];
        for ($l=0;$l<count($DataArr1);$l++)
        {
            array_push($DataArr,$DataArr1[$l]);
        }
        for ($l=0;$l<count($DataArr2);$l++)
        {
            array_push($DataArr,$DataArr2[$l]);
        }
        for ($l=0;$l<count($DataArr3);$l++)
        {
            array_push($DataArr,$DataArr3[$l]);
        }


        usort($DataArr,array($this,"sortCType"));

        return $DataArr;
    }

    private function sortCType($a, $b)
    {
        if ($a->听课时间 <= $b->听课时间)
        {
            return 1;
        }
        else
            return -1;
    }

    public function GetUnitNewList(Request $request)
    {
        $unit = $request->unit;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $ys = $YearSemester->GetYearSemester($time);
        $Version = $YearSemester->GetCurrentTableName($ys['YearSemester']);
//        设置时间节点，新学期的开始时间
        $NewTermTime = $YearSemester->GetTimeByYearSemester($ys['YearSemester']);

        $table1 = "front_theory_evaluation".$Version;
        $table2 = "front_practice_evaluation".$Version;
        $table3 = "front_physical_evaluation".$Version;

        $DataArr1 = DB::select('select * from '.$table1.'
                        where 课程名称 = any(
                            SELECT lesson_name from lessons where lesson_teacher_unit="'.$unit.'"
                        ) and 评价状态 = "已完成"
                        and `听课时间` > "'.$NewTermTime['time1'].'"
                        ORDER BY 听课时间 DESC limit 3');
        $DataArr2 = DB::select('select * from '.$table2.'
                        where 课程名称 = any(
                            SELECT lesson_name from lessons where lesson_teacher_unit="'.$unit.'"
                        ) and 评价状态 = "已完成"
                         and `听课时间` > "'.$NewTermTime['time1'].'"
                        ORDER BY 听课时间 DESC limit 3');
        $DataArr3 = DB::select('select * from '.$table3.'
                        where 课程名称 = any(
                            SELECT lesson_name from lessons where lesson_teacher_unit="'.$unit.'"
                        ) and 评价状态 = "已完成"
                         and `听课时间` > "'.$NewTermTime['time1'].'"
                        ORDER BY 听课时间 DESC limit 3');
        $DataArr = [];
        for ($l=0;$l<count($DataArr1);$l++)
        {
            array_push($DataArr,$DataArr1[$l]);
        }
        for ($l=0;$l<count($DataArr2);$l++)
        {
            array_push($DataArr,$DataArr2[$l]);
        }
        for ($l=0;$l<count($DataArr3);$l++)
        {
            array_push($DataArr,$DataArr3[$l]);
        }
        return $DataArr;
    }
    public function GetGroupNewList(Request $request)
    {
        $group = $request->group;
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $ys = $YearSemester->GetYearSemester($time);
        $Version = $YearSemester->GetCurrentTableName($ys['YearSemester']);

        $NewTermTime = $YearSemester->GetTimeByYearSemester($ys['YearSemester']);


        $table1 = "front_theory_evaluation".$Version;
        $table2 = "front_practice_evaluation".$Version;
        $table3 = "front_physical_evaluation".$Version;

        $DataArr1 = DB::select('select * from '.$table1.'
where `督导id` = any(
	SELECT user_id from users where users.`group`="'.$group.'"
)
 and `听课时间` > "'.$NewTermTime['time1'].'"
ORDER BY 听课时间 DESC limit 3');
        $DataArr2 = DB::select('select * from '.$table2.'
where `督导id` = any(
	SELECT user_id from users where users.`group`="'.$group.'"
)
 and `听课时间` > "'.$NewTermTime['time1'].'"
ORDER BY 听课时间 DESC limit 3');
        $DataArr3 = DB::select('select * from '.$table3.'
where `督导id` = any(
	SELECT user_id from users where users.`group`="'.$group.'"
)
 and `听课时间` > "'.$NewTermTime['time1'].'"
ORDER BY 听课时间 DESC limit 3');
        $DataArr = [];
        for ($l=0;$l<count($DataArr1);$l++)
        {
            array_push($DataArr,$DataArr1[$l]);
        }
        for ($l=0;$l<count($DataArr2);$l++)
        {
            array_push($DataArr,$DataArr2[$l]);
        }
        for ($l=0;$l<count($DataArr3);$l++)
        {
            array_push($DataArr,$DataArr3[$l]);
        }
        return $DataArr;
    }

}
