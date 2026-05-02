<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DusunSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Dago Atas', 1],
            ['Bulusan Timur', 2],
            ['Keputih Barat', 3],
            ['Pegangsaan Utara', 4],
            ['Banjaragung Utara', 5],
            ['Muja Muju Selatan', 6],
            ['Sanur Kaja', 7],
            ['Titi Rantai Barat', 8],
            ['5 Ilir Timur', 9],
            ['Karampuang Tengah', 10],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_dusun' => $index + 1,
                'id_desa' => $item[1],
                'nama_dusun' => $item[0],
            ];
        }

        DB::table('dusuns')->insert($rows);
    }
}
