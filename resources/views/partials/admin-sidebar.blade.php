<div class="w-full md:w-[240px] bg-dark shrink-0 flex flex-col md:sticky md:top-0 md:h-screen overflow-y-auto">
    <div class="p-6 border-b border-white/10">
        <div class="font-heading text-lg font-extrabold text-white flex items-center gap-2">
            <span class="text-primary text-xl"><i class="fi fi-rr-bolt"></i></span>
            Elektronik Modern
        </div>
        <div class="text-[11px] text-g500 mt-1">Panel {{ auth()->user()->role === 'owner' ? 'Owner' : 'Administrator' }}</div>
    </div>
    <div class="px-5 pt-5 pb-2 text-[10px] font-bold text-g600 tracking-wider uppercase">Menu Utama</div>
    <a href="{{ route('admin.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('admin.index') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-apps"></i></span> Dashboard
    </a>
    <a href="{{ route('admin.products.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('admin.products.*') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-box"></i></span> Kelola Produk
    </a>
    <a href="{{ route('admin.categories.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('admin.categories.*') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-tags"></i></span> Kelola Kategori
    </a>
    <a href="{{ route('admin.promos.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('admin.promos.*') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-badge-percent"></i></span> Kelola Promo
    </a>
    <a href="{{ route('admin.orders.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('admin.orders.*') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-document"></i></span> Kelola Pesanan
    </a>
    <a href="{{ route('admin.users.index') }}"
        class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left {{ request()->routeIs('admin.users.*') ? 'text-primary bg-primary/10 border-primary' : 'text-g500 hover:text-white hover:bg-white/5' }}">
        <span class="w-[18px] text-center text-base"><i class="fi fi-rr-users"></i></span> Kelola Customer
    </a>
    <div class="px-5 pt-5 pb-2 text-[10px] font-bold text-g600 tracking-wider uppercase">Akun</div>
    <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="flex items-center gap-3 py-2.5 px-5 text-[13px] font-medium cursor-pointer transition-all border-l-[3px] border-transparent no-underline w-full text-left text-g500 hover:text-white hover:bg-white/5 bg-transparent">
            <span class="w-[18px] text-center text-base"><i class="fi fi-rr-sign-out-alt"></i></span> Keluar
        </button>
    </form>
</div>
