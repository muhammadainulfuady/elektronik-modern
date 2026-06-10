<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        if (Storage::exists('wilayah/provinsi.json')) {
            $data = json_decode(Storage::get('wilayah/provinsi.json'), true);
            foreach (array_chunk($data, 1000) as $chunk) {
                DB::table('provinsis')->insert($chunk);
            }
        } else {
            $data = [
                'Jawa Timur',
                'Jawa Tengah',
                'Jawa Barat',
                'DKI Jakarta',
                'DI Yogyakarta',
            ];

            $rows = [];
            foreach ($data as $index => $nama) {
                $rows[] = [
                    'id_provinsi' => $index + 1,
                    'nama_provinsi' => $nama,
                ];
            }

            DB::table('provinsis')->insert($rows);
        }
    }
}
