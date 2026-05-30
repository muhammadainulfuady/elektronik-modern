<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Jawa Timur',
            'Jawa Tengah',
            'Jawa Barat',
            'DKI Jakarta',
            'DI Yogyakarta',
        ];

        $rows = [];
        foreach ($data as $index => $nama) {
            $rows[] = [
                'id_provinsi' => $index + 1,
                'nama_provinsi' => $nama,
            ];
        }

        DB::table('provinsis')->insert($rows);
    }
}
