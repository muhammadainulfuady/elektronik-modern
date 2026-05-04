<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $metode = ['transfer', 'ewallet'];

        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_pembayaran' => $i,
                'id_pesanan' => $i,
                'metode_pembayaran' => $metode[$i % 2],
                'bukti_bayar' => 'bukti_' . str_pad((string) $i, 3, '0', STR_PAD_LEFT) . '.jpg',
                'status_konfirmasi' => $i % 3 === 0 ? 0 : ($i % 3 === 1 ? 1 : 2),
            ];
        }

        DB::table('pembayarans')->insert($rows);
    }
}
