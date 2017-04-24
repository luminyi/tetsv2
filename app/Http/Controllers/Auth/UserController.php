<?php

namespace App\Http\Controllers\Auth;

use App\Model\Permission;
use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //用户权限切换
    public function user_switch_start( $new_user )
    {
//        $new_user = User::find( $new_user );
//        Auth::login( $new_user );

        session(['role'=>$new_user]);
        return Redirect::action('IndexController@index');
    }

    /**
     * 用户权限列表
     * getpermission从roles表中取出当前用的所有权限
     * @return mixed
     */

    public function GetStatus(Request $request)
    {
        $tid = $request->id;
        $year = $request->year;

        $user = User::where('id',$tid)->with(['roles'=>function($query) use ($year){
            return $query->where( 'supervise_time' ,'=' ,$year ) ;
        }])->get();

        if(session('role') == null)
        {
            $role = $user[0]->roles[0]->name;
            session(['role'=>$role]);
        }
        $data = $user[0]->roles;
        return $data;
    }
}
