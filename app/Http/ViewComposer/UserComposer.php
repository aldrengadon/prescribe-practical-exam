<?php

namespace App\Http\ViewComposer;

use Auth;
use Illuminate\Contracts\View\View;
use App\Models\UserRole;
use Illuminate\Support\Facades\Storage;
use App\Services\Hasher;

class UserComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Auth::user();
        $userRole = UserRole::find($user->role_id)->code;
        (int)$sessionLifetime = config('session.lifetime');

        $imageName = Hasher::encode($user->id);
        $exists = Storage::disk('public')->exists("images/$imageName.png");
        if($exists)
            $imageName .= ".png";
        else
            $imageName .= ".jpg";

        $view->with('userFullName', ucwords($user->first_name.' '.$user->last_name));
        $view->with('userRole', $userRole);
        $view->with('dateCreated', $user->created_at);
        $view->with('dateUpdated', $user->updated_at);
        $view->with('sessionLifetime',  (((($sessionLifetime - 1) * 60) * 1000)));//converted to milliseconds lessen by 60 seconds
        $view->with('imageName', $imageName);
        
    }
}