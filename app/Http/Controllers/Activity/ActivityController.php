<?php

namespace App\Http\Controllers\Activity;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index()
    {
        return view('acsystem.Activity.index');
    }
}
