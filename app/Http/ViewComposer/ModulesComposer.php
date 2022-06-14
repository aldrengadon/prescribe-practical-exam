<?php

namespace App\Http\ViewComposer;

use Auth;
use Illuminate\Contracts\View\View;
use App\Models\UserRole;

class ModulesComposer
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
        $role = UserRole::find($user->role_id);
        $modules = [];
        foreach($role->roleModules as $a)
            $modules[$a->userRoleModules->order_list] = $a->userRoleModules;

        ksort($modules);

        $view->with('modules', $modules);        
    }
}