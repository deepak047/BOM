<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'Purchase Dept',
            ],
             [
                'id'    => 3,
                'title' => 'Engineer',
            ],
             [
                'id'    => 4,
                'title' => 'Store Manager',
            ],
        ];

        Role::insert($roles);
    }
}
