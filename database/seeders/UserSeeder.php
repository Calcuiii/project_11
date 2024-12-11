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
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@admin',
                'password' => bcrypt('adminadmin'),
            ],
            [
                'name' => 'Alkhanza Amelia',
                'email' => 'soniaamelia4704@gmail.com',
                'password' => bcrypt('Khanza47@'),
            ]


        ]);
    }
}
