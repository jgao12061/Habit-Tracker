<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Dummy',
            'last_name' => 'Account',
            'email' => 'dummy@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
           
        ]);

        // Add more if you want a fuller table
        User::create([
            'first_name' => 'Leon',
            'last_name' => 'Kennedy',
            'email' => 'leon@rpd.gov',
            'password' => bcrypt('password'),
        ]);
    }
}
