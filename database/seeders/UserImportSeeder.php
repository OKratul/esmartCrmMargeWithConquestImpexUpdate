<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => "MD Rayhan Gofur",
                'email' => 'rayhan@conquestimpex.com',
                'password' => bcrypt('123456'),
                'user_role' => 'Accountant'
            ],
            [
                'name' => "Mohammad Rony",
                'email' => 'test@gmail.com',
                'password' => bcrypt('123456'),
                'user_role' => 'none',
            ],
            [
                'name' => "MD Shakil Ahmed",
                'email' => 'shakil@conquestimpex.com',
                'password' => bcrypt('123456'),
                'user_role' => 'Accountant',
            ],
            [
                'name' => "MD Ismail Hossain",
                'email' => 'test2@gmail.com', // Fixed the domain part (gmail.com)
                'password' => bcrypt('123456'),
                'user_role' => 'none',
            ],
            [
                'name' => "MD Rakibul Islam",
                'email' => 'test3@gmail.com', // Fixed the domain part (gmail.com)
                'password' => bcrypt('123456'),
                'user_role' => 'none',
            ],
            [
                'name' => "MD Arfin Ahmed",
                'email' => 'test4@gmail.com', // Fixed the domain part (gmail.com)
                'password' => bcrypt('123456'),
                'user_role' => 'none',
            ],
            [
                'name' => 'Shahid Hridoy',
                'email' => 'nahean@conquestimpex.com',
                'password' => bcrypt('123456'),
                'user_role' => 'none',
            ],
            [
              'name'=>'Omar Khaiyam',
              'email'=>'omarkhaiyamratul@gmail.com',
              'password'=>bcrypt('ok064636r'),
                'user_role' => 'none',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

    }
}
