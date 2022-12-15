<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->insert([
            [
                'name_ar' => 'مدير',
                'name_en' => 'admin',
                'guard_name' => 'admin'
            ],
            [
                'name_ar' => 'مالك متجر',
                'name_en' => 'Store Owner',
                'guard_name' => 'store_owner'
            ],
            [
                'name_ar' => 'موظف',
                'name_en' => 'Employee',
                'guard_name' => 'employee'
            ]
        ]);
    }
}
