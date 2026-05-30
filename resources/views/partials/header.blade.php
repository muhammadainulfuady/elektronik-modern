<!-- NAVBAR -->
<nav class="sticky top-0 z-[900] bg-white/95 backdrop-blur-[20px] border-b border-g200 px-4 md:px-8 h-[68px] flex items-center gap-5">
    <a href="{{ route('index') }}" class="font-heading text-[22px] font-extrabold text-primary whitespace-nowrap flex items-center gap-1.5">
        <i class="fi fi-rr-bolt"></i>
        Elektronik<span class="text-g900">Modern</span>
    </a>
    @php
        $showSearch = !auth()->check() || auth()->user()->role === 'customer';
        $isSearchPage = request()->routeIs('index') || request()->routeIs('products.index');
    @endphp

    @if ($showSearch && $isSearchPage)
    <div class="flex-1 max-w-[480px] relative hidden md:block">
        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-g400 text-base"><i class="fi fi-rr-search"></i></span>
        <input type="text" placeholder="Cari TV, kulkas, AC, mesin cuci..." id="navSearchInput"
            class="w-full py-2.5 pr-4 pl-11 rounded-full bg-g100 border-[1.5px] border-g200 font-sans text-sm text-g800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10"
            onkeydown="handleSearch(this)" 
            value="{{ request('q') }}" />
    </div>
    @else
    <div class="flex-1"></div>
    @endif
    <div class="flex items-center gap-2 ml-auto">
        @auth
            @if (auth()->user()->role === 'customer')
                {{-- Customer: tampilkan keranjang, profil, dan pesanan --}}
                <button type="button" class="w-[42px] h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-lg relative transition-colors hover:bg-g200" title="Notifikasi" onclick="toggleNotifPanel()">
                    <i class="fi fi-rr-bell"></i>
                    <span class="absolute -top-[1px] -right-[1px] bg-primary text-white rounded-full w-[18px] h-[18px] text-[10px] font-bold hidden items-center justify-center border-2 border-white" id="notifBadgeNav">0</span>
                </button>
                <a href="{{ route('customer.wishlist') }}" class="w-[42px] h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-lg relative transition-colors hover:bg-g200" title="Wishlist">
                    <i class="fi fi-rr-heart"></i>
                    <span class="absolute -top-[1px] -right-[1px] bg-primary text-white rounded-full w-[18px] h-[18px] text-[10px] font-bold hidden items-center justify-center border-2 border-white" id="wishlistBadgeNav">{{ auth()->user()->wishlists()->count() }}</span>
                </a>
                <a href="{{ route('cart.index') }}" class="w-[42px] h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-lg relative transition-colors hover:bg-g200" title="Keranjang">
                    <i class="fi fi-rr-shopping-cart"></i>
                    <span class="absolute -top-[1px] -right-[1px] bg-primary text-white rounded-full w-[18px] h-[18px] text-[10px] font-bold hidden items-center justify-center border-2 border-white" id="cartBadgeNav">{{ auth()->user()->keranjang ? auth()->user()->keranjang->detailKeranjangs()->sum('qty') : 0 }}</span>
                </a>
                <a href="{{ route('customer.profile') }}" class="w-[42px] h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-lg relative transition-colors hover:bg-g200" title="Profil Saya">
                    <i class="fi fi-rr-user"></i>
                </a>
                <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary hover:text-primary hover:bg-primary-light transition-all hidden md:inline-flex">
                    <i class="fi fi-rr-box"></i> Pesanan
                </a>
            @elseif (auth()->user()->role === 'admin')
                {{-- Admin: link ke dashboard admin --}}
                <a href="{{ route('admin.index') }}" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary hover:text-primary hover:bg-primary-light transition-all">
                    <i class="fi fi-rr-shield"></i> Admin
                </a>
            @elseif (auth()->user()->role === 'owner')
                {{-- Owner: link ke dashboard owner --}}
                <a href="{{ route('owner.index') }}" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary hover:text-primary hover:bg-primary-light transition-all">
                    <i class="fi fi-rr-crown"></i> Owner
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary hover:text-primary hover:bg-primary-light transition-all">
                    <i class="fi fi-rr-sign-out-alt"></i> Keluar
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary hover:text-primary hover:bg-primary-light transition-all">Masuk</a>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-primary text-white shadow-[0_4px_12px_rgba(26,92,255,0.3)] hover:bg-primary-dark hover:-translate-y-px hover:shadow-[0_6px_20px_rgba(26,92,255,0.4)] transition-all">Daftar</a>
        @endauth
    </div>
</nav>

@auth
    @if (auth()->user()->role === 'customer')
        <div class="fixed inset-0 z-[998] hidden bg-dark/50 backdrop-blur-sm transition-opacity" id="notifOverlay" onclick="closeNotifPanel()"></div>
        <div class="fixed top-[76px] right-4 md:right-20 w-[calc(100%-32px)] md:w-[360px] bg-white rounded-2xl shadow-card-lg z-[999] border border-g200 overflow-hidden transform -translate-y-2 scale-95 opacity-0 pointer-events-none transition-all duration-200" id="notifPanel">
            <div class="p-4 border-b border-g100 flex items-center justify-between bg-white">
                <h3 class="font-extrabold text-[15px] text-g900">Notifikasi</h3>
                <button type="button" class="text-xs font-semibold text-primary bg-transparent border-none cursor-pointer" onclick="markNotificationsRead()">Tandai dibaca</button>
            </div>
            <div class="max-h-[360px] overflow-y-auto" id="notifList">
                <div class="p-[18px_20px] text-g400 text-[13px] text-center">Memuat notifikasi...</div>
            </div>
        </div>
    @endif
@endauth
