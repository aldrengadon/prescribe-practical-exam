<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRole;
use App\Models\Module;
use App\Models\UserRoleModule;
use App\Models\UserRolePermission;

class RoleController extends Controller
{
    public function index(Request $request){
        $roles = UserRole::all();//get all roles

        return view('modules/role/index')->with([
            'roles' => $roles,
            'permissions' => $request->permissions
        ]);
    }

    public function getRoleModulesAndPermissions($id){
        //get role
        $role = UserRole::find($id);

        //get roles permissions per module
        $permissions = [];
        foreach($role->rolePermissions as $r){
            $permissions[] = [    
                "id"        => $r->id,            
                "role_id"   => $r->role_id,
                "module_id" => $r->module_id,
                "view"      => $r->view,
                "add"       => $r->add,
                "edit"      => $r->edit,
                "delete"    => $r->delete,
                "name"      => $r->permissionModule->name,
            ];
        }

        $modules    = [];
        $getModules = Module::all();//get all modules
        //get necessary fields for modules
        foreach($getModules as $g)
            $modules[] = [
                "id"          => $g->id,
                "label"       => $g->label,
                "is_selected" => false,
                "view"        => false,
                "add"         => false,
                "edit"        => false,
                "delete"      => false
            ];

        return [
            "roleData" => [
                "id" => $role->id,
                "name" => $role->name,
                "code" => $role->code,
                "permissions" => $permissions,
                "modules" => $role->roleModules
            ],
            "modules" => $modules
        ];
    }

    public function updateRole(Request $request){
        $data = $request->all();

        foreach($data['modules'] as $m){
            $userRoleModulesId = $m['user_role_modules_id'] ?? 0;
            if($userRoleModulesId || $m['is_selected']){
                $userRoleModule            = UserRoleModule::findOrNew($userRoleModulesId);
                $userRoleModule->role_id   = $data['role_id'];
                $userRoleModule->module_id = $m['id'];
                if(!$m['is_selected'] && $userRoleModulesId)
                    $userRoleModule->delete();//delete if no longer selected
                else
                    $userRoleModule->save();//update role modules

                $userRolePermissionsId         = $m['user_role_permissions_id'] ?? 0;
                $UserRolePermission            = UserRolePermission::findOrNew($userRolePermissionsId);
                $UserRolePermission->role_id   = $data['role_id'];
                $UserRolePermission->module_id = $m['id'];
                $UserRolePermission->view      = $m['view'];
                $UserRolePermission->add       = $m['add'];
                $UserRolePermission->edit      = $m['edit'];
                $UserRolePermission->delete    = $m['delete'];
                if(!$m['is_selected'] && $userRoleModulesId)
                    $UserRolePermission->delete();//delete if no longer selected
                else
                    $UserRolePermission->save();//update role permissions
            }
        }
        
        return [
            "success" => true,
            "message" => "Role has been updated!"
        ];
    }
}
