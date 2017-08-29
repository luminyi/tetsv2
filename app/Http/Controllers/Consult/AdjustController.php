<?php

namespace App\Http\Controllers\Consult;

use App\Model\ConsultsUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Help\HelpController;

class AdjustController extends Controller
{
    public function index(){
        $help = new HelpController;
        $Term = $help->GetYearSemester(date("Y-m-d"));
        $term = $Term['YearSemester'];
        return view('acsystem.Consult.Admin.AdjustIndex',compact('term'));
    }

    public function ConsultResult($action){
        if ($action=='undo')
        {
            $undo = DB::table('consult_user')
                ->select('users.name as username','users.unit','consult_user.*','consults_type.name')
                ->leftjoin('users','users.id','=','consult_user.user_id')
                ->leftjoin('consults_type','consult_user.consults_type_id','=','consults_type.id')
                ->where('consult_user.state','=','待协调')->get();
            return $undo;
        }
        elseif($action=='done'){
            $done =  DB::table('consult_user')
                ->select('users.name as username','users.unit','consult_user.*','consults_type.name','consults.*')
                ->leftjoin('consults_type','consult_user.consults_type_id','=','consults_type.id')
                ->leftjoin('users','users.id','=','consult_user.user_id')
                ->leftjoin('consults','consults.consult_id','=','consult_user.consult_id')
                ->where('consult_user.state','=','已协调')->get();
            return $done;
        }
    }

    public function ConsultCoordinate(Request $request){
        $id = $request->get('id');
        DB::table('consult_user')
            ->where('consult_id',$id)
            ->update(['state' => '已协调']);
        return '协调成功';
    }
}
