<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-name">⚡ Elektronik Modern</div>
        <div class="sidebar-brand-role">Panel {{ auth()->user()->role === 'owner' ? 'Owner' : 'Administrator' }}</div>
    </div>
    <div class="s-group">Menu Utama</div>
    <a href="{{ route('admin.index') }}"
        class="s-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <span class="si">📊</span> Dashboard
    </a>
    <a href="{{ route('admin.products.index') }}"
        class="s-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <span class="si">📦</span> Kelola Produk
    </a>
    <a href="{{ route('admin.categories.index') }}"
        class="s-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <span class="si">🏷️</span> Kelola Kategori
    </a>
    <a href="{{ route('admin.promos.index') }}"
        class="s-item {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
        <span class="si">🎟️</span> Kelola Promo
    </a>
    <a href="{{ route('admin.orders.index') }}"
        class="s-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <span class="si">🧾</span> Kelola Pesanan
    </a>
    <a href="{{ route('admin.users.index') }}"
        class="s-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span class="si">👥</span> Kelola Customer
    </a>
    <div class="s-group">Navigasi</div>

    <div class="s-group">Akun</div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="s-item" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:inherit;font-size:inherit;color:inherit">
            <span class="si">🚪</span> Keluar
        </button>
    </form>
</div>
