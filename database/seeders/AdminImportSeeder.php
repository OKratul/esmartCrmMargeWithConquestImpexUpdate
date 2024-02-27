<?php

namespace Database\Seeders;

use App\Models\CrmAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username'  => "mahmood reaz",
                'email'=> 'reaz@conquestimpex.com',
                'password' => bcrypt('reaz@impex50'),
            ],
            [
                'username'  => "omarKhaiyam",
                'email'=> 'omarKhaiyamratul@gmail.com',
                'password' => bcrypt('omar064636ratul'),
            ],
            [
                'username'  => "rythmm",
                'email'=> 'rythmm@conquestimpex.com',
                'password' => bcrypt('rythmm@@online50'),
            ]
        ];

        foreach ($users as $userData) {
            CrmAdmin::create($userData);
        }
    }
}
