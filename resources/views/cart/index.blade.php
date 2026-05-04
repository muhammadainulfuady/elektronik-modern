@extends('layouts.app')

@section('title', 'Keranjang Belanja – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
    <style>
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 24px;
            padding: 32px 0 64px;
            align-items: start
        }

        .cart-main {
            background: #fff;
            border-radius: var(--rlg);
            box-shadow: var(--sh);
            overflow: hidden
        }

        .cart-main-head {
            padding: 18px 22px;
            border-bottom: 1px solid var(--g100);
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--g50)
        }

        .cart-row {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            gap: 16px;
            align-items: center;
            padding: 18px 22px;
            border-bottom: 1px solid var(--g100)
        }

        .cart-row:last-child {
            border-bottom: none
        }

        .cart-img {
            width: 90px;
            height: 90px;
            border-radius: var(--radius);
            object-fit: cover;
            background: var(--g100)
        }

        .cart-name {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 4px;
            color: var(--g800)
        }

        .cart-sub {
            font-size: 12px;
            color: var(--g400);
            margin-bottom: 10px
        }

        .cart-price-col {
            text-align: right;
            min-width: 120px
        }

        .cart-price-val {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--blue)
        }

        .summary-card {
            background: #fff;
            border-radius: var(--rlg);
            box-shadow: var(--sh);
            padding: 24px;
            position: sticky;
            top: 84px
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--g600)
        }

        .sum-total {
            display: flex;
            justify-content: space-between;
            padding-top: 14px;
            margin-top: 8px;
            border-top: 2px solid var(--g200)
        }

        .sum-total span:first-child {
            font-size: 15px;
            font-weight: 700;
            color: var(--g800)
        }

        .sum-total span:last-child {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--blue)
        }

        .voucher-row {
            display: flex;
            gap: 8px;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid var(--g100)
        }
    </style>
@endsection

@section('header')
    <nav class="navbar">
        <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
        <div class="nav-right">
            <button class="nav-icon-btn" onclick="openCart()">🛒<span class="cart-badge">0</span></button>
            <a href="profile.html" class="nav-icon-btn" title="Profil" style="text-decoration:none;font-size:16px">👤</a>
            <a href="index.html" class="btn btn-outline btn-sm">← Lanjut Belanja</a>
        </div>
    </nav>
    <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2>🛒 Keranjang</h2><button class="cart-close" onclick="closeCart()">✕</button>
        </div>
        <div class="cart-items" id="cartSideItems"></div>
        <div class="cart-footer" id="cartSideFoot"></div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="breadcrumb"><a href="index.html">Home</a> › Keranjang Belanja</div>
        <div style="margin-bottom:20px">
            <div class="section-title" style="font-size:26px">🛒 Keranjang Belanja</div>
        </div>
        <div class="cart-layout">
            <div>
                <div class="cart-main" id="cartMain">
                    <div class="cart-main-head">
                        <input type="checkbox" checked style="width:16px;height:16px;accent-color:var(--blue)">
                        <span style="font-weight:700;font-size:13px" id="cartItemCount">0 produk dipilih</span>
                        <button
                            style="margin-left:auto;background:var(--dl);color:var(--danger);border:none;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer">🗑
                            Hapus Dipilih</button>
                    </div>
                    <div id="cartPageItems"></div>
                </div>
            </div>
            <div>
                <div class="summary-card">
                    <div style="font-weight:800;font-size:16px;margin-bottom:18px">📋 Ringkasan Belanja</div>
                    <div class="sum-row"><span>Total Harga</span><span id="sumBase">–</span></div>
                    <div class="sum-row"><span>Diskon</span><span style="color:var(--danger)" id="sumDisc">–</span>
                    </div>
                    <div class="sum-row"><span>Ongkos Kirim</span><span style="color:var(--success)">GRATIS</span></div>
                    <div class="sum-total"><span>Total Bayar</span><span id="sumTotal">–</span></div>
                    <a href="checkout.html" class="btn btn-primary"
                        style="width:100%;justify-content:center;padding:14px;margin-top:20px;font-size:15px">💳 Proses
                        Checkout</a>
                    <div style="font-size:11px;color:var(--g400);text-align:center;margin-top:10px">🔒 Transaksi aman &
                        terenkripsi</div>
                    <div class="voucher-row">
                        <input type="text" placeholder="Kode voucher..." style="font-size:13px;padding:9px 14px">
                        <button class="btn btn-outline btn-sm" style="white-space:nowrap">Pakai</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">⚡ Elektronik Modern</div>
                <p class="footer-desc">Platform belanja elektronik terpercaya.</p>
            </div>
            <div>
                <h4>Belanja</h4><a href="products.html">Semua Produk</a>
            </div>
            <div>
                <h4>Bantuan</h4><a href="#">Cara Pemesanan</a>
            </div>
            <div>
                <h4>Perusahaan</h4><a href="#">Tentang Kami</a>
            </div>
        </div>
        <div class="footer-bottom"><span>© 2024 Elektronik Modern – Kelompok 2 IF4E UTM</span></div>
    </footer>
    <div class="cart-toast" id="cart-toast"></div>
