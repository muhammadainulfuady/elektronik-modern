<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Elektronik Modern – Toko elektronik terpercaya dengan harga terbaik. Belanja ribuan produk elektronik berkualitas.">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
