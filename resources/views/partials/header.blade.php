<!-- NAVBAR -->
@php
    $user = auth()->user();
    $isAdmin = $user && $user->role === 'admin';
    $isOwner = $user && $user->role === 'owner';
    $isAdminOrOwner = $isAdmin || $isOwner;
@endphp

<nav
    class="sticky top-0 z-[900] bg-white/95 backdrop-blur-[20px] border-b border-g200 px-3 md:px-8 h-[68px] flex items-center justify-between gap-1.5 md:gap-5 overflow-hidden">
    <div class="flex items-center gap-1.5 sm:gap-3 min-w-0">
        {{-- Burger Menu Trigger --}}
        <button type="button"
            class="md:hidden w-9 h-9 flex items-center justify-center text-g700 hover:bg-g100 rounded-xl transition-all shrink-0"
            id="mobileMenuBtn">
            <i class="fi fi-rr-menu-burger text-lg" id="mobileMenuIcon"></i>
        </button>

        <a href="{{ route('index') }}"
            class="font-heading text-[15px] xs:text-[18px] sm:text-[20px] md:text-[22px] font-extrabold text-primary whitespace-nowrap flex items-center gap-1 overflow-hidden">
            @if($isAdmin)
                <i class="fi fi-rr-shield shrink-0 text-base xs:text-lg"></i>
                <span class="truncate">Admin<span class="text-g900">Panel</span></span>
            @elseif($isOwner)
                <i class="fi fi-rr-crown shrink-0 text-base xs:text-lg text-yellow-600"></i>
                <span class="truncate text-yellow-600">Owner<span class="text-g900">Panel</span></span>
            @else
                <i class="fi fi-rr-bolt shrink-0 text-base xs:text-lg"></i>
                <span class="truncate">Elektronik<span class="text-g900">Modern</span></span>
            @endif
        </a>
    </div>

    @if(!$isAdminOrOwner)
        @php
            $isSearchPage = request()->routeIs('index') || request()->routeIs('products.index');
        @endphp
        @if ($isSearchPage)
            <div class="flex-1 max-w-[480px] relative hidden lg:block mx-4">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-g400 text-base"><i
                        class="fi fi-rr-search"></i></span>
                <input type="text" placeholder="Cari produk elektronik..." id="navSearchInput"
                    class="w-full py-2.5 pr-4 pl-11 rounded-full bg-g100 border-[1.5px] border-g200 font-sans text-sm text-g800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10"
                    onkeydown="handleSearch(this)" value="{{ request('q') }}" />
            </div>
        @endif
    @endif

    <div class="flex items-center gap-1 md:gap-2 shrink-0">
        @auth
            @if ($user->role === 'customer')
                @if(isset($isSearchPage) && $isSearchPage)
                    <button type="button"
                        class="lg:hidden w-9 h-9 rounded-full flex items-center justify-center bg-g100 text-g700 text-base hover:bg-g200"
                        onclick="toggleMobileSearch()">
                        <i class="fi fi-rr-search"></i>
                    </button>
                @endif

                <button type="button"
                    class="w-9 h-9 md:w-[42px] md:h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-base relative hover:bg-g200"
                    title="Notifikasi" onclick="toggleNotifPanel()">
                    <i class="fi fi-rr-bell"></i>
                    <span
                        class="absolute top-0 right-0 bg-primary text-white rounded-full w-[15px] h-[15px] md:w-[18px] md:h-[18px] text-[8px] md:text-[10px] font-bold hidden items-center justify-center border-2 border-white"
                        id="notifBadgeNav">0</span>
                </button>

                <a href="{{ route('cart.index') }}"
                    class="w-9 h-9 md:w-[42px] md:h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-base relative hover:bg-g200"
                    title="Keranjang">
                    <i class="fi fi-rr-shopping-cart"></i>
                    <span
                        class="absolute top-0 right-0 bg-primary text-white rounded-full w-[15px] h-[15px] md:w-[18px] md:h-[18px] text-[8px] md:text-[10px] font-bold hidden items-center justify-center border-2 border-white"
                        id="cartBadgeNav">{{ $user->keranjang ? $user->keranjang->detailKeranjangs()->sum('qty') : 0 }}</span>
                </a>

                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('customer.wishlist') }}"
                        class="w-[42px] h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-lg relative hover:bg-g200"
                        title="Wishlist">
                        <i class="fi fi-rr-heart"></i>
                        <span
                            class="absolute -top-[1px] -right-[1px] bg-primary text-white rounded-full w-[18px] h-[18px] text-[10px] font-bold hidden items-center justify-center border-2 border-white"
                            id="wishlistBadgeNav">{{ $user->wishlists()->count() }}</span>
                    </a>
                    <a href="{{ route('customer.profile') }}"
                        class="w-[42px] h-[42px] rounded-full flex items-center justify-center bg-g100 text-g700 text-lg relative hover:bg-g200"
                        title="Profil Saya">
                        <i class="fi fi-rr-user"></i>
                    </a>
                </div>
            @else
                <div
                    class="w-9 h-9 md:w-10 md:h-10 {{ $isAdmin ? 'bg-primary/10 text-primary' : 'bg-yellow-500/10 text-yellow-600' }} rounded-full flex items-center justify-center text-[12px] font-bold border border-current/10">
                    {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                </div>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="m-0 hidden md:block">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary hover:text-primary transition-all">
                    <i class="fi fi-rr-sign-out-alt"></i> Keluar
                </button>
            </form>
        @else
            <div class="flex items-center gap-2">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-white border-[1.5px] border-g300 text-g700 hover:border-primary transition-all">Masuk</a>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex items-center gap-1.5 py-2 px-3.5 rounded-full font-bold text-[13px] whitespace-nowrap bg-primary text-white shadow-lg hover:bg-primary-dark transition-all">Daftar</a>
            </div>
        @endauth
    </div>
</nav>

{{-- Mobile Sidebar for Customer/Guest --}}
@if(!$isAdminOrOwner)
    <div id="mobileMenuOverlay"
        class="fixed inset-0 bg-dark/50 backdrop-blur-sm z-[1000] hidden opacity-0 transition-opacity duration-300"
        onclick="toggleMobileMenu()"></div>
    <div id="mobileMenu"
        class="fixed top-0 left-0 h-full w-[280px] bg-white z-[1001] transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl overflow-y-auto">
        <div class="p-5">
            <div class="flex items-center justify-between mb-6 gap-2">
                <a href="{{ route('index') }}"
                    class="font-heading text-[16px] xs:text-[18px] font-extrabold text-primary flex items-center gap-1 leading-tight overflow-hidden">
                    <i class="fi fi-rr-bolt shrink-0"></i>
                    <span class="truncate">Elektronik<span class="text-g900">Modern</span></span>
                </a>
                <button onclick="toggleMobileMenu()"
                    class="text-g400 hover:text-g900 shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-g50"><i
                        class="fi fi-rr-cross-small text-lg"></i></button>
            </div>

            {{-- User Profile Summary (If Logged In) --}}
            @auth
                <div class="mb-8 p-4 bg-primary-light/50 border border-primary/10 rounded-2xl flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-[13px] font-bold text-g900 truncate">{{ $user->nama }}</div>
                        <div class="text-[10px] font-medium text-g500 truncate">{{ $user->email }}</div>
                    </div>
                </div>
            @endauth

            <div class="space-y-1 mb-8">
                <div class="text-[10px] font-bold text-g400 uppercase tracking-widest mb-3 ml-2">Menu Utama</div>
                <a href="{{ route('index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('index') ? 'bg-primary-light text-primary font-bold' : 'text-g700 hover:bg-g100' }}">
                    <i class="fi fi-rr-home"></i> Beranda
                </a>
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('products.index') ? 'bg-primary-light text-primary font-bold' : 'text-g700 hover:bg-g100' }}">
                    <i class="fi fi-rr-shopping-bag"></i> Katalog Produk
                </a>
                <a href="{{ route('customer.orders') }}"
                    class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('customer.orders') ? 'bg-primary-light text-primary font-bold' : 'text-g700 hover:bg-g100' }}">
                    <i class="fi fi-rr-box"></i> Pesanan Saya
                </a>
                <a href="{{ route('customer.wishlist') }}"
                    class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('customer.wishlist') ? 'bg-primary-light text-primary font-bold' : 'text-g700 hover:bg-g100' }}">
                    <i class="fi fi-rr-heart"></i> Wishlist
                </a>
            </div>

            @auth
                <div class="space-y-1 mb-8">
                    <div class="text-[10px] font-bold text-g400 uppercase tracking-widest mb-3 ml-2">Akun Saya</div>
                    <a href="{{ route('customer.profile') }}"
                        class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('customer.profile') ? 'bg-primary-light text-primary font-bold' : 'text-g700 hover:bg-g100' }}">
                        <i class="fi fi-rr-user"></i> Profil Saya
                    </a>

                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0 border-t border-g100 pt-6">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 p-3 rounded-xl text-red-500 hover:bg-red-50 transition-colors font-bold">
                        <i class="fi fi-rr-sign-out-alt"></i> Keluar Akun
                    </button>
                </form>
            @else
                <div class="grid grid-cols-1 gap-3 pt-6 border-t border-g100">
                    <a href="{{ route('login') }}"
                        class="w-full py-3 px-4 text-center rounded-xl border-2 border-g200 text-g800 font-bold hover:border-primary hover:text-primary transition-all">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="w-full py-3 px-4 text-center rounded-xl bg-primary text-white font-bold shadow-lg shadow-primary/20">Daftar
                        Akun Baru</a>
                </div>
            @endauth

            <div class="mt-8 pt-8 border-t border-g50 text-center">
                <div class="text-[10px] font-bold text-g300 uppercase tracking-[0.2em] mb-1">Elektronik Modern</div>
                <div class="text-[9px] text-g400 font-medium">Versi 2.0.4 — © 2026</div>
            </div>
        </div>
    </div>
@endif

<script>
    function toggleMobileMenu() {
        @if($isAdminOrOwner)
            // Handled by sidebar specific scripts
            return;
        @else
                    const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            const icon = document.getElementById('mobileMenuIcon');
            if (!menu || !overlay) return;
            const isHidden = menu.classList.contains('-translate-x-full');
            if (isHidden) {
                menu.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                if (icon) { icon.classList.remove('fi-rr-menu-burger'); icon.classList.add('fi-rr-cross-small'); }
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                menu.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                if (icon) { icon.classList.remove('fi-rr-cross-small'); icon.classList.add('fi-rr-menu-burger'); }
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        @endif
    }
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('mobileMenuBtn');
        if (btn) btn.addEventListener('click', toggleMobileMenu);
    });
</script>