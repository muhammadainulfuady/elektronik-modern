<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
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
        $keranjang = $this->getUserKeranjang();
        $details   = $keranjang ? $keranjang->detailKeranjangs()->with('produk.kategori')->get() : collect();

        $items    = [];
        $subtotal = 0;

        foreach ($details as $detail) {
            if ($detail->produk) {
                $lineTotal = $detail->produk->harga * $detail->qty;
                $subtotal += $lineTotal;
                $items[] = (object) [
                    'produk'    => $detail->produk,
                    'qty'       => $detail->qty,
                    'lineTotal' => $lineTotal,
                ];
            }
        }

        $appliedPromo = $this->appliedPromo();
        $discount     = $appliedPromo ? $this->calculateDiscount($appliedPromo, $subtotal) : 0;
        $total        = max(0, $subtotal - $discount);

        $promos = Promo::where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->where('kuota', '>', 0)
            ->get();

        return view('cart.index', compact('items', 'subtotal', 'appliedPromo', 'discount', 'total', 'promos'));
    }

    /**
     * Cek apakah user admin/owner (tidak boleh beli).
     */
    private function isAdminOrOwner(): bool
    {
        if (Auth::check()) {
            return in_array(Auth::user()->role, ['admin', 'owner']);
        }
        return false;
    }

    /**
     * Ambil keranjang milik user yang login (tanpa membuat baru).
     */
    private function getUserKeranjang(): ?Keranjang
    {
        if (!Auth::check()) return null;
        return Keranjang::where('id_users', Auth::id())->first();
    }

    /**
     * Ambil atau buat keranjang milik user yang login.
     */
    private function getOrCreateKeranjang(): Keranjang
    {
        return Keranjang::firstOrCreate(['id_users' => Auth::id()]);
    }

    /**
     * Tambah produk ke keranjang (AJAX atau form POST).
     */
    public function add(Request $request)
    {
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

        $keranjang = $this->getOrCreateKeranjang();
        $detail    = $keranjang->detailKeranjangs()->where('id_produk', $id)->first();

        if ($detail) {
            $detail->increment('qty', $qty);
        } else {
            $keranjang->detailKeranjangs()->create(['id_produk' => $id, 'qty' => $qty]);
        }

        $cartCount = $keranjang->detailKeranjangs()->sum('qty');

        if ($request->expectsJson()) {
            return response()->json([
                'status'    => true,
                'message'   => 'Produk ditambahkan ke keranjang!',
                'cartCount' => $cartCount,
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

        $id        = (int) $request->id_produk;
        $qty       = (int) $request->qty;
        $keranjang = $this->getUserKeranjang();

        if ($keranjang) {
            $detail = $keranjang->detailKeranjangs()->where('id_produk', $id)->first();
            if ($detail) {
                if ($qty <= 0) {
                    $detail->delete();
                } else {
                    $detail->update(['qty' => $qty]);
                }
            }
        }

        $cartCount = $keranjang ? $keranjang->detailKeranjangs()->sum('qty') : 0;

        if ($request->expectsJson()) {
            return response()->json([
                'message'   => 'Keranjang diperbarui.',
                'cartCount' => $cartCount,
            ]);
        }

        return back()->with('status', 'Keranjang diperbarui.');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function remove(Request $request)
    {
        $id        = (int) $request->id_produk;
        $keranjang = $this->getUserKeranjang();

        if ($keranjang) {
            $keranjang->detailKeranjangs()->where('id_produk', $id)->delete();
        }

        $cartCount = $keranjang ? $keranjang->detailKeranjangs()->sum('qty') : 0;

        if ($request->expectsJson()) {
            return response()->json([
                'message'   => 'Produk dihapus dari keranjang.',
                'cartCount' => $cartCount,
            ]);
        }

        return back()->with('status', 'Produk dihapus dari keranjang.');
    }

    public function applyVoucher(Request $request)
    {
        $data = $request->validate([
            'kode_voucher' => ['required', 'string', 'max:50'],
        ], [
            'kode_voucher.required' => 'Silakan masukkan kode voucher terlebih dahulu.',
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
        $count = 0;
        if (Auth::check()) {
            $keranjang = $this->getUserKeranjang();
            $count     = $keranjang ? $keranjang->detailKeranjangs()->sum('qty') : 0;
        }

        return response()->json(['cartCount' => $count]);
    }

    public function appliedPromo(): ?Promo
    {
        $promoId = session('applied_promo_id');
        if (!$promoId) return null;

        return Promo::where('id_promo', $promoId)
            ->where('kuota', '>', 0)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_berakhir', '>=', now())
            ->first();
    }

    public function calculateDiscount(Promo $promo, int $subtotal): int
    {
        if ($subtotal <= 0) return 0;

        if ($promo->tipe_diskon === 'persen') {
            return min($subtotal, (int) floor($subtotal * $promo->nilai_diskon / 100));
        }

        return min($subtotal, (int) $promo->nilai_diskon);
    }
}
