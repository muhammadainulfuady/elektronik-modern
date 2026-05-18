@extends('layouts.app')

@section('title', 'Checkout – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .checkout-section { padding: 32px 0 72px }
        .checkout-section h1 { font-family: "Syne", sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 8px }

        .checkout-layout { display: grid; grid-template-columns: 1fr 380px; gap: 28px; align-items: start }

        .checkout-card {
            background: #fff; border-radius: var(--rlg); box-shadow: var(--sh);
            padding: 28px; margin-bottom: 20px
        }
        .checkout-card h3 {
            font-family: var(--font-h); font-size: 18px; font-weight: 800;
            margin-bottom: 20px; color: var(--g900)
        }

        .checkout-item {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 0; border-bottom: 1px solid var(--g100)
        }
        .checkout-item:last-child { border-bottom: none }
        .checkout-item img {
            width: 56px; height: 56px; border-radius: 10px;
            object-fit: cover; background: var(--g100)
        }
        .checkout-item-name { font-size: 13px; font-weight: 700; color: var(--g800) }
        .checkout-item-qty { font-size: 12px; color: var(--g500) }
        .checkout-item-price {
            margin-left: auto; font-family: var(--font-h);
            font-weight: 800; color: var(--blue); font-size: 14px; white-space: nowrap
        }

        .summary-card {
            background: #fff; border-radius: var(--rlg); box-shadow: var(--sh);
            padding: 28px; position: sticky; top: 84px
        }
        .summary-card h3 { font-family: var(--font-h); font-size: 18px; font-weight: 800; margin-bottom: 20px }
        .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14px }
        .summary-row.total { font-size: 18px; font-weight: 800; border-top: 2px solid var(--g200); padding-top: 16px; margin-top: 16px }
        .summary-row.total .val { color: var(--blue); font-family: var(--font-h); font-size: 22px }

        .pay-opt { display: flex; align-items: center; gap: 14px; padding: 16px; border: 2px solid var(--g200); border-radius: var(--rlg); cursor: pointer; transition: .2s; margin-bottom: 10px }
        .pay-opt:hover, .pay-opt.selected { border-color: var(--blue); background: var(--blue-l) }
        .pay-opt input[type="radio"] { accent-color: var(--blue); width: 18px; height: 18px }
        .bank-detail { background: var(--blue-l); border-radius: 10px; padding: 16px; margin-top: 12px; border-left: 4px solid var(--blue); display: none }
        .upload-zone { border: 2px dashed var(--g300); border-radius: var(--rlg); padding: 32px; text-align: center; color: var(--g400); cursor: pointer; transition: .2s }
        .upload-zone:hover { border-color: var(--blue); background: var(--blue-l) }

        .no-address {
            background: var(--wl); border-radius: 10px; padding: 16px;
            font-size: 13px; color: #92400E; margin-bottom: 16px
        }

        @media(max-width:900px) {
            .checkout-layout { grid-template-columns: 1fr }
            .summary-card { position: static }
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="checkout-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('index') }}">Beranda</a> <span>›</span>
                <a href="{{ route('cart.index') }}">Keranjang</a> <span>›</span>
                <span>Checkout</span>
            </div>
            <h1>🛒 Checkout</h1>
            <p style="color:var(--g500);margin-bottom:28px">Periksa pesanan Anda sebelum melanjutkan</p>

            @if (session('error'))
                <div style="background:var(--dl);color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:var(--dl);color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('customer.placeOrder') }}" enctype="multipart/form-data">
                @csrf
                <div class="checkout-layout">
                    <div>
                        <!-- Items -->
                        <div class="checkout-card">
                            <h3>📦 Produk Dipesan</h3>
                            @foreach ($items as $item)
                                <div class="checkout-item">
                                    <img src="{{ asset('storage/products/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" loading="lazy" decoding="async">
                                    <div>
                                        <div class="checkout-item-name">{{ $item->produk->nama_produk }}</div>
                                        <div class="checkout-item-qty">{{ $item->qty }} × Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="checkout-item-price">Rp {{ number_format($item->lineTotal, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Alamat Pengiriman -->
                        <div class="checkout-card">
                            <h3>📍 Alamat Pengiriman</h3>
                            @if ($alamats->count())
                                @foreach ($alamats as $alamat)
                                    <label style="display:flex;align-items:flex-start;gap:12px;padding:14px;background:var(--g50);border-radius:10px;margin-bottom:8px;cursor:pointer;border:1.5px solid var(--g200);transition:.2s">
                                        <input type="radio" name="id_alamat" value="{{ $alamat->id_alamat }}"
                                            {{ $loop->first ? 'checked' : '' }}
                                            style="width:18px;height:18px;margin-top:2px;accent-color:var(--blue);flex-shrink:0">
                                        <div>
                                            <div style="font-size:14px;font-weight:700;color:var(--g800);margin-bottom:2px">
                                                {{ $alamat->label_alamat }}
                                            </div>
                                            <div style="font-size:13px;color:var(--g600)">{{ $alamat->detail_alamat }}</div>
                                            <div style="font-size:12px;color:var(--g500);margin-top:4px">📞 {{ $alamat->nomor_telepon }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            @else
                                <div class="no-address">
                                    ⚠️ Anda belum memiliki alamat pengiriman. Tambahkan alamat terlebih dahulu melalui halaman profil.
                                </div>
                                <a href="{{ route('customer.profile') }}?tab=alamat" class="btn btn-outline">Tambah Alamat</a>
                            @endif
                        </div>

                        <!-- Ekspedisi -->
                        <div class="checkout-card">
                            <h3>🚚 Pilih Ekspedisi</h3>
                            @foreach ($ekspedisis as $ekspedisi)
                                <label style="display:flex;align-items:center;gap:12px;padding:14px;background:var(--g50);border-radius:10px;margin-bottom:8px;cursor:pointer;border:1.5px solid var(--g200);transition:.2s">
                                    <input type="radio" name="id_ekspedisi" value="{{ $ekspedisi->id_ekspedisi }}"
                                        {{ $loop->first ? 'checked' : '' }}
                                        style="width:18px;height:18px;accent-color:var(--blue);flex-shrink:0">
                                    <div style="flex:1">
                                        <div style="font-size:14px;font-weight:700;color:var(--g800)">{{ $ekspedisi->nama_ekspedisi }}</div>
                                    </div>
                                    <div style="font-weight:800;color:var(--blue);font-family:var(--font-h)">
                                        Rp {{ number_format($ekspedisi->biaya_pengiriman, 0, ',', '.') }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <!-- Pembayaran & Upload -->
                        <div class="checkout-card">
                            <h3>💳 Metode & Bukti Pembayaran</h3>
                            
                            <div class="pay-opt selected" onclick="selectPay(this, 'bank')">
                                <input type="radio" name="metode_pembayaran" value="Transfer Bank" checked />
                                <div style="font-size:28px">🏦</div>
                                <div>
                                    <div style="font-weight:700;font-size:14px;color:var(--g800)">Transfer Bank</div>
                                    <div style="font-size:12px;color:var(--g500)">BCA · BRI · BNI · Mandiri</div>
                                </div>
                            </div>
                            <div class="pay-opt" onclick="selectPay(this, 'ewallet')">
                                <input type="radio" name="metode_pembayaran" value="E-Wallet" />
                                <div style="font-size:28px">💚</div>
                                <div>
                                    <div style="font-weight:700;font-size:14px;color:var(--g800)">E-Wallet</div>
                                    <div style="font-size:12px;color:var(--g500)">GoPay · OVO · DANA · ShopeePay</div>
                                </div>
                            </div>
                            
                            <div class="bank-detail" id="bankDetail" style="display:block">
                                <div style="font-weight:700;color:var(--blue);margin-bottom:6px">📋 Detail Transfer Bank:</div>
                                <div style="font-size:14px;color:var(--g700)"><strong>Bank BCA</strong> – No. Rek: <strong>1234-5678-90</strong></div>
                                <div style="font-size:13px;color:var(--g500)">a.n. Elektronik Modern Store</div>
                            </div>

                            <div style="margin-top:24px">
                                <label style="display:block;font-weight:700;margin-bottom:12px;font-size:14px;color:var(--g800)">Upload Bukti Pembayaran</label>
                                <div class="upload-zone" onclick="document.getElementById('bukti_bayar').click()">
                                    <div style="font-size:44px;margin-bottom:10px">📸</div>
                                    <div style="font-weight:700;font-size:15px;margin-bottom:4px">Klik atau seret file ke sini</div>
                                    <div style="font-size:13px">Format: JPG, PNG, PDF · Maks. 5MB</div>
                                    <input type="file" id="bukti_bayar" name="bukti_bayar" accept="image/*,.pdf" style="display:none" onchange="handleUpload(this)" required />
                                </div>
                                <div id="uploadPreview" style="display:none;margin-top:12px;background:var(--sl);border-radius:10px;padding:12px;font-size:13px;color:var(--success);font-weight:600">
                                    ✅ File berhasil dipilih!
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="summary-card">
                        <h3>💳 Ringkasan Pembayaran</h3>
                        <div class="summary-row">
                            <span style="color:var(--g500)">Subtotal ({{ count($items) }} produk)</span>
                            <span style="font-weight:700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($appliedPromo)
                            <div class="summary-row">
                                <span style="color:var(--success);font-weight:700">Voucher {{ $appliedPromo->kode_voucher }}</span>
                                <span style="font-weight:700;color:var(--success)">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="summary-row">
                            <span style="color:var(--g500)">Ongkos Kirim</span>
                            <span style="font-weight:700;color:var(--g600)">Sesuai ekspedisi</span>
                        </div>
                        <div class="summary-row total">
                            <span>Estimasi Total</span>
                            <span class="val">Rp {{ number_format(max(0, $subtotal - $discount), 0, ',', '.') }}+</span>
                        </div>

                        <button type="submit" class="btn btn-primary" {{ $alamats->isEmpty() ? 'disabled' : '' }} style="width:100%;justify-content:center;padding:14px;font-size:15px;margin-top:16px;{{ $alamats->isEmpty() ? 'opacity:.6;cursor:not-allowed' : '' }}">
                            ✅ Buat Pesanan
                        </button>

                        <div style="text-align:center;font-size:11px;color:var(--g400);margin-top:12px">
                            🔒 Transaksi aman & terenkripsi
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('footer')
<script>
    function selectPay(el, type) {
        document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        el.querySelector('input').checked = true;
        document.getElementById('bankDetail').style.display = type === 'bank' ? 'block' : 'none';
    }
    function handleUpload(inp) {
        if (inp.files.length > 0) {
            document.getElementById('uploadPreview').style.display = 'block';
            document.getElementById('uploadPreview').textContent = '✅ File terpilih: ' + inp.files[0].name;
        }
    }
</script>
@endsection
