@extends('layouts.app')

@section('title', 'Keranjang Belanja – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .cart-section { padding: 32px 0 72px }
        .cart-section h1 { font-family: "Syne", sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 8px }

        .cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 28px; align-items: start }

        .cart-table { background: #fff; border-radius: var(--rlg); box-shadow: var(--sh); overflow: hidden }
        .cart-table table { width: 100% }
        .cart-table th { background: var(--g50); padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--g500); text-transform: uppercase; letter-spacing: .04em }
        .cart-table td { padding: 16px 20px; border-bottom: 1px solid var(--g100); vertical-align: middle }
        .cart-table tr:last-child td { border-bottom: none }

        .cart-prod { display: flex; align-items: center; gap: 14px }
        .cart-prod img { width: 64px; height: 64px; border-radius: 10px; object-fit: cover; background: var(--g100) }
        .cart-prod-name { font-size: 14px; font-weight: 700; color: var(--g800); margin-bottom: 2px }
        .cart-prod-cat { font-size: 11px; color: var(--g400) }

        .cart-qty { display: flex; align-items: center; gap: 0; border: 1.5px solid var(--g200); border-radius: 8px; overflow: hidden }
        .cart-qty button {
            width: 34px; height: 34px; border: none; background: var(--g50); cursor: pointer;
            font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center;
            color: var(--g700); transition: .15s
        }
        .cart-qty button:hover { background: var(--blue-l); color: var(--blue) }
        .cart-qty span {
            width: 40px; text-align: center; font-weight: 700; font-size: 14px;
            border-left: 1.5px solid var(--g200); border-right: 1.5px solid var(--g200);
            padding: 6px 0; background: #fff
        }

        .cart-price { font-family: "Syne",sans-serif; font-weight: 800; color: var(--blue); white-space: nowrap }

        /* Summary card */
        .summary-card {
            background: #fff; border-radius: var(--rlg); box-shadow: var(--sh);
            padding: 28px; position: sticky; top: 84px
        }
        .summary-card h3 { font-family: "Syne",sans-serif; font-size: 18px; font-weight: 800; margin-bottom: 20px }
        .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14px }
        .summary-row.total { font-size: 18px; font-weight: 800; border-top: 2px solid var(--g200); padding-top: 16px; margin-top: 16px }
        .summary-row.total .val { color: var(--blue); font-family: "Syne",sans-serif; font-size: 22px }
        .summary-actions { margin-top: 20px; display: flex; flex-direction: column; gap: 10px }
        .summary-actions .btn { justify-content: center; padding: 14px }
        .summary-note { text-align: center; font-size: 11px; color: var(--g400); margin-top: 12px }

        .empty-cart { text-align: center; padding: 60px 20px }
        .empty-cart .empty-icon { font-size: 64px; margin-bottom: 16px }

        @media(max-width:900px) {
            .cart-layout { grid-template-columns: 1fr }
            .summary-card { position: static }
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="cart-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('index') }}">Beranda</a> <span>›</span> <span>Keranjang</span>
            </div>
            <h1>🛒 Keranjang Belanja</h1>
            <p style="color:var(--g500);margin-bottom:28px">{{ count($items) }} produk di keranjang Anda</p>

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

            @if (count($items))
                <div class="cart-layout">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="cart-prod">
                                                <img src="{{ asset('storage/products/' . $item->produk->gambar) }}"
                                                    alt="{{ $item->produk->nama_produk }}">
                                                <div>
                                                    <div class="cart-prod-name">{{ $item->produk->nama_produk }}</div>
                                                    <div class="cart-prod-cat">{{ $item->produk->kategori->nama_kategori ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart-price">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="cart-qty">
                                                <form method="POST" action="{{ route('cart.update') }}" style="display:contents">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                    <input type="hidden" name="qty" value="{{ max(0, $item->qty - 1) }}">
                                                    <button type="submit">−</button>
                                                </form>
                                                <span>{{ $item->qty }}</span>
                                                <form method="POST" action="{{ route('cart.update') }}" style="display:contents">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                    <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                                    <button type="submit">+</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="cart-price">Rp {{ number_format($item->lineTotal, 0, ',', '.') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.remove') }}">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                <button type="submit" class="btn-del" title="Hapus">🗑</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="summary-card">
                        <h3>Ringkasan Belanja</h3>
                        <div class="summary-row">
                            <span style="color:var(--g500)">Subtotal ({{ count($items) }} produk)</span>
                            <span style="font-weight:700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <form method="POST" action="{{ route('cart.voucher.apply') }}" style="display:flex;gap:8px;margin:14px 0">
                            @csrf
                            <input name="kode_voucher" value="{{ $appliedPromo->kode_voucher ?? old('kode_voucher') }}" placeholder="Kode voucher"
                                style="min-width:0;flex:1;padding:10px 12px;border:1px solid var(--g200);border-radius:10px;text-transform:uppercase">
                            <button class="btn btn-outline" type="submit" style="padding:10px 12px">Pakai</button>
                        </form>
                        @if ($appliedPromo)
                            <div class="summary-row">
                                <span style="color:var(--success);font-weight:700">Voucher {{ $appliedPromo->kode_voucher }}</span>
                                <form method="POST" action="{{ route('cart.voucher.remove') }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del" style="padding:5px 8px">Hapus</button>
                                </form>
                            </div>
                            <div class="summary-row">
                                <span style="color:var(--g500)">Diskon</span>
                                <span style="font-weight:700;color:var(--success)">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="summary-row">
                            <span style="color:var(--g500)">Ongkos Kirim</span>
                            <span style="color:var(--success);font-weight:700">Gratis</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-actions">
                            @auth
                                @if (auth()->user()->role === 'customer')
                                    <a href="{{ route('customer.checkout') }}" class="btn btn-primary" style="justify-content:center;padding:14px">✅ Checkout Sekarang</a>
                                @endif
                            @endauth
                            <a href="{{ route('products.index') }}" class="btn btn-outline">← Lanjut Belanja</a>
                        </div>
                        <div class="summary-note">🔒 Transaksi aman & terenkripsi</div>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <div class="empty-icon">🛒</div>
                    <div style="font-weight:700;font-size:18px;color:var(--g700);margin-bottom:6px">
                        Keranjang Kosong
                    </div>
                    <div style="font-size:14px;color:var(--g400);margin-bottom:24px">
                        Yuk tambahkan produk favorit kamu!
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">🛍️ Belanja Sekarang</a>
                </div>
            @endif
        </div>
    </section>
@endsection
