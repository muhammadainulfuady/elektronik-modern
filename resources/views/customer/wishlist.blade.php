@extends('layouts.app')

@section('title', 'Wishlist Saya – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .wishlist-section { padding: 32px 0 72px }
        .wishlist-section h1 { font-family: "Syne", sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 8px }
        
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 28px;
        }

        .wishlist-card {
            background: #fff;
            border-radius: var(--rlg);
            box-shadow: var(--sh);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: .25s;
            border: 1.5px solid transparent;
        }
        .wishlist-card:hover {
            box-shadow: var(--sh-md);
            transform: translateY(-4px);
            border-color: var(--blue-mid);
        }

        .wishlist-img-wrap {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1.1;
            background: var(--g50);
        }
        .wishlist-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .4s;
        }
        .wishlist-card:hover .wishlist-img-wrap img {
            transform: scale(1.05);
        }

        .remove-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 2;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,.9);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
            transition: .2s;
            backdrop-filter: blur(4px);
            color: var(--danger);
        }
        .remove-btn:hover {
            transform: scale(1.15);
            background: #fff;
            box-shadow: 0 4px 12px rgba(220,38,38,.2);
        }

        .wishlist-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .wishlist-cat {
            font-size: 11px;
            font-weight: 700;
            color: var(--blue);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .wishlist-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--g800);
            margin-bottom: 12px;
            line-height: 1.4;
            flex-grow: 1;
            text-decoration: none;
        }
        .wishlist-name:hover {
            color: var(--blue);
        }
        .wishlist-price {
            font-family: var(--font-h);
            font-size: 18px;
            font-weight: 800;
            color: var(--blue);
            margin-bottom: 16px;
        }
        .wishlist-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .empty-wishlist { text-align: center; padding: 80px 20px }
        .empty-wishlist .empty-icon { font-size: 72px; margin-bottom: 20px }

        /* Animation for remove */
        .fade-out {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="wishlist-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('index') }}">Beranda</a> <span>›</span> <span>Wishlist Saya</span>
            </div>
            <h1 style="display:flex;align-items:center;gap:10px"><i class="fi fi-rr-heart" style="color:var(--blue)"></i> Wishlist Saya</h1>
            <p style="color:var(--g500);margin-bottom:12px">Daftar produk elektronik favorit Anda</p>

            @if (session('status'))
                <div style="background:var(--sl);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    <i class="fi fi-rr-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <div id="wishlistContainer">
                @if ($wishlists->count())
                    <div class="wishlist-grid">
                        @foreach ($wishlists as $wishlist)
                            @if ($wishlist->produk)
                                <div class="wishlist-card" id="card-{{ $wishlist->id_produk }}">
                                    <!-- Remove Button -->
                                    <button type="button" class="remove-btn" title="Hapus dari Wishlist"
                                        onclick="removeFromWishlist({{ $wishlist->id_produk }})">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>

                                    <!-- Image Wrap -->
                                    <div class="wishlist-img-wrap">
                                        <img src="{{ asset('storage/products/' . $wishlist->produk->gambar) }}"
                                            alt="{{ $wishlist->produk->nama_produk }}" loading="lazy" decoding="async">
                                    </div>

                                    <!-- Body Info -->
                                    <div class="wishlist-body">
                                        <div class="wishlist-cat">{{ $wishlist->produk->kategori->nama_kategori ?? '-' }}</div>
                                        <a href="{{ route('products.show', $wishlist->produk) }}" class="wishlist-name">
                                            {{ $wishlist->produk->nama_produk }}
                                        </a>
                                        <div class="wishlist-price">Rp {{ number_format($wishlist->produk->harga, 0, ',', '.') }}</div>

                                        <!-- Add to Cart Directly -->
                                        <div class="wishlist-actions">
                                            @if ($wishlist->produk->stok > 0)
                                                <form method="POST" action="{{ route('cart.add') }}" style="width: 100%">
                                                    @csrf
                                                    <input type="hidden" name="id_produk" value="{{ $wishlist->id_produk }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; display:flex; align-items:center; gap:6px">
                                                        <i class="fi fi-rr-shopping-cart"></i> Beli Sekarang
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-outline" style="width: 100%; justify-content: center; cursor: not-allowed; display:flex; align-items:center; gap:6px" disabled>
                                                    <i class="fi fi-rr-cross-circle"></i> Stok Habis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="empty-wishlist">
                        <div class="empty-icon"><i class="fi fi-rr-heart" style="font-size:48px;color:var(--g300)"></i></div>
                        <div style="font-weight:700;font-size:20px;color:var(--g700);margin-bottom:8px">
                            Wishlist Anda Kosong
                        </div>
                        <div style="font-size:14px;color:var(--g400);margin-bottom:28px">
                            Simpan produk-produk impian Anda di sini untuk dibeli nanti.
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg" style="display:inline-flex;align-items:center;gap:8px"><i class="fi fi-rr-search"></i> Cari Produk Favorit</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function removeFromWishlist(id_produk) {
            fetch('{{ route('wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id_produk: id_produk })
            })
            .then(response => response.json())
            .then(data => {
                if (data && typeof data.liked !== 'undefined' && !data.liked) {
                    const card = document.getElementById(`card-${id_produk}`);
                    if (card) {
                        card.classList.add('fade-out');
                        setTimeout(() => {
                            card.remove();
                            // Check if empty
                            const remainingCards = document.querySelectorAll('.wishlist-card');
                            if (remainingCards.length === 0) {
                                document.getElementById('wishlistContainer').innerHTML = `
                                    <div class="empty-wishlist">
                                        <div class="empty-icon"><i class="fi fi-rr-heart" style="font-size:48px;color:var(--g300)"></i></div>
                                        <div style="font-weight:700;font-size:20px;color:var(--g700);margin-bottom:8px">
                                            Wishlist Anda Kosong
                                        </div>
                                        <div style="font-size:14px;color:var(--g400);margin-bottom:28px">
                                            Simpan produk-produk impian Anda di sini untuk dibeli nanti.
                                        </div>
                                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg" style="display:inline-flex;align-items:center;gap:8px"><i class="fi fi-rr-search"></i> Cari Produk Favorit</a>
                                    </div>
                                `;
                            }
                        }, 300);
                    }
                    if (typeof refreshWishlistBadge === 'function') {
                        refreshWishlistBadge();
                    }
                }
            })
            .catch(() => {});
        }
    </script>
@endpush
