<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeranjangSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 5; $i++) {
            $rows[] = [
                'id_keranjang' => $i,
                'id_users' => $i,
            ];
        }

        DB::table('keranjangs')->insert($rows);
    }
}
