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
            ['Admin Toko', 'admin@example.com', 'admin'],
            ['Owner Toko', 'owner@example.com', 'owner'],
            ['Budi Santoso', 'budi@example.com', 'customer'],
            ['Siti Aminah', 'siti@example.com', 'customer'],
            ['Andi Pratama', 'andi@example.com', 'customer'],
            ['Rina Lestari', 'rina@example.com', 'customer'],
            ['Dewi Kartika', 'dewi@example.com', 'customer'],
            ['Rahmat Hidayat', 'rahmat@example.com', 'customer'],
            ['Intan Permata', 'intan@example.com', 'customer'],
            ['Fajar Nugroho', 'fajar@example.com', 'customer'],
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
