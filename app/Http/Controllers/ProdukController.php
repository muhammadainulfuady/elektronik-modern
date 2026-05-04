<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        $jumlahProduk = $produks->count();
        $jumlahUser = User::count();
        $rating = Ulasan::sum('rating') / count(Ulasan::all());
        return view('index', compact('produks', 'jumlahProduk', 'jumlahUser', 'rating'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Typically returns a view with categories for the dropdown
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        // Typically returns a view with categories and current product data
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {

    }
}
