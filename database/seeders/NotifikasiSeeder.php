<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = [
                'id_notifikasi' => $i,
                'id_users' => $i,
                'judul' => 'Update Pesanan #' . $i,
                'pesan' => 'Pesanan #' . $i . ' sedang diproses dan akan segera dikirim.',
                'is_read' => $i % 2,
            ];
        }

        DB::table('notifikasis')->insert($rows);
    }
}
