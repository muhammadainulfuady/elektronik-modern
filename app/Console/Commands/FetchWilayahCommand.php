<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FetchWilayahCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:wilayah';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mendownload data Provinsi, Kota, Kecamatan, dan Desa dari API dan menyimpannya secara lokal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai menarik data wilayah...');

        // 1. Provinsi
        $this->info('Mengambil data Provinsi...');
        $provResponse = Http::withoutVerifying()->timeout(60)->get('https://alamat.thecloudalert.com/api/provinsi/get/');
        if (!$provResponse->successful()) {
            $this->error('Gagal mengambil data Provinsi.');
            return;
        }
        
        $provData = $provResponse->json('result');
        if (!is_array($provData)) {
            $this->error('Format data Provinsi tidak valid.');
            return;
        }

        $provinsis = [];
        $kotas = [];
        $kecamatans = [];
        $desas = [];

        foreach ($provData as $p) {
            $provinsis[] = [
                'id_provinsi' => $p['id'],
                'nama_provinsi' => $p['text']
            ];
        }
        Storage::put('wilayah/provinsi.json', json_encode($provinsis, JSON_PRETTY_PRINT));
        DB::table('provinsis')->upsert($provinsis, ['id_provinsi'], ['nama_provinsi']);

        // 2. Kota
        $this->info('Mengambil data Kota...');
        $bar = $this->output->createProgressBar(count($provinsis));
        $bar->start();
        foreach ($provinsis as $prov) {
            try {
                $kotaRes = Http::withoutVerifying()->timeout(10)->get('https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=' . $prov['id_provinsi']);
                if ($kotaRes->successful() && is_array($kotaRes->json('result'))) {
                    foreach ($kotaRes->json('result') as $k) {
                        $kotas[] = [
                            'id_kota' => $k['id'],
                            'id_provinsi' => $prov['id_provinsi'],
                            'nama_kota' => $k['text']
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Ignore timeout for one and continue
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        Storage::put('wilayah/kota.json', json_encode($kotas, JSON_PRETTY_PRINT));
        foreach (array_chunk($kotas, 1000) as $chunk) {
            DB::table('kotas')->upsert($chunk, ['id_kota'], ['id_provinsi', 'nama_kota']);
        }

        // 3. Kecamatan
        $this->info('Mengambil data Kecamatan...');
        $bar = $this->output->createProgressBar(count($kotas));
        $bar->start();
        foreach ($kotas as $kota) {
            try {
                $kecRes = Http::withoutVerifying()->timeout(10)->get('https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=' . $kota['id_kota']);
                if ($kecRes->successful() && is_array($kecRes->json('result'))) {
                    foreach ($kecRes->json('result') as $kec) {
                        $kecamatans[] = [
                            'id_kecamatan' => $kec['id'],
                            'id_kota' => $kota['id_kota'],
                            'nama_kecamatan' => $kec['text']
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Continue on fail
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        Storage::put('wilayah/kecamatan.json', json_encode($kecamatans, JSON_PRETTY_PRINT));
        foreach (array_chunk($kecamatans, 1000) as $chunk) {
            DB::table('kecamatans')->upsert($chunk, ['id_kecamatan'], ['id_kota', 'nama_kecamatan']);
        }

        // 4. Desa
        $this->info('Mengambil data Desa/Kelurahan... (PERHATIAN: Ini akan memakan waktu lama)');
        $bar = $this->output->createProgressBar(count($kecamatans));
        $bar->start();
        foreach ($kecamatans as $kec) {
            try {
                $desaRes = Http::withoutVerifying()->timeout(10)->get('https://alamat.thecloudalert.com/api/kelurahan/get/?d_kecamatan_id=' . $kec['id_kecamatan']);
                if ($desaRes->successful() && is_array($desaRes->json('result'))) {
                    foreach ($desaRes->json('result') as $desa) {
                        $desas[] = [
                            'id_desa' => $desa['id'],
                            'id_kecamatan' => $kec['id_kecamatan'],
                            'nama_desa' => $desa['text']
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Continue on fail
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        
        // Simpan ke JSON (Tanpa format cantik untuk menghemat ukuran file)
        Storage::put('wilayah/desa.json', json_encode($desas)); 
        
        $this->info('Menyimpan ' . count($desas) . ' baris data desa ke database...');
        foreach (array_chunk($desas, 2000) as $chunk) {
            DB::table('desas')->upsert($chunk, ['id_desa'], ['id_kecamatan', 'nama_desa']);
        }

        $this->info('Selesai! Semua data berhasil disimpan dan dicadangkan di storage/app/wilayah.');
    }
}
