@extends('layouts.app')

@section('title', 'Produk – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .listing-wrap {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
            padding: 32px 0 64px;
        }

        .filter-panel {
            background: #fff;
            border-radius: var(--rlg);
            padding: 22px;
            box-shadow: var(--sh);
            height: fit-content;
            position: sticky;
            top: 84px;
        }

        .fp-title {
            font-weight: 800;
            font-size: 15px;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--g100);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .fp-section {
            margin-bottom: 22px;
            padding-bottom: 22px;
            border-bottom: 1px solid var(--g100);
        }

        .fp-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .fp-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--g500);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .fp-opt {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 9px;
            font-size: 14px;
            cursor: pointer;
            color: var(--g700);
        }

        .fp-opt input {
            width: 16px;
            height: 16px;
            accent-color: var(--blue);
            flex-shrink: 0;
        }

        .fp-opt:hover {
            color: var(--blue);
        }

        .price-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .price-inputs input {
            padding: 9px 12px;
            font-size: 13px;
        }

        .toolbar {
            background: #fff;
            border-radius: var(--rlg);
            padding: 14px 18px;
            box-shadow: var(--sh);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .toolbar-count {
            margin-left: auto;
            font-size: 13px;
            color: var(--g500);
            white-space: nowrap;
        }

        .prod-grid-4 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 28px;
        }

        .page-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            border: 1.5px solid var(--g200);
            background: #fff;
            color: var(--g600);
            transition: 0.15s;
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .page-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .page-btn.active {
            background: var(--blue);
            color: #fff;
            border-color: var(--blue);
        }
    </style>
@endsection

@section('header')
    <nav class="navbar">
        <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
        <div class="nav-search">
            <span class="search-icon">🔍</span><input type="text" placeholder="Cari produk..." />
        </div>
        <div class="nav-right">
            <button class="nav-icon-btn" onclick="toggleNotif()">
                🔔<span class="notif-badge">2</span>
            </button>
            <button class="nav-icon-btn" onclick="openCart()">
                🛒<span class="cart-badge">0</span>
            </button>
            <a href="profile.html" class="nav-icon-btn" title="Profil" style="text-decoration: none; font-size: 16px">👤</a>
            <a href="login.html" class="btn btn-outline btn-sm">Masuk</a>
            <a href="register.html" class="btn btn-primary btn-sm">Daftar</a>
        </div>
    </nav>

    <div class="notif-overlay" id="notifOverlay" onclick="closeNotif()"></div>
    <div class="notif-panel" id="notifPanel">
        <div class="notif-pheader">
            <h3>🔔 Notifikasi</h3>
            <button class="notif-mark" onclick="markAllRead()">
                Tandai dibaca
            </button>
        </div>
        <div class="notif-list" id="notifList"></div>
    </div>
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
        <div class="breadcrumb"><a href="index.html">Home</a> › Semua Produk</div>
        <div style="margin-bottom: 20px">
            <div class="section-title" style="font-size: 26px">Semua Produk</div>
            <p style="color: var(--g500); font-size: 14px">
                Menampilkan 87 produk elektronik terbaik
            </p>
        </div>
        <div class="listing-wrap">
            <div class="filter-panel">
                <div class="fp-title">🔧 Filter Produk</div>
                <div class="fp-section">
                    <div class="fp-label">Kategori</div>
                    <label class="fp-opt"><input type="checkbox" checked />Smart TV
                        <span style="margin-left: auto; font-size: 11px; color: var(--g400)">(48)</span></label>
                    <label class="fp-opt"><input type="checkbox" />Kulkas
                        <span style="margin-left: auto; font-size: 11px; color: var(--g400)">(32)</span></label>
                    <label class="fp-opt"><input type="checkbox" />Mesin Cuci
                        <span style="margin-left: auto; font-size: 11px; color: var(--g400)">(24)</span></label>
                    <label class="fp-opt"><input type="checkbox" />AC / Pendingin
                        <span style="margin-left: auto; font-size: 11px; color: var(--g400)">(38)</span></label>
                    <label class="fp-opt"><input type="checkbox" />Kompor & Dapur
                        <span style="margin-left: auto; font-size: 11px; color: var(--g400)">(56)</span></label>
                    <label class="fp-opt"><input type="checkbox" />Penerangan
                        <span style="margin-left: auto; font-size: 11px; color: var(--g400)">(41)</span></label>
                </div>
                <div class="fp-section">
                    <div class="fp-label">Harga</div>
                    <div class="price-inputs">
                        <input type="number" placeholder="Min" value="200000" />
                        <input type="number" placeholder="Max" value="20000000" />
                    </div>
                    <button class="btn btn-primary btn-sm" style="width: 100%; margin-top: 12px; justify-content: center">
                        Terapkan Filter
                    </button>
                </div>
                <div class="fp-section">
                    <div class="fp-label">Merek</div>
                    <label class="fp-opt"><input type="checkbox" checked />Samsung</label>
                    <label class="fp-opt"><input type="checkbox" checked />LG</label>
                    <label class="fp-opt"><input type="checkbox" />Sony</label>
                    <label class="fp-opt"><input type="checkbox" />Panasonic</label>
                    <label class="fp-opt"><input type="checkbox" />Daikin</label>
                    <label class="fp-opt"><input type="checkbox" />Sharp</label>
                    <label class="fp-opt"><input type="checkbox" />Philips</label>
                </div>
                <div class="fp-section">
                    <div class="fp-label">Ketersediaan</div>
                    <label class="fp-opt"><input type="checkbox" checked />Tersedia</label>
                    <label class="fp-opt"><input type="checkbox" />Hampir Habis</label>
                </div>
                <div>
                    <div class="fp-label">Rating</div>
                    <label class="fp-opt"><input type="radio" name="rating" /> ⭐⭐⭐⭐⭐ (5)</label>
                    <label class="fp-opt"><input type="radio" name="rating" /> ⭐⭐⭐⭐+ (4+)</label>
                    <label class="fp-opt"><input type="radio" name="rating" /> ⭐⭐⭐+ (3+)</label>
                </div>
            </div>
            <div>
                <div class="toolbar">
                    <div class="nav-search" style="max-width: 260px; flex: 1">
                        <span class="search-icon">🔍</span><input type="text" placeholder="Cari dalam hasil..." />
                    </div>
                    <select style="width: auto; padding: 10px 14px; font-size: 13px">
                        <option>Terbaru</option>
                        <option>Harga: Rendah–Tinggi</option>
                        <option>Harga: Tinggi–Rendah</option>
                        <option>Rating Tertinggi</option>
                        <option>Terlaris</option>
                    </select>
                    <div class="toolbar-count">
                        Menampilkan <strong>24</strong> dari 87
                    </div>
                </div>
                <div class="prod-grid-4" id="prodGrid"></div>
                <div class="pagination">
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <button class="page-btn">→</button>
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
                <p class="footer-desc">
                    Platform belanja elektronik rumah tangga terpercaya.
                </p>
            </div>
            <div>
                <h4>Belanja</h4>
                <a href="products.html">Smart TV</a><a href="products.html">Kulkas</a><a href="products.html">AC</a>
            </div>
            <div>
                <h4>Bantuan</h4>
                <a href="#">Cara Pemesanan</a><a href="orders.html">Lacak Pesanan</a>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <a href="#">Tentang Kami</a><a href="#">Kontak</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 Elektronik Modern – Kelompok 2 IF4E UTM</span>
        </div>
    </footer>
    <div class="cart-toast" id="cart-toast"></div>
