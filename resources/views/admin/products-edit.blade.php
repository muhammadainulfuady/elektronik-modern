@extends('layouts.app')

@section('title', 'Edit Produk – Admin Elektronik Modern')

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
                <div class="page-title">Edit Produk</div>
            </div>

            @if ($errors->any())
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px">
                    <strong>Gagal memperbarui produk.</strong>
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
                    <h3>Form Edit Produk</h3>
                </div>
                <form method="POST" action="{{ route('admin.products.update', $produk) }}" enctype="multipart/form-data"
                    style="padding:16px;display:grid;gap:12px">
                    @csrf
                    @method('PUT')
                    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px">
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Nama Produk</label>
                            <input name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required
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
                                        @selected(old('id_kategori', $produk->id_kategori) == $kategori->id_kategori)>
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
                            <input type="number" name="harga" min="0" value="{{ old('harga', $produk->harga) }}" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('harga') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('harga')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Stok</label>
                            <input type="number" name="stok" min="0" value="{{ old('stok', $produk->stok) }}" required
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('stok') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('stok')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Gambar Produk (opsional)</label>
                            <input type="file" name="gambar" accept="image/*"
                                style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('gambar') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">
                            @error('gambar')
                                <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" required
                            style="width:100%;padding:10px 12px;border:1px solid {{ $errors->has('deskripsi') ? '#ef4444' : 'var(--g200)' }};border-radius:10px">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div style="margin-top:6px;font-size:12px;color:#ef4444">{{ $message }}</div>
                        @enderror
                    </div>
                    <div style="display:flex;gap:8px">
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
