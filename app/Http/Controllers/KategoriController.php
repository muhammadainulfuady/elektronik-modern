<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    private function buildIconFilename(string $namaKategori, string $extension): string
    {
        $suffix = '-' . Str::random(8) . '.' . $extension;
        $base = Str::slug($namaKategori);
        $base = $base !== '' ? $base : 'kategori';
        $maxBase = 150 - strlen($suffix);
        $base = $maxBase > 0 ? Str::limit($base, $maxBase, '') : 'k';

        return $base . $suffix;
    }

    public function index()
    {
        $kategoris = Kategori::withCount('produks')
            ->orderBy('nama_kategori')
            ->get();

        return view('admin.categories', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50', 'unique:kategoris,nama_kategori'],
            'ikon_kategori' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $extension = $request->file('ikon_kategori')->getClientOriginalExtension();
        $filename = $this->buildIconFilename($data['nama_kategori'], $extension);
        $request->file('ikon_kategori')->storeAs('categories', $filename, 'public');
        $data['ikon_kategori'] = $filename;

        Kategori::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50', 'unique:kategoris,nama_kategori,' . $kategori->id_kategori . ',id_kategori'],
            'ikon_kategori' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('ikon_kategori')) {
            if ($kategori->ikon_kategori) {
                Storage::disk('public')->delete('categories/' . $kategori->ikon_kategori);
            }

            $extension = $request->file('ikon_kategori')->getClientOriginalExtension();
            $filename = $this->buildIconFilename($data['nama_kategori'], $extension);
            $request->file('ikon_kategori')->storeAs('categories', $filename, 'public');
            $data['ikon_kategori'] = $filename;
        } else {
            unset($data['ikon_kategori']);
        }

        $kategori->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->produks()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai produk.');
        }

        if ($kategori->ikon_kategori) {
            Storage::disk('public')->delete('categories/' . $kategori->ikon_kategori);
        }

        $kategori->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil dihapus.');
    }
}
