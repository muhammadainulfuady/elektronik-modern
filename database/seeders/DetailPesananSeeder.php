<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPesananSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_detail' => $i,
                'id_pesanan' => $i,
                'id_produk' => $i,
                'qty' => ($i % 2) + 1,
                'harga_beli' => 25000 + ($i * 5000),
            ];
        }

        DB::table('detail_pesanans')->insert($rows);
    }
}
