<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Ekspedisi;
use App\Models\AlamatUser;
use App\Models\Notifikasi;
use App\Models\Pembayaran;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Status flow yang berurutan.
     */
    private const STATUS_FLOW = ['menunggu', 'diproses', 'dikirim', 'selesai'];

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
        $jumlahMenunggu = Pesanan::where('status_pesanan', 'menunggu')->count();

        return view('admin.orders', compact('pesanans', 'jumlahDiproses', 'jumlahDikirim', 'jumlahSelesai', 'jumlahMenunggu'));
    }

    /**
     * Update status pesanan secara berurutan (admin).
     * menunggu → diproses → dikirim → selesai
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status_pesanan' => ['required', 'in:menunggu,diproses,dikirim,selesai'],
        ]);

        $currentIndex = array_search($pesanan->status_pesanan, self::STATUS_FLOW);
        $newIndex = array_search($data['status_pesanan'], self::STATUS_FLOW);

        if ($pesanan->status_pesanan === 'menunggu' && (int) ($pesanan->pembayaran?->status_konfirmasi ?? 0) !== 1) {
            return redirect()
                ->route('admin.orders.index')
                ->with('error', 'Pembayaran harus diverifikasi sebelum pesanan diproses.');
        }

        // Hanya boleh maju satu langkah ke depan
        if ($newIndex !== $currentIndex + 1) {
            return redirect()
                ->route('admin.orders.index')
                ->with('error', 'Status hanya bisa diubah ke tahap berikutnya secara berurutan.');
        }

        $pesanan->update($data);
        $this->notifyCustomer(
            $pesanan->id_users,
            $this->statusNotificationTitle($pesanan->status_pesanan),
            $this->statusNotificationMessage($pesanan)
        );

        return redirect()
            ->route('admin.orders.index')
            ->with('status', 'Status pesanan #' . $pesanan->id_pesanan . ' berhasil diperbarui.');
    }

    /**
     * Customer: riwayat pesanan.
     */
    public function customerOrders()
    {
        $pesanans = Pesanan::with(['detailPesanans.produk', 'ekspedisi', 'pembayaran'])
            ->where('id_users', Auth::id())
            ->latest('tanggal_pesan')
            ->get();

        return view('customer.orders', compact('pesanans'));
    }

    /**
     * Customer: checkout dari keranjang.
     */
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $ids = array_keys($cart);
        $produks = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');

        $items = [];
        $subtotal = 0;
        foreach ($cart as $id => $qty) {
            if ($produks->has($id)) {
                $produk = $produks[$id];
                $lineTotal = $produk->harga * $qty;
                $subtotal += $lineTotal;
                $items[] = (object) [
                    'produk' => $produk,
                    'qty' => $qty,
                    'lineTotal' => $lineTotal,
                ];
            }
        }

        $appliedPromo = $this->appliedPromo();
        $discount = $appliedPromo ? $this->calculateDiscount($appliedPromo, $subtotal) : 0;
        $alamats = AlamatUser::where('id_users', Auth::id())->get();
        $ekspedisis = Ekspedisi::all();

        return view('customer.checkout', compact('items', 'subtotal', 'discount', 'appliedPromo', 'alamats', 'ekspedisis'));
    }

    /**
     * Customer: proses pesanan.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'id_alamat' => ['required', 'exists:alamat_users,id_alamat'],
            'id_ekspedisi' => ['required', 'exists:ekspedisis,id_ekspedisi'],
            'metode_pembayaran' => ['required', 'string'],
            'bukti_bayar' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $alamatMilikUser = AlamatUser::where('id_users', Auth::id())
            ->where('id_alamat', $request->id_alamat)
            ->exists();

        if (!$alamatMilikUser) {
            return back()->with('error', 'Alamat pengiriman tidak valid.')->withInput();
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $ids = array_keys($cart);
        $produks = Produk::whereIn('id_produk', $ids)->get()->keyBy('id_produk');
        $ekspedisi = Ekspedisi::findOrFail($request->id_ekspedisi);

        $subtotal = 0;
        $orderItems = [];
        foreach ($cart as $id => $qty) {
            if ($produks->has($id)) {
                $produk = $produks[$id];
                if ($produk->stok < $qty) {
                    return back()
                        ->with('error', 'Stok ' . $produk->nama_produk . ' tidak mencukupi.')
                        ->withInput();
                }
                $lineTotal = $produk->harga * $qty;
                $subtotal += $lineTotal;
                $orderItems[] = [
                    'id_produk' => $id,
                    'qty' => $qty,
                    'harga_beli' => $produk->harga,
                ];
            }
        }

        $ongkir = $ekspedisi->biaya_pengiriman ?? 0;
        $appliedPromo = $this->appliedPromo();
        $discount = $appliedPromo ? $this->calculateDiscount($appliedPromo, $subtotal) : 0;
        $promo = $appliedPromo ?: $this->defaultPromo();
        $totalBayar = max(0, $subtotal - $discount) + $ongkir;

        $createdPesanan = DB::transaction(function () use ($request, $subtotal, $discount, $ongkir, $totalBayar, $orderItems, $promo, $appliedPromo) {
            $pesanan = Pesanan::create([
                'id_users' => Auth::id(),
                'id_alamat' => $request->id_alamat,
                'id_promo' => $promo->id_promo,
                'id_ekspedisi' => $request->id_ekspedisi,
                'tanggal_pesan' => now(),
                'subtotal' => $subtotal,
                'diskon' => $discount,
                'no_resi' => '', // diupdate setelah id didapat
                'ongkos_kirim' => $ongkir,
                'total_bayar' => $totalBayar,
                'status_pesanan' => 'menunggu',
            ]);

            $pesanan->update(['no_resi' => 'RESI-' . $pesanan->id_pesanan]);

            $buktiFileName = null;
            if ($request->hasFile('bukti_bayar')) {
                $file = $request->file('bukti_bayar');
                $buktiFileName = 'pay-' . $pesanan->id_pesanan . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('payments', $buktiFileName, 'public');
            }

            \App\Models\Pembayaran::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_bayar' => $buktiFileName,
                'status_konfirmasi' => 0,
            ]);

            if ($appliedPromo) {
                $appliedPromo->decrement('kuota');
            }

            foreach ($orderItems as $item) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item['id_produk'],
                    'qty' => $item['qty'],
                    'harga_beli' => $item['harga_beli'],
                ]);

                // Kurangi stok
                Produk::where('id_produk', $item['id_produk'])
                    ->decrement('stok', $item['qty']);
            }

            return $pesanan;
        });

        $this->notifyCustomer(
            Auth::id(),
            'Pesanan Berhasil Dibuat',
            'Pesanan ' . $createdPesanan->no_resi . ' sudah diterima dan menunggu verifikasi pembayaran admin.'
        );

        // Kosongkan keranjang
        session()->forget('cart');
        session()->forget('applied_promo_id');

        return redirect()->route('customer.orders')->with('status', 'Pesanan berhasil dibuat! Pembayaran Anda akan segera diverifikasi oleh admin.');
    }

    public function updatePayment(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status_konfirmasi' => ['required', 'integer', 'in:0,1,2'],
        ]);

        if (!$pesanan->pembayaran) {
            return redirect()
                ->route('admin.orders.index')
                ->with('error', 'Data pembayaran untuk pesanan ini belum tersedia.');
        }

        if ((int) $pesanan->pembayaran->status_konfirmasi === 1) {
            return redirect()
                ->route('admin.orders.index')
                ->with('error', 'Pembayaran yang sudah diverifikasi tidak dapat diubah kembali.');
        }

        $pesanan->pembayaran->update($data);

        if ((int) $data['status_konfirmasi'] === 1 && $pesanan->status_pesanan === 'menunggu') {
            $pesanan->update(['status_pesanan' => 'diproses']);
            $this->notifyCustomer(
                $pesanan->id_users,
                'Pembayaran Terverifikasi',
                'Pembayaran untuk pesanan ' . $pesanan->no_resi . ' sudah diverifikasi. Pesanan Anda sedang diproses.'
            );
        } elseif ((int) $data['status_konfirmasi'] === 2) {
            $this->notifyCustomer(
                $pesanan->id_users,
                'Pembayaran Ditolak',
                'Bukti pembayaran untuk pesanan ' . $pesanan->no_resi . ' ditolak. Silakan hubungi admin toko.'
            );
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('status', 'Status pembayaran pesanan #' . $pesanan->id_pesanan . ' berhasil diperbarui.');
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

    private function defaultPromo(): Promo
    {
        return Promo::firstOrCreate(
            ['kode_voucher' => 'NO-VOUCHER'],
            [
                'tipe_diskon' => 'nominal',
                'nilai_diskon' => 0,
                'kuota' => 999999,
                'tanggal_mulai' => now()->subYear(),
                'tanggal_berakhir' => now()->addYears(10),
            ]
        );
    }

    private function notifyCustomer(int $userId, string $title, string $message): void
    {
        Notifikasi::create([
            'id_users' => $userId,
            'judul' => $title,
            'pesan' => $message,
            'is_read' => 0,
        ]);
    }

    private function statusNotificationTitle(string $status): string
    {
        return match ($status) {
            'dikirim' => 'Pesanan Dikirim',
            'selesai' => 'Pesanan Selesai',
            'diproses' => 'Pesanan Diproses',
            default => 'Status Pesanan Diperbarui',
        };
    }

    private function statusNotificationMessage(Pesanan $pesanan): string
    {
        return match ($pesanan->status_pesanan) {
            'dikirim' => 'Pesanan ' . $pesanan->no_resi . ' sedang dalam proses pengiriman.',
            'selesai' => 'Pesanan ' . $pesanan->no_resi . ' sudah selesai. Terima kasih sudah berbelanja.',
            'diproses' => 'Pesanan ' . $pesanan->no_resi . ' sedang diproses oleh admin.',
            default => 'Status pesanan ' . $pesanan->no_resi . ' telah diperbarui.',
        };
    }
}
