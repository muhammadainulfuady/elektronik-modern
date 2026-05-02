<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlamatUserSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_alamat' => $i,
                'id_users' => $i,
                'id_dusun' => $i,
                'label_alamat' => $i % 2 === 0 ? 'Kantor' : 'Rumah',
                'nomor_telepon' => '0812000000' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'detail_alamat' => 'Alamat utama pelanggan ' . $i,
                'is_utama' => 1,
            ];
        }

        DB::table('alamat_users')->insert($rows);
    }
}
