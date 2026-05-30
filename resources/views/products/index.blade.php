@extends('layouts.app')

@section('title', 'Katalog Produk – Elektronik Modern')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="py-8 md:py-[72px] bg-g50 min-h-screen px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="mb-8">
                <div class="flex items-center gap-1.5 mb-3 text-[13px]">
                    <a href="{{ route('index') }}" class="text-g500 hover:text-primary transition-colors flex items-center gap-1.5"><i class="fi fi-rr-home"></i> Beranda</a> 
                    <i class="fi fi-rr-angle-small-right text-g400"></i> 
                    <span class="text-g800 font-semibold">Katalog Produk</span>
                </div>
                <h1 class="font-heading text-[32px] font-extrabold text-g900 mb-2">Katalog Produk</h1>
                <p class="text-g500 text-[15px]">Temukan produk elektronik berkualitas dengan harga terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-[240px_1fr] gap-7">
                <!-- FILTER SIDEBAR -->
                <aside class="bg-white rounded-2xl shadow-card p-6 h-fit md:sticky md:top-[84px] border border-g100">
                    <div class="font-heading text-[15px] font-extrabold text-g800 mb-4 flex items-center gap-2">
                        <i class="fi fi-rr-filter text-primary"></i> Filter
                    </div>

                    <!-- Search -->
                    <div class="mb-5">
                        <h4 class="text-xs font-bold text-g500 uppercase tracking-wider mb-2.5">Pencarian</h4>
                        <form method="GET" action="{{ route('products.index') }}" class="relative">
                            @if(request('kategori'))
                                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <i class="fi fi-rr-search absolute left-3.5 top-1/2 -translate-y-1/2 text-g400"></i>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                                class="w-full py-2.5 pr-3.5 pl-9 text-[13px] border-[1.5px] border-g200 rounded-xl outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                        </form>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="text-xs font-bold text-g500 uppercase tracking-wider mb-2.5">Kategori</h4>
                        <div class="flex flex-col gap-1">
                            <a href="{{ route('products.index', array_merge(request()->except('kategori','page'), [])) }}"
                                class="flex items-center justify-between py-2 px-3 rounded-lg text-[13px] font-semibold transition-colors {{ !request('kategori') ? 'bg-primary-light text-primary' : 'text-g600 hover:bg-g100' }}">
                                <div class="flex items-center gap-2">
                                    <i class="fi fi-rr-apps {{ !request('kategori') ? 'text-primary' : 'text-g400' }}"></i> Semua Kategori
                                </div>
                                <span class="text-[11px] font-medium {{ !request('kategori') ? 'text-primary' : 'text-g400' }}">{{ $kategoris->count() }}</span>
                            </a>
                            @foreach ($kategoris as $kategori)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['kategori' => $kategori->nama_kategori])) }}"
                                    class="flex items-center justify-between py-2 px-3 rounded-lg text-[13px] font-semibold transition-colors {{ request('kategori') == $kategori->nama_kategori ? 'bg-primary-light text-primary' : 'text-g600 hover:bg-g100' }}">
                                    <div class="flex items-center gap-2">
                                        {!! $kategori->ikonHtml('w-4 h-4 object-contain', request('kategori') == $kategori->nama_kategori ? 'text-primary' : 'text-g400') !!}
                                        {{ $kategori->nama_kategori }}
                                    </div>
                                    <span class="text-[11px] font-medium {{ request('kategori') == $kategori->nama_kategori ? 'text-primary' : 'text-g400' }}">{{ $kategori->produks_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <!-- PRODUCT GRID -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                        <div class="text-sm text-g500">
                            Menampilkan <strong class="text-g800">{{ $produks->total() }}</strong> produk
                            @if(request('q'))
                                untuk "<strong class="text-g800">{{ request('q') }}</strong>"
                            @endif
                        </div>
                        <div class="flex gap-1.5 overflow-x-auto pb-2 sm:pb-0 hide-scrollbar">
                            @php $currentSort = request('sort', 'terbaru'); @endphp
                            @foreach (['terbaru' => 'Terbaru', 'termurah' => 'Termurah', 'termahal' => 'Termahal', 'nama' => 'A-Z'] as $key => $label)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => $key])) }}"
                                    class="py-1.5 px-3.5 rounded-full text-xs font-bold transition-colors whitespace-nowrap {{ $currentSort === $key ? 'bg-primary text-white shadow-[0_2px_8px_rgba(26,92,255,0.3)]' : 'bg-white border border-g200 text-g600 hover:border-primary hover:text-primary' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($produks->count())
                        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-5">
                            @foreach ($produks as $produk)
                                <x-product-card :produk="$produk" :wishlistIds="$wishlistIds ?? []" />
                            @endforeach
                        </div>

                        <div class="mt-10 flex justify-center w-full overflow-hidden">
                            <div class="inline-flex max-w-full bg-white rounded-xl shadow-sm border border-g200 p-1">
                                {{ $produks->links('pagination::tailwind') }}
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-sm border border-g100 p-12 text-center mt-5">
                            <div class="text-[64px] text-g300 mb-4 inline-flex justify-center"><i class="fi fi-rr-search-alt"></i></div>
                            <h3 class="font-heading text-xl font-extrabold text-g800 mb-2">Produk Tidak Ditemukan</h3>
                            <p class="text-g500 text-sm mb-6 max-w-sm mx-auto">Coba ubah filter, kategori, atau kata kunci pencarian Anda untuk menemukan produk.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 py-2.5 px-6 rounded-full font-bold text-sm bg-primary text-white shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:-translate-y-px transition-all">Lihat Semua Produk</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
