   <!DOCTYPE html>
   <html id="htmlRoot" lang="ar" dir="rtl">

   <head>

       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta name="csrf-token" content="{{ csrf_token() }}">

       <!-- Primary Meta Tags -->
       <title>البرلسي للتطوير العقاري | منصة عقارية متكاملة</title>
       <meta name="title" content="البرلسي للتطوير العقاري | منصة عقارية متكاملة">
       <meta name="description"
           content="استكشف أحدث المشروعات العقارية والوحدات السكنية والتجارية مع البرلسي للتطوير العقاري. منصة متكاملة لعرض المشروعات والوحدات والأخبار العقارية والتواصل مع فريق المبيعات.">
       <meta name="keywords"
           content="البرلسي, البرلسي للتطوير العقاري, عقارات, شقق للبيع, استثمار عقاري, وحدات سكنية, وحدات تجارية, مشروعات عقارية, Albrolosy Real Estate">
       <meta name="author" content="Albrolosy Real Estate">

       <!-- Open Graph / Facebook -->
       <meta property="og:type" content="website">
       <meta property="og:site_name" content="Albrolosy Real Estate">
       <meta property="og:title" content="البرلسي للتطوير العقاري | منصة عقارية متكاملة">
       <meta property="og:description"
           content="استكشف أحدث المشروعات العقارية والوحدات السكنية والتجارية مع البرلسي للتطوير العقاري.">
       <meta property="og:image" content="{{ asset('albrolosy_logo.png') }}">
       <meta property="og:url" content="{{ url('/') }}">
       <meta property="og:locale" content="ar_EG">

       <!-- Twitter -->
       <meta name="twitter:card" content="summary_large_image">
       <meta name="twitter:title" content="البرلسي للتطوير العقاري | منصة عقارية متكاملة">
       <meta name="twitter:description"
           content="استكشف أحدث المشروعات العقارية والوحدات السكنية والتجارية مع البرلسي للتطوير العقاري.">
       <meta name="twitter:image" content="{{ asset('albrolosy_logo.png') }}">
       <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

       <title>{{ config('app.name', 'Albrolosy') }}</title>

       <!-- Scripts -->
       @vite(['resources/css/app.css', 'resources/js/app.js'])
       @stack('styles')
       @yield('style')
   </head>

   <body class="font-sans antialiased">
       @yield('content')

       <x-concierge-quiz />

       @stack('scripts')
   </body>

   </html>
