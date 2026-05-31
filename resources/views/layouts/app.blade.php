<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Elektronik Modern - Toko elektronik terpercaya dengan harga terbaik. Belanja ribuan produk elektronik berkualitas.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap"
        rel="stylesheet">
    <!-- Flaticon UIcons -->
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-brands/css/uicons-brands.css'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('head')
</head>

<body class="antialiased bg-g50 text-g900">
    <script>
        window.AppConfig = {
            csrfToken: '{{ csrf_token() }}',
            routes: {
                login: '{{ route('login') }}',
                cartCount: '{{ route('cart.count') ?? '' }}',
                wishlistCount: '{{ route('wishlist.count') ?? '' }}',
                wishlistToggle: '{{ route('wishlist.toggle') ?? '' }}',
                cartAdd: '{{ route('cart.add') ?? '' }}',
                cartRemove: '{{ route('cart.remove') ?? '' }}',
                cartUpdate: '{{ route('cart.update') ?? '' }}',
                notifications: '{{ route('customer.notifications.index') ?? '' }}',
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

        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('status') }}",
                    confirmButtonColor: '#1A5CFF',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#1A5CFF',
                });
            @endif
            
            window.showAlert = (icon, title, text) => {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                    confirmButtonColor: '#1A5CFF',
                });
            };

            window.showToast = (icon, title) => {
                Toast.fire({
                    icon: icon,
                    title: title
                });
            };
        });
    </script>
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