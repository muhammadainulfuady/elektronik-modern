@extends('layouts.app')

@section('title', 'Elektronik Modern – Toko Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        /* ===== HERO ===== */
        .hero {
            position: relative;
            min-height: 580px;
            background: linear-gradient(135deg,
                    #050d2e 0%,
                    #0f2060 40%,
                    #0a4d8c 70%,
                    #0a3060 100%);
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero-particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .hero-particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            animation: float linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0);
            }

            100% {
                transform: translateY(-100vh) rotate(360deg);
            }
        }

        .hero-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle,
                    rgba(26, 92, 255, 0.3) 0%,
                    transparent 70%);
            top: -200px;
            right: -100px;
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.9;
            }
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            max-width: 1280px;
            margin: 0 auto;
            padding: 60px 32px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            width: 100%;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.04em;
            backdrop-filter: blur(8px);
        }

        .hero h1 {
            font-family: "Syne", sans-serif;
            font-size: 50px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 18px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #60a5fa, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 36px;
        }

        .hero-stat {
            text-align: left;
        }

        .hero-stat-num {
            font-family: "Syne", sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #fff;
        }

        .hero-stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 2px;
        }

        .hero-img-col {
            position: relative;
        }

        .hero-main-img {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4);
            object-fit: cover;
            height: 380px;
        }

        .hero-float-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 14px 18px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hero-float-1 {
            bottom: -20px;
            left: -20px;
            animation: floatCard 3s ease-in-out infinite;
        }

        .hero-float-2 {
            top: -16px;
            right: -16px;
            animation: floatCard 3s ease-in-out infinite 0.5s;
        }

        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .hfc-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .hfc-label {
            font-size: 11px;
            color: #666;
            font-weight: 600;
        }

        .hfc-val {
            font-size: 14px;
            font-weight: 800;
            color: #111;
            font-family: "Syne", sans-serif;
        }

        /* ===== PROMO BANNER ===== */
        .promo-strip {
            background: linear-gradient(90deg, var(--blue), var(--teal));
            padding: 14px 32px;
            text-align: center;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
        }

        .promo-strip span {
            opacity: 0.8;
            margin: 0 20px;
        }

        /* ===== CATEGORY ===== */
        .cat-section {
            padding: 72px 0 0;
        }

        .cat-scroll {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-top: 28px;
        }

        .cat-card {
            background: #fff;
            border-radius: var(--rlg);
            padding: 0;
            box-shadow: var(--sh);
            cursor: pointer;
            transition: 0.25s;
            overflow: hidden;
            border: 2px solid transparent;
            text-decoration: none;
        }

        .cat-card:hover {
            border-color: var(--blue);
            transform: translateY(-4px);
            box-shadow: var(--sh-md);
        }

        .cat-img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            background: var(--g100);
        }

        .cat-body {
            padding: 14px;
            text-align: center;
        }

        .cat-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--g800);
            margin-bottom: 2px;
        }

        .cat-count {
            font-size: 11px;
            color: var(--g400);
        }

        /* ===== BRAND LOGOS ===== */
        .brands-section {
            padding: 56px 0;
            background: #fff;
            border-top: 1px solid var(--g100);
        }

        .brands-title {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--g400);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .brands-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 48px;
            flex-wrap: wrap;
        }

        .brand-logo {
            font-family: "Syne", sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--g300);
            transition: 0.2s;
            cursor: default;
        }

        .brand-logo:hover {
            color: var(--blue);
        }

        /* ===== FEATURED SECTION ===== */
        .featured-section {
            padding: 72px 0;
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .prod-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        /* ===== DEALS BANNER ===== */
        .deals-section {
            padding: 0 0 72px;
        }

        .deals-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .deal-card {
            border-radius: var(--rxl);
            overflow: hidden;
            position: relative;
            min-height: 260px;
            cursor: pointer;
            transition: 0.3s;
        }

        .deal-card:hover {
            transform: scale(1.01);
            box-shadow: var(--sh-lg);
        }

        .deal-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }

        .deal-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(10, 15, 30, 0.85) 0%,
                    rgba(10, 15, 30, 0.4) 100%);
            padding: 32px;
        }

        .deal-tag {
            font-size: 11px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 4px 12px;
            border-radius: 50px;
            margin-bottom: 10px;
            display: inline-block;
            letter-spacing: 0.04em;
        }

        .deal-title {
            font-family: "Syne", sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .deal-sub {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-bottom: 18px;
        }

        .deal-badge {
            display: inline-flex;
            background: linear-gradient(135deg, #ff6b35, #ff3366);
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 50px;
        }

        /* ===== TESTIMONIALS ===== */
        .review-section {
            padding: 72px 0;
            background: #fff;
        }

        .review-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 32px;
        }

        .review-card {
            background: var(--g50);
            border-radius: var(--rlg);
            padding: 24px;
            border: 1px solid var(--g200);
        }

        .review-stars {
            color: #f59e0b;
            font-size: 16px;
            margin-bottom: 12px;
        }

        .review-text {
            font-size: 14px;
            color: var(--g600);
            line-height: 1.7;
            margin-bottom: 16px;
            font-style: italic;
        }

        .review-author {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--g200);
        }

        .review-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--g800);
        }

        .review-date {
            font-size: 11px;
            color: var(--g400);
        }

        /* ===== WHY US ===== */
        .why-section {
            padding: 72px 0;
            background: linear-gradient(135deg, var(--dark) 0%, #0f2060 100%);
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .why-card {
            text-align: center;
            padding: 32px 20px;
        }

        .why-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .why-title {
            font-family: "Syne", sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .why-text {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.7;
        }

        /* ===== NEW ARRIVALS ===== */
        .new-section {
            padding: 72px 0;
        }

        /* ===== NEWSLETTER ===== */
        .newsletter {
            background: linear-gradient(135deg, var(--blue), var(--blue-mid));
            padding: 64px 32px;
            text-align: center;
            margin: 0;
        }

        .newsletter h2 {
            font-family: "Syne", sans-serif;
            font-size: 34px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }

        .newsletter p {
            color: rgba(255, 255, 255, 0.75);
            font-size: 16px;
            margin-bottom: 28px;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
            max-width: 460px;
            margin: 0 auto;
        }

        .newsletter-form input {
            flex: 1;
            padding: 13px 20px;
            border-radius: 50px;
            border: none;
            font-size: 14px;
            font-family: "Plus Jakarta Sans", sans-serif;
            outline: none;
        }
    </style>
@endsection

@section('header')
    <!-- PROMO STRIP -->
    <div class="promo-strip">
        🎉 Promo Hari Ini: Gratis ongkir untuk semua produk! <span>|</span> ⚡
        Flash Sale mulai pukul 12.00 WIB <span>|</span> 🔥 Diskon s/d 30%
    </div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
        <div class="nav-search">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Cari TV, kulkas, AC, mesin cuci..." />
        </div>
        <div class="nav-right">
            <button class="nav-icon-btn" onclick="toggleNotif()" title="Notifikasi">
                🔔<span class="notif-badge">2</span>
            </button>
            <button class="nav-icon-btn" onclick="openCart()" title="Keranjang">
                🛒<span class="cart-badge">0</span>
            </button>
            <a href="profile.html" class="nav-icon-btn" title="Profil Saya"
                style="text-decoration: none; font-size: 16px">👤</a>
            <a href="login.html" class="btn btn-outline btn-sm">Masuk</a>
            <a href="register.html" class="btn btn-primary btn-sm">Daftar</a>
        </div>
    </nav>

    <!-- NOTIFICATION PANEL -->
    <div class="notif-overlay" id="notifOverlay" onclick="closeNotif()"></div>
    <div class="notif-panel" id="notifPanel">
        <div class="notif-pheader">
            <h3>🔔 Notifikasi</h3>
            <button class="notif-mark" onclick="markAllRead()">
                Tandai semua dibaca
            </button>
        </div>
        <div class="notif-list" id="notifList"></div>
    </div>

    <!-- CART SIDEBAR -->
    <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2>🛒 Keranjang Belanja</h2>
            <button class="cart-close" onclick="closeCart()">✕</button>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-footer" id="cartFooter"></div>
    </div>

@endsection

@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="hero-particles" id="particles"></div>
        <div class="hero-glow"></div>
        <div class="hero-inner">
            <div>
                <div class="hero-tag">✨ Promo Akhir Tahun 2024</div>
                <h1>Elektronik <span>Rumah Modern</span>, Harga Terbaik!</h1>
                <p class="hero-desc">
                    Temukan ribuan produk elektronik pilihan — Smart TV, Kulkas, Mesin
                    Cuci, AC & lebih banyak lagi — dengan pengiriman cepat ke seluruh
                    Indonesia.
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap">
                    <a href="products.html" class="btn btn-primary btn-lg">🛍️ Belanja Sekarang</a>
                    <a href="products.html" class="btn btn-ghost btn-lg">Lihat Katalog →</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num">
                            {{ $jumlahProduk }}+
                        </div>
                        <div class="hero-stat-label">Produk Tersedia</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">
                            {{ $jumlahUser }}+
                        </div>
                        <div class="hero-stat-label">Pelanggan Puas</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">
                            {{ $rating }}★
                        </div>
                        <div class="hero-stat-label">Rating Toko</div>
                    </div>
                </div>
            </div>
            <div class="hero-img-col">
                <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=700&q=85" alt="Smart TV Samsung"
                    class="hero-main-img" />
                <div class="hero-float-card hero-float-1">
                    <div class="hfc-icon" style="background: #eef3ff">🚚</div>
                    <div>
                        <div class="hfc-label">Pengiriman</div>
                        <div class="hfc-val">Gratis Ongkir</div>
                    </div>
                </div>
                <div class="hero-float-card hero-float-2">
                    <div class="hfc-icon" style="background: #dcfce7">🛡️</div>
                    <div>
                        <div class="hfc-label">Garansi Resmi</div>
                        <div class="hfc-val">2 Tahun</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BRANDS -->
    <div class="brands-section">
        <div class="container">
            <div class="brands-title">
                Brand Resmi Tersedia di Elektronik Modern
            </div>
            <div class="brands-row">
                <div class="brand-logo">SAMSUNG</div>
                <div class="brand-logo">LG</div>
                <div class="brand-logo">SONY</div>
                <div class="brand-logo">DAIKIN</div>
                <div class="brand-logo">PANASONIC</div>
                <div class="brand-logo">SHARP</div>
                <div class="brand-logo">PHILIPS</div>
            </div>
        </div>
    </div>

    <!-- CATEGORIES -->
    <section class="cat-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <div class="section-tag">🏠 Kategori</div>
                    <div class="section-title">Belanja Berdasarkan Kategori</div>
                </div>
                <a href="products.html" class="btn btn-outline">Semua Kategori →</a>
            </div>
            <div class="cat-scroll">
                @foreach ($produks as $produk)

                @endforeach
                <a href="products.html" class="cat-card">
                    <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=300&q=75" alt="Smart TV"
                        class="cat-img" />
                    <div class="cat-body">
                        <div class="cat-name">Smart TV</div>
                        <div class="cat-count">48 produk</div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <div class="section-tag">⭐ Unggulan</div>
                    <div class="section-title">Produk Terlaris Minggu Ini</div>
                </div>
                <a href="products.html" class="btn btn-outline">Lihat Semua →</a>
            </div>
            <div class="prod-grid" id="featuredGrid"></div>
        </div>
    </section>

    <!-- DEALS BANNER -->
    <section class="deals-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <div class="section-tag">🔥 Penawaran</div>
                    <div class="section-title">Penawaran Spesial Hari Ini</div>
                </div>
            </div>
            <div class="deals-grid">
                <div class="deal-card">
                    <img src="https://images.unsplash.com/photo-1509281373149-e957c6296406?w=700&q=80" alt="TV Deal" />
                    <div class="deal-overlay">
                        <div class="deal-tag">⚡ Flash Sale</div>
                        <div class="deal-title">Smart TV Premium Diskon Besar</div>
                        <div class="deal-sub">
                            Sony BRAVIA & Samsung Crystal — stok terbatas!
                        </div>
                        <div class="deal-badge">Hemat s/d Rp 2 Juta</div>
                    </div>
                </div>
                <div class="deal-card">
                    <img src="https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=700&q=80" alt="AC Deal" />
                    <div class="deal-overlay" style="
                                                    background: linear-gradient(
                                                      135deg,
                                                      rgba(14, 165, 160, 0.85) 0%,
                                                      transparent 100%
                                                    );
                                                  ">
                        <div class="deal-tag">❄️ Musim Panas</div>
                        <div class="deal-title">AC Inverter Hemat Energi</div>
                        <div class="deal-sub">
                            Daikin & Panasonic — cicilan 0% 12 bulan
                        </div>
                        <div class="deal-badge">Mulai Rp 3,8 Juta</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW ARRIVALS -->
    <section class="new-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <div class="section-tag">🆕 Terbaru</div>
                    <div class="section-title">Produk Baru Masuk</div>
                </div>
                <a href="products.html" class="btn btn-outline">Lihat Semua →</a>
            </div>
            <div class="prod-grid" id="newGrid"></div>
        </div>
    </section>

    <!-- WHY US -->
    <section class="why-section">
        <div class="container">
            <div style="text-align: center">
                <div class="section-tag" style="
                                                  background: rgba(255, 255, 255, 0.1);
                                                  color: rgba(255, 255, 255, 0.8);
                                                ">
                    💡 Kenapa Elektronik Modern
                </div>
                <div class="section-title" style="color: #fff; margin-top: 8px">
                    Belanja Lebih Mudah & Terpercaya
                </div>
            </div>
            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon">🏆</div>
                    <div class="why-title">Produk 100% Original</div>
                    <div class="why-text">
                        Semua produk bersumber langsung dari distributor resmi dengan
                        garansi pabrik.
                    </div>
                </div>
                <div class="why-card">
                    <div class="why-icon">🚚</div>
                    <div class="why-title">Pengiriman Cepat</div>
                    <div class="why-text">
                        Pengiriman ke seluruh Indonesia dengan estimasi 1–5 hari kerja.
                    </div>
                </div>
                <div class="why-card">
                    <div class="why-icon">💳</div>
                    <div class="why-title">Pembayaran Aman</div>
                    <div class="why-text">
                        Transfer bank & e-wallet dengan konfirmasi manual oleh tim admin
                        kami.
                    </div>
                </div>
                <div class="why-card">
                    <div class="why-icon">🔧</div>
                    <div class="why-title">Layanan Purna Jual</div>
                    <div class="why-text">
                        Garansi retur 7 hari dan dukungan teknisi untuk produk elektronik
                        besar.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="review-section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 0">
                <div class="section-tag">💬 Ulasan</div>
                <div class="section-title">Kata Pelanggan Kami</div>
                <p class="section-sub" style="margin-top: 8px">
                    Rating rata-rata 4.9/5 dari 12.000+ ulasan
                </p>
            </div>
            <div class="review-grid">
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">
                        "TV Samsung 43" yang saya beli kualitasnya luar biasa! Pengiriman
                        cepat, harga terjangkau, dan barang 100% original. Sangat puas!"
                    </p>
                    <div class="review-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&q=75" alt="Budi"
                            class="review-avatar" />
                        <div>
                            <div class="review-name">Budi Santoso</div>
                            <div class="review-date">Desember 2024 • Surabaya</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">
                        "Kulkas LG yang dibeli masih mulus dan hemat listrik banget. Admin
                        responsif dan pesanan diproses dalam 1 hari!"
                    </p>
                    <div class="review-author">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&q=75" alt="Siti"
                            class="review-avatar" />
                        <div>
                            <div class="review-name">Siti Rahayu</div>
                            <div class="review-date">November 2024 • Bangkalan</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">
                        "AC Daikin inverter hemat banget! Sudah 3 bulan pemakaian, listrik
                        lebih irit 40%. Proses upload bukti bayar juga mudah."
                    </p>
                    <div class="review-author">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=75" alt="Ahmad"
                            class="review-avatar" />
                        <div>
                            <div class="review-name">Ahmad Fauzi</div>
                            <div class="review-date">Oktober 2024 • Pamekasan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWSLETTER -->
    <div class="newsletter">
        <h2>📬 Dapatkan Promo Eksklusif</h2>
        <p>
            Daftar ke newsletter kami dan dapatkan notifikasi flash sale & diskon
            spesial lebih awal.
        </p>
        <div class="newsletter-form">
            <input type="email" placeholder="Masukkan email Anda..." />
            <button class="btn btn-white">Daftar Sekarang</button>
        </div>
    </div>

    <div class="cart-toast" id="cart-toast"></div>

@endsection

@section('footer')
    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">⚡ Elektronik Modern</div>
                <p class="footer-desc">
                    Platform belanja elektronik rumah tangga terpercaya. Produk
                    original, harga bersaing, pengiriman cepat ke seluruh Indonesia.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap">
                    <a href="#" class="btn btn-sm" style="
                                                    background: rgba(255, 255, 255, 0.08);
                                                    color: #fff;
                                                    border: 1px solid rgba(255, 255, 255, 0.12);
                                                  ">📘 Facebook</a>
                    <a href="#" class="btn btn-sm" style="
                                                    background: rgba(255, 255, 255, 0.08);
                                                    color: #fff;
                                                    border: 1px solid rgba(255, 255, 255, 0.12);
                                                  ">📸 Instagram</a>
                </div>
            </div>
            <div>
                <h4>Belanja</h4>
                <a href="products.html">Smart TV</a><a href="products.html">Kulkas</a><a href="products.html">AC &
                    Pendingin</a><a href="products.html">Mesin Cuci</a><a href="products.html">Dapur</a>
            </div>
            <div>
                <h4>Bantuan</h4>
                <a href="#">Cara Pemesanan</a><a href="checkout.html">Konfirmasi Bayar</a><a href="orders.html">Lacak
                    Pesanan</a><a href="#">Kebijakan Retur</a>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <a href="#">Tentang Kami</a><a href="#">Kontak</a><a href="#">Karir</a><a href="#">Syarat &
                    Ketentuan</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 Elektronik Modern – Kelompok 2 IF4E Universitas Trunojoyo
                Madura</span>
            <span>Rekayasa Perangkat Lunak</span>
        </div>
    </footer>
@endsection

@push('scripts')
    <script src="{{ asset('shared.js') }}"></script>
    <script>
        // Build particles
        (function () {
            const c = document.getElementById("particles");
            for (let i = 0; i < 20; i++) {
                const d = document.createElement("div");
                d.className = "hero-particle";
                const s = Math.random() * 80 + 20;
                d.style.cssText = `width:${s}px;height:${s}px;left:${Math.random() * 100}%;bottom:${Math.random() * -20}%;animation-duration:${Math.random() * 15 + 8}s;animation-delay:${Math.random() * 10}s`;
                c.appendChild(d);
            }
        })();

        // Render products
        const FEATURED_IDS = [1, 2, 3, 4, 5, 6, 7, 8];
        const NEW_IDS = [8, 7, 6, 5];

        function prodCard(p) {
            const disc = p.badge
                ? `<div class="prod-card-badge badge ${p.badge.startsWith("−") || p.badge === "HOT" ? "badge-danger" : "badge-new"}">${p.badge}</div>`
                : "";
            const old = p.oldPrice
                ? `<span class="prod-old">${fmt(p.oldPrice)}</span>`
                : "";
            return `<div class="prod-card" onclick="window.location='product-detail.html'">
                                        <div class="prod-img-wrap">
                                          <img src="${p.img}" alt="${p.name}" loading="lazy">
                                          ${disc}
                                          <button class="prod-wishlist" onclick="event.stopPropagation()">♡</button>
                                        </div>
                                        <div class="prod-body">
                                          <div class="prod-cat">${p.cat}</div>
                                          <div class="prod-name">${p.name}</div>
                                          <div class="prod-price-row"><span class="prod-price">${fmt(p.price)}</span>${old}</div>
                                          <div class="prod-footer">
                                            <span class="prod-stock">Stok: ${p.stock} unit</span>
                                            <button class="add-cart-btn" onclick="event.stopPropagation();addToCart(${p.id})" title="Tambah ke keranjang">+</button>
                                          </div>
                                        </div>
                                      </div>`;
        }

        document.getElementById("featuredGrid").innerHTML = PRODUCTS.map((p) =>
            prodCard(p),
        ).join("");
        document.getElementById("newGrid").innerHTML = [...PRODUCTS]
            .reverse()
            .slice(0, 4)
            .map((p) => prodCard(p))
            .join("");

        // Cart
        function renderCart() {
            updateCartBadge();
            const el = document.getElementById("cartItems");
            const foot = document.getElementById("cartFooter");
            if (!CART.length) {
                el.innerHTML = `<div class="cart-empty"><div class="empty-icon">🛒</div><div style="font-weight:700;font-size:16px;color:var(--g700);margin-bottom:6px">Keranjang Kosong</div><div style="font-size:13px;color:var(--g400)">Yuk tambahkan produk favorit kamu!</div><a href="products.html" class="btn btn-primary" style="margin-top:20px;display:inline-flex">Belanja Sekarang</a></div>`;
                foot.innerHTML = "";
                return;
            }
            el.innerHTML = CART.map(
                (item) => `
                                        <div class="cart-item">
                                          <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                                          <div class="cart-item-info">
                                            <div class="cart-item-name">${item.name}</div>
                                            <div class="cart-item-price">${fmt(item.price)}</div>
                                            <div class="cart-qty">
                                              <button class="qty-btn" onclick="updateQty(${item.id},-1)">−</button>
                                              <input class="qty-num" value="${item.qty}" readonly>
                                              <button class="qty-btn" onclick="updateQty(${item.id},1)">+</button>
                                            </div>
                                          </div>
                                          <button class="cart-remove" onclick="removeFromCart(${item.id})">🗑</button>
                                        </div>`,
            ).join("");
            const total = cartTotal();
            const disc = total > 5000000 ? 500000 : 0;
            foot.innerHTML = `
                                        <div class="cart-subtotal"><span>Subtotal (${cartCount()} produk)</span><span>${fmt(total)}</span></div>
                                        ${disc ? `<div class="cart-subtotal"><span>Diskon</span><span style="color:var(--danger)">−${fmt(disc)}</span></div>` : ""}
                                        <div class="cart-total"><span>Total Bayar</span><span>${fmt(total - disc)}</span></div>
                                        <a href="cart.html" class="btn btn-outline" style="width:100%;justify-content:center;margin-bottom:10px">Lihat Keranjang</a>
                                        <a href="checkout.html" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px">💳 Checkout Sekarang</a>
                                        <div style="text-align:center;font-size:11px;color:var(--g400);margin-top:10px">🔒 Transaksi aman & terenkripsi</div>`;
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

        // Notifications
        function renderNotifs() {
            document.getElementById("notifList").innerHTML = NOTIFICATIONS.map(
                (n) => `
                                        <div class="notif-item ${n.read ? "" : "unread"}" onclick="markRead(${n.id})">
                                          <div class="notif-icon">${n.icon}</div>
                                          <div><div class="notif-title">${n.title}</div><div class="notif-msg">${n.msg}</div><div class="notif-time">${n.time}</div></div>
                                        </div>`,
            ).join("");
            updateNotifBadge();
        }
        function toggleNotif() {
            const p = document.getElementById("notifPanel");
            const o = document.getElementById("notifOverlay");
            const open = p.classList.toggle("open");
            o.style.display = open ? "block" : "none";
            if (open) renderNotifs();
        }
        function closeNotif() {
            document.getElementById("notifPanel").classList.remove("open");
            document.getElementById("notifOverlay").style.display = "none";
        }
        function markRead(id) {
            const n = NOTIFICATIONS.find((x) => x.id === id);
            if (n) n.read = true;
            renderNotifs();
        }
        function markAllRead() {
            NOTIFICATIONS.forEach((n) => (n.read = true));
            renderNotifs();
        }

        updateCartBadge();
        updateNotifBadge();
    </script>
@endpush