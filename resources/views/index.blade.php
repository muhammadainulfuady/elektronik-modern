@extends('layouts.app')

@section('title', 'Elektronik Modern – Toko Elektronik Terpercaya')

@section('content')
    <!-- HERO -->
    <section
        class="relative min-h-[580px] bg-gradient-to-br from-[#050d2e] via-[#0f2060] to-[#0a3060] overflow-hidden flex items-center">
        <div id="particles" class="absolute inset-0 overflow-hidden pointer-events-none"></div>
        <div
            class="absolute w-[600px] h-[600px] rounded-full bg-[radial-gradient(circle,rgba(26,92,255,0.3)_0%,transparent_70%)] -top-[200px] -right-[100px] animate-[pulse_4s_ease-in-out_infinite]">
        </div>

        <div
            class="relative z-10 max-w-[1280px] mx-auto px-4 md:px-8 py-[60px] grid grid-cols-1 md:grid-cols-2 gap-[60px] items-center w-full">
            <div class="text-center md:text-left">
                <x-badge variant="primary"
                    class="mb-5 tracking-wider gap-2 py-1.5 px-4 bg-white/10 border border-white/20 text-white backdrop-blur-md">
                    <i class="fi fi-rr-sparkles"></i> Toko Elektronik Terpercaya
                </x-badge>
                <h1 class="font-heading text-[40px] md:text-[50px] font-extrabold text-white leading-[1.1] mb-4.5">
                    Elektronik <span
                        class="bg-gradient-to-br from-blue-400 to-emerald-400 bg-clip-text text-transparent">Rumah
                        Modern</span>, Harga Terbaik!
                </h1>
                <p class="text-white/70 text-base leading-[1.7] mb-7">
                    Temukan ribuan produk elektronik pilihan — LED, Kabel, Speaker, Router
                    & lebih banyak lagi — dengan pengiriman cepat ke seluruh Indonesia.
                </p>
                <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                    <x-button onclick="window.location='{{ route('products.index') }}'" class="py-3.5 px-7 text-base">
                        <i class="fi fi-rr-shopping-bag"></i> Belanja Sekarang
                    </x-button>
                    <x-button variant="outline" onclick="window.location='{{ route('products.index') }}'"
                        class="py-3.5 px-7 text-base bg-white/15 text-white border-white/30 hover:bg-white/25">
                        Lihat Katalog →
                    </x-button>
                </div>
                <div class="flex justify-center md:justify-start gap-8 mt-9">
                    <div>
                        <div class="font-heading text-[26px] font-extrabold text-white">{{ $jumlahProduk }}+</div>
                        <div class="text-xs text-white/50 mt-0.5">Produk Tersedia</div>
                    </div>
                    <div>
                        <div class="font-heading text-[26px] font-extrabold text-white">{{ $jumlahUser }}+</div>
                        <div class="text-xs text-white/50 mt-0.5">Pelanggan Puas</div>
                    </div>
                    <div>
                        <div class="font-heading text-[26px] font-extrabold text-white flex items-center">
                            5.0<i class="fi fi-rr-star text-xl text-yellow-400 ml-1"></i>
                        </div>
                        <div class="text-xs text-white/50 mt-0.5">Rating Toko</div>
                    </div>
                </div>
            </div>
            <div class="relative hidden md:block">
                <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=700&q=85" alt="Electronics"
                    class="w-full h-[380px] rounded-3xl object-cover shadow-[0_32px_80px_rgba(0,0,0,0.4)]" decoding="async"
                    fetchpriority="high" />

                <div
                    class="absolute -bottom-5 -left-5 bg-white/95 backdrop-blur-md rounded-2xl p-3.5 px-4 shadow-[0_16px_40px_rgba(0,0,0,0.2)] flex items-center gap-3 animate-[floatSlow_6s_ease-in-out_infinite]">
                    <div
                        class="w-10 h-10 rounded-xl bg-green-100/50 flex items-center justify-center text-xl text-green-600">
                        <i class="fi fi-rr-shield-check"></i>
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500 font-semibold">Garansi Resmi</div>
                        <div class="text-sm font-extrabold text-slate-900 font-heading">100% Aman</div>
                    </div>
                </div>

                <div
                    class="absolute -top-4 -right-4 bg-white/95 backdrop-blur-md rounded-2xl p-3.5 px-4 shadow-[0_16px_40px_rgba(0,0,0,0.2)] flex items-center gap-3 animate-[floatSlow_6s_ease-in-out_infinite_0.5s]">
                    <div class="w-10 h-10 rounded-xl bg-blue-100/50 flex items-center justify-center text-xl text-primary">
                        <i class="fi fi-rr-truck-fast"></i>
                    </div>
                    <div>
                        <div class="text-[11px] text-slate-500 font-semibold">Pengiriman</div>
                        <div class="text-sm font-extrabold text-slate-900 font-heading">Super Cepat</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BRANDS -->
    <section class="py-14 bg-white border-t border-g100 px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <h3 class="text-center text-[13px] font-bold text-g400 tracking-widest uppercase mb-7">Merek Terpercaya Kami
            </h3>
            <div class="flex items-center justify-center gap-8 md:gap-12 flex-wrap">
                @foreach (['SAMSUNG', 'LG', 'SONY', 'DAIKIN', 'PANASONIC', 'SHARP', 'PHILIPS'] as $brand)
                    <div
                        class="font-heading text-[22px] font-extrabold text-g300 hover:text-primary transition-colors cursor-default uppercase">
                        {{ $brand }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="pt-[72px] bg-g50 px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <x-badge variant="primary" class="mb-3 tracking-wide gap-1.5 py-1.5 px-3.5">
                        <i class="fi fi-rr-apps"></i> Kategori Populer
                    </x-badge>
                    <h2 class="font-heading text-[32px] font-extrabold text-g900 leading-[1.2] mb-2">Jelajahi Produk Kami
                    </h2>
                    <p class="text-g500 text-[15px] m-0">Temukan barang impian berdasarkan kategori</p>
                </div>
                <x-button variant="outline" onclick="window.location='{{ route('products.index') }}'"
                    class="hidden md:inline-flex py-2.5 px-5 text-sm">
                    Lihat Semua Kategori
                </x-button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3.5 mt-7">
                @foreach ($kategoris as $k)
                    <a href="{{ route('products.index', ['kategori' => $k->nama_kategori]) }}"
                        class="bg-white rounded-xl p-5 shadow-card hover:shadow-card-md hover:-translate-y-1 hover:border-primary border-2 border-transparent text-center transition-all group">
                        <div
                            class="text-[32px] mb-2 text-primary transition-transform group-hover:scale-110 flex justify-center items-center h-[40px]">
                            {!! $k->ikonHtml() !!}
                        </div>
                        <div class="text-[13px] font-bold text-g800 mb-0.5">{{ $k->nama_kategori }}</div>
                        <div class="text-[11px] text-g400">{{ $k->produks_count }} Produk</div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8 text-center md:hidden">
                <x-button variant="outline" onclick="window.location='{{ route('products.index') }}'"
                    class="inline-flex py-2.5 px-5 text-sm">
                    Lihat Semua →
                </x-button>
            </div>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <!-- BEST SELLING -->
    @if($produkTerlaris->count() > 0)
        <section class="py-[80px] bg-g50 px-4 md:px-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary/5 rounded-full blur-[100px] -mr-48 -mt-48"></div>
            <div class="max-w-[1280px] mx-auto relative">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                    <div class="max-w-xl">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary-light text-primary text-xs font-bold uppercase tracking-wider mb-4">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                            </span>
                            Hot Item
                        </div>
                        <h2 class="font-heading text-[32px] font-extrabold text-g900 leading-[1.2] mb-2">Paling Banyak Dibeli
                        </h2>
                        <p class="text-g500 text-lg leading-relaxed">Produk favorit pilihan ribuan pelanggan yang sudah terbukti
                            kualitasnya.</p>
                    </div>
                    <x-button variant="primary" onclick="window.location='{{ route('products.index') }}'"
                        class="py-3 px-8 text-sm font-bold shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 group">
                        Eksplor Semua <i class="fi fi-rr-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </x-button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($produkTerlaris as $item)
                        @if ($item->produk)
                            <div class="relative group">
                                <div
                                    class="absolute -inset-0.5 bg-gradient-to-r from-primary/20 to-teal/20 rounded-[2rem] blur opacity-0 group-hover:opacity-100 transition duration-500">
                                </div>
                                <x-product-card :produk="$item->produk" :wishlistIds="$wishlistIds ?? []" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <!-- DEALS / HIGHLIGHT -->
        @if ($produkTerlaris->count() >= 2)
            <section class="pb-[80px] bg-g50 px-4 md:px-8">
                <div class="max-w-[1280px] mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach ($produkTerlaris->take(2) as $item)
                            <div class="group relative min-h-[340px] rounded-[2.5rem] overflow-hidden cursor-pointer border border-white/50 shadow-card transition-all duration-500 hover:shadow-card-lg hover:-translate-y-1"
                                onclick="window.location='{{ route('products.show', $item->produk) }}'">
                                <img src="{{ asset('storage/products/' . $item->produk->gambar) }}"
                                    alt="{{ $item->produk->nama_produk }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-g900/95 via-g900/60 to-transparent p-10 flex flex-col justify-end">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex -space-x-2">
                                            <div
                                                class="w-8 h-8 rounded-full border-2 border-white bg-g200 flex items-center justify-center text-[10px] font-bold">
                                                JD</div>
                                            <div
                                                class="w-8 h-8 rounded-full border-2 border-white bg-primary text-white flex items-center justify-center text-[10px] font-bold">
                                                AS</div>
                                            <div
                                                class="w-8 h-8 rounded-full border-2 border-white bg-teal text-white flex items-center justify-center text-[10px] font-bold">
                                                +50</div>
                                        </div>
                                        <span class="text-white/80 text-xs font-medium">Banyak orang telah membeli ini</span>
                                    </div>
                                    <h3 class="font-heading text-3xl font-extrabold text-white mb-3 leading-tight tracking-tight">
                                        {{ $item->produk->nama_produk }}
                                    </h3>
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex flex-col">
                                            <span class="text-white/50 text-[11px] uppercase tracking-widest font-bold mb-1">Harga
                                                Spesial</span>
                                            <div class="text-2xl font-extrabold text-white">
                                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div
                                            class="bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl group-hover:bg-primary transition-colors duration-300">
                                            <i class="fi fi-rr-arrow-right text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif

    <!-- NEW ARRIVALS -->
    <section class="py-[72px] bg-white px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <x-badge variant="primary" class="mb-3 tracking-wide gap-1.5 py-1.5 px-3.5">
                        <i class="fi fi-rr-sparkles"></i> Terbaru
                    </x-badge>
                    <h2 class="font-heading text-[32px] font-extrabold text-g900 leading-[1.2] mb-2">Produk Baru Masuk</h2>
                    <p class="text-g500 text-[15px] m-0">Jangan lewatkan koleksi terbaru kami!</p>
                </div>
                <x-button variant="outline" onclick="window.location='{{ route('products.index') }}'"
                    class="hidden md:inline-flex py-2.5 px-5 text-sm">
                    Lihat Semua →
                </x-button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4.5">
                @foreach ($produkBaru as $produk)
                    <x-product-card :produk="$produk" :wishlistIds="$wishlistIds ?? []" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- WHY US -->
    <section class="py-[72px] bg-gradient-to-br from-g900 to-[#0f2060] px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto text-center">
            <x-badge variant="primary"
                class="mb-3 tracking-wide gap-1.5 py-1.5 px-3.5 bg-white/10 border border-white/10 text-white/80">
                <i class="fi fi-rr-bolt text-primary"></i> Kenapa Elektronik Modern
            </x-badge>
            <h2 class="font-heading text-[32px] font-extrabold text-white leading-[1.2] mb-3">Belanja Lebih Mudah &
                Terpercaya</h2>
            <p class="text-white/60 text-sm max-w-xl mx-auto">Kami berkomitmen memberikan pelayanan terbaik dan produk
                berkualitas untuk kebutuhan elektronik Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-10">
                <div class="text-center p-8">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-[28px] mx-auto mb-4 border border-white/10 text-white">
                        <i class="fi fi-rr-shield-check"></i>
                    </div>
                    <h3 class="font-heading text-[17px] font-extrabold text-white mb-2">Produk 100% Original</h3>
                    <p class="text-[13px] text-white/50 leading-[1.7]">Semua produk bersumber langsung dari distributor
                        resmi dengan garansi pabrik.</p>
                </div>
                <div class="text-center p-8">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-[28px] mx-auto mb-4 border border-white/10 text-white">
                        <i class="fi fi-rr-truck-side"></i>
                    </div>
                    <h3 class="font-heading text-[17px] font-extrabold text-white mb-2">Pengiriman Cepat</h3>
                    <p class="text-[13px] text-white/50 leading-[1.7]">Pengiriman ke seluruh Indonesia dengan estimasi 1–5
                        hari kerja.</p>
                </div>
                <div class="text-center p-8">
                    <div
                        class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-[28px] mx-auto mb-4 border border-white/10 text-white">
                        <i class="fi fi-rr-credit-card"></i>
                    </div>
                    <h3 class="font-heading text-[17px] font-extrabold text-white mb-2">Pembayaran Aman</h3>
                    <p class="text-[13px] text-white/50 leading-[1.7]">Transfer bank & e-wallet dengan konfirmasi manual
                        oleh tim admin kami.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function buildHeroParticles() {
            const c = document.getElementById("particles");
            if (!c) return;
            for (let i = 0; i < 20; i++) {
                const d = document.createElement("div");
                d.className = "absolute rounded-full bg-white/5 animate-[floatSlow_linear_infinite]";
                const s = Math.random() * 80 + 20;
                d.style.cssText = `width:${s}px;height:${s}px;left:${Math.random() * 100}%;bottom:${Math.random() * -20}%;animation-duration:${Math.random() * 15 + 8}s;animation-delay:${Math.random() * 10}s`;
                c.appendChild(d);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(buildHeroParticles);
            } else {
                window.addEventListener('load', buildHeroParticles);
            }
        });
    </script>
@endpush