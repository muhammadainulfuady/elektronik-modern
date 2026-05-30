<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Airlangga', 1],
            ['Pepelegi', 2],
            ['Randuagung', 3],
            ['Tlogomas', 4],
            ['Gunung Gedangan', 5],
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
