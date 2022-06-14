<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Services\Hasher;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request){
        $params = $request->all();

        //validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //check if account is deleted
        $checkAccount = User::getUserByEmail($params['email']);
        if(!$checkAccount)
            return [
                "success" => false,
                "message" => "Account is already deleted!",
            ];
        
        //login account
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return [
                "success" => true,
                "message" => "Login Successful!",
            ];
        }
        
        //return if credentials are incorrect
        return [
            "success" => false,
            "message" => "Email or Password is Incorrect",
        ];
    }

    public function logout(){
        Session::flush();        
        Auth::logout();
        return redirect('/');
    }

    public function activateNewAccount($id, Request $request){
        //decode user id from link
        $id = Hasher::decode($id);

        //get user
        $user = User::find($id);

        //redirect to login page if user is not found
        if(!$user)
            return redirect('/');
        
        //login user
        Auth::loginUsingId($id);
        $request->session()->regenerate();

        return redirect('/welcome');
    }
}