@endsection

@push('scripts')
    <script src="{{ asset('shared.js') }}"></script>
    <script>
        // Seed some items if empty
        if (!CART.length) { CART.push({ ...PRODUCTS[0], qty: 1 }, { ...PRODUCTS[1], qty: 1 }, { ...PRODUCTS[3], qty: 2 }); saveCart(); }

        function renderPageCart() {
            updateCartBadge();
            document.getElementById('cartItemCount').textContent = CART.length + ' produk dipilih';
            const t = cartTotal(), disc = t > 5000000 ? 500000 : 0;
            document.getElementById('sumBase').textContent = fmt(t);
            document.getElementById('sumDisc').textContent = '−' + fmt(disc);
            document.getElementById('sumTotal').textContent = fmt(t - disc);
            document.getElementById('cartPageItems').innerHTML = CART.map(i => `
        <div class="cart-row">
          <img src="${i.img}" alt="${i.name}" class="cart-img">
          <div>
            <div class="cart-name">${i.name}</div>
            <div class="cart-sub">Garansi Resmi · Stok Tersedia</div>
            <div class="cart-qty">
              <button class="qty-btn" onclick="updateQty(${i.id},-1);renderPageCart()">−</button>
              <input class="qty-num" value="${i.qty}" readonly>
              <button class="qty-btn" onclick="updateQty(${i.id},1);renderPageCart()">+</button>
            </div>
          </div>
          <div class="cart-price-col">
            <div class="cart-price-val">${fmt(i.price * i.qty)}</div>
            <div style="font-size:12px;color:var(--g400)">${fmt(i.price)} / unit</div>
          </div>
          <button style="background:none;border:none;cursor:pointer;color:var(--g300);font-size:22px;transition:.2s" onmouseover="this.style.color='var(--danger)'" onmouseout="this.style.color='var(--g300)'" onclick="removeFromCart(${i.id});renderPageCart()">🗑</button>
        </div>`).join('');
        }

        function renderCart() {
            updateCartBadge();
            const el = document.getElementById('cartSideItems'), foot = document.getElementById('cartSideFoot');
            if (!CART.length) { el.innerHTML = `<div class="cart-empty"><div class="empty-icon">🛒</div><div style="font-weight:700">Keranjang Kosong</div></div>`; foot.innerHTML = ''; return; }
            el.innerHTML = CART.map(i => `<div class="cart-item"><img src="${i.img}" class="cart-item-img"><div class="cart-item-info"><div class="cart-item-name">${i.name}</div><div class="cart-item-price">${fmt(i.price)}</div><div class="cart-qty"><button class="qty-btn" onclick="updateQty(${i.id},-1);renderPageCart()">−</button><input class="qty-num" value="${i.qty}" readonly><button class="qty-btn" onclick="updateQty(${i.id},1);renderPageCart()">+</button></div></div><button class="cart-remove" onclick="removeFromCart(${i.id});renderPageCart()">🗑</button></div>`).join('');
            foot.innerHTML = `<div class="cart-total"><span>Total</span><span>${fmt(cartTotal())}</span></div><a href="checkout.html" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px">💳 Checkout</a>`;
        }
        function openCart() { document.getElementById('cartSidebar').classList.add('open'); document.getElementById('cartOverlay').classList.add('open'); document.body.style.overflow = 'hidden'; renderCart(); }
        function closeCart() { document.getElementById('cartSidebar').classList.remove('open'); document.getElementById('cartOverlay').classList.remove('open'); document.body.style.overflow = ''; }

        renderPageCart();
    </script>
@endpush