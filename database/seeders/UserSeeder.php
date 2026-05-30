<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ainulfuady', 'fuady@gmail.com', 'customer'],
            ['fajar', 'fajar@gmail.com', 'customer'],
            ['angga', 'angga@gmail.com', 'admin'],
            ['joni', 'joni@gmail.com', 'owner'],
            ['labib', 'labib@gmail.com', 'owner'],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_users' => $index + 1,
                'nama' => $item[0],
                'email' => $item[1],
                'password' => Hash::make('password'),
                'role' => $item[2],
            ];
        }

        DB::table('users')->insert($rows);
    }
}
