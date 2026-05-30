<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('index') }}" class="nav-logo">
        <i class="fi fi-rr-bolt" style="color:var(--blue)"></i>
        Elektronik<span>Modern</span>
    </a>
    <div class="nav-search">
        <span class="search-icon"><i class="fi fi-rr-search"></i></span>
        <input type="text" placeholder="Cari TV, kulkas, AC, mesin cuci..." id="navSearchInput"
            onkeydown="if(event.key==='Enter') window.location='{{ route('products.index') }}?q='+encodeURIComponent(this.value)" />
    </div>
    <div class="nav-right">
        @auth
            @if (auth()->user()->role === 'customer')
                {{-- Customer: tampilkan keranjang, profil, dan pesanan --}}
                <button type="button" class="nav-icon-btn" title="Notifikasi" onclick="toggleNotifPanel()">
                    <i class="fi fi-rr-bell"></i><span class="notif-badge" id="notifBadgeNav">0</span>
                </button>
                <a href="{{ route('customer.wishlist') }}" class="nav-icon-btn" title="Wishlist" style="text-decoration:none">
                    <i class="fi fi-rr-heart"></i><span class="wishlist-badge" id="wishlistBadgeNav">{{ auth()->user()->wishlists()->count() }}</span>
                </a>
                <a href="{{ route('cart.index') }}" class="nav-icon-btn" title="Keranjang" style="text-decoration:none">
                    <i class="fi fi-rr-shopping-cart"></i><span class="cart-badge" id="cartBadgeNav">{{ auth()->user()->keranjang ? auth()->user()->keranjang->detailKeranjangs()->sum('qty') : 0 }}</span>
                </a>
                <a href="{{ route('customer.profile') }}" class="nav-icon-btn" title="Profil Saya" style="text-decoration:none">
                    <i class="fi fi-rr-user"></i>
                </a>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline btn-sm">
                    <i class="fi fi-rr-box" style="margin-right:4px"></i> Pesanan
                </a>
            @elseif (auth()->user()->role === 'admin')
                {{-- Admin: link ke dashboard admin --}}
                <a href="{{ route('admin.index') }}" class="btn btn-outline btn-sm">
                    <i class="fi fi-rr-shield" style="margin-right:4px"></i> Admin
                </a>
            @elseif (auth()->user()->role === 'owner')
                {{-- Owner: link ke dashboard owner --}}
                <a href="{{ route('owner.index') }}" class="btn btn-outline btn-sm">
                    <i class="fi fi-rr-crown" style="margin-right:4px"></i> Owner
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">
                    <i class="fi fi-rr-sign-out-alt" style="margin-right:4px"></i> Keluar
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
        @endauth
    </div>
</nav>

@auth
    @if (auth()->user()->role === 'customer')
        <div class="notif-overlay" id="notifOverlay" onclick="closeNotifPanel()"></div>
        <div class="notif-panel" id="notifPanel">
            <div class="notif-pheader">
                <h3>Notifikasi</h3>
                <button type="button" class="notif-mark" onclick="markNotificationsRead()">Tandai dibaca</button>
            </div>
            <div class="notif-list" id="notifList">
                <div style="padding:18px 20px;color:var(--g400);font-size:13px;text-align:center">Memuat notifikasi...</div>
            </div>
        </div>

        <script>
            const cartBadgeNav = document.getElementById('cartBadgeNav');
            const wishlistBadgeNav = document.getElementById('wishlistBadgeNav');
            const notifBadgeNav = document.getElementById('notifBadgeNav');
            const notifPanel = document.getElementById('notifPanel');
            const notifOverlay = document.getElementById('notifOverlay');
            const notifList = document.getElementById('notifList');

            function setBadge(el, count) {
                if (!el) return;
                const value = Number(count) || 0;
                el.textContent = value > 99 ? '99+' : value;
                el.style.display = value > 0 ? 'flex' : 'none';
            }

            function refreshCartBadge() {
                fetch('{{ route('cart.count') }}')
                    .then(response => response.json())
                    .then(data => setBadge(cartBadgeNav, data.cartCount))
                    .catch(() => {});
            }

            function refreshWishlistBadge() {
                fetch('{{ route('wishlist.count') }}')
                    .then(response => response.json())
                    .then(data => setBadge(wishlistBadgeNav, data.wishlistCount))
                    .catch(() => {});
            }

            function loadNotifications() {
                fetch('{{ route('customer.notifications.index') }}')
                    .then(response => response.json())
                    .then(data => {
                        setBadge(notifBadgeNav, data.unreadCount);
                        if (!data.notifications.length) {
                            notifList.innerHTML = '<div style="padding:18px 20px;color:var(--g400);font-size:13px;text-align:center">Belum ada notifikasi.</div>';
                            return;
                        }

                        notifList.innerHTML = data.notifications.map(item => `
                            <div class="notif-item ${item.is_read ? '' : 'unread'}">
                                <div class="notif-icon">${item.ikon}</div>
                                <div>
                                    <div class="notif-title">${item.judul}</div>
                                    <div class="notif-msg">${item.pesan}</div>
                                </div>
                            </div>
                        `).join('');
                    })
                    .catch(() => {
                        notifList.innerHTML = '<div style="padding:18px 20px;color:var(--danger);font-size:13px;text-align:center">Notifikasi gagal dimuat.</div>';
                    });
            }

            function toggleNotifPanel() {
                notifPanel.classList.toggle('open');
                notifOverlay.classList.toggle('open');
                if (notifPanel.classList.contains('open')) {
                    loadNotifications();
                }
            }

            function closeNotifPanel() {
                notifPanel.classList.remove('open');
                notifOverlay.classList.remove('open');
            }

            function markNotificationsRead() {
                fetch('{{ route('customer.notifications.readAll') }}', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                }).then(() => loadNotifications());
            }

            document.addEventListener('DOMContentLoaded', () => {
                setBadge(cartBadgeNav, '{{ auth()->user()->keranjang ? auth()->user()->keranjang->detailKeranjangs()->sum('qty') : 0 }}');
                setBadge(wishlistBadgeNav, '{{ auth()->user()->wishlists()->count() }}');
                setBadge(notifBadgeNav, 0);
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(loadNotifications);
                } else {
                    window.addEventListener('load', loadNotifications);
                }
            });
        </script>
    @endif
@endauth
