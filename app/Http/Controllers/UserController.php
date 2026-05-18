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
        $jumlahUser = User::where('role', 'customer')->count();
        $jumlahMenungguKonfirmasi = Pesanan::where('status_pesanan', 'menunggu')->count();
        $pesananDiproses = Pesanan::where('status_pesanan', 'diproses')->count();
        $pesananDikirim = Pesanan::where('status_pesanan', 'dikirim')->count();
        $pesananSelesai = Pesanan::where('status_pesanan', 'selesai')->count();
        $statusPesanan = Pesanan::select('status_pesanan', \DB::raw('count(*) as total'))
            ->groupBy('status_pesanan')
            ->get();
        $jumlahProduk = Produk::count();
        $pesananTerbaru = Pesanan::with('user')->latest('tanggal_pesan')->take(5)->get();
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
            ->withCount('pesanans')
            ->orderBy('id_users')
            ->get();

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
        $jumlahAdmin = User::where('role', 'admin')->count();
        $jumlahProduk = Produk::count();

        $totalPendapatan = Pesanan::where('status_pesanan', 'selesai')->sum('total_bayar');
        $pesananBulanIni = Pesanan::whereMonth('tanggal_pesan', now()->month)
            ->whereYear('tanggal_pesan', now()->year)
            ->count();
        $pendapatanBulanIni = Pesanan::where('status_pesanan', 'selesai')
            ->whereMonth('tanggal_pesan', now()->month)
            ->whereYear('tanggal_pesan', now()->year)
            ->sum('total_bayar');
        $pendapatanBulanLalu = Pesanan::where('status_pesanan', 'selesai')
            ->whereMonth('tanggal_pesan', now()->subMonth()->month)
            ->whereYear('tanggal_pesan', now()->subMonth()->year)
            ->sum('total_bayar');
        $persenPendapatan = $pendapatanBulanLalu > 0
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : ($pendapatanBulanIni > 0 ? 100 : 0);

        $jumlahMenunggu = Pesanan::where('status_pesanan', 'menunggu')->count();
        $jumlahDiproses = Pesanan::where('status_pesanan', 'diproses')->count();
        $jumlahDikirim = Pesanan::where('status_pesanan', 'dikirim')->count();
        $jumlahSelesai = Pesanan::where('status_pesanan', 'selesai')->count();
        $totalPesanan = Pesanan::count();

        $statusPesanan = Pesanan::select('status_pesanan', \DB::raw('count(*) as total'))
            ->groupBy('status_pesanan')
            ->get();

        $pesananTerbaru = Pesanan::with('user')->latest('tanggal_pesan')->take(10)->get();
        $rataRataTransaksi = Pesanan::where('status_pesanan', 'selesai')->avg('total_bayar') ?? 0;
        $pendapatanBulanan = Pesanan::selectRaw('MONTH(tanggal_pesan) as bulan, SUM(total_bayar) as total')
            ->where('status_pesanan', 'selesai')
            ->whereYear('tanggal_pesan', now()->year)
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
        $produkTerlaris = DetailPesanan::with('produk.kategori')
            ->join('pesanans', 'detail_pesanans.id_pesanan', '=', 'pesanans.id_pesanan')
            ->where('pesanans.status_pesanan', 'selesai')
            ->select('detail_pesanans.id_produk')
            ->selectRaw('SUM(detail_pesanans.qty) as total_qty, SUM(detail_pesanans.qty * detail_pesanans.harga_beli) as total_nominal')
            ->groupBy('detail_pesanans.id_produk')
            ->orderByDesc('total_qty')
            ->take(5)
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
        
        $provinsis = \App\Models\Provinsi::all();
        $kotas = \App\Models\Kota::all();
        $kecamatans = \App\Models\Kecamatan::all();
        $desas = \App\Models\Desa::all();
        $dusuns = \App\Models\Dusun::all();

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
