<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleTest3Controller extends Controller
{
    public function index(Request $request){

        return view('modules/test3/index');
    }
}
