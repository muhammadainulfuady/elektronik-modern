@extends('layouts.app')

@section('title', 'Kelola Promo - Admin Elektronik Modern')

@section('head')
@endsection

@section('header')
@endsection

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen bg-g50">
        @include('partials.admin-sidebar')

        <div class="flex-1 w-full min-w-0 flex flex-col p-6 md:p-8 overflow-y-auto h-screen relative">
            <div class="flex justify-between items-center mb-8 pt-12 md:pt-0">
                <h1 class="font-heading text-[24px] font-extrabold text-g900">Kelola Promo</h1>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-g100 mb-8">
                <div class="p-6 border-b border-g100">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-badge-percent text-primary"></i> Tambah Promo
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.promos.store') }}" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-[1.2fr_1fr_1fr_1fr] gap-4 mb-4">
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Kode Voucher</label>
                            <input name="kode_voucher" value="{{ old('kode_voucher') }}" required placeholder="HEMAT50"
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-bold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 uppercase placeholder:normal-case">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Tipe Diskon</label>
                            <select name="tipe_diskon" required
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 cursor-pointer">
                                <option value="persen" @selected(old('tipe_diskon') === 'persen')>Persen (%)</option>
                                <option value="nominal" @selected(old('tipe_diskon') === 'nominal')>Nominal (Rp)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Nilai Diskon</label>
                            <input type="number" name="nilai_diskon" min="1" value="{{ old('nilai_diskon') }}" required
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Kuota</label>
                            <input type="number" name="kuota" min="0" value="{{ old('kuota', 10) }}" required
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-4 items-end">
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Tanggal Mulai</label>
                            <input type="datetime-local" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-g700 tracking-widest uppercase mb-1.5">Tanggal Berakhir</label>
                            <input type="datetime-local" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}"
                                required min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full py-2.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-g50 transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10">
                        </div>
                        <button type="submit" class="inline-flex py-2.5 px-5 bg-primary text-white rounded-lg font-bold text-[13px] shadow-sm hover:bg-primary-dark hover:-translate-y-px transition-all items-center justify-center gap-2 h-[42px]">
                            <i class="fi fi-rr-disk"></i> Simpan Promo
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-g100">
                <div class="p-6 border-b border-g100 flex justify-between items-center">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-ticket text-primary"></i> Daftar Promo
                    </h3>
                    <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-2.5 rounded text-[11px] font-extrabold tracking-widest uppercase">{{ $promos->count() }} promo</span>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full min-w-[900px] text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Kode</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Diskon</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Periode</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Kuota</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Status</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($promos as $promo)
                                @php
                                    $mulai = \Illuminate\Support\Carbon::parse($promo->tanggal_mulai);
                                    $akhir = \Illuminate\Support\Carbon::parse($promo->tanggal_berakhir);
                                    $aktif = $promo->kuota > 0 &&
                                        now()->greaterThanOrEqualTo($mulai) &&
                                        now()->lessThanOrEqualTo($akhir);
                                @endphp
                                <tr class="group hover:bg-g50/50 transition-colors">
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <form id="promo-{{ $promo->id_promo }}" method="POST" action="{{ route('admin.promos.update', $promo) }}" class="m-0">
                                            @csrf @method('PUT')
                                        </form>
                                        <input form="promo-{{ $promo->id_promo }}" name="kode_voucher"
                                            value="{{ old('kode_voucher', $promo->kode_voucher) }}" required
                                            class="w-full min-w-[120px] py-2 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-bold text-g900 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 uppercase">
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="flex gap-2">
                                            <select form="promo-{{ $promo->id_promo }}" name="tipe_diskon" required
                                                class="py-2 px-2 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-semibold text-g800 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10">
                                                <option value="persen" @selected(old('tipe_diskon', $promo->tipe_diskon) === 'persen')>%</option>
                                                <option value="nominal" @selected(old('tipe_diskon', $promo->tipe_diskon) === 'nominal')>Rp</option>
                                            </select>
                                            <input form="promo-{{ $promo->id_promo }}" type="number" name="nilai_diskon" min="1"
                                                value="{{ old('nilai_diskon', $promo->nilai_diskon) }}" required
                                                class="w-[100px] py-2 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-bold text-g900 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="flex flex-col gap-2">
                                            <input type="datetime-local" name="tanggal_mulai" form="promo-{{ $promo->id_promo }}"
                                                value="{{ old('tanggal_mulai', $mulai->format('Y-m-d\TH:i')) }}" required
                                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                                class="w-full py-1.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[11px] font-semibold text-g800 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10">
                                            <input type="datetime-local" name="tanggal_berakhir" form="promo-{{ $promo->id_promo }}"
                                                value="{{ old('tanggal_berakhir', $akhir->format('Y-m-d\TH:i')) }}" required
                                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                                class="w-full py-1.5 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[11px] font-semibold text-g800 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <input form="promo-{{ $promo->id_promo }}" type="number" name="kuota" min="0"
                                            value="{{ old('kuota', $promo->kuota) }}" required
                                            class="w-[80px] py-2 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-bold text-g900 bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 text-center">
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <span class="inline-flex items-center gap-1.5 {{ $aktif ? 'text-green-600 bg-green-50' : 'text-red-500 bg-red-50' }} py-1 px-2.5 rounded-lg text-[11px] font-extrabold tracking-widest uppercase">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $aktif ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $aktif ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="submit" form="promo-{{ $promo->id_promo }}" class="inline-flex py-1.5 px-3 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg font-bold text-[12px] hover:bg-blue-600 hover:text-white transition-colors items-center gap-1.5">
                                                <i class="fi fi-rr-disk"></i> Simpan
                                            </button>
                                            <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" onsubmit="return confirm('Hapus promo ini?')" class="m-0">
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
                                    <td colspan="6" class="py-8 px-6 text-center text-g500 font-semibold text-[13px]">
                                        Belum ada promo terdaftar.
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