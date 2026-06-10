<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KotaSeeder extends Seeder
{
    public function run(): void
    {
        if (Storage::exists('wilayah/kota.json')) {
            $data = json_decode(Storage::get('wilayah/kota.json'), true);
            foreach (array_chunk($data, 1000) as $chunk) {
                DB::table('kotas')->insert($chunk);
            }
        } else {
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
}
