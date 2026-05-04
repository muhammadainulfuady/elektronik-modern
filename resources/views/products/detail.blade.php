@extends('layouts.app')

@section('title', 'Samsung Smart TV 43" – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
    <style>
        .detail-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            padding: 32px 0 64px;
            align-items: start
        }

        .gallery {
            position: sticky;
            top: 84px
        }

        .gallery-main {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: var(--rxl);
            background: var(--g100);
            margin-bottom: 12px;
            box-shadow: var(--sh-md)
        }

        .gallery-thumbs {
            display: flex;
            gap: 10px
        }

        .g-thumb {
            width: 72px;
            height: 72px;
            border-radius: var(--radius);
            object-fit: cover;
            border: 2px solid transparent;
            cursor: pointer;
            transition: .2s;
            background: var(--g100)
        }

        .g-thumb.active,
        .g-thumb:hover {
            border-color: var(--blue)
        }

        .detail-brand {
            font-size: 12px;
            font-weight: 700;
            color: var(--blue);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 6px
        }

        .detail-title {
            font-family: 'Syne', sans-serif;
            font-size: 30px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 12px;
            color: var(--g900)
        }

        .stars-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px
        }

        .stars {
            color: #F59E0B;
            font-size: 17px
        }

        .rating-count {
            font-size: 13px;
            color: var(--g500)
        }

        .price-box {
            background: var(--g50);
            border-radius: var(--rlg);
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--g200)
        }

        .detail-price {
            font-family: 'Syne', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: var(--blue);
            margin-bottom: 4px
        }

        .detail-old {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--g400)
        }

        .detail-old s {
            font-size: 16px
        }

        .qty-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px
        }

        .qty-ctrl {
            display: flex;
            align-items: center;
            border: 2px solid var(--g200);
            border-radius: var(--radius);
            overflow: hidden;
            width: fit-content
        }

        .q-btn {
            width: 44px;
            height: 44px;
            border: none;
            background: var(--g50);
            cursor: pointer;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--g700);
            transition: .15s
        }

        .q-btn:hover {
            background: var(--blue-l);
            color: var(--blue)
        }

        .q-input {
            width: 60px;
            text-align: center;
            font-weight: 800;
            font-size: 16px;
            border: none;
            border-left: 2px solid var(--g200);
            border-right: 2px solid var(--g200);
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 0
        }

        .detail-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 24px
        }

        .spec-box {
            background: #fff;
            border-radius: var(--rlg);
            border: 1px solid var(--g200);
            overflow: hidden
        }

        .spec-title {
            padding: 16px 20px;
            font-weight: 800;
            font-size: 14px;
            background: var(--g50);
            border-bottom: 1px solid var(--g200)
        }

        .spec-grid {
            display: grid;
            grid-template-columns: 1fr 1fr
        }

        .spec-row {
            padding: 12px 20px;
            border-bottom: 1px solid var(--g100);
            display: flex;
            flex-direction: column
        }

        .spec-row:nth-child(odd) {
            background: var(--g50)
        }

        .spec-key {
            font-size: 11px;
            font-weight: 700;
            color: var(--g500);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 2px
        }

        .spec-val {
            font-size: 14px;
            font-weight: 600;
            color: var(--g800)
        }

        .info-strip {
            background: var(--g50);
            border-radius: var(--rlg);
            padding: 16px 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin-bottom: 20px;
            border: 1px solid var(--g100)
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 12px;
            border-right: 1px solid var(--g200)
        }

        .info-item:first-child {
            padding-left: 0
        }

        .info-item:last-child {
            border-right: none
        }

        .info-icon {
            font-size: 22px
        }

        .info-label {
            font-size: 11px;
            color: var(--g500);
            font-weight: 600
        }

        .info-val {
            font-size: 13px;
            font-weight: 800;
            color: var(--g800)
        }
    </style>
@endsection