@endsection

@push('scripts')
    <script src="{{ asset('shared.js') }}"></script>
    <script>
        function prodCard(p) {
            const disc = p.badge
                ? `<div class="prod-card-badge badge ${p.badge.startsWith("−") || p.badge === "HOT" ? "badge-danger" : "badge-new"}">${p.badge}</div>`
                : "";
            const old = p.oldPrice
                ? `<span class="prod-old">${fmt(p.oldPrice)}</span>`
                : "";
            return `<div class="prod-card" onclick="window.location='product-detail.html'">
        <div class="prod-img-wrap"><img src="${p.img}" alt="${p.name}" loading="lazy">${disc}<button class="prod-wishlist" onclick="event.stopPropagation()">♡</button></div>
        <div class="prod-body">
          <div class="prod-cat">${p.cat}</div>
          <div class="prod-name">${p.name}</div>
          <div class="prod-price-row"><span class="prod-price">${fmt(p.price)}</span>${old}</div>
          <div class="prod-footer"><span class="prod-stock">Stok: ${p.stock}</span><button class="add-cart-btn" onclick="event.stopPropagation();addToCart(${p.id})">+</button></div>
        </div></div>`;
        }
        document.getElementById("prodGrid").innerHTML = PRODUCTS.map((p) =>
            prodCard(p),
        ).join("");
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
                    `<div class="cart-item"><img src="${i.img}" class="cart-item-img"><div class="cart-item-info"><div class="cart-item-name">${i.name}</div><div class="cart-item-price">${fmt(i.price)}</div><div class="cart-qty"><button class="qty-btn" onclick="updateQty(${i.id},-1)">−</button><input class="qty-num" value="${i.qty}" readonly><button class="qty-btn" onclick="updateQty(${i.id},1)">+</button></div></div><button class="cart-remove" onclick="removeFromCart(${i.id})">🗑</button></div>`,
            ).join("");
            const t = cartTotal(),
                disc = t > 5000000 ? 500000 : 0;
            foot.innerHTML = `<div class="cart-subtotal"><span>Subtotal</span><span>${fmt(t)}</span></div><div class="cart-total"><span>Total</span><span>${fmt(t - disc)}</span></div><a href="cart.html" class="btn btn-outline" style="width:100%;justify-content:center;margin-bottom:10px">Lihat Keranjang</a><a href="checkout.html" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px">💳 Checkout</a>`;
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
        function renderNotifs() {
            document.getElementById("notifList").innerHTML = NOTIFICATIONS.map(
                (n) =>
                    `<div class="notif-item ${n.read ? "" : "unread"}"><div class="notif-icon">${n.icon}</div><div><div class="notif-title">${n.title}</div><div class="notif-msg">${n.msg}</div><div class="notif-time">${n.time}</div></div></div>`,
            ).join("");
            updateNotifBadge();
        }
        function toggleNotif() {
            const p = document.getElementById("notifPanel"),
                o = document.getElementById("notifOverlay");
            const open = p.classList.toggle("open");
            o.style.display = open ? "block" : "none";
            if (open) renderNotifs();
        }
        function closeNotif() {
            document.getElementById("notifPanel").classList.remove("open");
            document.getElementById("notifOverlay").style.display = "none";
        }
        function markAllRead() {
            NOTIFICATIONS.forEach((n) => (n.read = true));
            renderNotifs();
        }
        updateCartBadge();
        updateNotifBadge();
    </script>
@endpush