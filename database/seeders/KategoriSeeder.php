<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriData = [
            'Handphone' => 'handphone.png',
            'Kabel' => 'cable.png',
            'Kamera' => 'camera.png',
            'Kulkas' => 'kulkas.png',
            'Laptop' => 'laptop.png',
            'TV' => 'televisi.png',
        ];

        $sourceDir = base_path('ASSETS/IKON KATEGORI');
        $destDir = storage_path('app/public/categories');

        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        $rows = [];
        $id = 1;
        foreach ($kategoriData as $nama => $file) {
            $sourcePath = $sourceDir . '/' . $file;
            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destDir . '/' . $file);
            }

            $rows[] = [
                'id_kategori' => $id++,
                'nama_kategori' => $nama,
                'ikon_kategori' => $file,
            ];
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kategoris')->truncate();
        DB::table('kategoris')->insert($rows);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
