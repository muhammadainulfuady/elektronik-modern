@extends('layouts.app')

@section('title', $produk->nama_produk . ' – Elektronik Modern')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="py-8 md:py-[72px] bg-white min-h-[calc(100vh-68px)] px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex items-center gap-1.5 mb-8 text-[13px]">
                <a href="{{ route('index') }}" class="text-g500 hover:text-primary transition-colors flex items-center gap-1.5"><i class="fi fi-rr-home"></i> Beranda</a> 
                <i class="fi fi-rr-angle-small-right text-g400"></i> 
                <a href="{{ route('products.index') }}" class="text-g500 hover:text-primary transition-colors">Katalog</a>
                <i class="fi fi-rr-angle-small-right text-g400"></i>
                <span class="text-g800 font-semibold">{{ $produk->nama_produk }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-start">
                <!-- Product Image -->
                <div class="bg-g50 rounded-[32px] overflow-hidden aspect-square relative border border-g100 flex items-center justify-center p-8">
                    @if ($produk->gambar)
                        <img src="{{ asset('storage/products/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" decoding="async" fetchpriority="high" class="w-full h-full object-contain mix-blend-multiply">
                    @else
                        <div class="text-[120px] text-g300"><i class="fi fi-rr-picture"></i></div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <x-badge variant="primary" class="mb-3 tracking-widest uppercase">
                        {{ $produk->kategori->nama_kategori ?? '-' }}
                    </x-badge>
                    <h1 class="font-heading text-[28px] md:text-[36px] font-extrabold text-g900 mb-3 leading-[1.3]">{{ $produk->nama_produk }}</h1>
                    <div class="font-heading text-[32px] md:text-[40px] font-extrabold text-primary mb-6">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>

                    <div class="mb-6">
                        @if ($produk->stok > 10)
                            <x-badge variant="success" class="py-1.5 px-3.5 gap-1.5"><i class="fi fi-rr-check-circle"></i> Stok Tersedia</x-badge>
                        @elseif ($produk->stok > 0)
                            <x-badge variant="warn" class="py-1.5 px-3.5 gap-1.5"><i class="fi fi-rr-triangle-warning"></i> Stok Terbatas ({{ $produk->stok }})</x-badge>
                        @else
                            <x-badge variant="danger" class="py-1.5 px-3.5 gap-1.5"><i class="fi fi-rr-cross-circle"></i> Stok Habis</x-badge>
                        @endif
                    </div>

                    <div class="mb-8 border-t border-b border-g100 py-6">
                        <h3 class="text-[15px] font-extrabold text-g800 mb-2.5">Deskripsi Produk</h3>
                        <p class="text-sm text-g600 leading-[1.8] whitespace-pre-wrap">{{ $produk->deskripsi }}</p>
                    </div>

                    @if ($produk->stok > 0)
                        @auth
                            @if (auth()->user()->role === 'customer')
                                <div class="flex items-center gap-0 border-[1.5px] border-g200 rounded-xl overflow-hidden w-fit mb-6 bg-white shadow-sm">
                                    <button type="button" onclick="changeQty(-1)" class="w-11 h-11 border-none bg-g50 text-g700 text-xl font-bold flex items-center justify-center cursor-pointer hover:bg-primary-light hover:text-primary transition-colors">−</button>
                                    <input type="number" id="qtyInput" value="1" min="1" max="{{ $produk->stok }}" readonly class="w-14 text-center font-bold text-base border-none border-x-[1.5px] border-g200 outline-none bg-white h-11 p-0 m-0 focus:ring-0">
                                    <button type="button" onclick="changeQty(1)" class="w-11 h-11 border-none bg-g50 text-g700 text-xl font-bold flex items-center justify-center cursor-pointer hover:bg-primary-light hover:text-primary transition-colors">+</button>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <form method="POST" action="{{ route('cart.add') }}" id="addCartForm" class="m-0">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                        <input type="hidden" name="qty" id="qtyHidden" value="1">
                                        <x-button type="submit" class="py-3.5 px-7">
                                            <i class="fi fi-rr-shopping-cart-add"></i> Tambah ke Keranjang
                                        </x-button>
                                    </form>

                                    <form method="POST" action="{{ route('cart.add') }}" class="m-0">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                        <input type="hidden" name="qty" class="qtyHidden" value="1">
                                        <input type="hidden" name="buy_now" value="1">
                                        <x-button type="submit" variant="secondary" class="py-3.5 px-7 bg-teal-500 text-white hover:bg-teal-600 border-none shadow-[0_4px_12px_rgba(20,184,166,0.3)]">
                                            <i class="fi fi-rr-shopping-bag"></i> Beli Sekarang
                                        </x-button>
                                    </form>

                                    <x-button variant="{{ in_array($produk->id_produk, $wishlistIds) ? 'danger' : 'outline' }}" 
                                        class="py-3.5 px-7 {{ in_array($produk->id_produk, $wishlistIds) ? 'bg-red-50 border-red-200 text-red-500 hover:bg-red-100 shadow-none' : 'bg-white border-g300 text-g700 hover:border-primary hover:text-primary hover:bg-primary-light' }}"
                                        onclick="toggleWishlistDetail(this, {{ $produk->id_produk }})">
                                        @if(in_array($produk->id_produk, $wishlistIds))
                                            <i class="fi fi-sr-heart"></i> <span class="wishlist-text">Hapus dari Wishlist</span>
                                        @else
                                            <i class="fi fi-rr-heart"></i> <span class="wishlist-text">Tambah ke Wishlist</span>
                                        @endif
                                    </x-button>
                                </div>
                            @else
                                <x-alert type="warning">
                                    <i class="fi fi-rr-triangle-warning"></i> Admin dan Owner tidak dapat membeli barang.
                                </x-alert>
                            @endif
                        @else
                             <x-alert type="info" class="flex items-center gap-3 flex-wrap">
                                 <div class="flex items-center gap-2"><i class="fi fi-rr-lock"></i> Silakan login terlebih dahulu untuk membeli produk ini.</div>
                                 <a href="{{ route('login') }}" class="bg-primary text-white py-1.5 px-4 rounded-full text-[13px] font-bold hover:bg-primary-dark transition-colors">Masuk Sekarang</a>
                             </x-alert>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Related Products -->
            @if ($produkTerkait->count())
                <div class="mt-16 pt-16 border-t border-g100">
                    <h2 class="font-heading text-[24px] font-extrabold text-g900 mb-6 flex items-center gap-2">
                        <i class="fi fi-rr-boxes text-primary"></i> Produk Terkait
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                        @foreach ($produkTerkait as $related)
                            <x-product-card :produk="$related" :wishlistIds="$wishlistIds ?? []" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function changeQty(delta) {
        const input = document.getElementById('qtyInput');
        if (!input) return;
        
        let val = parseInt(input.value) + delta;
        val = Math.max(1, Math.min(val, parseInt(input.max) || Infinity));
        input.value = val;
        
        // Update all hidden quantity inputs
        const qtyHidden1 = document.getElementById('qtyHidden');
        if (qtyHidden1) qtyHidden1.value = val;
        
        document.querySelectorAll('.qtyHidden').forEach(el => el.value = val);
    }
</script>
@endpush

