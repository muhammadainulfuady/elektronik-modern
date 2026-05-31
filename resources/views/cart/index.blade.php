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
                    <div class="flex-1 w-full space-y-4">
                        {{-- Desktop Table --}}
                        <div class="hidden md:block bg-white rounded-2xl shadow-card overflow-hidden border border-g100">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr>
                                        <th class="bg-g50 py-4 px-6 text-[11px] font-bold text-g400 uppercase tracking-widest border-b border-g100">Produk</th>
                                        <th class="bg-g50 py-4 px-6 text-[11px] font-bold text-g400 uppercase tracking-widest border-b border-g100">Harga</th>
                                        <th class="bg-g50 py-4 px-6 text-[11px] font-bold text-g400 uppercase tracking-widest border-b border-g100 text-center">Jumlah</th>
                                        <th class="bg-g50 py-4 px-6 text-[11px] font-bold text-g400 uppercase tracking-widest border-b border-g100">Subtotal</th>
                                        <th class="bg-g50 py-4 px-6 border-b border-g100"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-g100">
                                    @foreach ($items as $item)
                                        <tr class="group hover:bg-g50/50 transition-colors">
                                            <td class="py-5 px-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-20 h-20 rounded-2xl bg-g50 border border-g100 p-2 flex items-center justify-center shrink-0">
                                                        @if($item->produk->gambar)
                                                            <img src="{{ asset('storage/products/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-contain mix-blend-multiply">
                                                        @else
                                                            <i class="fi fi-rr-picture text-3xl text-g300"></i>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="text-[11px] font-bold text-primary uppercase tracking-wider mb-1">{{ $item->produk->kategori->nama_kategori }}</div>
                                                        <div class="text-sm font-bold text-g900 line-clamp-2 leading-snug">{{ $item->produk->nama_produk }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-5 px-6">
                                                <div class="font-heading font-extrabold text-g900">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="py-5 px-6">
                                                <div class="flex items-center justify-center gap-0 border-2 border-g100 rounded-xl overflow-hidden w-fit mx-auto bg-white">
                                                    <form method="POST" action="{{ route('cart.update') }}" class="m-0">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                        <input type="hidden" name="qty" value="{{ max(0, $item->qty - 1) }}">
                                                        <button type="submit" class="w-9 h-9 flex items-center justify-center bg-g50 text-g700 hover:bg-primary-light hover:text-primary transition-colors">−</button>
                                                    </form>
                                                    <span class="w-10 text-center font-bold text-sm">{{ $item->qty }}</span>
                                                    <form method="POST" action="{{ route('cart.update') }}" class="m-0">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                        <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                                        <button type="submit" class="w-9 h-9 flex items-center justify-center bg-g50 text-g700 hover:bg-primary-light hover:text-primary transition-colors">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="py-5 px-6">
                                                <div class="font-heading font-extrabold text-primary text-lg">Rp {{ number_format($item->lineTotal, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="py-5 px-6 text-right">
                                                <form method="POST" action="{{ route('cart.remove') }}" class="m-0">
                                                    @csrf @method('DELETE')
                                                    <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                    <button type="submit" class="w-10 h-10 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center mx-auto">
                                                        <i class="fi fi-rr-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Cards --}}
                        <div class="md:hidden space-y-4">
                            @foreach ($items as $item)
                                <div class="bg-white rounded-3xl p-5 shadow-card border border-g100 relative group">
                                    <div class="flex gap-4">
                                        <div class="w-24 h-24 rounded-2xl bg-g50 border border-g100 p-2 flex items-center justify-center shrink-0">
                                            @if($item->produk->gambar)
                                                <img src="{{ asset('storage/products/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-contain mix-blend-multiply">
                                            @else
                                                <i class="fi fi-rr-picture text-3xl text-g300"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 pr-8">
                                            <div class="text-[10px] font-bold text-primary uppercase tracking-wider mb-1">{{ $item->produk->kategori->nama_kategori }}</div>
                                            <div class="text-[14px] font-bold text-g900 line-clamp-2 leading-tight mb-2">{{ $item->produk->nama_produk }}</div>
                                            <div class="font-heading font-extrabold text-primary text-base">Rp {{ number_format($item->lineTotal, 0, ',', '.') }}</div>
                                            <div class="text-[11px] text-g400 font-medium mt-1">@ Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-g50">
                                        <div class="flex items-center gap-0 border-2 border-g100 rounded-xl overflow-hidden bg-white">
                                            <form method="POST" action="{{ route('cart.update') }}" class="m-0">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                <input type="hidden" name="qty" value="{{ max(0, $item->qty - 1) }}">
                                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-g50 text-g700">−</button>
                                            </form>
                                            <span class="w-10 text-center font-bold text-sm">{{ $item->qty }}</span>
                                            <form method="POST" action="{{ route('cart.update') }}" class="m-0">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                                <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-g50 text-g700">+</button>
                                            </form>
                                        </div>
                                        
                                        <form method="POST" action="{{ route('cart.remove') }}" class="m-0">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="id_produk" value="{{ $item->produk->id_produk }}">
                                            <button type="submit" class="flex items-center gap-2 py-2 px-4 rounded-xl text-red-500 font-bold text-xs bg-red-50">
                                                <i class="fi fi-rr-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="w-full lg:w-[360px] shrink-0 lg:sticky lg:top-[84px]">
                        <div class="bg-white rounded-[2.5rem] shadow-card p-6 md:p-8 border border-g100">
                            <h3 class="font-heading text-xl font-extrabold text-g900 mb-6">Ringkasan Belanja</h3>
    
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-g500 font-medium">Subtotal ({{ count($items) }} produk)</span>
                                    <span class="font-bold text-g900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                
                                @if ($appliedPromo)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-green-600 font-bold flex items-center gap-2">
                                            <i class="fi fi-rr-ticket"></i> Voucher ({{ $appliedPromo->kode_voucher }})
                                        </span>
                                        <span class="font-bold text-green-600">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('cart.voucher.apply') }}" class="relative mt-6">
                                @csrf
                                <input name="kode_voucher" value="{{ $appliedPromo->kode_voucher ?? old('kode_voucher') }}"
                                    placeholder="KODE VOUCHER" required
                                    class="w-full py-3.5 pr-20 pl-4 border-2 border-g100 rounded-2xl outline-none text-xs font-bold text-g900 uppercase focus:border-primary transition-all">
                                <button type="submit" class="absolute right-2 top-2 bottom-2 px-4 rounded-xl bg-g900 text-white text-[10px] font-bold uppercase hover:bg-primary transition-colors">Pakai</button>
                            </form>
                            
                            @if ($appliedPromo)
                                <div class="flex justify-between items-center mt-3 bg-green-50 py-2 px-4 rounded-xl border border-green-100">
                                    <span class="text-[11px] font-bold text-green-700 flex items-center gap-2"><i class="fi fi-rr-ticket"></i> {{ $appliedPromo->kode_voucher }}</span>
                                    <form method="POST" action="{{ route('cart.voucher.remove') }}" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Hapus</button>
                                    </form>
                                </div>
                            @endif

                            @if ($promos->isNotEmpty())
                                <div class="mt-6 pt-6 border-t border-g100">
                                    <h4 class="text-[11px] font-extrabold text-g400 uppercase tracking-widest mb-3">Voucher Tersedia</h4>
                                    <div class="space-y-2">
                                        @foreach ($promos as $p)
                                            <div class="flex items-center justify-between p-3 bg-g50 rounded-xl border border-g100 group hover:border-primary transition-colors">
                                                <div class="min-w-0">
                                                    <div class="text-[12px] font-bold text-g800 uppercase">{{ $p->kode_voucher }}</div>
                                                    <div class="text-[10px] text-g500 font-medium">
                                                        Diskon {{ $p->tipe_diskon === 'persen' ? $p->nilai_diskon . '%' : 'Rp ' . number_format($p->nilai_diskon, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                                <button type="button" 
                                                    onclick="document.getElementsByName('kode_voucher')[0].value='{{ $p->kode_voucher }}'; document.querySelector('form[action=\'{{ route('cart.voucher.apply') }}\']').submit();"
                                                    class="text-[10px] font-bold text-primary uppercase hover:underline">Gunakan</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center mt-8 pt-6 border-t-2 border-dashed border-g100">
                                <span class="text-base font-bold text-g900">Total</span>
                                <span class="font-heading text-2xl font-extrabold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="mt-8 space-y-3">
                                @auth
                                    @if (auth()->user()->role === 'customer')
                                        <x-button onclick="window.location='{{ route('customer.checkout') }}'" class="w-full py-4 text-[15px] shadow-xl shadow-primary/20">
                                            Checkout Sekarang <i class="fi fi-rr-arrow-right ml-2"></i>
                                        </x-button>
                                    @endif
                                @endauth
                                <x-button variant="outline" onclick="window.location='{{ route('products.index') }}'" class="w-full py-4 border-2 font-bold text-g700">
                                    Lanjut Belanja
                                </x-button>
                            </div>
                            
                            <div class="mt-6 flex items-center justify-center gap-2 text-[10px] font-bold text-g400 uppercase tracking-widest">
                                <i class="fi fi-rr-lock text-xs"></i> 100% Secure Checkout
                            </div>
                        </div>
                    </div>
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
@if($errors->has('kode_voucher'))
    document.addEventListener('DOMContentLoaded', function() {
        window.showAlert('error', 'Voucher Gagal', "{{ $errors->first('kode_voucher') }}");
    });
@endif

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