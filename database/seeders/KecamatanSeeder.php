<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Coblong', 1],
            ['Tembalang', 2],
            ['Sukolilo', 3],
            ['Menteng', 4],
            ['Cipocok Jaya', 5],
            ['Umbulharjo', 6],
            ['Denpasar Selatan', 7],
            ['Medan Baru', 8],
            ['Ilir Timur I', 9],
            ['Panakkukang', 10],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_kecamatan' => $index + 1,
                'id_kota' => $item[1],
                'nama_kecamatan' => $item[0],
            ];
        }

        DB::table('kecamatans')->insert($rows);
    }
}
