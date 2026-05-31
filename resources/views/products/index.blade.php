@extends('layouts.app')

@section('title', 'Katalog Produk - Elektronik Modern')

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

            <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-6 md:gap-8">
                <!-- FILTER SIDEBAR -->
                <aside class="w-full">
                    {{-- Mobile Filter Toggle --}}
                    <button type="button" class="lg:hidden w-full flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-g200 mb-4" onclick="toggleFilters()">
                        <div class="flex items-center gap-2 font-heading font-extrabold text-g900">
                            <i class="fi fi-rr-filter text-primary"></i> Filter & Kategori
                        </div>
                        <i class="fi fi-rr-angle-small-down transition-transform duration-300" id="filterChevron"></i>
                    </button>

                    <div id="filterContent" class="hidden lg:block bg-white rounded-2xl shadow-card p-6 h-fit lg:sticky lg:top-[84px] border border-g100">
                        <div class="hidden lg:flex font-heading text-[15px] font-extrabold text-g800 mb-6 items-center gap-2">
                            <i class="fi fi-rr-filter text-primary"></i> Filter
                        </div>

                        <!-- Search -->
                        <div class="mb-6">
                            <h4 class="text-[10px] font-bold text-g400 uppercase tracking-widest mb-3">Pencarian</h4>
                            <form method="GET" action="{{ route('products.index') }}" class="relative">
                                @if(request('kategori'))
                                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                                @endif
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                <i class="fi fi-rr-search absolute left-3.5 top-1/2 -translate-y-1/2 text-g400"></i>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                                    class="w-full py-2.5 pr-3.5 pl-10 text-[13px] border-[1.5px] border-g200 rounded-xl outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
                            </form>
                        </div>

                        <!-- Categories -->
                        <div>
                            <h4 class="text-[10px] font-bold text-g400 uppercase tracking-widest mb-3">Kategori</h4>
                            <div class="flex flex-col gap-1.5">
                                <a href="{{ route('products.index', array_merge(request()->except('kategori','page'), [])) }}"
                                    class="flex items-center justify-between py-2.5 px-3.5 rounded-xl text-[13px] font-bold transition-all {{ !request('kategori') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-g600 hover:bg-g100' }}">
                                    <div class="flex items-center gap-2.5">
                                        <i class="fi fi-rr-apps {{ !request('kategori') ? 'text-white' : 'text-g400' }}"></i> Semua
                                    </div>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ !request('kategori') ? 'bg-white/20 text-white' : 'bg-g100 text-g500' }}">{{ $kategoris->count() }}</span>
                                </a>
                                @foreach ($kategoris as $kategori)
                                    <a href="{{ route('products.index', array_merge(request()->except('page'), ['kategori' => $kategori->nama_kategori])) }}"
                                        class="flex items-center justify-between py-2.5 px-3.5 rounded-xl text-[13px] font-bold transition-all {{ request('kategori') == $kategori->nama_kategori ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-g600 hover:bg-g100' }}">
                                        <div class="flex items-center gap-2.5">
                                            <span class="{{ request('kategori') == $kategori->nama_kategori ? 'text-white' : 'text-primary' }}">{!! $kategori->ikonHtml() !!}</span>
                                            {{ $kategori->nama_kategori }}
                                        </div>
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ request('kategori') == $kategori->nama_kategori ? 'bg-white/20 text-white' : 'bg-g100 text-g500' }}">{{ $kategori->produks_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- PRODUCT GRID -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div class="text-[13px] md:text-sm text-g500 font-medium">
                            Menampilkan <strong class="text-g900">{{ $produks->total() }}</strong> produk
                            @if(request('q'))
                                untuk "<strong class="text-g900">{{ request('q') }}</strong>"
                            @endif
                        </div>
                        <div class="flex gap-2 overflow-x-auto pb-2 sm:pb-0 hide-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
                            @php $currentSort = request('sort', 'terbaru'); @endphp
                            @foreach (['terbaru' => 'Terbaru', 'termurah' => 'Termurah', 'termahal' => 'Termahal', 'nama' => 'A-Z'] as $key => $label)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => $key])) }}"
                                    class="py-2 px-4 rounded-full text-[11px] font-extrabold transition-all whitespace-nowrap {{ $currentSort === $key ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white border border-g200 text-g600 hover:border-primary hover:text-primary' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($produks->count())
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                            @foreach ($produks as $produk)
                                <x-product-card :produk="$produk" :wishlistIds="$wishlistIds ?? []" />
                            @endforeach
                        </div>

                        <div class="mt-12 flex justify-center">
                            {{ $produks->links('pagination::tailwind') }}
                        </div>
                    @else
                        <div class="bg-white rounded-[2.5rem] shadow-sm border border-g100 p-12 md:p-20 text-center mt-5">
                            <div class="w-20 h-20 mx-auto rounded-3xl bg-g50 flex items-center justify-center text-[40px] text-g300 mb-6"><i class="fi fi-rr-search-alt"></i></div>
                            <h3 class="font-heading text-xl md:text-2xl font-extrabold text-g900 mb-3">Produk Tidak Ditemukan</h3>
                            <p class="text-g500 text-sm md:text-base mb-8 max-w-sm mx-auto">Coba ubah filter, kategori, atau kata kunci pencarian Anda untuk menemukan produk.</p>
                            <x-button variant="primary" onclick="window.location='{{ route('products.index') }}'" class="py-3 px-8">
                                Lihat Semua Produk
                            </x-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function toggleFilters() {
            const content = document.getElementById('filterContent');
            const chevron = document.getElementById('filterChevron');
            const isHidden = content.classList.contains('hidden');
            
            if (isHidden) {
                content.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        }
    </script>
    @endpush
        </div>
    </section>
@endsection
