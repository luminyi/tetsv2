<?php

namespace App\Http\Controllers;

use App\Model\Role;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only',['teacherManage']]);
    }

    public function teacherManage()
    {
        return view('UserManage.TeacherManage');
    }

    public function teacherInfo()
    {
        $user = Role::find(6)//在roles表中，6号对应的教师
        ->users()->distinct()->get();
        return $user->toArray();
    }
}
