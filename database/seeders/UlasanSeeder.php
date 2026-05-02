<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UlasanSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_ulasan' => $i,
                'id_users' => $i,
                'id_produk' => $i,
                'rating' => 4 + ($i % 2),
                'komentar' => 'Produk #' . $i . ' kualitas bagus dan pengiriman cepat.',
            ];
        }

        DB::table('ulasans')->insert($rows);
    }
}
