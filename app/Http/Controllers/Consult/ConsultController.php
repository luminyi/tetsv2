<?php

namespace App\Http\Controllers\Consult;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConsultController extends Controller
{
    public function index()
    {
        return view('acsystem.Consult.index');
    }
}
