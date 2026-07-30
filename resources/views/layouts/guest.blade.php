<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nay') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --olive-dark: #4E5146;
            --sage: #8F957D;
            --bg-soft: #F3F4EF;
            --text-main: #2B2E26;
            --cream: #E6E1D5;
            --gold-soft: #CBBF9A;
            --error-muted: #A55C5C;
        }

        body {
            background-color: var(--bg-soft);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
        }

        .btn-olive {
            background-color: var(--olive-dark);
            color: white;
            transition: all 0.3s;
        }

        .btn-olive:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .input-custom:focus {
            border-color: var(--sage) !important;
            --tw-ring-color: var(--sage) !important;
        }

        /* --- Login Logo --- */
        #login-logo {
            width: 70px;
            height: auto;
            opacity: 0;
            transform: translateY(-12px);
            transition: all 0.6s ease;
        }

        #login-logo.show {
            opacity: 1;
            transform: translateY(0);
        }

        .login-logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        @yield('content')
    </div>
    @stack('scripts')
</body>

</html>
