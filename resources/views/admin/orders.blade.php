@extends('layouts.app')

@section('title', 'Kelola Pesanan – Admin Elektronik Modern')

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
                <div class="page-title">Kelola Pesanan</div>
            </div>

            @if (session('status'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--sl);color:#15803D">
                    <strong><i class="fi fi-rr-check-circle" style="color:var(--success);margin-right:6px"></i> {{ session('status') }}</strong>
                </div>
            @endif

            @if (session('error'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--dl);color:#991B1B">
                    <strong><i class="fi fi-rr-cross-circle" style="color:var(--danger);margin-right:6px"></i> {{ session('error') }}</strong>
                </div>
            @endif

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico blue"><i class="fi fi-rr-time-fast"></i></div>
                    <div>
                        <div class="stat-label">Menunggu</div>
                        <div class="stat-val">{{ $jumlahMenunggu }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico blue"><i class="fi fi-rr-settings"></i></div>
                    <div>
                        <div class="stat-label">Diproses</div>
                        <div class="stat-val">{{ $jumlahDiproses }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal"><i class="fi fi-rr-truck-side"></i></div>
                    <div>
                        <div class="stat-label">Dikirim</div>
                        <div class="stat-val">{{ $jumlahDikirim }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico green"><i class="fi fi-rr-check-circle"></i></div>
                    <div>
                        <div class="stat-label">Selesai</div>
                        <div class="stat-val">{{ $jumlahSelesai }}</div>
                    </div>
                </div>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3 style="display:flex;align-items:center;gap:8px"><i class="fi fi-rr-document" style="color:var(--blue)"></i> Daftar Pesanan</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanans as $pesanan)
                            @php
                                $statusLabel = match ($pesanan->status_pesanan) {
                                    'diproses' => 'Diproses',
                                    'dikirim'  => 'Dikirim',
                                    'selesai'  => 'Selesai',
                                    default    => 'Menunggu',
                                };
                                $statusClass = match ($pesanan->status_pesanan) {
                                    'diproses' => 'badge-warn',
                                    'dikirim'  => 'badge-info',
                                    'selesai'  => 'badge-success',
                                    default    => 'badge-pend',
                                };
                                $buktiAda = !empty($pesanan->pembayaran?->bukti_bayar);
                                $paymentStatus = (int) ($pesanan->pembayaran?->status_konfirmasi ?? 0);
                                $paymentLabel = match ($paymentStatus) {
                                    1 => 'Terverifikasi',
                                    2 => 'Ditolak',
                                    default => 'Menunggu',
                                };
                                $paymentClass = match ($paymentStatus) {
                                    1 => 'badge-success',
                                    2 => 'badge-danger',
                                    default => 'badge-pend',
                                };
                                $buktiExt = $buktiAda ? strtolower(pathinfo($pesanan->pembayaran->bukti_bayar, PATHINFO_EXTENSION)) : '';
                            @endphp
                            <tr>
                                <td style="font-weight:700">
                                    {{ $pesanan->no_resi }}
                                </td>
                                <td>
                                    <div style="font-weight:700;font-size:13px">{{ $pesanan->user->nama ?? '-' }}</div>
                                    <div style="font-size:11px;color:var(--g400)">
                                        {{ \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                                    </div>
                                    <div style="margin-top:8px;font-size:11px;color:var(--g500)">
                                        @foreach($pesanan->detailPesanans as $detail)
                                            <div>- {{ $detail->produk->nama_produk ?? 'Produk Dihapus' }} (x{{ $detail->qty }})</div>
                                        @endforeach
                                    </div>
                                </td>
                                <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">
                                    Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($buktiAda)
                                        @if ($buktiExt === 'pdf')
                                            <a class="badge badge-info" href="{{ asset('storage/payments/' . $pesanan->pembayaran->bukti_bayar) }}" target="_blank">PDF</a>
                                        @else
                                            <a href="{{ asset('storage/payments/' . $pesanan->pembayaran->bukti_bayar) }}" target="_blank" title="Lihat Bukti Bayar">
                                                <img src="{{ asset('storage/payments/' . $pesanan->pembayaran->bukti_bayar) }}" alt="Bukti Bayar" style="width:44px;height:44px;border-radius:8px;object-fit:cover;border:1.5px solid #bbf7d0" loading="lazy" decoding="async">
                                            </a>
                                        @endif
                                        <div style="margin-top:8px">
                                            <span class="badge {{ $paymentClass }}">{{ $paymentLabel }}</span>
                                        </div>
                                        @if ($paymentStatus === 1)
                                            <div style="font-size:11px;color:var(--g500);margin-top:6px">Final</div>
                                        @else
                                            <form method="POST" action="{{ route('admin.orders.updatePayment', $pesanan) }}" style="display:flex;gap:6px;margin-top:8px">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status_konfirmasi" value="1">
                                                <button class="btn-edit" type="submit">Verifikasi</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.orders.updatePayment', $pesanan) }}" style="display:flex;gap:6px;margin-top:6px">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status_konfirmasi" value="2">
                                                <button class="btn-del" type="submit">Tolak</button>
                                            </form>
                                        @endif
                                    @else
                                        <div style="width:44px;height:44px;border-radius:8px;background:var(--wl);border:1.5px solid #fde68a;display:flex;align-items:center;justify-content:center;font-size:20px" title="Belum Dibayar">
                                            404
                                        </div>
                                    @endif
                                </td>
                                <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>
                                    @if ($pesanan->status_pesanan !== 'selesai')
                                        <form method="POST" action="{{ route('admin.orders.updateStatus', $pesanan) }}">
                                            @csrf @method('PATCH')
                                            <div style="display:flex;gap:6px;align-items:center">
                                                @php
                                                    $nextStatus = match ($pesanan->status_pesanan) {
                                                        'menunggu' => 'diproses',
                                                        'diproses' => 'dikirim',
                                                        'dikirim'  => 'selesai',
                                                        default    => null,
                                                    };
                                                    $nextLabel = match ($nextStatus) {
                                                        'diproses' => '<i class="fi fi-rr-settings" style="margin-right:4px"></i> Proses',
                                                        'dikirim'  => '<i class="fi fi-rr-truck-side" style="margin-right:4px"></i> Kirim',
                                                        'selesai'  => '<i class="fi fi-rr-check-circle" style="margin-right:4px"></i> Selesai',
                                                        default    => '',
                                                    };
                                                @endphp
                                                @if ($nextStatus)
                                                    <input type="hidden" name="status_pesanan" value="{{ $nextStatus }}">
                                                    <button type="submit" class="btn-edit">{!! $nextLabel !!}</button>
                                                @endif
                                            </div>
                                        </form>
                                    @else
                                        <span class="badge badge-success" style="display:inline-flex;align-items:center;gap:4px"><i class="fi fi-rr-check"></i> Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;color:var(--g400);padding:18px">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="padding:16px">
                    {{ $pesanans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
