@extends('layouts.app')

@section('title', 'Owner Dashboard – Elektronik Modern')

@section('head')
@endsection

@section('header')
@endsection

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen bg-g50">
        @include('partials.owner-sidebar')

        <div class="flex-1 w-full min-w-0 flex flex-col p-6 md:p-8 overflow-y-auto h-screen relative">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8 pt-12 md:pt-0">
                <div class="flex flex-col md:flex-row md:items-center gap-4 w-full justify-between">
                    <div>
                        <div class="text-[13px] text-g500 mb-0.5">Selamat datang,</div>
                        <h1 class="font-heading text-[24px] font-extrabold text-g900">Dashboard Owner</h1>
                    </div>
                    <div class="flex flex-wrap gap-3 items-center">
                        <form action="{{ route('owner.report.download') }}" method="GET" class="flex items-center gap-2 bg-white p-1.5 rounded-xl border border-g200 shadow-sm">
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

            <!-- Revenue Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div class="bg-gradient-to-br from-primary to-blue-500 rounded-2xl p-7 text-white relative overflow-hidden shadow-[0_8px_24px_rgba(26,92,255,0.25)]">
                    <div class="absolute w-[200px] h-[200px] rounded-full bg-white/10 -top-20 -right-16"></div>
                    <div class="text-[13px] font-semibold text-white/80 mb-1.5 flex items-center gap-2"><i class="fi fi-rr-sack-dollar"></i> Total Pendapatan</div>
                    <div class="font-heading text-[36px] font-extrabold mb-1 tracking-tight">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="text-[12px] text-white/70">Dari {{ $jumlahSelesai }} pesanan selesai</div>
                </div>
                <div class="bg-gradient-to-br from-teal-500 to-emerald-400 rounded-2xl p-7 text-white relative overflow-hidden shadow-[0_8px_24px_rgba(20,184,166,0.25)]">
                    <div class="absolute w-[200px] h-[200px] rounded-full bg-white/10 -top-20 -right-16"></div>
                    <div class="text-[13px] font-semibold text-white/80 mb-1.5 flex items-center gap-2"><i class="fi fi-rr-chart-line-up"></i> Pendapatan Bulan Ini</div>
                    <div class="font-heading text-[36px] font-extrabold mb-1 tracking-tight">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                    <div class="text-[12px] text-white/70">{{ $pesananBulanIni }} pesanan bulan ini · {{ $persenPendapatan >= 0 ? '+' : '' }}{{ $persenPendapatan }}% dari bulan lalu</div>
                </div>
                <div class="bg-gradient-to-br from-violet-600 to-purple-500 rounded-2xl p-7 text-white relative overflow-hidden shadow-[0_8px_24px_rgba(124,58,237,0.25)]">
                    <div class="absolute w-[200px] h-[200px] rounded-full bg-white/10 -top-20 -right-16"></div>
                    <div class="text-[13px] font-semibold text-white/80 mb-1.5 flex items-center gap-2"><i class="fi fi-rr-receipt"></i> Rata-rata Transaksi</div>
                    <div class="font-heading text-[36px] font-extrabold mb-1 tracking-tight">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</div>
                    <div class="text-[12px] text-white/70">Dihitung dari pesanan selesai</div>
                </div>
                <div class="bg-gradient-to-br from-slate-900 to-slate-700 rounded-2xl p-7 text-white relative overflow-hidden shadow-[0_8px_24px_rgba(15,23,42,0.25)]">
                    <div class="absolute w-[200px] h-[200px] rounded-full bg-white/10 -top-20 -right-16"></div>
                    <div class="text-[13px] font-semibold text-white/80 mb-1.5 flex items-center gap-2"><i class="fi fi-rr-briefcase"></i> Pendapatan Bulan Lalu</div>
                    <div class="font-heading text-[36px] font-extrabold mb-1 tracking-tight">Rp {{ number_format($pendapatanBulanLalu, 0, ',', '.') }}</div>
                    <div class="text-[12px] text-white/70">Pembanding performa bulan berjalan</div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-blue-50 text-blue-600"><i class="fi fi-rr-box"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Produk</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $jumlahProduk }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-green-50 text-green-600"><i class="fi fi-rr-users"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Customer</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $jumlahCustomer }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-teal-50 text-teal-600"><i class="fi fi-rr-shield-check"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Admin</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $jumlahAdmin }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-g100 flex items-center gap-4 hover:shadow-card transition-shadow">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 bg-orange-50 text-orange-600"><i class="fi fi-rr-receipt"></i></div>
                    <div>
                        <div class="text-[12px] font-bold text-g500 uppercase tracking-wider mb-1">Total Pesanan</div>
                        <div class="font-heading text-2xl font-extrabold text-g900">{{ $totalPesanan }}</div>
                    </div>
                </div>
            </div>

            <!-- Order Status Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-g100 flex flex-col">
                    <div class="p-6 border-b border-g100">
                        <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                            <i class="fi fi-rr-chart-histogram text-primary"></i> Status Pesanan
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        @php
                            $total = max(1, $totalPesanan);
                            $statusData = [
                                ['Menunggu', $jumlahMenunggu, 'bg-violet-600'],
                                ['Diproses', $jumlahDiproses, 'bg-blue-600'],
                                ['Dikirim', $jumlahDikirim, 'bg-teal-500'],
                                ['Selesai', $jumlahSelesai, 'bg-green-600'],
                            ];
                        @endphp
                        @foreach($statusData as [$label, $val, $colorClass])
                            <div>
                                <div class="flex justify-between text-[13px] mb-1.5">
                                    <span class="font-semibold text-g700">{{ $label }}</span>
                                    <strong class="text-g900">{{ $val }}</strong>
                                </div>
                                <div class="h-2 bg-g100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $colorClass }} rounded-full" style="width:{{ round($val/$total*100) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-g100 flex flex-col">
                    <div class="p-6 border-b border-g100">
                        <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                            <i class="fi fi-rr-document text-primary"></i> Ringkasan
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col gap-3">
                        <div class="flex justify-between items-center p-3 bg-g50 rounded-xl">
                            <span class="text-[13px] text-g600 flex items-center gap-2 font-medium"><i class="fi fi-rr-time-fast"></i> Menunggu Konfirmasi</span>
                            <span class="inline-flex items-center bg-orange-50 text-orange-600 border border-orange-200 py-1 px-3 rounded-lg text-[13px] font-extrabold">{{ $jumlahMenunggu }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-g50 rounded-xl">
                            <span class="text-[13px] text-g600 flex items-center gap-2 font-medium"><i class="fi fi-rr-settings"></i> Sedang Diproses</span>
                            <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-3 rounded-lg text-[13px] font-extrabold">{{ $jumlahDiproses }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-g50 rounded-xl">
                            <span class="text-[13px] text-g600 flex items-center gap-2 font-medium"><i class="fi fi-rr-truck-side"></i> Dalam Pengiriman</span>
                            <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-3 rounded-lg text-[13px] font-extrabold">{{ $jumlahDikirim }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-g50 rounded-xl">
                            <span class="text-[13px] text-g600 flex items-center gap-2 font-medium"><i class="fi fi-rr-check-circle"></i> Selesai</span>
                            <span class="inline-flex items-center bg-green-50 text-green-600 border border-green-200 py-1 px-3 rounded-lg text-[13px] font-extrabold">{{ $jumlahSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
                <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-g100 flex flex-col">
                    <div class="p-6 border-b border-g100">
                        <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                            <i class="fi fi-rr-coins text-primary"></i> Pendapatan Bulanan
                        </h3>
                    </div>
                    @php
                        $maxPendapatan = max(1, (int) collect($pendapatanBulanan)->max());
                        $bulanLabels = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
                    @endphp
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-end gap-2 h-[150px] w-full px-1 mb-3">
                            @foreach($bulanLabels as $bulan => $label)
                                @php $nilai = (int) ($pendapatanBulanan[$bulan] ?? 0); @endphp
                                <div title="{{ $label }}: Rp {{ number_format($nilai, 0, ',', '.') }}" class="flex-1 min-w-[14px] bg-gradient-to-t from-teal-500 to-primary rounded-t-md hover:opacity-80 transition-opacity cursor-pointer" style="height:{{ max(4, round($nilai / $maxPendapatan * 140)) }}px"></div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-12 gap-2 text-[10px] font-bold text-g500 text-center">
                            @foreach($bulanLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-g100 flex flex-col">
                    <div class="p-6 border-b border-g100">
                        <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                            <i class="fi fi-rr-tags text-primary"></i> Penjualan per Kategori
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        @php $totalKategori = max(1, (int) $penjualanKategori->sum('total_nominal')); @endphp
                        @forelse($penjualanKategori as $kategori)
                            @php $pct = round($kategori->total_nominal / $totalKategori * 100); @endphp
                            <div>
                                <div class="flex justify-between text-[13px] mb-1.5">
                                    <span class="font-bold text-g800">{{ $kategori->nama_kategori }}</span>
                                    <span class="font-semibold text-g600">{{ $pct }}%</span>
                                </div>
                                <div class="h-2 bg-g100 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-500 rounded-full" style="width:{{ $pct }}%"></div>
                                </div>
                                <div class="text-[11px] font-medium text-g500 mt-1.5">{{ $kategori->total_qty }} unit · Rp {{ number_format($kategori->total_nominal, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <div class="text-[13px] text-g500 font-semibold text-center py-6">Belum ada penjualan selesai.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-g100 mb-8">
                <div class="p-6 border-b border-g100">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-flame text-primary"></i> Produk Terlaris
                    </h3>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full min-w-[700px] text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Produk</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Kategori</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Unit Terjual</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produkTerlaris as $item)
                                <tr class="group hover:bg-g50/50 transition-colors">
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-bold text-g800 text-[13px]">{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-2.5 rounded text-[10px] font-extrabold tracking-widest uppercase">
                                            {{ $item->produk->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-semibold text-g700 text-[13px]">{{ $item->total_qty }} unit</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-heading font-extrabold text-primary text-[15px] whitespace-nowrap">
                                            Rp {{ number_format($item->total_nominal, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-6 text-center text-g500 font-semibold text-[13px]">
                                        Belum ada produk terjual.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-2xl shadow-sm border border-g100">
                <div class="p-6 border-b border-g100 flex justify-between items-center">
                    <h3 class="font-heading text-[16px] font-extrabold text-g900 flex items-center gap-2">
                        <i class="fi fi-rr-document text-primary"></i> Pesanan Terbaru
                    </h3>
                    <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-200 py-1 px-2.5 rounded text-[11px] font-extrabold tracking-widest uppercase">{{ $totalPesanan }} total</span>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full min-w-[800px] text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">No. Resi</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Pelanggan</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Tanggal</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Total</th>
                                <th class="bg-g50 py-3.5 px-6 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesananTerbaru as $pesanan)
                                @php
                                    $statusClass = match ($pesanan->status_pesanan) {
                                        'menunggu' => 'bg-orange-50 text-orange-600 border-orange-200',
                                        'diproses' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'dikirim'  => 'bg-purple-50 text-purple-600 border-purple-200',
                                        'selesai'  => 'bg-green-50 text-green-600 border-green-200',
                                        default    => 'bg-g100 text-g600 border-g200',
                                    };
                                    $statusLabel = match ($pesanan->status_pesanan) {
                                        'menunggu' => '<i class="fi fi-rr-time-fast"></i> Menunggu',
                                        'diproses' => '<i class="fi fi-rr-settings"></i> Diproses',
                                        'dikirim'  => '<i class="fi fi-rr-truck-side"></i> Dikirim',
                                        'selesai'  => '<i class="fi fi-rr-check-circle"></i> Selesai',
                                        default    => ucfirst($pesanan->status_pesanan),
                                    };
                                @endphp
                                <tr class="group hover:bg-g50/50 transition-colors">
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-extrabold text-g900 text-[14px]">{{ $pesanan->no_resi }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-bold text-g800 text-[13px]">{{ $pesanan->user->nama ?? '-' }}</div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-medium text-g500 text-[12px]">
                                            {{ \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <div class="font-heading font-extrabold text-primary text-[15px] whitespace-nowrap">
                                            Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 border-b border-g100 group-last:border-none">
                                        <span class="inline-flex items-center gap-1.5 {{ $statusClass }} border py-1 px-2.5 rounded text-[11px] font-extrabold tracking-widest uppercase">
                                            {!! $statusLabel !!}
                                        </span>
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
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
