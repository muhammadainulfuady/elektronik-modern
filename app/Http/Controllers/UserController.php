<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Admin dashboard.
     */
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahMenungguKonfirmasi = Pesanan::where('status_pesanan', 'diproses')->count();
        $pesananDikirim = Pesanan::where('status_pesanan', 'dikirim')->count();
        $pesananSelesai = Pesanan::where('status_pesanan', 'selesai')->count();
        $statusPesanan = Pesanan::select('status_pesanan', \DB::raw('count(*) as total'))
            ->groupBy('status_pesanan')
            ->get();
        $jumlahProduk = Produk::count();
        $pesananTerbaru = Pesanan::with('user')->latest('tanggal_pesan')->take(5)->get();
        $pesanan_tujuh_hari_terakhir = Pesanan::where('tanggal_pesan', '>=', now()->subDays(7))->count();

        return view('admin.index', compact(
            'jumlahUser',
            'jumlahMenungguKonfirmasi',
            'pesananDikirim',
            'pesananSelesai',
            'statusPesanan',
            'jumlahProduk',
            'pesananTerbaru',
            'pesanan_tujuh_hari_terakhir'
        ));
    }

    /**
     * Admin: daftar pengguna.
     */
    public function userList()
    {
        $users = User::withCount('pesanans')->orderBy('id_users')->get();

        return view('admin.users', compact('users'));
    }
}
