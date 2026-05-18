@extends('layouts.app')

@section('title', 'Pesanan Saya – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .orders-section { padding: 32px 0 72px }
        .orders-section h1 { font-family: "Syne", sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 8px }

        .order-card {
            background: #fff; border-radius: var(--rlg); box-shadow: var(--sh);
            margin-bottom: 16px; overflow: hidden; transition: .2s
        }
        .order-card:hover { box-shadow: var(--sh-md) }

        .order-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px; border-bottom: 1px solid var(--g100);
            flex-wrap: wrap; gap: 12px
        }
        .order-id { font-weight: 800; font-size: 15px; color: var(--g900) }
        .order-date { font-size: 12px; color: var(--g500); margin-left: 12px }

        .order-items { padding: 16px 24px }
        .order-item {
            display: flex; align-items: center; gap: 14px;
            padding: 10px 0; border-bottom: 1px solid var(--g100)
        }
        .order-item:last-child { border-bottom: none }
        .order-item img {
            width: 56px; height: 56px; border-radius: 10px;
            object-fit: cover; background: var(--g100)
        }
        .order-item-name { font-size: 13px; font-weight: 700; color: var(--g800) }
        .order-item-qty { font-size: 12px; color: var(--g500) }
        .order-item-price {
            margin-left: auto; font-family: var(--font-h);
            font-weight: 800; color: var(--blue); font-size: 14px
        }

        .order-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 24px; background: var(--g50);
            border-top: 1px solid var(--g100); flex-wrap: wrap; gap: 12px
        }
        .order-total-label { font-size: 13px; color: var(--g500) }
        .order-total-val {
            font-family: var(--font-h); font-size: 20px;
            font-weight: 800; color: var(--blue)
        }

        .empty-orders { text-align: center; padding: 60px 20px }
        .empty-orders .empty-icon { font-size: 64px; margin-bottom: 16px }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="orders-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('index') }}">Beranda</a> <span>›</span> <span>Pesanan Saya</span>
            </div>
            <h1>📦 Pesanan Saya</h1>
            <p style="color:var(--g500);margin-bottom:28px">Riwayat dan status pesanan Anda</p>

            @if (session('status'))
                <div style="background:var(--sl);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    ✓ {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background:var(--dl);color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @forelse ($pesanans as $pesanan)
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
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">{{ $pesanan->no_resi }}</span>
                            <span class="order-date">{{ \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y, H:i') }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px">
                            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach ($pesanan->detailPesanans as $detail)
                            <div class="order-item">
                                @if ($detail->produk)
                                    <img src="{{ asset('storage/products/' . $detail->produk->gambar) }}" alt="{{ $detail->produk->nama_produk }}" loading="lazy" decoding="async">
                                    <div>
                                        <div class="order-item-name">{{ $detail->produk->nama_produk }}</div>
                                        <div class="order-item-qty">{{ $detail->qty }} × Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="order-item-price">Rp {{ number_format($detail->harga_beli * $detail->qty, 0, ',', '.') }}</div>
                                @else
                                    <div>
                                        <div class="order-item-name">Produk tidak tersedia</div>
                                        <div class="order-item-qty">{{ $detail->qty }} item</div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div>
                            <div class="order-total-label">
                                Ekspedisi: {{ $pesanan->ekspedisi->nama_ekspedisi ?? '-' }}
                                • Ongkir: Rp {{ number_format($pesanan->ongkos_kirim, 0, ',', '.') }}
                            </div>
                        </div>
                        <div>
                            <div class="order-total-label">Total Bayar</div>
                            <div class="order-total-val">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-orders">
                    <div class="empty-icon">📦</div>
                    <div style="font-weight:700;font-size:18px;color:var(--g700);margin-bottom:6px">
                        Belum Ada Pesanan
                    </div>
                    <div style="font-size:14px;color:var(--g400);margin-bottom:24px">
                        Yuk mulai belanja produk elektronik berkualitas!
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">🛍️ Belanja Sekarang</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
