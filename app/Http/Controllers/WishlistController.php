<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Halaman wishlist milik customer.
     */
    public function index()
    {
        $wishlists = Wishlist::where('id_users', Auth::id())
            ->with('produk.kategori')
            ->get();

        return view('customer.wishlist', compact('wishlists'));
    }

    /**
     * Toggle wishlist (tambah/hapus) via AJAX.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'id_produk' => ['required', 'integer', 'exists:produks,id_produk'],
        ]);

        $existing = Wishlist::where('id_users', Auth::id())
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Wishlist::create([
                'id_users'  => Auth::id(),
                'id_produk' => $request->id_produk,
            ]);
            $liked = true;
        }

        $wishlistCount = Wishlist::where('id_users', Auth::id())->count();

        return response()->json([
            'liked'         => $liked,
            'wishlistCount' => $wishlistCount
        ]);
    }

    /**
     * Ambil jumlah item di wishlist.
     */
    public function count()
    {
        $wishlistCount = Wishlist::where('id_users', Auth::id())->count();
        return response()->json(['wishlistCount' => $wishlistCount]);
    }
}
