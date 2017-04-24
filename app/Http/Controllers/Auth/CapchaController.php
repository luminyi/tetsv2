<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Help\CptcodeController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Mews\Captcha\Facades\Captcha;
class CapchaController extends Controller
{
    public function makecode()
    {
//        return Captcha::create('flat');
        $code = new CptcodeController;
        $code->make();
    }

    public function getcode()
    {
//        return Captcha::create('flat');
        $code = new CptcodeController;
        return $code->get();
    }
}
