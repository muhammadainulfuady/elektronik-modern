@extends('layouts.app')

@section('title', 'Owner Dashboard – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .revenue-card {
            background: linear-gradient(135deg, var(--blue) 0%, #4F80FF 100%);
            border-radius: var(--rlg);
            padding: 28px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .revenue-card::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            top: -80px;
            right: -60px;
        }
        .revenue-label { font-size: 13px; opacity: 0.8; font-weight: 600; margin-bottom: 6px }
        .revenue-val { font-family: var(--font-h); font-size: 36px; font-weight: 800; margin-bottom: 4px }
        .revenue-sub { font-size: 12px; opacity: 0.7 }

        .overview-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 24px }

        .progress-bar-wrap {
            height: 8px;
            background: var(--g100);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 6px;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.6s ease;
        }
        .mini-bars { display:flex;align-items:flex-end;gap:8px;height:150px;padding:12px 4px 0 }
        .mini-bar { flex:1;min-width:14px;background:linear-gradient(180deg,var(--blue),var(--teal));border-radius:6px 6px 0 0 }
    </style>
@endsection

@section('header')
@endsection

@section('content')
    <div class="admin-layout">
        @include('partials.owner-sidebar')

        <div class="admin-main">
            <div class="admin-topbar">
                <div>
                    <div style="font-size:13px;color:var(--g500);margin-bottom:2px">Selamat datang,</div>
                    <div class="page-title">Dashboard Owner</div>
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                    <span class="btn btn-outline btn-sm">📅 {{ now()->format('d M Y') }}</span>
                    <div style="width:40px;height:40px;background:linear-gradient(135deg, #f59e0b, #d97706);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:14px">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'O', 0, 2)) }}
                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="overview-grid">
                <div class="revenue-card">
                    <div class="revenue-label">💰 Total Pendapatan</div>
                    <div class="revenue-val">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="revenue-sub">Dari {{ $jumlahSelesai }} pesanan selesai</div>
                </div>
                <div class="revenue-card" style="background:linear-gradient(135deg, var(--teal) 0%, #34d399 100%)">
                    <div class="revenue-label">📈 Pendapatan Bulan Ini</div>
                    <div class="revenue-val">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                    <div class="revenue-sub">{{ $pesananBulanIni }} pesanan bulan ini · {{ $persenPendapatan >= 0 ? '+' : '' }}{{ $persenPendapatan }}% dari bulan lalu</div>
                </div>
                <div class="revenue-card" style="background:linear-gradient(135deg, #7c3aed 0%, #a855f7 100%)">
                    <div class="revenue-label">🧮 Rata-rata Transaksi</div>
                    <div class="revenue-val">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</div>
                    <div class="revenue-sub">Dihitung dari pesanan selesai</div>
                </div>
                <div class="revenue-card" style="background:linear-gradient(135deg, #0f172a 0%, #334155 100%)">
                    <div class="revenue-label">📅 Pendapatan Bulan Lalu</div>
                    <div class="revenue-val">Rp {{ number_format($pendapatanBulanLalu, 0, ',', '.') }}</div>
                    <div class="revenue-sub">Pembanding performa bulan berjalan</div>
                </div>
            </div>

            <!-- Stats -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico blue">📦</div>
                    <div>
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-val">{{ $jumlahProduk }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico green">👥</div>
                    <div>
                        <div class="stat-label">Total Customer</div>
                        <div class="stat-val">{{ $jumlahCustomer }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">🛡️</div>
                    <div>
                        <div class="stat-label">Total Admin</div>
                        <div class="stat-val">{{ $jumlahAdmin }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico warn">🧾</div>
                    <div>
                        <div class="stat-label">Total Pesanan</div>
                        <div class="stat-val">{{ $totalPesanan }}</div>
                    </div>
                </div>
            </div>

            <!-- Order Status Overview -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px">
                <div class="data-card">
                    <div class="data-card-head"><h3>📊 Status Pesanan</h3></div>
                    <div style="padding:24px;display:flex;flex-direction:column;gap:16px">
                        @php
                            $total = max(1, $totalPesanan);
                            $statusData = [
                                ['Menunggu', $jumlahMenunggu, '--pend', '#7C3AED'],
                                ['Diproses', $jumlahDiproses, '--blue', '#1A5CFF'],
                                ['Dikirim', $jumlahDikirim, '--teal', '#0EA5A0'],
                                ['Selesai', $jumlahSelesai, '--success', '#16A34A'],
                            ];
                        @endphp
                        @foreach($statusData as [$label, $val, $colorVar, $color])
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
                                    <span style="font-weight:600">{{ $label }}</span>
                                    <strong>{{ $val }}</strong>
                                </div>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar-fill" style="width:{{ round($val/$total*100) }}%;background:{{ $color }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="data-card">
                    <div class="data-card-head"><h3>📋 Ringkasan</h3></div>
                    <div style="padding:24px;display:flex;flex-direction:column;gap:14px">
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;background:var(--g50);border-radius:10px">
                            <span style="font-size:13px;color:var(--g600)">⏳ Menunggu Konfirmasi</span>
                            <span class="badge badge-pend" style="font-size:13px;padding:5px 14px">{{ $jumlahMenunggu }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;background:var(--g50);border-radius:10px">
                            <span style="font-size:13px;color:var(--g600)">⚙️ Sedang Diproses</span>
                            <span class="badge badge-info" style="font-size:13px;padding:5px 14px">{{ $jumlahDiproses }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;background:var(--g50);border-radius:10px">
                            <span style="font-size:13px;color:var(--g600)">🚚 Dalam Pengiriman</span>
                            <span class="badge badge-info" style="font-size:13px;padding:5px 14px">{{ $jumlahDikirim }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px;background:var(--g50);border-radius:10px">
                            <span style="font-size:13px;color:var(--g600)">✅ Selesai</span>
                            <span class="badge badge-success" style="font-size:13px;padding:5px 14px">{{ $jumlahSelesai }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1.2fr .8fr;gap:20px;margin-bottom:24px">
                <div class="data-card">
                    <div class="data-card-head"><h3>📈 Pendapatan Bulanan</h3></div>
                    @php
                        $maxPendapatan = max(1, (int) collect($pendapatanBulanan)->max());
                        $bulanLabels = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
                    @endphp
                    <div style="padding:20px">
                        <div class="mini-bars">
                            @foreach($bulanLabels as $bulan => $label)
                                @php $nilai = (int) ($pendapatanBulanan[$bulan] ?? 0); @endphp
                                <div title="{{ $label }}: Rp {{ number_format($nilai, 0, ',', '.') }}" class="mini-bar" style="height:{{ max(4, round($nilai / $maxPendapatan * 140)) }}px"></div>
                            @endforeach
                        </div>
                        <div style="display:grid;grid-template-columns:repeat(12,1fr);gap:8px;font-size:10px;color:var(--g400);text-align:center">
                            @foreach($bulanLabels as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="data-card">
                    <div class="data-card-head"><h3>🍩 Penjualan per Kategori</h3></div>
                    <div style="padding:20px;display:flex;flex-direction:column;gap:12px">
                        @php $totalKategori = max(1, (int) $penjualanKategori->sum('total_nominal')); @endphp
                        @forelse($penjualanKategori as $kategori)
                            @php $pct = round($kategori->total_nominal / $totalKategori * 100); @endphp
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
                                    <span style="font-weight:700">{{ $kategori->nama_kategori }}</span>
                                    <span>{{ $pct }}%</span>
                                </div>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar-fill" style="width:{{ $pct }}%;background:var(--teal)"></div>
                                </div>
                                <div style="font-size:11px;color:var(--g500);margin-top:4px">{{ $kategori->total_qty }} unit · Rp {{ number_format($kategori->total_nominal, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <div style="font-size:13px;color:var(--g400);text-align:center;padding:20px">Belum ada penjualan selesai.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="data-card" style="margin-bottom:24px">
                <div class="data-card-head"><h3>🏆 Produk Terlaris</h3></div>
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Unit Terjual</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produkTerlaris as $item)
                            <tr>
                                <td style="font-weight:700">{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</td>
                                <td><span class="badge badge-info">{{ $item->produk->kategori->nama_kategori ?? '-' }}</span></td>
                                <td>{{ $item->total_qty }} unit</td>
                                <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">Rp {{ number_format($item->total_nominal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;color:var(--g400);padding:18px">Belum ada produk terjual.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Recent Orders -->
            <div class="data-card">
                <div class="data-card-head">
                    <h3>🧾 Pesanan Terbaru</h3>
                    <span class="badge badge-info">{{ $totalPesanan }} total</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No. Resi</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesananTerbaru as $pesanan)
                            @php
                                $statusClass = match ($pesanan->status_pesanan) {
                                    'menunggu' => 'badge-pend',
                                    'diproses' => 'badge-warn',
                                    'dikirim'  => 'badge-info',
                                    'selesai'  => 'badge-success',
                                    default    => 'badge-info',
                                };
                                $statusLabel = match ($pesanan->status_pesanan) {
                                    'menunggu' => '⏳ Menunggu',
                                    'diproses' => '⚙️ Diproses',
                                    'dikirim'  => '🚚 Dikirim',
                                    'selesai'  => '✅ Selesai',
                                    default    => ucfirst($pesanan->status_pesanan),
                                };
                            @endphp
                            <tr>
                                <td style="font-weight:700">{{ $pesanan->no_resi }}</td>
                                <td>{{ $pesanan->user->nama ?? '-' }}</td>
                                <td style="font-size:12px;color:var(--g500)">
                                    {{ \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                                </td>
                                <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">
                                    Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                </td>
                                <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--g400);padding:18px">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
