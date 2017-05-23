<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Help\HelpController;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnitUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only',['UnitUserManage']]);
    }

    public function UnitUserManage()
    {
        $title=null;
        return view('UserManage.UnitUserManage',compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ChangeUnitUserInfo(Request $request)
    {
        $user_id = $request->get('user_id');
        $supervisor_phone = $request->get('phone');
        $supervisor_email = $request->get('email');
        $flag1=DB::table('users')
            ->where('user_id','=',$user_id)
            ->update([
                'email'=>$supervisor_email,
                'phone'=>$supervisor_phone,
            ]);
        $title='操作成功！';
        return view('UserManage.UnitUserManage',compact('title'));
    }

    //select the information about Unit responsibility
    public function GetUnitUserInfo(Request $request)
    {
        $Info = $request->all();

        if($Info['level'] == '校级' || $Info['level'] == '大组长')
            return $this->GetAllUnitUserInfo();
        else
            return $this->GetGroupUnitUserInfo($Info['group']);
    }

    /**
     * @return string
     * 校级，查看院级教学负责人所有的信息
     */
    protected function GetAllUnitUserInfo()
    {

        $record = DB::table('users')
            ->where('name','like','%教学负责人')
            ->get();

        return $record;
    }

    /**
     * @return string
     * 小组长和督导，查看本组对应的教学负责人的信息
     */
    protected function GetGroupUnitUserInfo($group)
    {

        $record = DB::table('users')
            ->where('name','like','%教学负责人')
            ->whereIn('unit',function($query)  use ($group){
                $query->select('unit')
                    ->from('users') ->where('unit','like','%学院')
                    ->where('group','=',$group);
            })
            ->get();

        return $record;
    }

    //select the specific unit responsibility information
    public function GetSpecificUnitInfo(Request $request)
    {
        $user_id = $request->data;
        $record = DB::table('users')
            ->select('name','phone','email','user_id')
            ->where('user_id','=',$user_id)
            ->get();
        return $record;
    }

}
