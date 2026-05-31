@extends('layouts.app')

@section('title', 'Admin Dashboard – Elektronik Modern')

@section('head')
@endsection

@section('header')
@endsection

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen bg-g50">
        @include('partials.admin-sidebar')

        <div class="flex-1 w-full min-w-0 flex flex-col p-6 md:p-8 overflow-y-auto h-screen relative">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8 pt-12 md:pt-0">
                <div class="flex flex-col md:flex-row md:items-center gap-4 w-full justify-between">
                    <div>
                        <div class="text-[13px] text-g500 mb-0.5">Selamat datang kembali,</div>
                        <h1 class="font-heading text-[24px] font-extrabold text-g900">Dashboard Admin</h1>
                    </div>
                    <div class="flex flex-wrap gap-3 items-center">
                        <form action="{{ route('admin.report.download') }}" method="GET" class="flex items-center gap-2 bg-white p-1.5 rounded-xl border border-g200 shadow-sm">
                            <select name="bulan" class="bg-transparent border-none text-[12px] font-bold text-g700 outline-none pr-6">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" @selected(now()->month == $m)>{{ date('F', mktime(0,0,0,$m,10)) }}</option>
                                @endforeach
                            </select>
                            <select name="tahun" class="bg-transparent border-none text-[12px] font-bold text-g700 outline-none pr-6">
                                @foreach(range(now()->year-2, now()->year) as $y)
                                    <option value="{{ $y }}" @selected(now()->year == $y)>{{ $y }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-primary text-white p-2 rounded-lg hover:bg-primary-dark transition-colors flex items-center gap-1.5 text-[12px] font-bold">
                                <i class="fi fi-rr-download"></i> Laporan PDF
                            </button>
                        </form>
                        <span class="inline-flex items-center gap-2 py-2 px-4 bg-white border border-g200 rounded-xl text-[13px] font-bold text-g700 shadow-sm">
                            <i class="fi fi-rr-calendar text-primary"></i> {{ now()->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <x-card class="p-6 flex items-center gap-4 hover:-translate-y-1 transition-all cursor-default">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-blue-50 text-blue-600"><i class="fi fi-rr-box"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Produk</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $jumlahProduk }}</div>
                    </div>
                </x-card>
                <x-card class="p-6 flex items-center gap-4 hover:-translate-y-1 transition-all cursor-default">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-green-50 text-green-600"><i class="fi fi-rr-users"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Customer</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $jumlahUser }}</div>
                    </div>
                </x-card>
                <x-card class="p-6 flex items-center gap-4 hover:-translate-y-1 transition-all cursor-default">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-orange-50 text-orange-600"><i class="fi fi-rr-time-fast"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Perlu Konfirmasi</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $jumlahMenungguKonfirmasi }}</div>
                        <div class="text-[11px] font-semibold text-orange-600 mt-1">Pesanan tertunda</div>
                    </div>
                </x-card>
                <x-card class="p-6 flex items-center gap-4 hover:-translate-y-1 transition-all cursor-default">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-teal-50 text-teal-600"><i class="fi fi-rr-check-circle"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Pesanan Selesai</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $pesananSelesai }}</div>
                    </div>
                </x-card>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <x-card class="lg:col-span-2 flex flex-col p-0 overflow-hidden">
                    <div class="p-6 border-b border-g100 flex justify-between items-center bg-white">
                        <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                            <i class="fi fi-rr-chart-line-up text-primary"></i> Pesanan 7 Hari Terakhir
                        </h3>
                        <x-badge variant="primary" class="uppercase tracking-widest text-[11px] py-1 px-2.5 bg-blue-50 border border-blue-100 text-blue-600">{{ $pesanan_tujuh_hari_terakhir }} pesanan</x-badge>
                    </div>
                    <div class="p-6 flex-1 flex items-end bg-white">
                        <div class="flex items-end gap-2 h-[160px] w-full px-1">
                            @php $days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min']; $heights = [55,72,48,83,91,65,38]; @endphp
                            @foreach($days as $i => $day)
                                <div class="flex flex-col items-center gap-2 flex-1 group">
                                    <div class="w-full rounded-t-lg {{ $i >= 5 ? 'bg-g300' : 'bg-primary' }} min-h-[4px] transition-all duration-300 group-hover:opacity-80" style="height:{{ $heights[$i] }}%"></div>
                                    <div class="text-[10px] font-bold text-g500">{{ $day }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-card>
                
                <x-card class="flex flex-col p-0 overflow-hidden">
                    <div class="p-6 border-b border-g100 bg-white">
                        <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                            <i class="fi fi-rr-chart-histogram text-primary"></i> Status Pesanan
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col gap-4 bg-white">
                        @php
                            $total = max(1, ($statusPesanan->sum('total')));
                        @endphp
                        @foreach([
                            ['Menunggu', 'menunggu', 'bg-orange-500'],
                            ['Diproses', 'diproses', 'bg-blue-500'],
                            ['Dikirim', 'dikirim', 'bg-purple-500'],
                            ['Selesai', 'selesai', 'bg-green-500'],
                        ] as [$label, $key, $colorClass])
                            @php $val = $statusPesanan->get($key, 0); @endphp
                            <div>
                                <div class="flex justify-between text-[13px] mb-1.5">
                                    <span class="text-g600 font-semibold">{{ $label }}</span>
                                    <strong class="text-g900">{{ $val }}</strong>
                                </div>
                                <div class="h-1.5 bg-g100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $colorClass }} rounded-full" style="width:{{ round($val/$total*100) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            </div>

            <!-- Recent Orders -->
            <x-card class="p-0 overflow-hidden">
                <div class="p-6 border-b border-g100 flex justify-between items-center flex-wrap gap-4 bg-white">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-document text-primary"></i> Pesanan Terbaru
                    </h3>
                    <x-button variant="outline" onclick="window.location='{{ route('admin.orders.index') }}'" class="py-1.5 px-4 text-[12px]">
                        Lihat Semua <i class="fi fi-rr-arrow-right"></i>
                    </x-button>
                </div>
                <div class="overflow-x-auto w-full bg-white">
                    <table class="w-full min-w-[700px] text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">No. Resi</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Pelanggan</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Total</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Status</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesananTerbaru as $pesanan)
                                <tr class="group hover:bg-g50/50 transition-colors">
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-extrabold text-g900 text-[14px]">{{ $pesanan->no_resi }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-semibold text-g700 text-[13px]">{{ $pesanan->user->nama ?? '-' }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-heading font-extrabold text-primary text-[15px] whitespace-nowrap">
                                            Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        @php
                                            $badgeClass = match ($pesanan->status_pesanan) {
                                                'menunggu' => 'warn',
                                                'diproses' => 'primary',
                                                'dikirim'  => 'success', /* using success for dikirim as per existing logic */
                                                'selesai'  => 'success',
                                                default    => 'g700',
                                            };
                                        @endphp
                                        <x-badge variant="{{ $badgeClass }}" class="py-1 px-2.5 uppercase tracking-widest text-[10px]">
                                            {{ ucfirst($pesanan->status_pesanan) }}
                                        </x-badge>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        @if ($pesanan->status_pesanan !== 'selesai')
                                            @php
                                                $nextStatus = match ($pesanan->status_pesanan) {
                                                    'menunggu' => 'diproses',
                                                    'diproses' => 'dikirim',
                                                    'dikirim'  => 'selesai',
                                                    default    => null,
                                                };
                                                $nextLabel = match ($nextStatus) {
                                                    'diproses' => 'Proses',
                                                    'dikirim'  => 'Kirim',
                                                    'selesai'  => 'Selesai',
                                                    default    => '',
                                                };
                                            @endphp
                                            @if ($nextStatus)
                                                <form method="POST" action="{{ route('admin.orders.updateStatus', $pesanan) }}" class="m-0">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status_pesanan" value="{{ $nextStatus }}">
                                                    <x-button type="submit" variant="secondary" class="py-1.5 px-3 text-[11px] bg-primary-light text-primary hover:bg-primary hover:text-white border border-primary/20 hover:border-primary">
                                                        {{ $nextLabel }} <i class="fi fi-rr-arrow-small-right"></i>
                                                    </x-button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[12px] font-bold text-green-600 bg-green-50 py-1.5 px-3 rounded-lg"><i class="fi fi-rr-check"></i> Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 px-6 text-center text-g500 font-semibold text-[13px]">
                                        Belum ada pesanan terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
@endsection

@section('footer')
@endsection