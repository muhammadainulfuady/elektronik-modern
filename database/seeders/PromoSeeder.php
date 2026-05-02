<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_promo' => $i,
                'kode_voucher' => 'PROMO' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'tipe_diskon' => $i % 2 === 0 ? 'nominal' : 'persen',
                'nilai_diskon' => $i % 2 === 0 ? 15000 : 10,
                'kuota' => 100 - ($i * 3),
                'tanggal_mulai' => Carbon::now()->subDays(15 - $i),
                'tanggal_berakhir' => Carbon::now()->addDays($i),
            ];
        }

        DB::table('promos')->insert($rows);
    }
}
