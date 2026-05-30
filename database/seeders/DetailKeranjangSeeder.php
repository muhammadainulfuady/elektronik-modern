<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailKeranjangSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 5; $i++) {
            $rows[] = [
                'id_detail_keranjang' => $i,
                'id_produk' => $i,
                'id_keranjang' => $i,
                'qty' => ($i % 3) + 1,
            ];
        }

        DB::table('detail_keranjangs')->insert($rows);
    }
}
