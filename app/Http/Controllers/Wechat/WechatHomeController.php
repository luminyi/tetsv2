<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\HelpController;
use App\Http\Controllers\Auth\HomeController;


class WechatHomeController extends Controller
{
    // a weixin test
    public function weixinTheoryEvaluationTableView()
    {
        $HomeController = new HomeController;
        $frontdata = $HomeController->GetFrontValueTable();
        $backdata = $HomeController->GetBackValueTable();
        $front =array(
            '1'=>$frontdata[2][0],//一级菜单项
            '2'=>$frontdata[3][0],//二级菜单项
            '3'=>$frontdata[4][0]//三级菜单项
        );
        $back =array(
            '1'=>$backdata[2][0],//背面1级
            '2'=>$backdata[3][0]//背面2级
        );
        return view('weixin.TheoryEvaluationTable',compact('front','back'));
    }

    public function weixinPhysicalEvaluationTableView()
    {
        $HomeController = new HomeController;
        $frontdata = $HomeController->GetFrontValueTable();
        $backdata = $HomeController->GetBackValueTable();

        $front =array(
            '1'=>$frontdata[2][2],
            '2'=>$frontdata[3][2],
            '3'=>$frontdata[4][2]
        );
        $back =array(
            '1'=>$backdata[2][2],
            '2'=>$backdata[3][2]
        );
        return view('weixin.PhysicalEvaluationTable',compact('front','back'));
    }

    public function weixinPracticeEvaluationTableView()
    {
        $HomeController = new HomeController;
        $frontdata = $HomeController->GetFrontValueTable();
        $backdata = $HomeController->GetBackValueTable();
        $front =array(
            '1'=>$frontdata[2][1],
            '2'=>$frontdata[3][1],
            '3'=>$frontdata[4][1]
        );
        $back =array(
            '1'=>$backdata[2][1],
            '2'=>$backdata[3][1]
        );
        return view('weixin.PracticeEvaluationTable',compact('front','back'));
    }
}