@section('header')
    <nav class="navbar">
        <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
        <div class="nav-search"><span class="search-icon">🔍</span><input type="text" placeholder="Cari produk...">
        </div>
        <div class="nav-right">
            <button class="nav-icon-btn" onclick="toggleNotif()">🔔<span class="notif-badge">2</span></button>
            <button class="nav-icon-btn" onclick="openCart()">🛒<span class="cart-badge">0</span></button>
            <a href="profile.html" class="nav-icon-btn" title="Profil" style="text-decoration:none;font-size:16px">👤</a>
            <a href="login.html" class="btn btn-outline btn-sm">Masuk</a>
        </div>
    </nav>
    <div class="notif-overlay" id="notifOverlay" onclick="closeNotif()"></div>
    <div class="notif-panel" id="notifPanel">
        <div class="notif-pheader">
            <h3>🔔 Notifikasi</h3><button class="notif-mark" onclick="markAllRead()">Tandai dibaca</button>
        </div>
        <div class="notif-list" id="notifList"></div>
    </div>
    <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2>🛒 Keranjang</h2><button class="cart-close" onclick="closeCart()">✕</button>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-footer" id="cartFooter"></div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="breadcrumb"><a href="index.html">Home</a> › <a href="products.html">Smart TV</a> › Samsung Smart TV
            43"</div>
        <div class="detail-layout">
            <!-- Gallery -->
            <div class="gallery">
                <img id="mainImg" src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=700&q=85"
                    alt="Samsung TV" class="gallery-main">
                <div class="gallery-thumbs">
                    <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=200&q=75"
                        class="g-thumb active"
                        onclick="changeImg(this,'https://images.unsplash.com/photo-1593784991095-a205069470b6?w=700&q=85')">
                    <img src="https://images.unsplash.com/photo-1509281373149-e957c6296406?w=200&q=75" class="g-thumb"
                        onclick="changeImg(this,'https://images.unsplash.com/photo-1509281373149-e957c6296406?w=700&q=85')">
                    <img src="https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=200&q=75" class="g-thumb"
                        onclick="changeImg(this,'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=700&q=85')">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&q=75" class="g-thumb"
                        onclick="changeImg(this,'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=700&q=85')">
                </div>
            </div>
            <!-- Detail -->
            <div>
                <div class="detail-brand">SAMSUNG</div>
                <h1 class="detail-title">Samsung Smart TV 43" 4K UHD Crystal HDR</h1>
                <div class="stars-row">
                    <span class="stars">★★★★★</span>
                    <span class="rating-count">4.9 (128 ulasan)</span>
                    <span class="badge badge-success">✓ Tersedia</span>
                    <span class="badge badge-danger" style="margin-left:4px">−15%</span>
                </div>
                <div class="price-box">
                    <div class="detail-price">Rp 6.499.000</div>
                    <div class="detail-old"><s>Rp 7.650.000</s> <span class="badge badge-danger">Hemat Rp
                            1.151.000</span></div>
                </div>
                <div class="info-strip">
                    <div class="info-item">
                        <div class="info-icon">🚚</div>
                        <div>
                            <div class="info-label">Pengiriman</div>
                            <div class="info-val">Gratis Ongkir</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">🛡️</div>
                        <div>
                            <div class="info-label">Garansi Resmi</div>
                            <div class="info-val">2 Tahun</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">↩️</div>
                        <div>
                            <div class="info-label">Retur</div>
                            <div class="info-val">7 Hari</div>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom:18px">
                    <div style="font-size:14px;color:var(--g600);line-height:1.8">Samsung Smart TV 43" 4K UHD dengan
                        teknologi <strong>Crystal Processor 4K</strong> menghadirkan gambar yang jernih dan tajam.
                        Dilengkapi sistem operasi <strong>Tizen OS</strong> untuk akses Netflix, YouTube, Disney+, dan
                        streaming lainnya langsung dari TV.</div>
                </div>
                <div class="qty-row">
                    <div>
                        <label style="margin-bottom:8px">Jumlah</label>
                        <div class="qty-ctrl">
                            <button class="q-btn" onclick="changeQty(-1)">−</button>
                            <input class="q-input" id="qtyInput" value="1" readonly>
                            <button class="q-btn" onclick="changeQty(1)">+</button>
                        </div>
                    </div>
                    <div style="font-size:13px;color:var(--g500);margin-top:20px">Stok: <strong
                            style="color:var(--success)">12 unit</strong> tersedia</div>
                </div>
                <div class="detail-actions">
                    <button class="btn btn-primary" style="flex:1;justify-content:center;padding:13px"
                        onclick="addToCart(1,parseInt(document.getElementById('qtyInput').value));openCart()">🛒 Tambah
                        ke Keranjang</button>
                    <button class="btn btn-outline" style="padding:13px 16px">♡</button>
                    <button class="btn btn-outline" style="padding:13px 16px">🔗</button>
                </div>
                <a href="checkout.html" class="btn btn-outline"
                    style="width:100%;justify-content:center;margin-bottom:24px">⚡ Beli Sekarang</a>
                <!-- Specs -->
                <div class="spec-box">
                    <div class="spec-title">📋 Spesifikasi Produk</div>
                    <div class="spec-grid">
                        <div class="spec-row"><span class="spec-key">Ukuran Layar</span><span class="spec-val">43
                                Inci</span></div>
                        <div class="spec-row"><span class="spec-key">Resolusi</span><span class="spec-val">4K UHD
                                3840×2160</span></div>
                        <div class="spec-row"><span class="spec-key">Panel</span><span class="spec-val">Crystal
                                Display</span></div>
                        <div class="spec-row"><span class="spec-key">Sistem Operasi</span><span class="spec-val">Tizen
                                OS 7.0</span></div>
                        <div class="spec-row"><span class="spec-key">HDMI</span><span class="spec-val">3 × HDMI
                                2.0</span></div>
                        <div class="spec-row"><span class="spec-key">USB</span><span class="spec-val">2 × USB 2.0</span>
                        </div>
                        <div class="spec-row"><span class="spec-key">Audio</span><span class="spec-val">20W Dolby
                                Digital</span></div>
                        <div class="spec-row"><span class="spec-key">Garansi</span><span class="spec-val">2 Tahun
                                Resmi</span></div>
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
                <h4>Bantuan</h4><a href="orders.html">Riwayat Pesanan</a>
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
        function changeImg(el, src) { document.getElementById('mainImg').src = src; document.querySelectorAll('.g-thumb').forEach(t => t.classList.remove('active')); el.classList.add('active'); }
        function changeQty(d) { const i = document.getElementById('qtyInput'); const v = Math.max(1, parseInt(i.value) + d); i.value = v; }
        function renderCart() {
            updateCartBadge();
            const el = document.getElementById('cartItems'), foot = document.getElementById('cartFooter');
            if (!CART.length) { el.innerHTML = `<div class="cart-empty"><div class="empty-icon">🛒</div><div style="font-weight:700">Keranjang Kosong</div></div>`; foot.innerHTML = ''; return; }
            el.innerHTML = CART.map(i => `<div class="cart-item"><img src="${i.img}" class="cart-item-img"><div class="cart-item-info"><div class="cart-item-name">${i.name}</div><div class="cart-item-price">${fmt(i.price)}</div><div class="cart-qty"><button class="qty-btn" onclick="updateQty(${i.id},-1)">−</button><input class="qty-num" value="${i.qty}" readonly><button class="qty-btn" onclick="updateQty(${i.id},1)">+</button></div></div><button class="cart-remove" onclick="removeFromCart(${i.id})">🗑</button></div>`).join('');
            const t = cartTotal();
            foot.innerHTML = `<div class="cart-total"><span>Total</span><span>${fmt(t)}</span></div><a href="checkout.html" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px">💳 Checkout</a>`;
        }
        function openCart() { document.getElementById('cartSidebar').classList.add('open'); document.getElementById('cartOverlay').classList.add('open'); document.body.style.overflow = 'hidden'; renderCart(); }
        function closeCart() { document.getElementById('cartSidebar').classList.remove('open'); document.getElementById('cartOverlay').classList.remove('open'); document.body.style.overflow = ''; }
        function renderNotifs() { document.getElementById('notifList').innerHTML = NOTIFICATIONS.map(n => `<div class="notif-item ${n.read ? '' : 'unread'}"><div class="notif-icon">${n.icon}</div><div><div class="notif-title">${n.title}</div><div class="notif-msg">${n.msg}</div><div class="notif-time">${n.time}</div></div></div>`).join(''); updateNotifBadge(); }
        function toggleNotif() { const p = document.getElementById('notifPanel'), o = document.getElementById('notifOverlay'); const open = p.classList.toggle('open'); o.style.display = open ? 'block' : 'none'; if (open) renderNotifs(); }
        function closeNotif() { document.getElementById('notifPanel').classList.remove('open'); document.getElementById('notifOverlay').style.display = 'none'; }
        function markAllRead() { NOTIFICATIONS.forEach(n => n.read = true); renderNotifs(); }
        updateCartBadge(); updateNotifBadge();
    </script>
@endpush