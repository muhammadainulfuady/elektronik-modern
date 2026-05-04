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
                    <strong>✓ {{ session('status') }}</strong>
                </div>
            @endif

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico blue">⚙️</div>
                    <div>
                        <div class="stat-label">Diproses</div>
                        <div class="stat-val">{{ $jumlahDiproses }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">🚚</div>
                    <div>
                        <div class="stat-label">Dikirim</div>
                        <div class="stat-val">{{ $jumlahDikirim }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico green">✅</div>
                    <div>
                        <div class="stat-label">Selesai</div>
                        <div class="stat-val">{{ $jumlahSelesai }}</div>
                    </div>
                </div>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Pesanan</h3>
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
                                    'diproses' => '⚙️ Diproses',
                                    'dikirim'  => '🚚 Dikirim',
                                    'selesai'  => '✅ Selesai',
                                    default    => '⏳ Menunggu',
                                };
                                $statusClass = match ($pesanan->status_pesanan) {
                                    'diproses' => 'badge-warn',
                                    'dikirim'  => 'badge-info',
                                    'selesai'  => 'badge-success',
                                    default    => 'badge-pend',
                                };
                                $buktiAda = !empty($pesanan->pembayaran?->bukti_bayar);
                            @endphp
                            <tr>
                                <td style="font-weight:700">
                                    #ORD-{{ str_pad((string) $pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <div style="font-weight:700;font-size:13px">{{ $pesanan->user->nama ?? '-' }}</div>
                                    <div style="font-size:11px;color:var(--g400)">
                                        {{ \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                                    </div>
                                </td>
                                <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">
                                    Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div style="width:44px;height:44px;border-radius:8px;background:{{ $buktiAda ? 'var(--sl)' : 'var(--wl)' }};border:1.5px solid {{ $buktiAda ? '#bbf7d0' : '#fde68a' }};display:flex;align-items:center;justify-content:center;font-size:20px">
                                        {{ $buktiAda ? '✅' : '⚠️' }}
                                    </div>
                                </td>
                                <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>
                                    @if ($pesanan->status_pesanan !== 'selesai')
                                        <form method="POST" action="{{ route('admin.orders.updateStatus', $pesanan) }}">
                                            @csrf @method('PATCH')
                                            <div style="display:flex;gap:6px;align-items:center">
                                                <select name="status_pesanan" style="width:auto;padding:6px 10px;font-size:12px">
                                                    @if ($pesanan->status_pesanan === 'diproses')
                                                        <option value="dikirim">→ Kirim</option>
                                                        <option value="selesai">→ Selesai</option>
                                                    @elseif ($pesanan->status_pesanan === 'dikirim')
                                                        <option value="selesai">→ Selesai</option>
                                                    @endif
                                                </select>
                                                <button type="submit" class="btn-edit">Update</button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="badge badge-success">✓ Selesai</span>
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
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection