@extends('layouts.app')

@section('title', $produk->nama_produk . ' – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .detail-section { padding: 32px 0 72px }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start }
        .detail-img-wrap {
            background: var(--g50); border-radius: var(--rxl); overflow: hidden;
            aspect-ratio: 1; position: relative
        }
        .detail-img-wrap img { width: 100%; height: 100%; object-fit: cover }
        .detail-info h1 { font-family: "Syne",sans-serif; font-size: 28px; font-weight: 800; color: var(--g900); margin-bottom: 8px; line-height: 1.3 }
        .detail-cat { font-size: 12px; font-weight: 700; color: var(--blue); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 12px }
        .detail-price {
            font-family: "Syne",sans-serif; font-size: 32px; font-weight: 800;
            color: var(--blue); margin-bottom: 20px
        }
        .detail-stock { display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px }
        .detail-desc { margin-bottom: 28px }
        .detail-desc h3 { font-size: 15px; font-weight: 800; margin-bottom: 10px; color: var(--g800) }
        .detail-desc p { font-size: 14px; color: var(--g600); line-height: 1.8 }

        .qty-control {
            display: flex; align-items: center; gap: 0; border: 1.5px solid var(--g200);
            border-radius: 10px; overflow: hidden; width: fit-content; margin-bottom: 20px
        }
        .qty-control button {
            width: 44px; height: 44px; border: none; background: var(--g50); cursor: pointer;
            font-size: 20px; font-weight: 700; display: flex; align-items: center; justify-content: center;
            color: var(--g700); transition: .15s
        }
        .qty-control button:hover { background: var(--blue-l); color: var(--blue) }
        .qty-control input {
            width: 56px; text-align: center; font-weight: 700; font-size: 16px;
            border: none; border-left: 1.5px solid var(--g200); border-right: 1.5px solid var(--g200);
            outline: none; padding: 0; background: #fff; height: 44px
        }

        .add-actions { display: flex; gap: 12px; flex-wrap: wrap }
        .wishlist-detail-btn.liked {
            border-color: #fca5a5 !important;
            background: #fef2f2 !important;
            color: var(--danger) !important;
        }

        /* Related */
        .related-section { margin-top: 48px; padding-top: 48px; border-top: 1px solid var(--g200) }
        .related-section h2 { font-family: "Syne",sans-serif; font-size: 22px; font-weight: 800; margin-bottom: 20px }
        .prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 18px }

        /* Success toast */
        .toast-success {
            position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%) translateY(80px);
            background: var(--dark); color: #fff; padding: 14px 24px; border-radius: 50px;
            font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px;
            z-index: 2000; box-shadow: var(--sh-lg); opacity: 0; transition: .3s; white-space: nowrap
        }
        .toast-success.show { opacity: 1; transform: translateX(-50%) translateY(0) }

        @media(max-width:768px) {
            .detail-grid { grid-template-columns: 1fr }
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="detail-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('index') }}">Beranda</a> <span>›</span>
                <a href="{{ route('products.index') }}">Katalog</a> <span>›</span>
                <span>{{ $produk->nama_produk }}</span>
            </div>

            <div class="detail-grid">
                <!-- Product Image -->
                <div class="detail-img-wrap">
                    <img src="{{ asset('storage/products/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" decoding="async" fetchpriority="high">
                </div>

                <!-- Product Info -->
                <div class="detail-info">
                    <div class="detail-cat">{{ $produk->kategori->nama_kategori ?? '-' }}</div>
                    <h1>{{ $produk->nama_produk }}</h1>
                    <div class="detail-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>

                    <div class="detail-stock">
                        @if ($produk->stok > 10)
                            <span class="badge badge-success" style="display:inline-flex;align-items:center;gap:4px"><i class="fi fi-rr-check-circle"></i> Stok Tersedia</span>
                        @elseif ($produk->stok > 0)
                            <span class="badge badge-warn" style="display:inline-flex;align-items:center;gap:4px"><i class="fi fi-rr-triangle-warning"></i> Stok Terbatas ({{ $produk->stok }})</span>
                        @else
                            <span class="badge badge-danger" style="display:inline-flex;align-items:center;gap:4px"><i class="fi fi-rr-cross-circle"></i> Stok Habis</span>
                        @endif
                    </div>

                    <div class="detail-desc">
                        <h3>Deskripsi Produk</h3>
                        <p>{{ $produk->deskripsi }}</p>
                    </div>

                    @if ($produk->stok > 0)
                        @auth
                            @if (auth()->user()->role === 'customer')
                                <div class="qty-control">
                                    <button type="button" onclick="changeQty(-1)">−</button>
                                    <input type="number" id="qtyInput" value="1" min="1" max="{{ $produk->stok }}" readonly>
                                    <button type="button" onclick="changeQty(1)">+</button>
                                </div>

                                <div class="add-actions">
                                    <form method="POST" action="{{ route('cart.add') }}" id="addCartForm" style="display:inline-block">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                        <input type="hidden" name="qty" id="qtyHidden" value="1">
                                        <button type="submit" class="btn btn-primary btn-lg" style="display:inline-flex;align-items:center;gap:8px"><i class="fi fi-rr-shopping-cart"></i> Tambah ke Keranjang</button>
                                    </form>
                                    <button type="button"
                                        class="btn btn-outline btn-lg wishlist-detail-btn {{ in_array($produk->id_produk, $wishlistIds) ? 'liked' : '' }}"
                                        onclick="toggleWishlistDetail(this, {{ $produk->id_produk }})">
                                        @if(in_array($produk->id_produk, $wishlistIds))
                                            <i class="fi fi-sr-heart" style="color:var(--danger); margin-right: 6px;"></i> Hapus dari Wishlist
                                        @else
                                            <i class="fi fi-rr-heart" style="margin-right: 6px;"></i> Tambah ke Wishlist
                                        @endif
                                    </button>
                                </div>
                            @else
                                <div style="background:var(--wl);color:#92400E;padding:14px 18px;border-radius:12px;font-size:14px;font-weight:600">
                                    <i class="fi fi-rr-triangle-warning" style="margin-right:6px"></i> Admin dan Owner tidak dapat membeli barang.
                                </div>
                            @endif
                        @else
                             <div style="background:var(--blue-l);color:var(--blue-d);padding:14px 18px;border-radius:12px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                                 <i class="fi fi-rr-lock" style="margin-right: 6px;"></i> Silakan login terlebih dahulu untuk membeli produk ini.
                                 <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Masuk Sekarang</a>
                             </div>
                        @endauth
                    @endif
                </div>
            </div>


            <!-- Related Products -->
            @if ($produkTerkait->count())
                <div class="related-section">
                    <h2><i class="fi fi-rr-boxes" style="margin-right: 8px;"></i> Produk Terkait</h2>
                    <div class="prod-grid">
                        @foreach ($produkTerkait as $related)
                            <a href="{{ route('products.show', $related) }}" class="prod-card" style="text-decoration:none;color:inherit">
                                <div class="prod-img-wrap">
                                    <img src="{{ asset('storage/products/' . $related->gambar) }}"
                                        alt="{{ $related->nama_produk }}" loading="lazy" decoding="async">
                                </div>
                                <div class="prod-body">
                                    <div class="prod-cat">{{ $related->kategori->nama_kategori ?? '-' }}</div>
                                    <div class="prod-name">{{ $related->nama_produk }}</div>
                                    <div class="prod-price-row">
                                        <span class="prod-price">Rp {{ number_format($related->harga, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="prod-footer">
                                        <span class="prod-stock">Stok: {{ $related->stok }} unit</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="toast-success" id="cartToast"><i class="fi fi-rr-check-circle" style="margin-right: 6px;"></i> Produk ditambahkan ke keranjang!</div>
@endsection

@push('scripts')
    <script>
        function changeQty(delta) {
            const input = document.getElementById('qtyInput');
            const hidden = document.getElementById('qtyHidden');
            let val = parseInt(input.value) + delta;
            val = Math.max(1, Math.min(val, parseInt(input.max)));
            input.value = val;
            hidden.value = val;
        }

        function toggleWishlistDetail(btn, id_produk) {
            fetch('{{ route('wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id_produk: id_produk })
            })
            .then(response => {
                if (response.status === 401) {
                    window.location = '{{ route('login') }}';
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && typeof data.liked !== 'undefined') {
                    if (data.liked) {
                        btn.classList.add('liked');
                        btn.innerHTML = '<i class="fi fi-sr-heart" style="color:var(--danger); margin-right: 6px;"></i> Hapus dari Wishlist';
                    } else {
                        btn.classList.remove('liked');
                        btn.innerHTML = '<i class="fi fi-rr-heart" style="margin-right: 6px;"></i> Tambah ke Wishlist';
                    }
                    if (typeof refreshWishlistBadge === 'function') {
                        refreshWishlistBadge();
                    }
                }
            })
            .catch(() => {});
        }

        @if(session('status') || session('error'))
            // Show toast
            const toast = document.getElementById('cartToast');
            toast.innerHTML = `<i class="fi fi-rr-check-circle" style="margin-right: 6px;"></i> {{ session('status') ?: session('error') }}`;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        @endif
    </script>
@endpush
