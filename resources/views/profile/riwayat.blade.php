@extends('layouts.app')

@section('title', 'Riwayat Pesanan – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .orders-wrap {
            padding: 32px 0 64px;
            max-width: 800px;
            margin: 0 auto;
        }

        .tab-bar {
            display: flex;
            gap: 4px;
            background: #fff;
            border-radius: 50px;
            padding: 4px;
            box-shadow: var(--sh);
            margin-bottom: 24px;
            width: fit-content;
        }

        .tab-btn {
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: "Plus Jakarta Sans", sans-serif;
            color: var(--g500);
            transition: 0.2s;
        }

        .tab-btn.active {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 4px 12px rgba(26, 92, 255, 0.3);
        }

        .order-card {
            background: #fff;
            border-radius: var(--rlg);
            box-shadow: var(--sh);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .order-head {
            padding: 14px 20px;
            border-bottom: 1px solid var(--g100);
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--g50);
        }

        .order-num {
            font-weight: 800;
            font-size: 13px;
            color: var(--g800);
        }

        .order-date {
            font-size: 12px;
            color: var(--g400);
        }

        .order-body {
            padding: 18px 20px;
        }

        .order-item {
            display: flex;
            gap: 14px;
            align-items: center;
            margin-bottom: 14px;
        }

        .order-item-img {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            object-fit: cover;
            background: var(--g100);
            flex-shrink: 0;
        }

        .order-item-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--g800);
        }

        .order-item-qty {
            font-size: 12px;
            color: var(--g400);
            margin-top: 2px;
        }

        .order-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid var(--g100);
            margin-top: 4px;
        }

        .order-total {
            font-size: 14px;
            color: var(--g600);
        }

        .order-total strong {
            font-family: "Syne", sans-serif;
            font-size: 17px;
            color: var(--blue);
        }
    </style>
@endsection

