<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-name"><i class="fi fi-rr-crown" style="margin-right: 6px; color: #eab308;"></i> Elektronik Modern</div>
        <div class="sidebar-brand-role">Panel Owner</div>
    </div>
    <div class="s-group">Menu Utama</div>
    <a href="{{ route('owner.index') }}" class="s-item {{ request()->routeIs('owner.index') ? 'active' : '' }}">
        <span class="si"><i class="fi fi-rr-chart-histogram"></i></span> Dashboard
    </a>
    <div class="s-group">Akun</div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="s-item"
            style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:inherit;font-size:inherit;color:inherit">
            <span class="si"><i class="fi fi-rr-sign-out-alt"></i></span> Keluar
        </button>
    </form>
</div>
