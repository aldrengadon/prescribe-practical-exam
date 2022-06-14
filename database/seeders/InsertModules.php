<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertModules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'order_list' => 1,
                'name'  => 'dashboard',
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon'  => 'icon-linecons-tv'
            ],
            [
                'order_list' => 2,
                'name'  => 'users',
                'label' => 'Users',
                'route' => 'users',
                'icon'  => 'icon-users'
            ],
            [
                'order_list' => 3,
                'name'  => 'roles',
                'label' => 'Roles',
                'route' => 'roles',
                'icon'  => 'icon-cogs'
            ],
            [
                'order_list' => 4,
                'name'  => 'module_test_1',
                'label' => 'Modules Test 1',
                'route' => 'module-test-1',
                'icon'  => 'icon-newspaper-o'
            ],
            [
                'order_list' => 5,
                'name'  => 'module_test_2',
                'label' => 'Modules Test 2',
                'route' => 'module-test-2',
                'icon'  => 'icon-newspaper-o'
            ],
            [
                'order_list' => 6,
                'name'  => 'module_test_3',
                'label' => 'Modules Test 3',
                'route' => 'module-test-3',
                'icon'  => 'icon-newspaper-o'
            ],
        ]);
    }
}
