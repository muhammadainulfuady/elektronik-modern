<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $subtotal = 100000 + ($i * 15000);
            $diskon = $i % 2 === 0 ? 10000 : 5000;
            $ongkir = 15000 + ($i * 500);
            $rows[] = [
                'id_pesanan' => $i,
                'id_users' => $i,
                'id_alamat' => $i,
                'id_promo' => $i,
                'id_ekspedisi' => $i,
                'tanggal_pesan' => Carbon::now()->subDays(10 - $i),
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'no_resi' => 'RESI' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'ongkos_kirim' => $ongkir,
                'total_bayar' => $subtotal - $diskon + $ongkir,
                'status_pesanan' => $i % 3 === 0 ? 'selesai' : ($i % 2 === 0 ? 'dikirim' : 'diproses'),
            ];
        }

        DB::table('pesanans')->insert($rows);
    }
}
