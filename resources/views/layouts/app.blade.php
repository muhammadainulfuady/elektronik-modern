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
    <style>
        /* Flaticon icon sizing helpers */
        .fi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
            line-height: 1;
            margin-bottom: 2px;
        }

        .fi-sm {
            font-size: 14px;
        }

        .fi-md {
            font-size: 18px;
        }

        .fi-lg {
            font-size: 22px;
        }

        .fi-xl {
            font-size: 28px;
        }

        .si {
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
            line-height: 1;
        }
    </style>
    @yield('head')
</head>

<body>
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