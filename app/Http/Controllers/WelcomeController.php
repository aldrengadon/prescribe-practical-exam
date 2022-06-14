<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Services\Hasher;
use Illuminate\Support\Facades\Storage;

class WelcomeController extends Controller
{
    
    public function index(){
        $user = Auth::user();
        $imageName = Hasher::encode($user->id);
        $exists = Storage::disk('public')->exists("images/$imageName.png");
        if($exists)
            $imageName .= ".png";
        else
            $imageName .= ".jpg";

        return view('modules/welcome/index')->with([
            'imageName' => $imageName
        ]);
    }
}
