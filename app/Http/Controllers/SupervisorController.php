<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Help\HelpController;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only',['SupervisorInfo']]);
    }

//the view of supervisor management
    public function SupervisorInfo()
    {
        $title=null;
        $help = New HelpController;
        //一次续聘4个学期
        $TermNum = 4;
        //目前聘期的结束学期
        $currentEndTerm = DB::table('role_user')->max('supervise_time');
        //下一个聘期的结束学期
        $termArray=$help->CaculateTerm($currentEndTerm, $TermNum);
        $nextTime =max($termArray);

        return view('SupervisorInfo',compact('title','currentEndTerm','nextTime'));
    }



//select the information of supervisors
    public function Get_SupervisorInfo(Request $request)
    {
        $user_id = $request->data;
        $record = DB::table('role_user')
            ->select('users.id','users.user_id','users.name','roles.name as level','sex',
                "state","status","group","workstate","unit","email",
                "phone","supervise_time","skill","prorank")
            ->leftjoin('users','role_user.user_id','=','users.id')
            ->leftjoin('roles','role_user.role_id','=','roles.id')
            ->where('users.user_id','=',$user_id)
            ->where('users.name','not like','%负责人')
            ->where('users.name','not like','%管理员')
            ->get();
        return $record;
    }


//校级管理员重置密码功能。
    public function ResetPass(Request $request)
    {
        $flag = DB::table('users')
            ->where('user_id', $request->data)
            ->update(['password' => bcrypt('123456')]);
        return $flag;
    }
    /**
     * @return string
     * 校级，查看督导所有的信息
     * 活跃或者不再担任督导的均列举
     */
    public function GetAllSupervisorInfo(Request $request)
    {
        $help = New HelpController;

        $TimeFlag = $request->TimeFlag;
        if($TimeFlag==null)
        {
            $record = DB::table('role_user')
                ->select('users.user_id','users.name','roles.name as level','sex',"state","status","group",
                    "workstate","unit","email","phone","supervise_time","skill")
                ->leftjoin('users','role_user.user_id','=','users.id')
                ->leftjoin('roles','role_user.role_id','=','roles.id')
                ->where('users.name','not like','%负责人')
                ->where('users.name','not like','%管理员')
                ->where('role_user.role_id','!=','6')
                ->get();
        }

        else{

            $record = DB::table('role_user')
                ->select('users.user_id','users.name','roles.name as level','sex',"state","status","group",
                    "workstate","unit","email","phone","supervise_time","skill")
                ->leftjoin('users','role_user.user_id','=','users.id')
                ->leftjoin('roles','role_user.role_id','=','roles.id')
                ->where('role_user.supervise_time','=',$TimeFlag)
                ->where('users.name','not like','%负责人')
                ->where('users.name','not like','%管理员')
                ->get();
        }
        $record = $help->UnionRole($record);
        return json_encode($record);
    }






    /**
     * @return string
     * 大组长，查看督导所有的信息
     */
    public function GetBigGroupSupervisorInfo(Request $request)
    {
        $help = New HelpController;
        $TimeFlag = $request->TimeFlag;

        if($TimeFlag==null)
        {
            $record = DB::table('role_user')
                ->select('users.user_id','users.name','roles.name as level','sex',"state","status","group","workstate","unit","email","phone","supervise_time","skill")
                ->leftjoin('users','role_user.user_id','=','users.id')
                ->leftjoin('roles','role_user.role_id','=','roles.id')
                ->where('users.name','not like','%负责人')
                ->where('users.name','not like','%管理员')
                ->get();
        }

        else{

            $record = DB::table('role_user')
                ->select('users.user_id','users.name','roles.name as level','sex',"state","status","group","workstate","unit","email","phone","supervise_time","skill")
                ->leftjoin('users','role_user.user_id','=','users.id')
                ->leftjoin('roles','role_user.role_id','=','roles.id')
                ->where('role_user.supervise_time','=',$TimeFlag)
                ->where('users.name','not like','%负责人')
                ->where('users.name','not like','%管理员')
                ->get();
        }
        $record = $help->UnionRole($record);
        return json_encode($record);
    }
    /**
     * @return string
     * 院级，查看本学院督导所有的信息
     * 需要列出院级所属组别中所有督导的信息
     *  1、先确定该院督导所在组
     *  2、根据坐在组别将该组内的督导信息查询出来
     */
    public function GetUnitSupervisorInfo(Request $request)
    {
        $help = New HelpController;

        $unit = $request->unit;
        $TimeFlag = $request->TimeFlag;//是否有任职学期的时间限制
//        Log::write('info',$unit);        Log::write('info',$TimeFlag);
//        $unit = '信息学院';
//        $TimeFlag = '2016-2017-1';
//        查询督导所在组：
        $group = DB::table('users')->select('group')
            ->where('name','not like','%负责人')
            ->where('unit','=',$unit)->distinct()->get();
//        Log::write('info',$group);
        if($TimeFlag==null)
            $record = DB::table('users')
                ->where('group','=',$group[0]->group)
                ->where('name','not like','%负责人')
                ->where('name','not like','%管理员')

                ->orderBy('supervise_time','desc')->get();
        else
            $record = DB::table('users')
                ->where('supervise_time','=',$TimeFlag)
                ->where('group','=',$group[0]->group)
                ->where('name','not like','%负责人')
                ->where('name','not like','%管理员')

                ->orderBy('supervise_time','desc')
                ->get();
//dd($record);
        $record = $help->UnionRole($record);

        return json_encode($record);
    }
    /**
     * @return string
     * 小组长，查看本学院督导所有的信息
     */
    public function GetGroupSupervisorInfo(Request $request)
    {
        $help = New HelpController;

        $group = $request->group;
        $TimeFlag = $request->TimeFlag;
//        $group='第一组';
//        $TimeFlag='2016-2017-1';
//        $TimeFlag=null;
        if($TimeFlag==null)
            $record = DB::table('users')
                ->where('group','=',$group)
                ->where('name','not like','%负责人')
                ->where('name','not like','%管理员')

                ->orderBy('supervise_time','desc')->get();
        else
            $record = DB::table('users')->where('supervise_time','=',$TimeFlag)
                ->where('name','not like','%负责人')
                ->where('name','not like','%管理员')

                ->where('group','=',$group)->orderBy('supervise_time','desc')->get();
        $record = $help->UnionRole($record);

//        dd($record);
        return json_encode($record);
    }

    /**
     * @param $userInfo
     * userInfo is a array and the form of userInfo is:
     * change_begin_time, change_end_time, xiaoji, dazuzhang. xiaozuzhang, dudao
     *
     * @param $id
     * users table's primary key:id
     */
    protected function addRole($userInfo, $id){
        $changetime1 =$userInfo['change_begin_time'];
        $changetime2 =$userInfo['change_end_time'];
        $help=new HelpController;
        $termArray = $help->CaculateTerm($changetime1, $changetime2);
        //judge this user weather has these jobs as fallow :xiaoji xiaozuzhang dazuzhang dudao
        $role = [];
        $unrole = array(Role::find(1),Role::find(3),Role::find(4),Role::find(5));
        if (array_key_exists('xiaoji',$userInfo))
            array_push($role , Role::find(1));
        if (array_key_exists('dazuzhang',$userInfo))
            array_push($role , Role::find(3));
        if (array_key_exists('xiaozuzhang',$userInfo))
            array_push($role , Role::find(4));
        if (array_key_exists('dudao',$userInfo))
            array_push($role , Role::find(5));
        //更新单个督导信息的 role_user 表
        $user = \App\Model\User::find($id);


        for($iterm=0;$iterm<count($termArray);$iterm++)
        {
            DB::table('role_user')
                ->where('user_id', '=', $id)
                ->where('supervise_time', '=', $termArray[$iterm])
                ->delete();
        }


        for ($irole=0;$irole<count($role);$irole++)
        {
            for($iterm=0;$iterm<count($termArray);$iterm++)
            {
                $user->roles()->attach($role[$irole],['supervise_time' => $termArray[$iterm]]);
            }
        }

    }

    public function ChangeSupervisorInfo(Request $request)
    {
        $userInfo = $request->all();
        $user_id = $request->get('user_id');
        $supervisor_name = $request->get('account_name');
        $supervisor_phone = $request->get('phone');
        $supervisor_state = $request->get('state');
        $supervisor_sex = $request->get('sex');
        $supervisor_unit = $request->get('unit');
        $supervisor_email = $request->get('email');
        $supervisor_status = $request->get('status');
        $supervisor_group = $request->get('group');
        $supervisor_workstate = $request->get('workstate');
        $supervisor_ProRank = $request->get('ProRank');
        $supervisor_skill = $request->get('skill');

        $flag1=\App\Model\User::updateOrCreate(
            ['user_id' => $user_id ],
            [
                'email'=>$supervisor_email,
                'phone'=>$supervisor_phone,
                'state'=>$supervisor_state,
                'unit'=>$supervisor_unit,
                'skill'=>$supervisor_skill,
                'ProRank'=>$supervisor_ProRank,
                'status'=>$supervisor_status,
                'workstate'=>$supervisor_workstate,
                'group'=>$supervisor_group,
                'name'=>$supervisor_name,
                'sex'=>$supervisor_sex
            ]
        );

        if(array_key_exists('tid',$userInfo))//form table comes from change user information
            $id = $userInfo['tid'];
        else//form table comes from add user information
        {
            $id = DB::table('users')->select('id')->where('user_id',$user_id)->get();
            $id = $id[0]->id;
        }
        $this->addRole($userInfo, $id);


        $title='操作成功！';

//        return view('SupervisorInfo',compact('title','EndTime','nextTime'));
        return redirect('/SupervisorInfo')->with('title');
    }

    public function ChangeUnitUserInfo(Request $request)
    {
        $teacher_id = $request->get('teacher_id');
//        $teacher_id = $request->get('teacher_id');
//        $supervisor_name = $request->get('account_name');
        $supervisor_phone = $request->get('phone');
//        $supervisor_level = $request->get('level_change');
//        $supervisor_state = $request->get('state');
//        $supervisor_sex = $request->get('sex');
        $supervise_time = $request->get('supervise_time');
//        $supervisor_unit = $request->get('unit');
        $supervisor_email = $request->get('email');
//更新单个督导信息
        $flag1=DB::table('users')
            ->where('id','=',$teacher_id)
            ->where('supervise_time','=',$supervise_time)
            ->update([
//                'level'=>$supervisor_level,
                'email'=>$supervisor_email,
                'phone'=>$supervisor_phone,
//                'state'=>$supervisor_state,
//                'unit'=>$supervisor_unit,
//                'skill'=>$supervisor_skill,
//                'ProRank'=>$supervisor_ProRank,
//                'status'=>$supervisor_status,
//                'workstate'=>$supervisor_workstate,
//                'group'=>$supervisor_group,
//                'name'=>$supervisor_name,
//                'sex'=>$supervisor_sex
            ]);

        $title='操作成功！';
//        else
//            $title='操作失败，请稍后重试！';
        return view('UnitUserManage',compact('title'));

    }


    public function GetSupervisorName(Request $request)
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $key = $request->get('supervisor');
//        $InputValue = DB::select('select DISTINCT name from users where name like "' . $key . '%" limit 10');
//        $InputValue = DB::select('select DISTINCT teacher_id,name from users where supervise_time="'.$version['YearSemester'].'";');
        $InputValue = DB::table('users')->select('user_id','name')
