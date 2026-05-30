@extends('layouts.app')

@section('title', 'Wishlist Saya – Elektronik Modern')

@section('head')
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="py-8 md:py-[72px] bg-g50 min-h-screen px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex items-center gap-1.5 mb-6 text-[13px]">
                <a href="{{ route('index') }}" class="text-g500 hover:text-primary transition-colors flex items-center gap-1.5"><i class="fi fi-rr-home"></i> Beranda</a> 
                <i class="fi fi-rr-angle-small-right text-g400"></i> 
                <span class="text-g800 font-semibold">Wishlist Saya</span>
            </div>
            
            <div class="mb-8">
                <h1 class="font-heading text-[28px] md:text-[32px] font-extrabold text-g900 mb-2 flex items-center gap-3">
                    <i class="fi fi-rr-heart text-primary"></i> Wishlist Saya
                </h1>
                <p class="text-g500 text-[15px]">Daftar produk elektronik favorit Anda</p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 text-green-700 py-3 px-4 rounded-xl text-[13px] font-bold mb-6 flex items-center gap-2 border border-green-200">
                    <i class="fi fi-rr-check-circle text-lg"></i> {{ session('status') }}
                </div>
            @endif

            <div id="wishlistContainer">
                @if ($wishlists->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-5">
                        @foreach ($wishlists as $wishlist)
                            @if ($wishlist->produk)
                                <div class="wishlist-card bg-white rounded-2xl shadow-card overflow-hidden transition-all duration-300 cursor-pointer relative flex flex-col group hover:shadow-card-md hover:-translate-y-1 border border-g100" id="card-{{ $wishlist->id_produk }}">
                                    <!-- Remove Button -->
                                    <button type="button" class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 text-red-500 border border-white flex items-center justify-center text-[15px] shadow-[0_2px_8px_rgba(0,0,0,0.1)] transition-all duration-200 backdrop-blur-sm hover:scale-110 hover:bg-white hover:shadow-[0_4px_12px_rgba(220,38,38,0.2)]" title="Hapus dari Wishlist"
                                        onclick="removeFromWishlist({{ $wishlist->id_produk }})">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>

                                    <!-- Image Wrap -->
                                    <div class="relative overflow-hidden aspect-square bg-g50 p-4">
                                        @if($wishlist->produk->gambar)
                                            <img src="{{ asset('storage/products/' . $wishlist->produk->gambar) }}"
                                                alt="{{ $wishlist->produk->nama_produk }}" loading="lazy" decoding="async" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[60px] text-g300"><i class="fi fi-rr-picture"></i></div>
                                        @endif
                                    </div>

                                    <!-- Body Info -->
                                    <div class="p-5 flex-1 flex flex-col border-t border-g100">
                                        <div class="text-[10px] font-bold text-primary tracking-wider uppercase mb-1.5">{{ $wishlist->produk->kategori->nama_kategori ?? '-' }}</div>
                                        <a href="{{ route('products.show', $wishlist->produk) }}" class="text-[14px] md:text-[15px] font-bold text-g800 mb-2 leading-[1.4] flex-1 line-clamp-2 hover:text-primary transition-colors">
                                            {{ $wishlist->produk->nama_produk }}
                                        </a>
                                        <div class="font-heading text-[17px] md:text-lg font-extrabold text-primary mb-4">Rp {{ number_format($wishlist->produk->harga, 0, ',', '.') }}</div>

                                        <!-- Add to Cart Directly -->
                                        <div class="mt-auto">
                                            @if ($wishlist->produk->stok > 0)
                                                <form method="POST" action="{{ route('cart.add') }}" class="m-0 w-full">
                                                    @csrf
                                                    <input type="hidden" name="id_produk" value="{{ $wishlist->id_produk }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <button type="submit" class="w-full py-2.5 px-4 bg-primary text-white rounded-xl font-bold text-[13px] shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:-translate-y-px transition-all flex items-center justify-center gap-2">
                                                        <i class="fi fi-rr-shopping-cart"></i> Beli Sekarang
                                                    </button>
                                                </form>
                                            @else
                                                <button class="w-full py-2.5 px-4 bg-g100 text-g500 rounded-xl font-bold text-[13px] cursor-not-allowed flex items-center justify-center gap-2" disabled>
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
                    <div class="bg-white rounded-2xl shadow-sm border border-g100 p-12 text-center mt-5">
                        <div class="text-[64px] text-g300 mb-4 inline-flex justify-center"><i class="fi fi-rr-heart"></i></div>
                        <h3 class="font-heading text-xl font-extrabold text-g800 mb-2">Wishlist Anda Kosong</h3>
                        <p class="text-g500 text-sm mb-6 max-w-sm mx-auto">Simpan produk-produk impian Anda di sini untuk dibeli nanti.</p>
                        <a href="{{ route('products.index') }}" class="inline-flex py-3 px-6 bg-primary text-white rounded-full font-bold text-[15px] shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:-translate-y-px transition-all items-center gap-2">
                            <i class="fi fi-rr-search"></i> Cari Produk Favorit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
