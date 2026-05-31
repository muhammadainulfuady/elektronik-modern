<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderByDesc('tanggal_mulai')->get();

        return view('admin.promos', compact('promos'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['kode_voucher'] = strtoupper($data['kode_voucher']);

        Promo::create($data);

        // Hanya kirim notifikasi jika promo sudah aktif saat ini
        if (now()->greaterThanOrEqualTo($data['tanggal_mulai'])) {
            $this->notifyCustomers(
                'Promo Baru: ' . $data['kode_voucher'],
                'Gunakan voucher ' . $data['kode_voucher'] . ' untuk mendapatkan diskon ' . $this->discountLabel($data) . '.'
            );
        }

        return redirect()
            ->route('admin.promos.index')
            ->with('status', 'Promo berhasil ditambahkan.');
    }

    public function update(Request $request, Promo $promo)
    {
        $data = $this->validatedData($request, $promo);
        $data['kode_voucher'] = strtoupper($data['kode_voucher']);

        $promo->update($data);

        return redirect()
            ->route('admin.promos.index')
            ->with('status', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()
            ->route('admin.promos.index')
            ->with('status', 'Promo berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Promo $promo = null): array
    {
        return $request->validate([
            'kode_voucher' => [
                'required',
                'string',
                'max:50',
                Rule::unique('promos', 'kode_voucher')->ignore($promo?->id_promo, 'id_promo'),
            ],
            'tipe_diskon' => ['required', 'in:persen,nominal'],
            'nilai_diskon' => ['required', 'integer', 'min:1'],
            'kuota' => ['required', 'integer', 'min:0'],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_berakhir' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
        ], [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
        ]);
    }

    private function notifyCustomers(string $title, string $message): void
    {
        $notifications = User::where('role', 'customer')
            ->pluck('id_users')
            ->map(fn ($userId) => [
                'id_users' => $userId,
                'judul' => $title,
                'pesan' => $message,
                'is_read' => 0,
            ])
            ->all();

        if (!empty($notifications)) {
            Notifikasi::insert($notifications);
        }
    }

    private function discountLabel(array $promo): string
    {
        if ($promo['tipe_diskon'] === 'persen') {
            return $promo['nilai_diskon'] . '%';
        }

        return 'Rp ' . number_format((int) $promo['nilai_diskon'], 0, ',', '.');
    }
}
