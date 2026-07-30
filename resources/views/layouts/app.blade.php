<!DOCTYPE html>
<html id="htmlRoot" lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="NAY Brand - Premium Skincare & Haircare Products" />
    <meta property="og:description"
        content="Discover high-quality skincare and haircare products from NAY Brand at the best prices." />
    <meta property="og:image" content="https://nay-brand.shop/nay_logo.jpg" />
    <meta property="og:url" content="https://nay-brand.shop/" />
    <meta property="og:type" content="website" />
    <title>{{ config('app.name', 'Albrolosy') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @yield('style')
</head>

<body class="font-sans antialiased">
    @yield('content')


    @stack('scripts')
</body>

</html>
