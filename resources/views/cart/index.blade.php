@extends('layouts.app')

@section('title', 'Keranjang Belanja – Elektronik Modern')

@section('head')
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="py-8 md:py-[72px] bg-g50 min-h-screen px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto" id="cartContainer">
            <div class="flex items-center gap-1.5 mb-6 text-[13px]">
                <a href="{{ route('index') }}" class="text-g500 hover:text-primary transition-colors flex items-center gap-1.5"><i class="fi fi-rr-home"></i> Beranda</a> 
                <i class="fi fi-rr-angle-small-right text-g400"></i> 
                <span class="text-g800 font-semibold">Keranjang</span>
            </div>
            
            <div class="mb-8">
                <h1 class="font-heading text-[28px] md:text-[32px] font-extrabold text-g900 mb-2 flex items-center gap-3">
                    <i class="fi fi-rr-shopping-cart text-primary"></i> Keranjang Belanja
                </h1>
                <p class="text-g500 text-[15px]">{{ count($items) }} produk di keranjang Anda</p>
            </div>

            @if ($errors->any())
                <x-alert type="danger" class="mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            @if (count($items))
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    <!-- Cart Items -->
                    <div class="flex-1 bg-white rounded-2xl shadow-card overflow-x-auto border border-g100 w-full">
                        <table class="w-full min-w-[600px] text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="bg-g50 py-3.5 px-5 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Produk</th>
                                    <th class="bg-g50 py-3.5 px-5 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Harga</th>
                                    <th class="bg-g50 py-3.5 px-5 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Jumlah</th>
                                    <th class="bg-g50 py-3.5 px-5 text-xs font-extrabold text-g500 uppercase tracking-widest border-b border-g200">Subtotal</th>
                                    <th class="bg-g50 py-3.5 px-5 border-b border-g200"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr class="group hover:bg-g50 transition-colors">
                                        <td class="py-4 px-5 border-b border-g100 group-last:border-none">
                                            <div class="flex items-center gap-4">
                                                <div class="w-16 h-16 rounded-xl bg-g50 border border-g100 p-1 flex items-center justify-center shrink-0">
                                                    @if($item->produk->gambar)
                                                        <img src="{{ asset('storage/products/' . $item->produk->gambar) }}"
                                                            alt="{{ $item->produk->nama_produk }}" loading="lazy" decoding="async" class="w-full h-full object-contain mix-blend-multiply">
                                                    @else
                                                        <i class="fi fi-rr-picture text-2xl text-g300"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <x-badge variant="primary" class="mb-1 uppercase tracking-wider">
                                                        {{ $item->produk->kategori->nama_kategori ?? '-' }}
                                                    </x-badge>
                                                    <div class="text-sm font-bold text-g800 line-clamp-2">{{ $item->produk->nama_produk }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-5 border-b border-g100 group-last:border-none">
                                            <div class="font-heading font-extrabold text-g800 whitespace-nowrap">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="py-4 px-5 border-b border-g100 group-last:border-none">
                                            <div class="flex items-center gap-0 border-[1.5px] border-g200 rounded-lg overflow-hidden w-fit bg-white shadow-sm">
                                                <form method="POST" action="{{ route('cart.update') }}" class="m-0">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                    <input type="hidden" name="qty" value="{{ max(0, $item->qty - 1) }}">
                                                    <button type="submit" class="w-8 h-8 border-none bg-g50 text-g700 text-lg font-bold flex items-center justify-center cursor-pointer hover:bg-primary-light hover:text-primary transition-colors">−</button>
                                                </form>
                                                <span class="w-10 text-center font-bold text-[13px] border-x-[1.5px] border-g200 py-1.5">{{ $item->qty }}</span>
                                                <form method="POST" action="{{ route('cart.update') }}" class="m-0">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                    <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                                    <button type="submit" class="w-8 h-8 border-none bg-g50 text-g700 text-lg font-bold flex items-center justify-center cursor-pointer hover:bg-primary-light hover:text-primary transition-colors">+</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="py-4 px-5 border-b border-g100 group-last:border-none">
                                            <div class="font-heading font-extrabold text-primary whitespace-nowrap">Rp {{ number_format($item->lineTotal, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="py-4 px-5 border-b border-g100 group-last:border-none text-right">
                                            <form method="POST" action="{{ route('cart.remove') }}" class="m-0 inline-block">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 border border-red-100 flex items-center justify-center cursor-pointer hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Hapus">
                                                    <i class="fi fi-rr-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Card -->
                    <x-card class="w-full lg:w-[360px] shrink-0 p-6 lg:sticky lg:top-[84px] shadow-card">
                        <h3 class="font-heading text-lg font-extrabold text-g900 mb-5">Ringkasan Belanja</h3>

                        <div class="flex justify-between items-center mb-3 text-[13px]">
                            <span class="text-g500">Subtotal ({{ count($items) }} produk)</span>
                            <span class="font-bold text-g800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('cart.voucher.apply') }}" class="flex gap-2 my-4">
                            @csrf
                            <input name="kode_voucher" value="{{ $appliedPromo->kode_voucher ?? old('kode_voucher') }}"
                                placeholder="Kode voucher" required
                                class="flex-1 py-2 px-3 border-[1.5px] border-g200 rounded-lg outline-none text-[13px] font-bold text-g800 uppercase focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            <x-button type="submit" variant="secondary" class="py-2 px-4 text-[13px]">Pakai</x-button>
                        </form>
                        
                        <div class="mb-4">
                            <h6 class="text-[10px] font-extrabold text-g400 uppercase tracking-widest mb-2">Promo yang Tersedia</h6>
                            <div class="flex flex-col gap-1">
                            @foreach ($promos as $promo)
                                <div class="bg-primary-light border border-primary/20 py-1.5 px-3 rounded text-[11px] font-bold text-primary flex items-center justify-between">
                                    <div class="flex items-center gap-1.5"><i class="fi fi-rr-ticket"></i> {{ $promo->kode_voucher }}</div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        
                        @if ($appliedPromo)
                            <div class="flex justify-between items-center mb-2 bg-green-50 py-1.5 px-3 rounded-lg border border-green-100">
                                <span class="text-[11px] font-bold text-green-700 flex items-center gap-1.5"><i class="fi fi-rr-ticket"></i> {{ $appliedPromo->kode_voucher }}</span>
                                <form method="POST" action="{{ route('cart.voucher.remove') }}" class="m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[10px] font-extrabold text-red-500 hover:text-red-700 uppercase tracking-widest transition-colors">Hapus</button>
                                </form>
                            </div>
                            <div class="flex justify-between items-center mb-3 text-[13px]">
                                <span class="text-g500">Diskon</span>
                                <span class="font-bold text-green-600">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center mt-5 pt-4 border-t-2 border-g100">
                            <span class="text-sm font-bold text-g500">Total</span>
                            <span class="font-heading text-xl font-extrabold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="mt-6 flex flex-col gap-3">
                            @auth
                                @if (auth()->user()->role === 'customer')
                                    <x-button onclick="window.location='{{ route('customer.checkout') }}'" class="w-full">
                                        <i class="fi fi-rr-checkbox"></i> Checkout Sekarang
                                    </x-button>
                                @endif
                            @endauth
                            <x-button variant="outline" onclick="window.location='{{ route('products.index') }}'" class="w-full border-g200 text-g700 hover:border-primary">
                                <i class="fi fi-rr-arrow-left"></i> Lanjut Belanja
                            </x-button>
                        </div>
                        <div class="text-center text-[11px] font-semibold text-g400 mt-4 flex items-center justify-center gap-1.5">
                            <i class="fi fi-rr-lock"></i> Transaksi aman & terenkripsi
                        </div>
                    </x-card>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-g100 p-12 text-center mt-5">
                    <div class="text-[64px] text-g300 mb-4 inline-flex justify-center"><i class="fi fi-rr-shopping-cart"></i></div>
                    <h3 class="font-heading text-xl font-extrabold text-g800 mb-2">Keranjang Kosong</h3>
                    <p class="text-g500 text-sm mb-6 max-w-sm mx-auto">Yuk tambahkan produk favorit kamu ke keranjang dan mulai berbelanja!</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 py-3 px-6 rounded-full font-bold text-[15px] bg-primary text-white shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:-translate-y-px transition-all">
                        <i class="fi fi-rr-shopping-bag"></i> Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('submit', async function(e) {
    const form = e.target;
    // Intercept only forms inside cart container
    if (!form.closest('#cartContainer')) return;
    
    e.preventDefault();
    
    const container = document.getElementById('cartContainer');
    // Visual feedback during request
    container.style.transition = 'opacity 0.2s';
    container.style.opacity = '0.5';
    container.style.pointerEvents = 'none';

    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            body: formData,
            // Intentionally not sending X-Requested-With so Laravel returns HTML instead of JSON
        });

        const html = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        const newContainer = doc.getElementById('cartContainer');
        if (newContainer) {
            container.innerHTML = newContainer.innerHTML;
            
            // Sync navbar badge
            const newBadge = doc.getElementById('cartBadgeNav');
            const oldBadge = document.getElementById('cartBadgeNav');
            if (newBadge && oldBadge) {
                oldBadge.innerHTML = newBadge.innerHTML;
                oldBadge.style.display = newBadge.style.display;
            }
        }
    } catch (error) {
        console.error(error);
    } finally {
        container.style.opacity = '1';
        container.style.pointerEvents = 'auto';
    }
});
</script>
@endpush