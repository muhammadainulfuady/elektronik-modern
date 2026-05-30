@props(['produk', 'wishlistIds' => []])

@php
    $inWishlist = auth()->check() && in_array($produk->id_produk, $wishlistIds);
    $adaPromo = $produk->promo && $produk->promo->status === 'aktif' && now()->between($produk->promo->tanggal_mulai, $produk->promo->tanggal_selesai);
    $hargaTampil = $adaPromo ? $produk->harga - ($produk->harga * ($produk->promo->diskon / 100)) : $produk->harga;
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-card overflow-hidden transition-all duration-250 cursor-pointer relative flex flex-col group hover:shadow-card-md hover:-translate-y-1']) }} 
     onclick="window.location='{{ route('products.show', $produk->getRouteKey()) }}'">
    
    @if ($adaPromo)
        <div class="absolute top-3 left-3 z-10 text-[11px] font-extrabold bg-gradient-to-br from-[#FF6B35] to-[#FF3366] text-white py-1 px-2.5 rounded-lg tracking-wide">
            Diskon {{ $produk->promo->diskon }}%
        </div>
    @elseif($produk->stok < 5 && $produk->stok > 0)
        <div class="absolute top-3 left-3 z-10 text-[11px] font-extrabold bg-warn-light text-warn py-1 px-2.5 rounded-lg tracking-wide">
            Sisa {{ $produk->stok }}
        </div>
    @elseif($produk->stok == 0)
        <div class="absolute top-3 left-3 z-10 text-[11px] font-extrabold bg-danger-light text-danger py-1 px-2.5 rounded-lg tracking-wide">
            Habis
        </div>
    @endif

    <button type="button" 
            onclick="toggleWishlist(this, {{ $produk->id_produk }}, event)"
            class="absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full bg-white/90 border-none cursor-pointer flex items-center justify-center text-base shadow-[0_2px_8px_rgba(0,0,0,0.15)] transition-all duration-200 backdrop-blur-sm {{ $inWishlist ? 'text-red-500' : 'text-slate-400' }} hover:scale-110 hover:bg-white">
        <i class="{{ $inWishlist ? 'fi fi-sr-heart' : 'fi fi-rr-heart' }}"></i>
    </button>

    <div class="relative overflow-hidden aspect-square bg-g50">
        @if ($produk->gambar)
            <img src="{{ asset('storage/products/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105" />
        @else
            <div class="w-full h-full flex items-center justify-center text-g300 text-[60px]">
                <i class="fi fi-rr-picture"></i>
            </div>
        @endif
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <div class="text-[11px] font-bold text-primary tracking-wider uppercase mb-1.5">{{ $produk->kategori->nama_kategori }}</div>
        <div class="text-sm font-bold text-g800 mb-2 leading-[1.4] flex-1 line-clamp-2">{{ $produk->nama_produk }}</div>
        
        <div class="flex items-baseline gap-2 mb-2">
            <div class="font-heading text-[17px] font-extrabold text-primary">Rp {{ number_format($hargaTampil, 0, ',', '.') }}</div>
            @if ($adaPromo)
                <div class="text-xs text-g400 line-through">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
            @endif
        </div>

        <div class="flex items-center justify-between mt-auto">
            <div class="text-[11px] text-g500 font-semibold"><i class="fi fi-rr-box mr-1"></i> Stok {{ $produk->stok }}</div>
            @if ($produk->stok > 0)
                <button class="w-[34px] h-[34px] rounded-lg bg-primary text-white border-none cursor-pointer flex items-center justify-center text-lg transition-all shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:scale-110" onclick="addToCart(this, {{ $produk->id_produk }}, 1, event)" title="Tambah ke Keranjang">
                    <i class="fi fi-rr-shopping-cart-add"></i>
                </button>
            @else
                <button disabled class="w-[34px] h-[34px] rounded-lg bg-g200 text-g400 border-none cursor-not-allowed flex items-center justify-center text-lg">
                    <i class="fi fi-rr-ban"></i>
                </button>
            @endif
        </div>
    </div>
</div>
