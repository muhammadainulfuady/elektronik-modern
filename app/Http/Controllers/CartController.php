<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cart    = session('cart', []);
        $ids     = array_keys($cart);
        $produks = Produk::with('kategori')->whereIn('id_produk', $ids)->get()->keyBy('id_produk');

        $items = [];
        $subtotal = 0;

        foreach ($cart as $id => $qty) {
            if ($produks->has($id)) {
                $produk = $produks[$id];
                $lineTotal = $produk->harga * $qty;
                $subtotal += $lineTotal;
                $items[] = (object) [
                    'produk'    => $produk,
                    'qty'       => $qty,
                    'lineTotal' => $lineTotal,
                ];
            }
        }

        return view('cart.index', compact('items', 'subtotal'));
    }

    /**
     * Tambah produk ke keranjang (AJAX atau form POST).
     */
    public function add(Request $request)
    {
        $request->validate([
            'id_produk' => ['required', 'integer', 'exists:produks,id_produk'],
            'qty'       => ['nullable', 'integer', 'min:1'],
        ]);

        $id  = (int) $request->id_produk;
        $qty = (int) ($request->qty ?? 1);

        $cart = session('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        session(['cart' => $cart]);

        if ($request->ajax()) {
            return response()->json([
                'message'   => 'Produk ditambahkan ke keranjang!',
                'cartCount' => array_sum($cart),
            ]);
        }

        return back()->with('status', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Update jumlah item di keranjang.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_produk' => ['required', 'integer'],
            'qty'       => ['required', 'integer', 'min:0'],
        ]);

        $id  = (int) $request->id_produk;
        $qty = (int) $request->qty;

        $cart = session('cart', []);

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $qty;
        }

        session(['cart' => $cart]);

        if ($request->ajax()) {
            return response()->json([
                'message'   => 'Keranjang diperbarui.',
                'cartCount' => array_sum($cart),
            ]);
        }

        return back()->with('status', 'Keranjang diperbarui.');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function remove(Request $request)
    {
        $id   = (int) $request->id_produk;
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        if ($request->ajax()) {
            return response()->json([
                'message'   => 'Produk dihapus dari keranjang.',
                'cartCount' => array_sum($cart),
            ]);
        }

        return back()->with('status', 'Produk dihapus dari keranjang.');
    }

    /**
     * Hitung jumlah item di keranjang (AJAX).
     */
    public function count()
    {
        return response()->json([
            'cartCount' => array_sum(session('cart', [])),
        ]);
    }
}
