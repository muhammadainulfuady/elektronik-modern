<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Elektronik Modern - Toko elektronik terpercaya dengan harga terbaik. Belanja ribuan produk elektronik berkualitas.')">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', 'Elektronik Modern - Toko elektronik terpercaya dengan harga terbaik.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('logo.png'))">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Flaticon UIcons -->
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-brands/css/uicons-brands.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('head')
    <style>
        .reveal { opacity: 1; transform: none; transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1); will-change: transform, opacity; }
        
        @media (prefers-reduced-motion: no-preference) {
            .js-enabled .reveal { opacity: 0; transform: translateY(30px); }
            .js-enabled .reveal.active { opacity: 1; transform: translateY(0); }
            .js-enabled .reveal-group > * { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.2, 1, 0.3, 1); }
            .js-enabled .reveal-group.active > * { opacity: 1; transform: translateY(0); }
        }
        
        @for($i = 1; $i <= 10; $i++)
            .reveal-group.active > *:nth-child({{ $i }}) { transition-delay: {{ $i * 0.1 }}s; }
        @endfor
    </style>
    <script>document.documentElement.classList.add('js-enabled');</script>
</head>

<body class="antialiased bg-g50 text-g900">
    <script>
        window.AppConfig = {
            csrfToken: '{{ csrf_token() }}',
            routes: {
                login: '{{ route('login') }}',
                products: '{{ route('products.index') }}',
                cartCount: '{{ route('cart.count') ?? '' }}',
                wishlistCount: '{{ route('wishlist.count') ?? '' }}',
                wishlistToggle: '{{ route('wishlist.toggle') ?? '' }}',
                cartAdd: '{{ route('cart.add') ?? '' }}',
                cartRemove: '{{ route('cart.remove') ?? '' }}',
                cartUpdate: '{{ route('cart.update') ?? '' }}',
                notifications: '{{ route('customer.notifications.index') ?? '' }}',
                notificationsRead: '{{ route('customer.notifications.read', ':id') ?? '' }}',
                notificationsReadAll: '{{ route('customer.notifications.readAll') ?? '' }}',
                notificationsDestroy: '{{ route('customer.notifications.destroy', ':id') ?? '' }}'
            },
            auth: {
                check: {{ auth()->check() ? 'true' : 'false' }},
                role: '{{ auth()->check() ? auth()->user()->role : '' }}',
                cartQty: {{ auth()->check() && auth()->user()->keranjang ? auth()->user()->keranjang->detailKeranjangs()->sum('qty') : 0 }},
                wishlistCount: {{ auth()->check() ? auth()->user()->wishlists()->count() : 0 }}
            }
        };
    </script>
    @include('partials.flash-messages')

    @hasSection('header')
        @yield('header')
    @else
        @include('partials.header')
    @endif

    @yield('content')

    @hasSection('footer')
        @yield('footer')
    @else
        @include('partials.footer')
    @endif

    @stack('scripts')
</body>

</html>
