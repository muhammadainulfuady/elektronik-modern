<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Lampu', 'icon-lampu.svg'],
            ['Kabel', 'icon-kabel.svg'],
            ['Daya', 'icon-daya.svg'],
            ['Audio', 'icon-audio.svg'],
            ['Jaringan', 'icon-jaringan.svg'],
            ['Komputer', 'icon-komputer.svg'],
            ['Aksesoris', 'icon-aksesoris.svg'],
            ['Keamanan', 'icon-keamanan.svg'],
            ['Smart Home', 'icon-smart-home.svg'],
            ['Peralatan', 'icon-peralatan.svg'],
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
