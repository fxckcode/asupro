<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_admin = [
            [
                'id' => 1,
                'nombre' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin')
            ]
        ];

        DB::table('users')->insert($user_admin);

    }
}
