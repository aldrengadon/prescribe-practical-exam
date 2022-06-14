<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleTest2Controller extends Controller
{
    public function index(Request $request){

        return view('modules/test2/index');
    }
}
