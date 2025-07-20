<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'first_name' => 'User',
                'last_name' => 'user',
                'email' => 'user@gmail.com',
                'number_phone' => '770000000',
                'password' => bcrypt('passer'),
                'role_id' => 3,
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@recruit.com',
                'number_phone' => '771234567',
                'password' => bcrypt('admin123'),
                'role_id' => 1,
            ],
        ]);
    }
}
