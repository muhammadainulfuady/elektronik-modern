<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $sourceDir = base_path('ASSETS/BARANG');
        $destDir = storage_path('app/public/products');

        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        // Map folder name to Kategori ID
        $kategoriMap = [
            'HANDPHONE' => 1,
            'KABEL' => 2,
            'KAMERA' => 3,
            'KULKAS' => 4,
            'LAPTOP' => 5,
            'TV' => 6,
        ];

        $rows = [];
        $id = 1;

        foreach ($kategoriMap as $folderName => $kategoriId) {
            $folderPath = $sourceDir . '/' . $folderName;
            
            if (File::isDirectory($folderPath)) {
                $files = File::files($folderPath);
                
                foreach ($files as $file) {
                    $filename = $file->getFilename();
                    $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
                    
                    // Generate a readable name from filename (e.g., asus-ideaped -> Asus Ideaped)
                    $namaProduk = ucwords(str_replace('-', ' ', $nameWithoutExt));
                    
                    // Copy file to storage
                    File::copy($file->getPathname(), $destDir . '/' . $filename);

                    $rows[] = [
                        'id_produk' => $id++,
                        'id_kategori' => $kategoriId,
                        'gambar' => $filename,
                        'nama_produk' => $namaProduk,
                        'deskripsi' => 'Produk unggulan ' . $namaProduk . ' dengan kualitas terbaik dan garansi resmi.',
                        'harga' => rand(10, 150) * 50000, // random price between 500k and 7.5m
                        'stok' => rand(10, 100),
                    ];
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('produks')->truncate();
        DB::table('produks')->insert($rows);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
