<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleTest1Controller extends Controller
{
    public function index(Request $request){

        return view('modules/test1/index');
    }
}
