<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EkspedisiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['JNE', 18000],
            ['JNT', 17000],
            ['SiCepat', 16000],
            ['POS', 15000],
            ['TIKI', 17500],
            ['AnterAja', 16500],
            ['Ninja', 19000],
            ['Wahana', 14000],
            ['ID Express', 15500],
            ['Lion Parcel', 18500],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_ekspedisi' => $index + 1,
                'nama_ekspedisi' => $item[0],
                'biaya_pengiriman' => $item[1],
            ];
        }

        DB::table('ekspedisis')->insert($rows);
    }
}
