@extends('layouts.app')

@section('title', 'Katalog Produk – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .catalog-section { padding: 32px 0 72px }
        .catalog-header { margin-bottom: 32px }
        .catalog-header h1 { font-family: "Syne", sans-serif; font-size: 32px; font-weight: 800; margin-bottom: 8px }
        .catalog-header p { color: var(--g500); font-size: 15px }

        .catalog-layout { display: grid; grid-template-columns: 240px 1fr; gap: 28px }

        /* Filter sidebar */
        .filter-panel { background: #fff; border-radius: var(--rlg); box-shadow: var(--sh); padding: 24px; height: fit-content; position: sticky; top: 84px }
        .filter-title { font-family: "Syne",sans-serif; font-size: 15px; font-weight: 800; margin-bottom: 16px; color: var(--g800) }
        .filter-group { margin-bottom: 20px }
        .filter-group h4 { font-size: 12px; font-weight: 700; color: var(--g500); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 10px }
        .filter-cat { display: flex; flex-direction: column; gap: 4px }
        .filter-cat a {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;
            color: var(--g600); text-decoration: none; transition: .15s
        }
        .filter-cat a:hover, .filter-cat a.active { background: var(--blue-l); color: var(--blue) }
        .filter-cat a .count { font-size: 11px; color: var(--g400); font-weight: 500 }
        .filter-cat a.active .count { color: var(--blue) }

        /* Sort bar */
        .sort-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px }
        .sort-bar .result-count { font-size: 14px; color: var(--g500) }
        .sort-bar .result-count strong { color: var(--g800) }
        .sort-options { display: flex; gap: 6px }
        .sort-options a {
            padding: 7px 14px; border-radius: 50px; font-size: 12px; font-weight: 700;
            text-decoration: none; color: var(--g500); background: var(--g100); transition: .15s
        }
        .sort-options a:hover, .sort-options a.active { background: var(--blue); color: #fff }

        .prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 18px }
        .pagination-wrap { margin-top: 32px; display: flex; justify-content: center }
        .pagination-wrap nav { display: flex; gap: 4px }
        .pagination-wrap .page-link {
            padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 700;
            text-decoration: none; color: var(--g600); background: #fff; border: 1px solid var(--g200); transition: .15s
        }
        .pagination-wrap .page-link:hover { border-color: var(--blue); color: var(--blue) }
        .pagination-wrap .page-item.active .page-link { background: var(--blue); color: #fff; border-color: var(--blue) }
        .pagination-wrap .page-item.disabled .page-link { color: var(--g300); cursor: default }

        .empty-state { text-align: center; padding: 60px 20px }
        .empty-state .empty-icon { font-size: 60px; margin-bottom: 16px }

        @media(max-width:768px) {
            .catalog-layout { grid-template-columns: 1fr }
            .filter-panel { position: static }
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="catalog-section">
        <div class="container">
            <div class="catalog-header">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}">Beranda</a> <span>›</span> <span>Katalog Produk</span>
                </div>
                <h1>Katalog Produk</h1>
                <p>Temukan produk elektronik berkualitas dengan harga terbaik</p>
            </div>

            <div class="catalog-layout">
                <!-- FILTER SIDEBAR -->
                <aside class="filter-panel">
                    <div class="filter-title">🔍 Filter</div>

                    <!-- Search -->
                    <div class="filter-group">
                        <h4>Pencarian</h4>
                        <form method="GET" action="{{ route('products.index') }}">
                            @if(request('kategori'))
                                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                                style="padding:10px 14px;font-size:13px">
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="filter-group">
                        <h4>Kategori</h4>
                        <div class="filter-cat">
                            <a href="{{ route('products.index', array_merge(request()->except('kategori','page'), [])) }}"
                                class="{{ !request('kategori') ? 'active' : '' }}">
                                Semua Kategori
                                <span class="count">{{ $kategoris->sum('produks_count') }}</span>
                            </a>
                            @foreach ($kategoris as $kategori)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['kategori' => $kategori->id_kategori])) }}"
                                    class="{{ request('kategori') == $kategori->id_kategori ? 'active' : '' }}">
                                    {{ $kategori->nama_kategori }}
                                    <span class="count">{{ $kategori->produks_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <!-- PRODUCT GRID -->
                <div>
                    <div class="sort-bar">
                        <div class="result-count">
                            Menampilkan <strong>{{ $produks->total() }}</strong> produk
                            @if(request('q'))
                                untuk "<strong>{{ request('q') }}</strong>"
                            @endif
                        </div>
                        <div class="sort-options">
                            @php $currentSort = request('sort', 'terbaru'); @endphp
                            @foreach (['terbaru' => 'Terbaru', 'termurah' => 'Termurah', 'termahal' => 'Termahal', 'nama' => 'A-Z'] as $key => $label)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['sort' => $key])) }}"
                                    class="{{ $currentSort === $key ? 'active' : '' }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>

                    @if ($produks->count())
                        <div class="prod-grid">
                            @foreach ($produks as $produk)
                                <a href="{{ route('products.show', $produk) }}" class="prod-card" style="text-decoration:none;color:inherit">
                                    <div class="prod-img-wrap">
                                        <img src="{{ asset('storage/products/' . $produk->gambar) }}"
                                            alt="{{ $produk->nama_produk }}" loading="lazy" decoding="async">
                                        @if ($produk->stok <= 0)
                                            <div class="prod-card-badge badge badge-danger">HABIS</div>
                                        @elseif ($produk->stok <= 10)
                                            <div class="prod-card-badge badge badge-warn">TERBATAS</div>
                                        @endif
                                    </div>
                                    <div class="prod-body">
                                        <div class="prod-cat">{{ $produk->kategori->nama_kategori ?? '-' }}</div>
                                        <div class="prod-name">{{ $produk->nama_produk }}</div>
                                        <div class="prod-price-row">
                                            <span class="prod-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="prod-footer">
                                            <span class="prod-stock">Stok: {{ $produk->stok }} unit</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="pagination-wrap">
                            {{ $produks->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">🔍</div>
                            <div style="font-weight:700;font-size:18px;color:var(--g700);margin-bottom:6px">
                                Produk Tidak Ditemukan
                            </div>
                            <div style="font-size:14px;color:var(--g400);margin-bottom:20px">
                                Coba ubah filter atau kata kunci pencarian Anda.
                            </div>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Semua Produk</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
