@extends('layouts.app')

@section('title', 'Admin Dashboard – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .chart-bars { display:flex;align-items:flex-end;gap:6px;height:160px;padding:0 4px }
        .bar-wrap { display:flex;flex-direction:column;align-items:center;gap:4px;flex:1 }
        .bar-fill { width:100%;border-radius:6px 6px 0 0;background:var(--blue);min-height:4px;transition:.3s }
        .bar-label { font-size:10px;color:var(--g400);font-weight:600 }
    </style>
@endsection

@section('header')
@endsection

@section('content')
    <div class="admin-layout">
        @include('partials.admin-sidebar')

        <div class="admin-main">
            <div class="admin-topbar">
                <div>
                    <div style="font-size:13px;color:var(--g500);margin-bottom:2px">Selamat datang kembali,</div>
                    <div class="page-title">Dashboard Admin</div>
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                    <span class="btn btn-outline btn-sm">📅 {{ now()->format('d M Y') }}</span>
                    <div style="width:40px;height:40px;background:var(--blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:14px">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 2)) }}
                    </div>
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
                        <div class="stat-val">{{ $jumlahUser }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico warn">⏳</div>
                    <div>
                        <div class="stat-label">Menunggu Konfirmasi</div>
                        <div class="stat-val">{{ $jumlahMenungguKonfirmasi }}</div>
                        <div class="stat-chg" style="color:var(--warn)">Perlu ditangani</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">✅</div>
                    <div>
                        <div class="stat-label">Pesanan Selesai</div>
                        <div class="stat-val">{{ $pesananSelesai }}</div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px">
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>📈 Pesanan 7 Hari Terakhir</h3>
                        <span class="badge badge-info">{{ $pesanan_tujuh_hari_terakhir }} pesanan</span>
                    </div>
                    <div style="padding:20px">
                        <div class="chart-bars">
                            @php $days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min']; $heights = [55,72,48,83,91,65,38]; @endphp
                            @foreach($days as $i => $day)
                                <div class="bar-wrap">
                                    <div class="bar-fill" style="height:{{ $heights[$i] }}% {{ $i >= 5 ? ';background:var(--g300)' : '' }}"></div>
                                    <div class="bar-label">{{ $day }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="data-card">
                    <div class="data-card-head"><h3>📦 Status Pesanan</h3></div>
                    <div style="padding:20px;display:flex;flex-direction:column;gap:12px">
                        @php
                            $total = max(1, ($statusPesanan->sum('total')));
                        @endphp
                        @foreach([
                            ['Menunggu', 'menunggu', '--pend'],
                            ['Diproses', 'diproses', '--blue'],
                            ['Dikirim', 'dikirim', '--teal'],
                            ['Selesai', 'selesai', '--success'],
                        ] as [$label, $key, $color])
                            @php $val = $statusPesanan->where('status_pesanan', $key)->first()->total ?? 0; @endphp
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
                                    <span>{{ $label }}</span><strong>{{ $val }}</strong>
                                </div>
                                <div style="height:6px;background:var(--g100);border-radius:3px">
                                    <div style="width:{{ round($val/$total*100) }}%;height:100%;background:var({{ $color }});border-radius:3px"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="data-card">
                <div class="data-card-head">
                    <h3>🧾 Pesanan Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No. Resi</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesananTerbaru as $pesanan)
                            <tr>
                                <td style="font-weight:700">{{ $pesanan->no_resi }}</td>
                                <td>{{ $pesanan->user->nama ?? '-' }}</td>
                                <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">
                                    Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match ($pesanan->status_pesanan) {
                                            'menunggu' => 'badge-pend',
                                            'diproses' => 'badge-warn',
                                            'dikirim'  => 'badge-info',
                                            'selesai'  => 'badge-success',
                                            default    => 'badge-info',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($pesanan->status_pesanan) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($pesanan->status_pesanan !== 'selesai')
                                        @php
                                            $nextStatus = match ($pesanan->status_pesanan) {
                                                'menunggu' => 'diproses',
                                                'diproses' => 'dikirim',
                                                'dikirim'  => 'selesai',
                                                default    => null,
                                            };
                                            $nextLabel = match ($nextStatus) {
                                                'diproses' => '→ Proses',
                                                'dikirim'  => '→ Kirim',
                                                'selesai'  => '→ Selesai',
                                                default    => '',
                                            };
                                        @endphp
                                        @if ($nextStatus)
                                            <form method="POST" action="{{ route('admin.orders.updateStatus', $pesanan) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status_pesanan" value="{{ $nextStatus }}">
                                                <button class="btn-edit" type="submit">{{ $nextLabel }}</button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="badge badge-success">✓ Done</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center;color:var(--g400);padding:18px">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection