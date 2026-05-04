<!-- PROMO STRIP -->
<div class="promo-strip">
    🎉 Promo Hari Ini: Gratis ongkir untuk semua produk! <span>|</span> ⚡
    Flash Sale mulai pukul 12.00 WIB <span>|</span> 🔥 Diskon s/d 30%
</div>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('index') }}" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
    <div class="nav-search">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Cari TV, kulkas, AC, mesin cuci..." id="navSearchInput"
            onkeydown="if(event.key==='Enter') window.location='{{ route('products.index') }}?q='+this.value" />
    </div>
    <div class="nav-right">
        <a href="{{ route('cart.index') }}" class="nav-icon-btn" title="Keranjang" style="text-decoration:none">
            🛒<span class="cart-badge" id="cartBadgeNav">0</span>
        </a>
        @auth
            <a href="{{ route('index') }}" class="nav-icon-btn" title="Profil Saya"
                style="text-decoration: none; font-size: 16px">👤</a>
            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'owner')
                <a href="{{ route('admin.index') }}" class="btn btn-outline btn-sm">🛡️ Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
        @endauth
    </div>
</nav>