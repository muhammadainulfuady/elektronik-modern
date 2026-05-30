<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinsiSeeder::class,
            KotaSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,
            DusunSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            ProdukSeeder::class,
            PromoSeeder::class,
            EkspedisiSeeder::class,
            // Tabel yang dipicu oleh aktivitas user (seperti keranjang, pesanan, dsb) 
            // sengaja tidak dipanggil agar database fresh.
        ]);
    }
}
