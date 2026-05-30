<?php

namespace App\Http\Controllers;

use App\Models\AlamatUser;
use App\Models\DetailPesanan;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Admin dashboard.
     */
    public function index()
    {
        // 1 query untuk semua jumlah status pesanan
        $statusCounts = Pesanan::selectRaw('status_pesanan, count(*) as total')
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan');

        $jumlahMenungguKonfirmasi = $statusCounts->get('menunggu', 0);
        $pesananDiproses          = $statusCounts->get('diproses', 0);
        $pesananDikirim           = $statusCounts->get('dikirim', 0);
        $pesananSelesai           = $statusCounts->get('selesai', 0);

        $jumlahUser   = User::where('role', 'customer')->count();
        $jumlahProduk = Produk::count();

        $statusPesanan = $statusCounts;

        $pesananTerbaru = Pesanan::with('user:id_users,nama,email')
            ->select('id_pesanan','id_users','no_resi','tanggal_pesan','status_pesanan','total_bayar')
            ->latest('tanggal_pesan')
            ->take(5)
            ->get();

        $pesanan_tujuh_hari_terakhir = Pesanan::where('tanggal_pesan', '>=', now()->subDays(7))->count();

        return view('admin.index', compact(
            'jumlahUser',
            'jumlahMenungguKonfirmasi',
            'pesananDiproses',
            'pesananDikirim',
            'pesananSelesai',
            'statusPesanan',
            'jumlahProduk',
            'pesananTerbaru',
            'pesanan_tujuh_hari_terakhir'
        ));
    }

    /**
     * Admin: daftar pengguna (hanya customer).
     */
    public function userList()
    {
        $users = User::where('role', 'customer')
            ->select('id_users', 'nama', 'email', 'role')
            ->withCount('pesanans')
            ->orderBy('id_users')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'customer';

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'Customer berhasil ditambahkan!');
    }

    public function editUser(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email,' . $user->id_users . ',id_users'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->nama = $data['nama'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'Customer berhasil diperbarui!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'Customer berhasil dihapus!');
    }

    /**
     * Owner dashboard.
     */
    public function ownerDashboard()
    {
        $jumlahCustomer = User::where('role', 'customer')->count();
        $jumlahAdmin    = User::where('role', 'admin')->count();
        $jumlahProduk   = Produk::count();

        // Gabungkan status count dalam 1 query
        $statusCounts = Pesanan::selectRaw('status_pesanan, count(*) as total')
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan');

        $jumlahMenunggu = $statusCounts->get('menunggu', 0);
        $jumlahDiproses = $statusCounts->get('diproses', 0);
        $jumlahDikirim  = $statusCounts->get('dikirim', 0);
        $jumlahSelesai  = $statusCounts->get('selesai', 0);
        $totalPesanan   = $statusCounts->sum();
        $statusPesanan  = $statusCounts;

        $totalPendapatan = Pesanan::where('status_pesanan', 'selesai')->sum('total_bayar');

        // Bulan ini dan bulan lalu dalam 1 aggregate query
        $now = now();
        $pesananBulanIni = Pesanan::whereYear('tanggal_pesan', $now->year)
            ->whereMonth('tanggal_pesan', $now->month)
            ->count();
        $pendapatanBulanIni = Pesanan::where('status_pesanan', 'selesai')
            ->whereYear('tanggal_pesan', $now->year)
            ->whereMonth('tanggal_pesan', $now->month)
            ->sum('total_bayar');
        $lastMonth = $now->copy()->subMonth();
        $pendapatanBulanLalu = Pesanan::where('status_pesanan', 'selesai')
            ->whereYear('tanggal_pesan', $lastMonth->year)
            ->whereMonth('tanggal_pesan', $lastMonth->month)
            ->sum('total_bayar');

        $persenPendapatan = $pendapatanBulanLalu > 0
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : ($pendapatanBulanIni > 0 ? 100 : 0);

        $rataRataTransaksi = Pesanan::where('status_pesanan', 'selesai')->avg('total_bayar') ?? 0;

        $pendapatanBulanan = Pesanan::selectRaw('MONTH(tanggal_pesan) as bulan, SUM(total_bayar) as total')
            ->where('status_pesanan', 'selesai')
            ->whereYear('tanggal_pesan', $now->year)
            ->groupByRaw('MONTH(tanggal_pesan)')
            ->pluck('total', 'bulan');

        $penjualanKategori = DetailPesanan::query()
            ->join('pesanans', 'detail_pesanans.id_pesanan', '=', 'pesanans.id_pesanan')
            ->join('produks', 'detail_pesanans.id_produk', '=', 'produks.id_produk')
            ->join('kategoris', 'produks.id_kategori', '=', 'kategoris.id_kategori')
            ->where('pesanans.status_pesanan', 'selesai')
            ->selectRaw('kategoris.nama_kategori, SUM(detail_pesanans.qty) as total_qty, SUM(detail_pesanans.qty * detail_pesanans.harga_beli) as total_nominal')
            ->groupBy('kategoris.id_kategori', 'kategoris.nama_kategori')
            ->orderByDesc('total_nominal')
            ->get();

        $produkTerlaris = DetailPesanan::with(['produk:id_produk,id_kategori,nama_produk,gambar,harga'])
            ->join('pesanans', 'detail_pesanans.id_pesanan', '=', 'pesanans.id_pesanan')
            ->where('pesanans.status_pesanan', 'selesai')
            ->select('detail_pesanans.id_produk')
            ->selectRaw('SUM(detail_pesanans.qty) as total_qty, SUM(detail_pesanans.qty * detail_pesanans.harga_beli) as total_nominal')
            ->groupBy('detail_pesanans.id_produk')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $pesananTerbaru = Pesanan::with('user:id_users,nama,email')
            ->select('id_pesanan','id_users','no_resi','tanggal_pesan','status_pesanan','total_bayar')
            ->latest('tanggal_pesan')
            ->take(10)
            ->get();

        return view('owner.index', compact(
            'jumlahCustomer',
            'jumlahAdmin',
            'jumlahProduk',
            'totalPendapatan',
            'pesananBulanIni',
            'pendapatanBulanIni',
            'pendapatanBulanLalu',
            'persenPendapatan',
            'rataRataTransaksi',
            'jumlahMenunggu',
            'jumlahDiproses',
            'jumlahDikirim',
            'jumlahSelesai',
            'totalPesanan',
            'statusPesanan',
            'pesananTerbaru',
            'pendapatanBulanan',
            'penjualanKategori',
            'produkTerlaris'
        ));
    }

    /**
     * Customer: tampilkan profil.
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('alamatUsers.dusun.desa.kecamatan.kota.provinsi');

        // Load hanya provinsi (level teratas) — kota/kecamatan/desa/dusun
        // dimuat secara dinamis via AJAX atau hanya yang terkait user
        $provinsis  = \App\Models\Provinsi::select('id_provinsi', 'nama_provinsi')->orderBy('nama_provinsi')->get();
        $kotas      = \App\Models\Kota::select('id_kota', 'id_provinsi', 'nama_kota')->get();
        $kecamatans = \App\Models\Kecamatan::select('id_kecamatan', 'id_kota', 'nama_kecamatan')->get();
        $desas      = \App\Models\Desa::select('id_desa', 'id_kecamatan', 'nama_desa')->get();
        $dusuns     = \App\Models\Dusun::select('id_dusun', 'id_desa', 'nama_dusun')->get();

        return view('customer.profile', compact('user', 'provinsis', 'kotas', 'kecamatans', 'desas', 'dusuns'));
    }

    /**
     * Customer: tambah alamat.
     */
    public function storeAlamat(Request $request)
    {
        $data = $request->validate([
            'label_alamat' => ['required', 'string', 'max:50'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'detail_alamat' => ['required', 'string'],
            'id_dusun' => ['required', 'exists:dusuns,id_dusun'],
        ]);
        
        $data['id_users'] = Auth::id();
        $data['is_utama'] = $request->has('is_utama') ? 1 : 0;

        if ($data['is_utama'] == 1) {
            \App\Models\AlamatUser::where('id_users', Auth::id())->update(['is_utama' => 0]);
        }

        \App\Models\AlamatUser::create($data);

        return redirect()->route('customer.profile')->with('status', 'Alamat berhasil ditambahkan!');
    }

    public function updateAlamat(Request $request, AlamatUser $alamatUser)
    {
        abort_unless($alamatUser->id_users === Auth::id(), 403);

        $data = $request->validate([
            'label_alamat' => ['required', 'string', 'max:50'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'detail_alamat' => ['required', 'string'],
            'id_dusun' => ['required', 'exists:dusuns,id_dusun'],
        ]);

        $data['is_utama'] = $request->has('is_utama') ? 1 : 0;

        if ($data['is_utama'] == 1) {
            AlamatUser::where('id_users', Auth::id())
                ->where('id_alamat', '!=', $alamatUser->id_alamat)
                ->update(['is_utama' => 0]);
        }

        $alamatUser->update($data);

        return redirect()->route('customer.profile', ['tab' => 'alamat'])->with('status', 'Alamat berhasil diperbarui!');
    }

    public function destroyAlamat(AlamatUser $alamatUser)
    {
        abort_unless($alamatUser->id_users === Auth::id(), 403);

        if ($alamatUser->pesanans()->exists()) {
            return redirect()
                ->route('customer.profile', ['tab' => 'alamat'])
                ->with('error', 'Alamat tidak bisa dihapus karena sudah dipakai pada pesanan.');
        }

        $alamatUser->delete();

        return redirect()->route('customer.profile', ['tab' => 'alamat'])->with('status', 'Alamat berhasil dihapus!');
    }

    /**
     * Customer: update profil.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email,' . $user->id_users . ',id_users'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->nama = $data['nama'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('customer.profile')->with('status', 'Profil berhasil diperbarui!');
    }
}
