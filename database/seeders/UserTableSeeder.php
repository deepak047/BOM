<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $admin = User::create([
                'name'           => "Admin",
                'email'          => "admin@example.com",
                'password'       => bcrypt('password'),
            
            ]);

            $admin->roles()->sync(1);
           

            $sales = User::create([
                'name'           => "Purchase",
                'email'          => "purchase@example.com",
                'password'       => bcrypt('password'),
            
            ]);
            $sales->roles()->sync(2);

            $sales = User::create([
                'name'           => "Engineer",
                'email'          => "engineer@example.com",
                'password'       => bcrypt('password'),
            
            ]);
            $sales->roles()->sync(3);

            $sales = User::create([
                'name'           => "Store Manager",
                'email'          => "manager@example.com",
                'password'       => bcrypt('password'),
            
            ]);
            $sales->roles()->sync(4);
            
    }
}
