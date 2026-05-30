@extends('layouts.app')

@section('title', 'Kelola Produk – Admin Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="admin-layout">
        @include('partials.admin-sidebar')

        <div class="admin-main">
            <div class="admin-topbar">
                <div class="page-title">Kelola Produk</div>
            </div>

            @if (session('status'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px">
                    <strong>{{ session('status') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px">
                    <strong>Gagal menyimpan produk.</strong>
                    <div style="font-size:12px;color:var(--g500)">Cek kembali input yang wajib diisi.</div>
                    <ul style="margin:8px 0 0 16px;font-size:12px;color:var(--g500)">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="data-card" style="margin-bottom:16px">
                <div class="data-card-head">
                    <h3>Tambah Produk</h3>
                </div>
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
                    style="padding:16px;display:grid;gap:12px">
                    @csrf
                    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px">
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Nama Produk</label>
                            <input name="nama_produk" value="{{ old('nama_produk') }}" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('nama_produk') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('nama_produk')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Kategori</label>
                            <select name="id_kategori" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('id_kategori') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                                <option value="">Pilih kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}"
                                        @selected(old('id_kategori') == $kategori->id_kategori)>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Harga</label>
                            <input type="number" name="harga" min="0" value="{{ old('harga') }}" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('harga') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('harga')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Stok</label>
                            <input type="number" name="stok" min="0" value="{{ old('stok') }}" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('stok') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('stok')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Gambar Produk</label>
                            <input type="file" name="gambar" accept="image/*" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('gambar') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('gambar')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" required
                            style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('deskripsi') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Simpan Produk</button>
                    </div>
                </form>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3 style="display:flex;align-items:center;gap:8px"><i class="fi fi-rr-box" style="color:var(--blue)"></i> Daftar Produk</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $produk)
                            <tr>
                                <td style="color:var(--g400);font-size:12px">
                                    #P{{ str_pad((string) $produk->id_produk, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <img src="{{ asset('storage/products/' . $produk->gambar) }}"
                                            style="width:44px;height:44px;border-radius:8px;object-fit:cover"
                                            alt="{{ $produk->nama_produk }}" loading="lazy" decoding="async">
                                        <span style="font-weight:700;font-size:13px">{{ $produk->nama_produk }}</span>
                                    </div>
                                </td>
                                <td><span class="badge badge-info">{{ $produk->kategori->nama_kategori ?? '-' }}</span></td>
                                <td style="font-weight:800;font-family:'Syne',sans-serif">Rp
                                    {{ number_format($produk->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $produk->stok > 10 ? 'badge-success' : ($produk->stok > 0 ? 'badge-warn' : 'badge-danger') }}">
                                        {{ $produk->stok }} unit
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $produk->stok > 0 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $produk->stok > 0 ? 'Aktif' : 'Habis' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <a class="btn-edit" style="display:inline-flex;align-items:center;gap:4px" href="{{ route('admin.products.edit', $produk) }}"><i class="fi fi-rr-edit"></i> Edit</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $produk) }}"
                                            onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-del" type="submit" style="display:inline-flex;align-items:center;gap:4px"><i class="fi fi-rr-trash"></i> Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;color:var(--g400);padding:18px">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="padding:16px">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
