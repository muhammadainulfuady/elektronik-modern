<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KotaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Surabaya', 1],
            ['Sidoarjo', 1],
            ['Gresik', 1],
            ['Malang', 1],
            ['Mojokerto', 1],
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
