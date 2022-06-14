<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertUserRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            [
            'name' => 'Admin',
            'code' => 'ADMIN'
            ],
            [
            'name' => 'Client Manager',
            'code' => 'CM'
            ],
            [
            'name' => 'Senior Client Manager',
            'code' => 'SCM'
            ]
        ]);
    }
}
