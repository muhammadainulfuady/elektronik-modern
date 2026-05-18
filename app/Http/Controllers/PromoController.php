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
        $this->notifyCustomers(
            'Promo Baru: ' . $data['kode_voucher'],
            'Gunakan voucher ' . $data['kode_voucher'] . ' untuk mendapatkan diskon ' . $this->discountLabel($data) . '.'
        );

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
        if ($promo->pesanans()->exists()) {
            return redirect()
                ->route('admin.promos.index')
                ->with('error', 'Promo tidak bisa dihapus karena sudah dipakai pesanan.');
        }

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
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_berakhir' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
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
