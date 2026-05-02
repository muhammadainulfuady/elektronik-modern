<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_users' => ['required', 'integer', 'exists:users,id_users'],
            'id_alamat' => ['required', 'integer', 'exists:alamat_users,id_alamat'],
            'id_promo' => ['required', 'integer', 'exists:promos,id_promo'],
            'id_ekspedisi' => ['required', 'integer', 'exists:ekspedisis,id_ekspedisi'],
            'tanggal_pesan' => ['required', 'date'],
            'subtotal' => ['required', 'integer', 'min:0'],
            'diskon' => ['required', 'integer', 'min:0'],
            'no_resi' => ['required', 'string', 'max:50'],
            'ongkos_kirim' => ['required', 'integer', 'min:0'],
            'total_bayar' => ['required', 'integer', 'min:0'],
            'status_pesanan' => ['required', 'in:diproses,dikirim'],
        ]);

        Pesanan::create($data);

        return redirect()->back()->with('status', 'Pesanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'id_users' => ['required', 'integer', 'exists:users,id_users'],
            'id_alamat' => ['required', 'integer', 'exists:alamat_users,id_alamat'],
            'id_promo' => ['required', 'integer', 'exists:promos,id_promo'],
            'id_ekspedisi' => ['required', 'integer', 'exists:ekspedisis,id_ekspedisi'],
            'tanggal_pesan' => ['required', 'date'],
            'subtotal' => ['required', 'integer', 'min:0'],
            'diskon' => ['required', 'integer', 'min:0'],
            'no_resi' => ['required', 'string', 'max:50'],
            'ongkos_kirim' => ['required', 'integer', 'min:0'],
            'total_bayar' => ['required', 'integer', 'min:0'],
            'status_pesanan' => ['required', 'in:diproses,dikirim'],
        ]);

        $pesanan->update($data);

        return redirect()->back()->with('status', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }
}
