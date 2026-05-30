<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Gubeng', 1],
            ['Waru', 2],
            ['Kebomas', 3],
            ['Lowokwaru', 4],
            ['Magersari', 5],
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