//            ->where('supervise_time','=',$version['YearSemester'])
            ->where('name','like',$key.'%')
            ->where('name','not like','%教学负责人')
            ->where('name','not like','%管理员')
            ->where('status','=','活跃')
            ->distinct()
            ->get();
//        $data = [];
//        for ($i=0;$i<count($InputValue);$i++)
//        {
//            $data[$i]=$InputValue[$i]->name;
//        }
        return $InputValue;
    }
    public function GetSupervisorIDbyName(Request $request)
    {
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $key = $request->get('supervisor');
//        $InputValue = DB::select('select DISTINCT name from users where name like "' . $key . '%" limit 10');
//        $InputValue = DB::select('select DISTINCT teacher_id,name from users where supervise_time="'.$version['YearSemester'].'";');
        $InputValue = DB::table('users')->select('teacher_id')
            ->where('supervise_time','=',$version['YearSemester'])
            ->where('name','=',$key)
            ->where('name','not like','%教学负责人')
            ->where('name','not like','%管理员')
            ->where('status','=','活跃')
            ->distinct()
            ->get();
//        $data = [];
//        for ($i=0;$i<count($InputValue);$i++)
//        {
//            $data[$i]=$InputValue[$i]->name;
//        }
        return $InputValue;
    }
    public function GetUnitSupervisorName(Request $request)
    {
        $unit = $request->get('unit');
        $time = date("Y-m-d");
        $YearSemester=new HelpController;
        $version = $YearSemester->GetYearSemester($time);
        $InputValue = DB::select('select DISTINCT name from users where unit="'.$unit.'" and supervise_time="'.$version['YearSemester'].'";');
        $data = [];
        for ($i=0;$i<count($InputValue);$i++)
        {
            $data[$i]=$InputValue[$i]->name;
        }
        return $data;
    }
    public function GetGroupSupervisorName(Request $request)
    {
        $group = $request->get('group');
        $year1=$request->get('year1');
        $year2=$request->get('year2');
        $semester=$request->get('semester');

        $supervise_time = $year1.'-'.$year2.'-'.$semester[0];
//        $group ='B组';

        $InputValue = DB::table('users')
            ->select('name','teacher_id')
            ->where('group','=',$group)
            ->where('supervise_time','=',$supervise_time)
            ->distinct()->get();

        return $InputValue;
    }


    /*
     * 1、calculate current term
     * 2、calculate the end term of this period
     * 3、
     * */
    public function RenewContacts()
    {
        $time = date("Y-m-d");
        $help=new HelpController;
        //calculate current term
        $currentTerm = $help->GetYearSemester($time);

        //4 terms as one period, 1 term is current term
        $TermNum = 5;
        //the end term of current period
        $currentEndTerm = DB::table('role_user')->max('supervise_time');
        //end term of next period, store in variable:nextTime
        $termArray=$help->CaculateTerm($currentEndTerm, $TermNum);
        $nextTime =max($termArray);

        //if current term equal to the end term of current period
        if($currentTerm['YearSemester']==$currentEndTerm)
        {
            $users = DB::table('users')
                ->select('id')
                ->where('name','not like','%负责人')->get();
//            change_begin_time, change_end_time, xiaoji, dazuzhang. xiaozuzhang, dudao
            for($iuser=0; $iuser<count($users); $iuser++)
            {
                $userInfo = $this->GetUserRoles($users[$iuser]->id, $currentEndTerm);
                //the new contract is begin with new term, so the index is 1
                $userInfo['change_begin_time'] = $termArray[0];
                $userInfo['change_end_time'] = $nextTime;

                $this->addRole($userInfo, $users[$iuser]->id);
            }

            $title = "续约成功！";
            return view('SupervisorInfo',compact('title','currentEndTerm','nextTime'));
        }

        else{
            $title='续约期未结束！';
            return view('SupervisorInfo',compact('title','currentEndTerm','nextTime'));
        }
    }

    /**
     * @param $id
     *      table:users's primary key
     * @param $term
     *      current term
     * @return array
     *      get current user roles in current semester
     */
    protected function GetUserRoles($id, $term)
    {
        $user = \App\Model\User::where('id',$id)->with(['roles'=>function($query) use ($term){
            return $query->where( 'supervise_time' ,'=' ,$term ) ;
        }])->get();

        $userRole = array();
        foreach($user[0]->roles as $role)
        {
            if($role->name == '校级')
            {
                $userRole['xiaoji']='1';
                continue;
            }
            if($role->name == '大组长')
            {
                $userRole['dazuzhang']='1';
                continue;
            }
            if($role->name == '小组长')
            {
                $userRole['xiaozuzhang']='1';
                continue;
            }
            if($role->name == '督导')
            {
                $userRole['dudao']='1';
                continue;
            }
        }
        return $userRole;

    }

}
