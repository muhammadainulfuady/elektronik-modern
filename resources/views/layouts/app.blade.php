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
        /* Reveal Animation Styles */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
            will-change: transform, opacity;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered delay for child elements */
        .reveal-group > * {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .reveal-group.active > * {
            opacity: 1;
            transform: translateY(0);
        }

        @php
            for($i = 1; $i <= 10; $i++) {
                echo ".reveal-group.active > *:nth-child($i) { transition-delay: " . ($i * 0.1) . "s; }\n";
            }
        @endphp
    </style>
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
            // Scroll Reveal Implementation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const revealElements = document.querySelectorAll('.reveal, .reveal-group');
            revealElements.forEach(el => observer.observe(el));

            // SweetAlert Config
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

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Ups!',
                    html: "{!! implode('<br>', $errors->all()) !!}",
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
