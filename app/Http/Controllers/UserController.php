<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\Hasher;
use App\Mail\CreateUserEmail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    
    public function index(Request $request){
        $users = [];
        $getUsers  = User::where('is_valid', 1)->get();//get all valid users
        $userRoles = UserRole::all();

        foreach($getUsers as $g)//get all needed user fields
            $users[] = [
                'id'         => $g->id,
                'email'      => $g->email,
                'first_name' => $g->first_name,
                'last_name'  => $g->last_name,
                'role'       => $g->userRole->code,
                'role_id'    => $g->role_id,
                'created_at' => date('F j, Y g:i A', strtotime($g->created_at)),
                'updated_at' => date('F j, Y g:i A', strtotime($g->updated_at)),
            ];

        return view('modules/user/index')->with([
            'users' => $users,
            'userRoles' => $userRoles,
            'permissions' => $request->permissions
        ]);
    }

    public function createUser(Request $request){
        $data = $request->all();

        //validate data
        $validate = $this->validateUserData($request);
        if(!$validate)
            return [
                'success' => false,
                'message' => "Please fill in all required fields!"
            ];
        
        //create random password
        $data['password'] = Hash::make(Str::random(12));
        //save new user
        $create = User::create($data);

        //send email to user
        $this->sendEmail($create);

        return [
            'success' => true,
            'userId' => $create->id
        ];

    }

    public function updateUser(Request $request){
        $data = $request->all();

        //validate data
        $validate = $this->validateUserData($request);
        if(!$validate)
            return [
                'success' => false,
                'message' => "Please fill in all required fields!"
            ];
        
        //get user
        $user = User::find($data['id']);
        
        //save user
        $user->update($data);

        return [
            'success' => true,
            'userId' => $user->id,
            'message' => 'User has been saved!'
        ];

    }

    public function deleteUser(Request $request){
        $data = $request->all();
        $user = User::find($data['id']);
        if(!$user)
            return [
                'success' => false,
                'message' => "Could not find user!"
            ];

        $user->is_valid = 0;
        $user->update();

        return [
            'success' => true,
            'message' => 'User has been deleted!'
        ];

    }

    public function uploadFile(Request $request){
		$data         = $request->all();
		$userId       = $data['userId'];//user id
        $userFile     = $request->file('userFiles');

        //explode file name
        $explodeFile  = explode(".", $userFile[0]->getClientOriginalName());

        //get file extension
        $fileExtension= end($explodeFile);

        //get files
        $fileBody     = file_get_contents($userFile[0]->getPathname());

        //hashed file name from user id
        $fileName     = Hasher::encode($userId);
        
        //image path
        $imagePath    = "/images/$fileName.$fileExtension";
        
        //upload file
        Storage::disk('public')->put($imagePath, $fileBody);

        return [
            'success' => true,
            'message' => 'User has been saved!'
        ];
    }

    public function savePassword($password){
        $auth = Auth::user();
        $user = User::find($auth->id);
        $user->password = Hash::make($password);
        $user->save();

        return [
            "success" => true,
            "message" => "Password has been saved!"
        ];
    }

    public function getAllUsers(){
        $users = [];
        $getUsers  = User::where('is_valid', 1)->get();//get all valid users

        foreach($getUsers as $g)//get all needed user fields
            $users[] = [
                'id'         => $g->id,
                'email'      => $g->email,
                'first_name' => $g->first_name,
                'last_name'  => $g->last_name,
                'role'       => $g->userRole->code,
                'role_id'    => $g->role_id,
                'created_at' => date('F j, Y g:i A', strtotime($g->created_at)),
                'updated_at' => date('F j, Y g:i A', strtotime($g->updated_at)),
            ];

        return $users;
    }

    private function sendEmail($data){
        //get app url
        $config       = config('app.url');

        //hash user id
        $hashedUserId = Hasher::encode($data->id);

        //new account link
        $data->url  = "$config/activate-new-account/$hashedUserId";

        return Mail::to($data->email)->send(new CreateUserEmail($data));
    }

    private function validateUserData($request){
        return $request->validate([
            'email' => ['required', 'email'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'role_id' => ['required'],
        ]);
    }
}
