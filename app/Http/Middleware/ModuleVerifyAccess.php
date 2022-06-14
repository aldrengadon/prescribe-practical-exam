<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleVerifyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $moduleName
     * @return mixed
     */
    public function handle($request, Closure $next, $moduleName = null)
    {
        $roleId = Auth::user()->role_id;
		if(!$request->hasHeader('X-axios')) {
			$perms = Permissions::getByModuleName($moduleName);
            $perms = $perms->modulePermissions->where('role_id', $roleId);
            
			$request->merge(['permissions' => $perms[0]]);
		}

        return $next($request);
    }
}
