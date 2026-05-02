<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Dago', 1],
            ['Bulusan', 2],
            ['Keputih', 3],
            ['Pegangsaan', 4],
            ['Banjaragung', 5],
            ['Muja Muju', 6],
            ['Sanur', 7],
            ['Titi Rantai', 8],
            ['5 Ilir', 9],
            ['Karampuang', 10],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_desa' => $index + 1,
                'id_kecamatan' => $item[1],
                'nama_desa' => $item[0],
            ];
        }

        DB::table('desas')->insert($rows);
    }
}
