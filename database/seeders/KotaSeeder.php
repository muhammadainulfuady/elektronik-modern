<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KotaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Bandung', 1],
            ['Semarang', 2],
            ['Surabaya', 3],
            ['Jakarta', 4],
            ['Serang', 5],
            ['Yogyakarta', 6],
            ['Denpasar', 7],
            ['Medan', 8],
            ['Palembang', 9],
            ['Makassar', 10],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_kota' => $index + 1,
                'id_provinsi' => $item[1],
                'nama_kota' => $item[0],
            ];
        }

        DB::table('kotas')->insert($rows);
    }
}
