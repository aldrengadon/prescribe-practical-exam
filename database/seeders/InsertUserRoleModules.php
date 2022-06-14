<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertUserRoleModules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role_modules')->insert([
            [
                'role_id'   => 1,
                'module_id' => 2
            ],
            [
                'role_id'   => 1,
                'module_id' => 3
            ],
        ]);
    }
}
