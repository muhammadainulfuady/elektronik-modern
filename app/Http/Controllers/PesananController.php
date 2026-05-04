<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Admin: daftar pesanan.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'pembayaran', 'ekspedisi', 'detailPesanans.produk'])
            ->latest('tanggal_pesan')
            ->get();
        $jumlahDiproses = Pesanan::where('status_pesanan', 'diproses')->count();
        $jumlahDikirim = Pesanan::where('status_pesanan', 'dikirim')->count();
        $jumlahSelesai = Pesanan::where('status_pesanan', 'selesai')->count();

        return view('admin.orders', compact('pesanans', 'jumlahDiproses', 'jumlahDikirim', 'jumlahSelesai'));
    }

    /**
     * Update status pesanan (admin).
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status_pesanan' => ['required', 'in:diproses,dikirim,selesai'],
        ]);

        $pesanan->update($data);

        return redirect()
            ->route('admin.orders.index')
            ->with('status', 'Status pesanan #' . $pesanan->id_pesanan . ' berhasil diperbarui.');
    }
}
