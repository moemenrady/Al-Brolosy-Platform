<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Albrolosy Real Estate')</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===================================== */
        /* 1. Design Tokens (نظام الألوان والقياسات) */
        /* ===================================== */
        :root {
            /* الألوان الأساسية */
            --primary: #B40000;
            --accent: #E4DCC7;
            --success: #28a745;
            --danger: #dc3545;

            /* المسافات والحدود */
            --radius-sm: 8px;
            --radius: 20px;
            --max-w-7xl: 1280px;
            --transition: 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            --header-h: 70px;
        }

        /* الوضع الداكن (Dark Theme - Default) */
        html[data-theme="dark"] {
            --bg-main: #000000;
            --surface: #0d0d0f;
            --surface-2: #1a1a1a;
            --text: #F0F0F0;
            --muted: #76767A;
            --border: rgba(228, 220, 199, 0.15);
            --shadow-lux: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* الوضع الفاتح (Light Theme) */
        html[data-theme="light"] {
            --bg-main: #F0F0F0;
            --surface: #ffffff;
            --surface-2: #f8f9fa;
            --text: #111111;
            --muted: #696969;
            --border: rgba(0, 0, 0, 0.1);
            --shadow-lux: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        /* ===================================== */
        /* 2. الإعدادات العامة (Base Styles)     */
        /* ===================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        html[dir="rtl"] {
            font-family: 'Cairo', sans-serif;
        }

        html[dir="ltr"] {
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ===================================== */
        /* 3. Top Progress Bar (GitHub Style)    */
        /* ===================================== */
        #top-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background-color: var(--primary);
            z-index: 99999;
            transition: width 0.3s ease, opacity 0.3s ease;
            box-shadow: 0 0 10px var(--primary);
        }

        /* ===================================== */
        /* 4. Top Navigation (70px Height)       */
        /* ===================================== */
        .top-nav {
            height: var(--header-h);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            background: rgba(var(--bg-main), 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-logo {
            color: var(--accent);
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-actions {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-btn {
            background: none;
            border: none;
            color: var(--text);
            cursor: pointer;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }

        .nav-btn:hover {
            color: var(--primary);
        }

        .nav-btn svg {
            width: 20px;
            height: 20px;
        }

        /* ===================================== */
        /* 5. Global Search Overlay (Spotlight)  */
        /* ===================================== */
        .search-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 15vh;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease-out;
            /* يفتح في أقل من 200ms */
        }

        .search-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .search-container {
            width: 90%;
            max-width: 700px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lux);
            transform: translateY(-20px);
            transition: transform 0.3s ease-out;
            overflow: hidden;
        }

        .search-overlay.active .search-container {
            transform: translateY(0);
        }

        .search-input {
            width: 100%;
            padding: 1.5rem;
            background: transparent;
            border: none;
            color: var(--text);
            font-size: 1.2rem;
            outline: none;
        }

        /* ===================================== */
        /* 6. Page Hero & Breadcrumb             */
        /* ===================================== */
        .page-hero {
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
            text-align: center;
            padding: 0 1rem;
        }

        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .breadcrumb a {
            color: var(--muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 300;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .hero-subtitle {
            color: var(--primary);
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* ===================================== */
        /* 7. Main Content & Layouts             */
        /* ===================================== */
        .main-container {
            max-width: var(--max-w-7xl);
            margin: 0 auto;
            padding: 80px 5%;
            /* مساحات داخلية كبيرة للراحة البصرية */
        }

        /* الكروت الموحدة حسب الـ Design System */
        .card-component {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
        }

        .card-component:hover {
            transform: translateY(-8px);
            border-color: rgba(180, 0, 0, 0.4);
            box-shadow: var(--shadow-lux);
        }

        /* ===================================== */
        /* 8. Floating Utilities & Bottom Nav    */
        /* ===================================== */
        .floating-utility-bar {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 1rem 0.5rem;
            border-radius: 50px;
            box-shadow: var(--shadow-lux);
            z-index: 900;
        }

        html[dir="rtl"] .floating-utility-bar {
            right: auto;
            left: 20px;
        }

        .bottom-mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 0.8rem 1rem;
            z-index: 900;
            justify-content: space-around;
        }

        @media (max-width: 768px) {
            .floating-utility-bar {
                display: none;
            }

            .bottom-mobile-nav {
                display: flex;
            }

            .main-container {
                padding: 40px 5% 100px 5%;
            }

            /* مساحة للـ bottom nav */
        }

        /* أدوات التحكم في الظهور */
        .hide-mobile {
            display: block;
        }

        .show-mobile {
            display: none;
        }

        @media (max-width: 768px) {
            .hide-mobile {
                display: none;
            }

            .show-mobile {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- 1. Top Progress Bar -->
    <div id="top-progress-bar"></div>

    <!-- 2. Global Search Overlay -->
    <div id="global-search-overlay" class="search-overlay">
        <div class="search-container">
            <input type="text" class="search-input" data-placeholder-ar="ابحث عن المشاريع، الوحدات، الوظائف..."
                data-placeholder-en="Search projects, units, jobs..." placeholder="Search projects, units, jobs..."
                id="global-search-input">
        </div>
    </div>

    <!-- 3. Top Navigation -->
    <header class="top-nav">
        <a href="/" class="brand-logo">Albrolosy</a>
        <div class="nav-actions">
            <!-- Search Button (Spotlight) -->
            <button class="nav-btn js-open-search" title="Search (Spotlight)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>

            <!-- Language Toggle Button -->
            <button class="nav-btn hide-mobile" id="toggle-lang">
                <span class="lang-en">EN</span> / <span class="lang-ar">AR</span>
            </button>

            <!-- Theme Toggle Button -->
            <button class="nav-btn hide-mobile" id="toggle-theme">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>

            <!-- Profile Button -->
            <a class="nav-btn" href="{{ route('profile') }}" title="Profile">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </a>
        </div>
    </header>

    <!-- 4. Page Hero -->
    <section class="page-hero">
        <nav class="breadcrumb">
            <a href="/" data-ar="الرئيسية" data-en="Home">@lang('Home')</a>
            <span>/</span>
            @yield('breadcrumb')
        </nav>
        <h1 class="hero-title">@yield('page_title')</h1>
        <span class="hero-subtitle">@yield('page_subtitle')</span>
    </section>

    @hasSection('quick_actions')
        <div class="quick-actions" style="display:flex; justify-content:center; gap:1rem; transform: translateY(-50%);">
            @yield('quick_actions')
        </div>
    @endif

    <!-- 5. Main Content -->
    <main class="main-container">
        @yield('content')
    </main>

    @hasSection('related_content')
        <section class="related-content-section" style="background: var(--surface-2); padding: 60px 5%;">
            <div class="main-container" style="padding: 0;">
                @yield('related_content')
            </div>
        </section>
    @endif

    <!-- 6. Footer -->
    <footer
        style="padding: 3rem 5%; background: var(--surface); border-top: 1px solid var(--border); text-align: center;">
        <h2 class="brand-logo" style="margin-bottom: 1rem; display: block;">Albrolosy</h2>
        <p style="color: var(--muted); font-size: 0.9rem;"
            data-ar="&copy; 2026 البرلسي للتطوير العقاري. جميع الحقوق محفوظة."
            data-en="&copy; 2026 Albrolosy Real Estate. All rights reserved.">
            &copy; 2026 Albrolosy Real Estate. All rights reserved.
        </p>
    </footer>

    <!-- 7. Floating Utility Bar -->
    <aside class="floating-utility-bar">
        <button class="nav-btn" onclick="window.scrollTo(0,0)" title="Back to top">↑</button>
    </aside>

    <!-- 8. Mobile Bottom Nav -->
    <nav class="bottom-mobile-nav">
        <a href="/" class="nav-btn">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </a>
        <!-- Global Search Trigger (Mobile) -->
        <button class="nav-btn js-open-search">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
        <button class="nav-btn">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg>
        </button>
        <button class="nav-btn">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </button>
    </nav>

    <!-- 9. Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Fake Top Progress Bar (Simulating Page Load Performance)
            const progressBar = document.getElementById('top-progress-bar');
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 30;
                if (progress > 90) progress = 90;
                progressBar.style.width = `${progress}%`;
            }, 100);

            window.onload = () => {
                clearInterval(interval);
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBar.style.opacity = '0';
                    setTimeout(() => progressBar.style.width = '0%', 300);
                }, 500);
            };

            // 2. Global Search Overlay (Spotlight Mode)
            const searchOverlay = document.getElementById('global-search-overlay');
            const searchInput = document.getElementById('global-search-input');
            const openSearchBtns = document.querySelectorAll('.js-open-search');

            // فتح نافذة البحث الشامل من أي زر يحمل الكلاس js-open-search
            openSearchBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    searchOverlay.classList.add('active');
                    setTimeout(() => searchInput.focus(), 100);
                });
            });

            searchOverlay.addEventListener('click', (e) => {
                if (e.target === searchOverlay) searchOverlay.classList.remove('active');
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                    searchOverlay.classList.remove('active');
                }
                // Ctrl+K or Cmd+K to open search like professional apps
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (openSearchBtns.length > 0) openSearchBtns[0].click();
                }
            });

            // 3. Theme & Lang Integration (Using the global Preferences class)
            // ربط الزر الخاص بالثيم بالجلوبال كلاس
            document.getElementById('toggle-theme')?.addEventListener('click', () => {
                if (window.preferences && typeof window.preferences.toggleTheme === 'function') {
                    window.preferences.toggleTheme();
                }
            });

            // ربط الزر الخاص باللغة بالجلوبال كلاس
            document.getElementById('toggle-lang')?.addEventListener('click', () => {
                if (window.preferences && typeof window.preferences.toggleLanguage === 'function') {
                    window.preferences.toggleLanguage();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
