@extends('layouts.app')

@section('title', 'Kelola Kategori - Admin Elektronik Modern')

@section('head')
@endsection

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen bg-g50">
        @include('partials.admin-sidebar')

        <div class="flex-1 w-full min-w-0 flex flex-col p-6 md:p-8 overflow-y-auto h-screen">
            <div class="flex justify-between items-center mb-8">
                <h1 class="font-heading text-[24px] font-extrabold text-g900">Kelola Kategori</h1>
            </div>

            @if (session('status'))
                <div class="bg-green-50 text-green-700 py-3 px-4 rounded-xl text-[13px] font-bold mb-6 flex items-center gap-2 border border-green-200">
                    <i class="fi fi-rr-check-circle text-lg"></i> {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 text-red-700 py-3 px-4 rounded-xl text-[13px] font-bold mb-6 flex items-center gap-2 border border-red-200">
                    <i class="fi fi-rr-triangle-warning text-lg"></i> {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-200">
                    <div class="font-bold flex items-center gap-2 mb-1 text-[14px]"><i class="fi fi-rr-triangle-warning"></i> Gagal menyimpan kategori.</div>
                    <ul class="list-disc pl-5 text-[12px] font-semibold space-y-1 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-g100 mb-8">
                <div class="p-6 border-b border-g100">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-layer-plus text-primary"></i> Tambah Kategori
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-4 items-end">
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Nama Kategori</label>
                            <input name="nama_kategori" value="{{ old('nama_kategori') }}" required
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Ikon Kategori</label>
                            <input type="file" name="ikon_kategori" accept="image/*,.svg" required
                                class="w-full py-2 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[12px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                        <button type="submit" class="inline-flex py-2.5 px-5 bg-primary text-white rounded-lg font-bold text-[13px] shadow-sm hover:bg-primary-dark hover:-translate-y-px transition-all items-center justify-center gap-2 h-[42px]">
                            <i class="fi fi-rr-disk"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-g100">
                <div class="p-6 border-b border-g100 flex justify-between items-center">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-tags text-primary"></i> Daftar Kategori
                    </h3>
                    <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-2.5 rounded text-[11px] font-extrabold tracking-widest uppercase">{{ $kategoris->count() }} kategori</span>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full min-w-[800px] text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">ID</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200 w-1/3">Kategori</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Ikon</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Jumlah Produk</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $kategori)
                                <tr class="group hover:bg-g50/50 transition-colors">
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-bold text-g400 text-[12px]">#K{{ str_pad((string) $kategori->id_kategori, 3, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <form id="category-{{ $kategori->id_kategori }}" method="POST" action="{{ route('admin.categories.update', $kategori) }}" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-2 m-0">
                                            @csrf @method('PUT')
                                            <input name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required
                                                class="w-full py-2 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10">
                                            <input type="file" name="ikon_kategori" accept="image/*,.svg"
                                                class="w-full py-1.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[11px] font-semibold text-g800 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                        </form>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        @php
                                            $iconExists = $kategori->ikon_kategori && \Illuminate\Support\Facades\Storage::disk('public')->exists('categories/' . $kategori->ikon_kategori);
                                        @endphp
                                        <div class="flex items-center gap-3">
                                            @if ($iconExists)
                                                <div class="w-10 h-10 rounded-lg bg-white border border-g100 p-1 flex items-center justify-center shrink-0">
                                                    <img src="{{ asset('storage/categories/' . $kategori->ikon_kategori) }}"
                                                        alt="{{ $kategori->nama_kategori }}"
                                                        class="w-full h-full object-contain mix-blend-multiply"
                                                        loading="lazy" decoding="async">
                                                </div>
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-g50 border border-g100 flex items-center justify-center shrink-0 text-primary text-xl">
                                                    <i class="fi {{ $kategori->fallback_icon }}"></i>
                                                </div>
                                            @endif
                                            <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-2 rounded text-[10px] font-bold tracking-wider max-w-[120px] truncate">{{ $kategori->ikon_kategori ?? 'Tidak ada ikon' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="text-[13px] font-semibold text-g600"><strong class="text-g900 font-extrabold">{{ $kategori->produks_count }}</strong> produk</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="submit" form="category-{{ $kategori->id_kategori }}" class="inline-flex py-1.5 px-3 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg font-bold text-[12px] hover:bg-blue-600 hover:text-white transition-colors items-center gap-1.5">
                                                <i class="fi fi-rr-disk"></i> Simpan
                                            </button>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex py-1.5 px-3 bg-red-50 text-red-600 border border-red-100 rounded-lg font-bold text-[12px] hover:bg-red-600 hover:text-white transition-colors items-center gap-1.5">
                                                    <i class="fi fi-rr-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-6 text-center text-g500 font-semibold text-[13px]">
                                        Belum ada kategori terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
