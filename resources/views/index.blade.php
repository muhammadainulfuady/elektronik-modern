@extends('layouts.app')

@section('title', 'Elektronik Modern – Toko Elektronik Terpercaya')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        /* ===== HERO ===== */
        .hero {
            position: relative;
            min-height: 580px;
            background: linear-gradient(135deg, #050d2e 0%, #0f2060 40%, #0a4d8c 70%, #0a3060 100%);
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero-particles { position: absolute; inset: 0; overflow: hidden; pointer-events: none }
        .hero-particle { position: absolute; border-radius: 50%; background: rgba(255,255,255,.06); animation: float linear infinite }
        @keyframes float { 0%{transform:translateY(0) rotate(0)} 100%{transform:translateY(-100vh) rotate(360deg)} }
        .hero-glow { position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(26,92,255,.3) 0%,transparent 70%);top:-200px;right:-100px;animation:pulse 4s ease-in-out infinite }
        @keyframes pulse { 0%,100%{transform:scale(1);opacity:.6} 50%{transform:scale(1.1);opacity:.9} }
        .hero-inner { position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:60px 32px;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;width:100% }
        .hero-tag { display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);color:#fff;padding:6px 16px;border-radius:50px;font-size:12px;font-weight:700;margin-bottom:20px;letter-spacing:.04em;backdrop-filter:blur(8px) }
        .hero h1 { font-family:"Syne",sans-serif;font-size:50px;font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px }
        .hero h1 span { background:linear-gradient(135deg,#60a5fa,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text }
        .hero-desc { color:rgba(255,255,255,.7);font-size:16px;line-height:1.7;margin-bottom:28px }
        .hero-stats { display:flex;gap:32px;margin-top:36px }
        .hero-stat-num { font-family:"Syne",sans-serif;font-size:26px;font-weight:800;color:#fff }
        .hero-stat-label { font-size:12px;color:rgba(255,255,255,.5);margin-top:2px }
        .hero-img-col { position:relative }
        .hero-main-img { width:100%;border-radius:24px;box-shadow:0 32px 80px rgba(0,0,0,.4);object-fit:cover;height:380px }
        .hero-float-card { position:absolute;background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border-radius:16px;padding:14px 18px;box-shadow:0 16px 40px rgba(0,0,0,.2);display:flex;align-items:center;gap:12px }
        .hero-float-1 { bottom:-20px;left:-20px;animation:floatCard 3s ease-in-out infinite }
        .hero-float-2 { top:-16px;right:-16px;animation:floatCard 3s ease-in-out infinite .5s }
        @keyframes floatCard { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .hfc-icon { width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px }
        .hfc-label { font-size:11px;color:#666;font-weight:600 }
        .hfc-val { font-size:14px;font-weight:800;color:#111;font-family:"Syne",sans-serif }

        .promo-strip { background:linear-gradient(90deg,var(--blue),var(--teal));padding:14px 32px;text-align:center;color:#fff;font-size:14px;font-weight:600 }
        .promo-strip span { opacity:.8;margin:0 20px }

        .cat-section { padding:72px 0 0 }
        .cat-scroll { display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-top:28px }
        .cat-card { background:#fff;border-radius:var(--rlg);padding:20px;box-shadow:var(--sh);cursor:pointer;transition:.25s;border:2px solid transparent;text-decoration:none;text-align:center }
        .cat-card:hover { border-color:var(--blue);transform:translateY(-4px);box-shadow:var(--sh-md) }
        .cat-icon { font-size:32px;margin-bottom:8px }
        .cat-name { font-size:13px;font-weight:700;color:var(--g800);margin-bottom:2px }
        .cat-count { font-size:11px;color:var(--g400) }

        .brands-section { padding:56px 0;background:#fff;border-top:1px solid var(--g100) }
        .brands-title { text-align:center;font-size:13px;font-weight:700;color:var(--g400);letter-spacing:.1em;text-transform:uppercase;margin-bottom:28px }
        .brands-row { display:flex;align-items:center;justify-content:center;gap:48px;flex-wrap:wrap }
        .brand-logo { font-family:"Syne",sans-serif;font-size:22px;font-weight:800;color:var(--g300);transition:.2s;cursor:default }
        .brand-logo:hover { color:var(--blue) }

        .featured-section { padding:72px 0 }
        .section-header { display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px }
        .prod-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:18px }

        .deals-section { padding:0 0 72px }
        .deals-grid { display:grid;grid-template-columns:1fr 1fr;gap:20px }
        .deal-card { border-radius:var(--rxl);overflow:hidden;position:relative;min-height:260px;cursor:pointer;transition:.3s }
        .deal-card:hover { transform:scale(1.01);box-shadow:var(--sh-lg) }
        .deal-card img { width:100%;height:100%;object-fit:cover;position:absolute;inset:0 }
        .deal-overlay { position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,15,30,.85) 0%,rgba(10,15,30,.4) 100%);padding:32px }
        .deal-tag { font-size:11px;font-weight:700;background:rgba(255,255,255,.15);color:#fff;padding:4px 12px;border-radius:50px;margin-bottom:10px;display:inline-block }
        .deal-title { font-family:"Syne",sans-serif;font-size:24px;font-weight:800;color:#fff;margin-bottom:8px;line-height:1.2 }
        .deal-sub { color:rgba(255,255,255,.7);font-size:14px;margin-bottom:18px }
        .deal-badge { display:inline-flex;background:linear-gradient(135deg,#ff6b35,#ff3366);color:#fff;font-size:13px;font-weight:800;padding:6px 16px;border-radius:50px }

        .review-section { padding:72px 0;background:#fff }
        .review-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;margin-top:32px }
        .review-card { background:var(--g50);border-radius:var(--rlg);padding:24px;border:1px solid var(--g200) }
        .review-stars { color:#f59e0b;font-size:16px;margin-bottom:12px }
        .review-text { font-size:14px;color:var(--g600);line-height:1.7;margin-bottom:16px;font-style:italic }
        .review-author { display:flex;align-items:center;gap:10px }
        .review-avatar { width:38px;height:38px;border-radius:50%;object-fit:cover;background:var(--g200) }
        .review-name { font-size:13px;font-weight:700;color:var(--g800) }
        .review-date { font-size:11px;color:var(--g400) }

        .why-section { padding:72px 0;background:linear-gradient(135deg,var(--dark) 0%,#0f2060 100%) }
        .why-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;margin-top:40px }
        .why-card { text-align:center;padding:32px 20px }
        .why-icon { width:64px;height:64px;border-radius:20px;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;border:1px solid rgba(255,255,255,.1) }
        .why-title { font-family:"Syne",sans-serif;font-size:17px;font-weight:700;color:#fff;margin-bottom:8px }
        .why-text { font-size:13px;color:rgba(255,255,255,.5);line-height:1.7 }

        .new-section { padding:72px 0 }
        @media(max-width:900px) {
            .hero-inner{grid-template-columns:1fr;text-align:center}
            .hero-img-col{display:none}
            .hero-stats{justify-content:center}
            .deals-grid{grid-template-columns:1fr}
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="hero-particles" id="particles"></div>
        <div class="hero-glow"></div>
        <div class="hero-inner">
            <div>
                <div class="hero-tag">✨ Toko Elektronik Terpercaya</div>
                <h1>Elektronik <span>Rumah Modern</span>, Harga Terbaik!</h1>
                <p class="hero-desc">
                    Temukan ribuan produk elektronik pilihan — LED, Kabel, Speaker, Router
                    & lebih banyak lagi — dengan pengiriman cepat ke seluruh Indonesia.
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">🛍️ Belanja Sekarang</a>
                    <a href="{{ route('products.index') }}" class="btn btn-ghost btn-lg">Lihat Katalog →</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num">{{ $jumlahProduk }}+</div>
                        <div class="hero-stat-label">Produk Tersedia</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">{{ $jumlahUser }}+</div>
                        <div class="hero-stat-label">Pelanggan Puas</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">{{ round($rating, 1) }}★</div>
                        <div class="hero-stat-label">Rating Toko</div>
                    </div>
                </div>
            </div>
            <div class="hero-img-col">
                <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=700&q=85" alt="Electronics"
                    class="hero-main-img" decoding="async" fetchpriority="high" />
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
            <div class="brands-title">Brand Resmi Tersedia di Elektronik Modern</div>
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
                <a href="{{ route('products.index') }}" class="btn btn-outline">Semua Kategori →</a>
            </div>
            <div class="cat-scroll">
                @php
                    $catIcons = ['💡','🔌','⚡','🔊','🌐','💻','🎧','📷','🏠','🔧'];
                @endphp
                @foreach ($kategoris as $i => $kategori)
                    <a href="{{ route('products.index', ['kategori' => $kategori->id_kategori]) }}" class="cat-card">
                        <div class="cat-icon">{{ $catIcons[$i] ?? '📦' }}</div>
                        <div class="cat-name">{{ $kategori->nama_kategori }}</div>
                        <div class="cat-count">{{ $kategori->produks_count }} produk</div>
                    </a>
                @endforeach
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
                <a href="{{ route('products.index') }}" class="btn btn-outline">Lihat Semua →</a>
            </div>
            <div class="prod-grid">
                @foreach ($produkTerlaris as $item)
                    <a href="{{ route('products.show', $item->produk) }}" class="prod-card" style="text-decoration:none;color:inherit">
                        <div class="prod-img-wrap">
                            <img src="{{ asset('storage/products/' . $item->produk->gambar) }}"
                                alt="{{ $item->produk->nama_produk }}" loading="lazy" decoding="async">
                            <div class="prod-card-badge badge badge-danger">TERLARIS</div>
                        </div>
                        <div class="prod-body">
                            <div class="prod-cat">{{ $item->produk->kategori->nama_kategori ?? '-' }}</div>
                            <div class="prod-name">{{ $item->produk->nama_produk }}</div>
                            <div class="prod-price-row">
                                <span class="prod-price">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="prod-footer">
                                <span class="prod-stock">Stok: {{ $item->produk->stok }} unit</span>
                                <span class="badge badge-info">{{ $item->total_terjual }} terjual</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- DEALS -->
    @if ($produkTerlaris->count() >= 2)
    <section class="deals-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <div class="section-tag">🔥 Penawaran</div>
                    <div class="section-title">Penawaran Spesial Hari Ini</div>
                </div>
            </div>
            <div class="deals-grid">
                @foreach ($produkTerlaris->take(2) as $item)
                    <div class="deal-card">
                        <img src="{{ asset('storage/products/' . $item->produk->gambar) }}"
                            alt="{{ $item->produk->nama_produk }}" loading="lazy" decoding="async" />
                        <div class="deal-overlay" @if (!$loop->first) style="background: linear-gradient(135deg, rgba(14, 165, 160, 0.85) 0%, transparent 100%);" @endif>
                            <div class="deal-tag">🔥 Penawaran Terlaris</div>
                            <div class="deal-title">{{ $item->produk->nama_produk }}</div>
                            <div class="deal-sub">
                                {{ $item->produk->kategori->nama_kategori ?? 'Kategori' }} — Terjual {{ $item->total_terjual }} item
                            </div>
                            <div class="deal-badge">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- NEW ARRIVALS -->
    <section class="new-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <div class="section-tag">🆕 Terbaru</div>
                    <div class="section-title">Produk Baru Masuk</div>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline">Lihat Semua →</a>
            </div>
            <div class="prod-grid">
                @foreach ($produkBaru as $produk)
                    <a href="{{ route('products.show', $produk) }}" class="prod-card" style="text-decoration:none;color:inherit">
                        <div class="prod-img-wrap">
                            <img src="{{ asset('storage/products/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" loading="lazy" decoding="async">
                            <div class="prod-card-badge badge badge-new">BARU</div>
                        </div>
                        <div class="prod-body">
                            <div class="prod-cat">{{ $produk->kategori->nama_kategori ?? '-' }}</div>
                            <div class="prod-name">{{ $produk->nama_produk }}</div>
                            <div class="prod-price-row">
                                <span class="prod-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="prod-footer">
                                <span class="prod-stock">Stok: {{ $produk->stok }} unit</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- WHY US -->
    <section class="why-section">
        <div class="container">
            <div style="text-align: center">
                <div class="section-tag" style="background: rgba(255, 255, 255, 0.1); color: rgba(255, 255, 255, 0.8);">
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
                    <div class="why-text">Semua produk bersumber langsung dari distributor resmi dengan garansi pabrik.</div>
                </div>
                <div class="why-card">
                    <div class="why-icon">🚚</div>
                    <div class="why-title">Pengiriman Cepat</div>
                    <div class="why-text">Pengiriman ke seluruh Indonesia dengan estimasi 1–5 hari kerja.</div>
                </div>
                <div class="why-card">
                    <div class="why-icon">💳</div>
                    <div class="why-title">Pembayaran Aman</div>
                    <div class="why-text">Transfer bank & e-wallet dengan konfirmasi manual oleh tim admin kami.</div>
                </div>
                <div class="why-card">
                    <div class="why-icon">🔧</div>
                    <div class="why-title">Layanan Purna Jual</div>
                    <div class="why-text">Garansi retur 7 hari dan dukungan teknisi untuk produk elektronik besar.</div>
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
                <p class="section-sub" style="margin-top: 8px">Rating rata-rata {{ round($rating, 1) }}/5</p>
            </div>
            <div class="review-grid">
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Produk kualitasnya luar biasa! Pengiriman cepat, harga terjangkau, dan barang 100% original."</p>
                    <div class="review-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&q=75" alt="Budi" class="review-avatar" loading="lazy" decoding="async" />
                        <div>
                            <div class="review-name">Budi Santoso</div>
                            <div class="review-date">Customer • Surabaya</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Admin responsif dan pesanan diproses dalam 1 hari. Sangat puas berbelanja di sini!"</p>
                    <div class="review-author">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&q=75" alt="Siti" class="review-avatar" loading="lazy" decoding="async" />
                        <div>
                            <div class="review-name">Siti Rahayu</div>
                            <div class="review-date">Customer • Bangkalan</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Proses upload bukti bayar mudah. Barang sampai dalam kondisi sempurna."</p>
                    <div class="review-author">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=75" alt="Ahmad" class="review-avatar" loading="lazy" decoding="async" />
                        <div>
                            <div class="review-name">Ahmad Fauzi</div>
                            <div class="review-date">Customer • Pamekasan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function buildHeroParticles() {
            const c = document.getElementById("particles");
            if(!c) return;
            for (let i = 0; i < 20; i++) {
                const d = document.createElement("div");
                d.className = "hero-particle";
                const s = Math.random() * 80 + 20;
                d.style.cssText = `width:${s}px;height:${s}px;left:${Math.random()*100}%;bottom:${Math.random()*-20}%;animation-duration:${Math.random()*15+8}s;animation-delay:${Math.random()*10}s`;
                c.appendChild(d);
            }
        }

        if ('requestIdleCallback' in window) {
            requestIdleCallback(buildHeroParticles);
        } else {
            window.addEventListener('load', buildHeroParticles);
        }
    </script>
@endpush