@section('header')
    <nav class="navbar">
        <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
        <div class="nav-right">
            <button class="nav-icon-btn" onclick="openCart()">
                🛒<span class="cart-badge">0</span>
            </button>
            <a href="profile.html" class="nav-icon-btn" title="Profil" style="text-decoration: none; font-size: 16px">👤</a>
            <a href="index.html" class="btn btn-outline btn-sm">← Lanjut Belanja</a>
        </div>
    </nav>
    <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2>🛒 Keranjang</h2>
            <button class="cart-close" onclick="closeCart()">✕</button>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-footer" id="cartFooter"></div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html">Home</a> › Riwayat Pesanan
        </div>
        <div class="orders-wrap">
            <div class="section-title" style="font-size: 26px; margin-bottom: 8px">
                📋 Riwayat Pesanan
            </div>
            <p style="color: var(--g500); font-size: 14px; margin-bottom: 24px">
                Pantau status semua pesanan Anda
            </p>
            <div class="tab-bar">
                <button class="tab-btn active">Semua</button>
                <button class="tab-btn">⏳ Menunggu</button>
                <button class="tab-btn">⚙️ Diproses</button>
                <button class="tab-btn">🚚 Dikirim</button>
                <button class="tab-btn">✅ Selesai</button>
            </div>
            <!-- Order 1 - Selesai -->
            <div class="order-card">
                <div class="order-head">
                    <div>
                        <div class="order-num">#ORD-20241201-001</div>
                        <div class="order-date">01 Desember 2024</div>
                    </div>
                    <span class="badge badge-success" style="margin-left: auto">✅ Selesai</span>
                </div>
                <div class="order-body">
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=120&q=75"
                            class="order-item-img" />
                        <div style="flex: 1">
                            <div class="order-item-name">
                                Samsung Smart TV 43" 4K UHD Crystal
                            </div>
                            <div class="order-item-qty">×1 unit</div>
                        </div>
                        <div style="
                      font-weight: 800;
                      color: var(--blue);
                      font-family: &quot;Syne&quot;, sans-serif;
                    ">
                            Rp 6.499.000
                        </div>
                    </div>
                    <div class="order-foot">
                        <div class="order-total">
                            Total: <strong>Rp 6.499.000</strong>
                        </div>
                        <div style="display: flex; gap: 8px">
                            <button class="btn btn-outline btn-sm">⭐ Beri Ulasan</button>
                            <a href="products.html" class="btn btn-primary btn-sm">🔄 Beli Lagi</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order 2 - Dikirim -->
            <div class="order-card">
                <div class="order-head">
                    <div>
                        <div class="order-num">#ORD-20241128-002</div>
                        <div class="order-date">28 November 2024</div>
                    </div>
                    <span class="badge badge-info" style="margin-left: auto">🚚 Dikirim</span>
                </div>
                <div class="order-body">
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1571175443880-49e1d25b2bc5?w=120&q=75"
                            class="order-item-img" />
                        <div style="flex: 1">
                            <div class="order-item-name">
                                LG Kulkas 2 Pintu 380L Inverter
                            </div>
                            <div class="order-item-qty">×1 unit</div>
                        </div>
                        <div style="
                      font-weight: 800;
                      color: var(--blue);
                      font-family: &quot;Syne&quot;, sans-serif;
                    ">
                            Rp 5.199.000
                        </div>
                    </div>
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=120&q=75"
                            class="order-item-img" />
                        <div style="flex: 1">
                            <div class="order-item-name">
                                Daikin AC Split 1PK Inverter 5-Star
                            </div>
                            <div class="order-item-qty">×2 unit</div>
                        </div>
                        <div style="
                      font-weight: 800;
                      color: var(--blue);
                      font-family: &quot;Syne&quot;, sans-serif;
                    ">
                            Rp 7.700.000
                        </div>
                    </div>
                    <div style="
                    background: var(--blue-l);
                    border-radius: var(--radius);
                    padding: 10px 14px;
                    font-size: 13px;
                    color: var(--blue);
                    font-weight: 600;
                    margin-bottom: 14px;
                  ">
                        🚚 Dalam pengiriman · JNE Reguler · No. Resi: JNE1234567890
                    </div>
                    <div class="order-foot">
                        <div class="order-total">
                            Total: <strong>Rp 12.899.000</strong>
                        </div>
                        <button class="btn btn-outline btn-sm">📍 Lacak Paket</button>
                    </div>
                </div>
            </div>
            <!-- Order 3 - Diproses -->
            <div class="order-card">
                <div class="order-head">
                    <div>
                        <div class="order-num">#ORD-20241205-003</div>
                        <div class="order-date">05 Desember 2024</div>
                    </div>
                    <span class="badge badge-warn" style="margin-left: auto">⚙️ Diproses</span>
                </div>
                <div class="order-body">
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?w=120&q=75"
                            class="order-item-img" />
                        <div style="flex: 1">
                            <div class="order-item-name">
                                Panasonic Mesin Cuci Front Load 7KG
                            </div>
                            <div class="order-item-qty">×1 unit</div>
                        </div>
                        <div style="
                      font-weight: 800;
                      color: var(--blue);
                      font-family: &quot;Syne&quot;, sans-serif;
                    ">
                            Rp 4.299.000
                        </div>
                    </div>
                    <div class="order-foot">
                        <div class="order-total">
                            Total: <strong>Rp 4.299.000</strong>
                        </div>
                        <button class="btn btn-outline btn-sm">📋 Detail</button>
                    </div>
                </div>
            </div>
            <!-- Order 4 - Menunggu -->
            <div class="order-card">
                <div class="order-head">
                    <div>
                        <div class="order-num">#ORD-20241206-004</div>
                        <div class="order-date">06 Desember 2024</div>
                    </div>
                    <span class="badge badge-pend" style="margin-left: auto">⏳ Menunggu</span>
                </div>
                <div class="order-body">
                    <div class="order-item">
                        <img src="https://images.unsplash.com/photo-1509281373149-e957c6296406?w=120&q=75"
                            class="order-item-img" />
                        <div style="flex: 1">
                            <div class="order-item-name">
                                Sony BRAVIA 55" OLED 4K Google TV
                            </div>
                            <div class="order-item-qty">×1 unit</div>
                        </div>
                        <div style="
                      font-weight: 800;
                      color: var(--blue);
                      font-family: &quot;Syne&quot;, sans-serif;
                    ">
                            Rp 14.999.000
                        </div>
                    </div>
                    <div style="
                    background: var(--wl);
                    border-radius: var(--radius);
                    padding: 10px 14px;
                    font-size: 13px;
                    color: var(--warn);
                    font-weight: 600;
                    margin-bottom: 14px;
                  ">
                        ⚠️ Menunggu konfirmasi admin · Upload bukti pembayaran jika belum
                    </div>
                    <div class="order-foot">
                        <div class="order-total">
                            Total: <strong>Rp 14.999.000</strong>
                        </div>
                        <div style="display: flex; gap: 8px">
                            <a href="checkout.html" class="btn btn-outline btn-sm">📸 Upload Bukti</a>
                            <button class="btn btn-sm" style="
                        background: var(--dl);
                        color: var(--danger);
                        border: none;
                        font-weight: 700;
                      ">
                                Batalkan
                            </button>
                        </div>
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
                <div class="footer-brand">⚡ Elektronik Moder</div>
                <p class="footer-desc">Platform belanja elektronik terpercaya.</p>
            </div>
            <div>
                <h4>Belanja</h4>
                <a href="products.html">Semua Produk</a>
            </div>
            <div>
                <h4>Bantuan</h4>
                <a href="#">Cara Pemesanan</a>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <a href="#">Tentang Kami</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 Elektronik Moder – Kelompok 2 IF4E UTM</span>
        </div>
    </footer>
@endsection

@push('scripts')
    <script src="{{ asset('shared.js') }}"></script>
    <script>
        function renderCart() {
            updateCartBadge();
            const el = document.getElementById("cartItems"),
                foot = document.getElementById("cartFooter");
            if (!CART.length) {
                el.innerHTML = `<div class="cart-empty"><div class="empty-icon">🛒</div><div style="font-weight:700">Keranjang Kosong</div><a href="products.html" class="btn btn-primary" style="margin-top:16px;display:inline-flex">Belanja</a></div>`;
                foot.innerHTML = "";
                return;
            }
            el.innerHTML = CART.map(
                (i) =>
                    `<div class="cart-item"><img src="${i.img}" class="cart-item-img"><div class="cart-item-info"><div class="cart-item-name">${i.name}</div><div class="cart-item-price">${fmt(i.price)}</div></div><button class="cart-remove" onclick="removeFromCart(${i.id});renderCart()">🗑</button></div>`,
            ).join("");
            foot.innerHTML = `<div class="cart-total"><span>Total</span><span>${fmt(cartTotal())}</span></div><a href="checkout.html" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px;margin-top:12px">💳 Checkout</a>`;
        }
        function openCart() {
            document.getElementById("cartSidebar").classList.add("open");
            document.getElementById("cartOverlay").classList.add("open");
            document.body.style.overflow = "hidden";
            renderCart();
        }
        function closeCart() {
            document.getElementById("cartSidebar").classList.remove("open");
            document.getElementById("cartOverlay").classList.remove("open");
            document.body.style.overflow = "";
        }
        updateCartBadge();
    </script>
@endpush