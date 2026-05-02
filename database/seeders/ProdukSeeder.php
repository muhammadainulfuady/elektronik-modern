<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Lampu LED 12W', 'lampu-led-12w.jpg', 1, 25000, 120, 'Lampu LED hemat energi untuk ruangan kecil.'],
            ['Kabel USB Type-C', 'kabel-usb-c.jpg', 2, 18000, 200, 'Kabel data 1m dengan konektor Type-C.'],
            ['Adaptor 12V 2A', 'adaptor-12v.jpg', 3, 55000, 90, 'Adaptor daya stabil untuk perangkat elektronik.'],
            ['Speaker Bluetooth', 'speaker-bluetooth.jpg', 4, 175000, 60, 'Speaker portable dengan suara jernih.'],
            ['Router WiFi AC1200', 'router-ac1200.jpg', 5, 320000, 40, 'Router dual band untuk rumah.'],
            ['Keyboard Mechanical', 'keyboard-mechanical.jpg', 6, 450000, 35, 'Keyboard mekanikal untuk produktivitas.'],
            ['Headphone Studio', 'headphone-studio.jpg', 7, 290000, 55, 'Headphone nyaman untuk monitoring.'],
            ['Kamera CCTV 1080p', 'cctv-1080p.jpg', 8, 260000, 70, 'Kamera CCTV indoor resolusi 1080p.'],
            ['Smart Plug WiFi', 'smart-plug.jpg', 9, 85000, 150, 'Stop kontak pintar dengan kontrol aplikasi.'],
            ['Power Strip 6 Port', 'power-strip.jpg', 10, 95000, 110, 'Terminal listrik dengan 6 port USB.'],
        ];

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                'id_produk' => $index + 1,
                'id_kategori' => $item[2],
                'gambar' => $item[1],
                'nama_produk' => $item[0],
                'deskripsi' => $item[5],
                'harga' => $item[3],
                'stok' => $item[4],
            ];
        }

        DB::table('produks')->insert($rows);
    }
}
