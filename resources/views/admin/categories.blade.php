@extends('layouts.app')

@section('title', 'Kelola Kategori - Admin Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('content')
    <div class="admin-layout">
        @include('partials.admin-sidebar')

        <div class="admin-main">
            <div class="admin-topbar">
                <div class="page-title">Kelola Kategori</div>
            </div>

            @if (session('status'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--sl);color:#15803D">
                    <strong>{{ session('status') }}</strong>
                </div>
            @endif
            @if (session('error'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--dl);color:#991B1B">
                    <strong>{{ session('error') }}</strong>
                </div>
            @endif
            @if ($errors->any())
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--dl);color:#991B1B">
                    <strong>Gagal menyimpan kategori.</strong>
                    <ul style="margin:8px 0 0 16px;font-size:12px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="data-card" style="margin-bottom:16px">
                <div class="data-card-head"><h3>Tambah Kategori</h3></div>
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" style="padding:16px;display:grid;grid-template-columns:1fr 1fr auto;gap:12px;align-items:end">
                    @csrf
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Nama Kategori</label>
                        <input name="nama_kategori" value="{{ old('nama_kategori') }}" required
                            style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                    </div>
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Ikon Kategori</label>
                        <input type="file" name="ikon_kategori" accept="image/*,.svg" required
                            style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Kategori</h3>
                    <span class="badge badge-info">{{ $kategoris->count() }} kategori</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Ikon</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $kategori)
                            <tr>
                                <td style="color:var(--g400);font-size:12px">#K{{ str_pad((string) $kategori->id_kategori, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <form id="category-{{ $kategori->id_kategori }}" method="POST" action="{{ route('admin.categories.update', $kategori) }}" enctype="multipart/form-data" style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                                        @csrf @method('PUT')
                                        <input name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                        <input type="file" name="ikon_kategori" accept="image/*,.svg"
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                    </form>
                                </td>
                                <td>
                                    @php
                                        $iconExists = $kategori->ikon_kategori && \Illuminate\Support\Facades\Storage::disk('public')->exists('categories/' . $kategori->ikon_kategori);
                                    @endphp
                                    <div style="display:flex;align-items:center;gap:8px">
                                        @if ($iconExists)
                                            <img src="{{ asset('storage/categories/' . $kategori->ikon_kategori) }}"
                                                alt="{{ $kategori->nama_kategori }}"
                                                style="width:36px;height:36px;border-radius:8px;object-fit:cover;border:1px solid var(--g200)"
                                                loading="lazy" decoding="async">
                                        @endif
                                        <span class="badge badge-info">{{ $kategori->ikon_kategori }}</span>
                                    </div>
                                </td>
                                <td><strong>{{ $kategori->produks_count }}</strong> produk</td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <button class="btn-edit" type="submit" form="category-{{ $kategori->id_kategori }}">Simpan</button>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn-del" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--g400);padding:18px">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
