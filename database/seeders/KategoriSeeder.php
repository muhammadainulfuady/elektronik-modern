<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Lampu', 'fi fi-rr-bulb'],
            ['Kabel', 'fi fi-rr-pulse'],
            ['Daya', 'fi fi-rr-charging-station'],
            ['Audio', 'fi fi-rr-volume'],
            ['Jaringan', 'fi fi-rr-wifi'],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_kategori' => $index + 1,
                'nama_kategori' => $item[0],
                'ikon_kategori' => $item[1],
            ];
        }

        DB::table('kategoris')->insert($rows);
    }
}
