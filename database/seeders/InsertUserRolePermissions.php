<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertUserRolePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role_permissions')->insert([
            [
                'role_id'   => 1,
                'module_id' => 2,
                'view'      => 1,
                'add'       => 1,
                'edit'      => 1,
                'delete'    => 1
            ],
            [
                'role_id'   => 1,
                'module_id' => 3,
                'view'      => 1,
                'add'       => 1,
                'edit'      => 1,
                'delete'    => 1
            ],
        ]);
    }
}
