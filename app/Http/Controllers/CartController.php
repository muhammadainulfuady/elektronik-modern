<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $appliedPromo = $this->appliedPromo();
        $discount = $appliedPromo ? $this->calculateDiscount($appliedPromo, $subtotal) : 0;
        $total = max(0, $subtotal - $discount);

        return view('cart.index', compact('items', 'subtotal', 'appliedPromo', 'discount', 'total'));
    }

    /**
     * Cek apakah user admin/owner (tidak boleh beli).
     */
    private function isAdminOrOwner(): bool
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            return in_array($role, ['admin', 'owner']);
        }
        return false;
    }

    /**
     * Tambah produk ke keranjang (AJAX atau form POST).
     */
    public function add(Request $request)
    {
        // Admin/Owner tidak boleh membeli
        if ($this->isAdminOrOwner()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Admin dan Owner tidak dapat membeli barang.'], 403);
            }
            return back()->with('error', 'Admin dan Owner tidak dapat membeli barang.');
        }

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

    public function applyVoucher(Request $request)
    {
        $data = $request->validate([
            'kode_voucher' => ['required', 'string', 'max:50'],
        ]);

        $promo = Promo::where('kode_voucher', strtoupper($data['kode_voucher']))
            ->where('kuota', '>', 0)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->first();

        if (!$promo) {
            return back()->with('error', 'Kode voucher tidak valid, habis, atau sudah kedaluwarsa.');
        }

        session(['applied_promo_id' => $promo->id_promo]);

        return back()->with('status', 'Voucher ' . $promo->kode_voucher . ' berhasil digunakan.');
    }

    public function removeVoucher()
    {
        session()->forget('applied_promo_id');

        return back()->with('status', 'Voucher dihapus dari keranjang.');
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

    private function appliedPromo(): ?Promo
    {
        $promoId = session('applied_promo_id');
        if (!$promoId) {
            return null;
        }

        return Promo::where('id_promo', $promoId)
            ->where('kuota', '>', 0)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->first();
    }

    private function calculateDiscount(Promo $promo, int $subtotal): int
    {
        if ($subtotal <= 0) {
            return 0;
        }

        if ($promo->tipe_diskon === 'persen') {
            return min($subtotal, (int) floor($subtotal * $promo->nilai_diskon / 100));
        }

        return min($subtotal, (int) $promo->nilai_diskon);
    }
}
