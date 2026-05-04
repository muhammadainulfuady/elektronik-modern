<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use App\Models\Ulasan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    private function buildImageFilename(string $namaProduk, string $extension): string
    {
        $suffix = '-' . Str::random(8) . '.' . $extension;
        $base = Str::slug($namaProduk);
        $base = $base !== '' ? $base : 'produk';
        $maxBase = 50 - strlen($suffix);
        $base = $maxBase > 0 ? Str::limit($base, $maxBase, '') : 'p';

        return $base . $suffix;
    }

    /**
     * Halaman utama / landing page.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        $produkBaru = Produk::with('kategori')->latest('id_produk')->take(4)->get();
        $kategoris = Kategori::withCount('produks')->get();
        $jumlahProduk = Produk::count();
        $jumlahUser = User::count();
        $rating = Ulasan::avg('rating') ?? 0;
        $produkTerlaris = DetailPesanan::query()
            ->select('id_produk')
            ->selectRaw('SUM(qty) as total_terjual')
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', 'dikirim');
            })
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->with('produk.kategori')
            ->take(8)
            ->get();
        return view('index', compact('produks', 'produkBaru', 'kategoris', 'jumlahProduk', 'jumlahUser', 'rating', 'produkTerlaris'));
    }

    /**
     * Halaman katalog produk dengan filter.
     */
    public function catalog(Request $request)
    {
        $kategoris = Kategori::withCount('produks')->orderBy('nama_kategori')->get();

        $query = Produk::with('kategori');

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Search by name
        if ($request->filled('q')) {
            $query->where('nama_produk', 'like', '%' . $request->q . '%');
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        $query = match ($sort) {
            'termurah'  => $query->orderBy('harga', 'asc'),
            'termahal'  => $query->orderBy('harga', 'desc'),
            'nama'      => $query->orderBy('nama_produk', 'asc'),
            default     => $query->latest('id_produk'),
        };

        $produks = $query->paginate(12)->appends($request->query());

        return view('products.index', compact('produks', 'kategoris'));
    }

    /**
     * Halaman detail produk.
     */
    public function show(Produk $produk)
    {
        $produk->load(['kategori', 'ulasans.user']);
        $produkTerkait = Produk::with('kategori')
            ->where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $produk->id_produk)
            ->take(4)
            ->get();

        return view('products.detail', compact('produk', 'produkTerkait'));
    }

    /**
     * Admin: daftar produk.
     */
    public function adminIndex()
    {
        $produks = Produk::with('kategori')->latest('id_produk')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.products', compact('produks', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => ['required', 'integer', 'exists:kategoris,id_kategori'],
            'nama_produk' => ['required', 'string', 'max:50'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $extension = $request->file('gambar')->getClientOriginalExtension();
        $filename = $this->buildImageFilename($data['nama_produk'], $extension);
        $request->file('gambar')->storeAs('products', $filename, 'public');
        $data['gambar'] = $filename;

        Produk::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.products-edit', compact('produk', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'id_kategori' => ['required', 'integer', 'exists:kategoris,id_kategori'],
            'nama_produk' => ['required', 'string', 'max:50'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete('products/' . $produk->gambar);
            }

            $extension = $request->file('gambar')->getClientOriginalExtension();
            $filename = $this->buildImageFilename($data['nama_produk'], $extension);
            $request->file('gambar')->storeAs('products', $filename, 'public');
            $data['gambar'] = $filename;
        } else {
            unset($data['gambar']);
        }

        $produk->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete('products/' . $produk->gambar);
        }

        $produk->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil dihapus.');
    }
}
