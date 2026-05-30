<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DusunSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Airlangga Gubeng', 1],
            ['Pepelegi Indah', 2],
            ['Randuagung Timur', 3],
            ['Tlogomas Permai', 4],
            ['Gunung Gedangan Asri', 5],
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
