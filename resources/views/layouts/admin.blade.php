<!DOCTYPE html>
<html lang="ar" data-theme="dark" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البرلسي - لوحة الإدارة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===================================== */
        /* 1. إعدادات المتغيرات (Theme Variables) */
        /* ===================================== */
        :root {
            /* ألوان الهوية الأساسية */
            --primary-red: #B40000;
            --gold: #d7b64a;
            --warm-beige: #E4DCC7;

            /* لون مخصص للأدمن (Midnight Blue) للإحساس بالتحكم */
            --admin-accent: #0F172A;
            --admin-hover: #1E293B;

            --sidebar-width: 280px;
            --topbar-height: 80px;
            --transition-speed: 0.3s;
        }

        html[data-theme="dark"] {
            --bg-main: #050505;
            /* أسود داكن جداً للخلفية */
            --bg-sidebar: #0A0A0A;
            /* لون القائمة الجانبية */
            --bg-card: #141414;
            --text-main: #F0F0F0;
            --text-muted: #8E8E93;
            --glass-border: rgba(228, 220, 199, 0.1);
        }

        html[data-theme="light"] {
            --bg-main: #F4F6F9;
            /* رمادي فاتح جداً */
            --bg-sidebar: #FFFFFF;
            --bg-card: #FFFFFF;
            --text-main: #1A1A1A;
            --text-muted: #666666;
            --glass-border: rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            overflow-x: hidden;
            display: flex;
            font-family: 'Cairo', sans-serif;
        }

        /* تخصيص السكرول بار ليناسب فخامة اللوحة */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-main);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--glass-border);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold);
        }

        /* ===================================== */
        /* 2. القائمة الجانبية (Sidebar)         */
        /* ===================================== */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            border-left: 1px solid var(--glass-border);
            border-right: none;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            left: auto;
            z-index: 1000;
            transition: transform var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-header {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--glass-border);
            padding: 0 1.5rem;
            background: linear-gradient(to left, rgba(180, 0, 0, 0.05), rgba(212, 175, 55, 0.05));
        }

        .brand-logo {
            color: var(--gold);
            font-size: 1.4rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-menu {
            padding: 1.5rem 1rem;
            list-style: none;
            flex: 1;
        }

        /* تنسيق عناصر القائمة */
        .menu-item {
            margin-bottom: 0.5rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: all var(--transition-speed);
            font-weight: 500;
            cursor: pointer;
        }

        .menu-link:hover,
        .menu-item.active>.menu-link {
            background-color: var(--admin-hover);
            color: var(--text-main);
        }

        .menu-item.active>.menu-link {
            border-right: 4px solid var(--primary-red);
            border-left: none;
        }

        .menu-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-icon {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .arrow-icon {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        /* القوائم الفرعية (Submenu) */
        .submenu {
            list-style: none;
            padding-right: 2.5rem;
            padding-left: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }

        .menu-item.open .submenu {
            max-height: 500px;
            /* رقم كبير يكفي لعرض القائمة */
            margin-top: 0.5rem;
        }

        .submenu-link {
            display: block;
            padding: 0.6rem 0;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
            position: relative;
        }

        .submenu-link::before {
            content: '';
            position: absolute;
            right: -15px;
            left: auto;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--glass-border);
            transition: 0.3s;
        }

        .submenu-link:hover,
        .submenu-link.active {
            color: var(--gold);
        }

        .submenu-link:hover::before,
        .submenu-link.active::before {
            background-color: var(--gold);
        }

        /* ميزة الكروت الذكية المميزة */
        .smart-card-feature {
            color: var(--gold) !important;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
        }

        .smart-card-feature::before {
            background-color: var(--gold) !important;
            box-shadow: 0 0 8px var(--gold);
        }

        /* الفواصل (Dividers) */
        .menu-divider {
            height: 1px;
            background-color: var(--glass-border);
            margin: 1.5rem 0;
        }

        /* ===================================== */
        /* 3. الهيكل الرئيسي والبار العلوي       */
        /* ===================================== */
        .main-wrapper {
            flex: 1;
            margin-right: var(--sidebar-width);
            margin-left: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin var(--transition-speed) ease;
            width: calc(100% - var(--sidebar-width));
        }

        .topbar {
            height: var(--topbar-height);
            background: rgba(var(--bg-main-rgb), 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-right,
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .toggle-sidebar-btn {
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.4rem;
            cursor: pointer;
            display: none;
            /* مخفي في الديسكتوب */
        }

        .topbar-title {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--admin-accent);
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .theme-switcher-btn {
            background: none;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            font-size: 1.2rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
            border: 1px solid var(--glass-border);
        }

        .theme-switcher-btn:hover {
            background: var(--admin-hover);
        }

        /* ===================================== */
        /* 4. منطقة المحتوى (Content Area)       */
        /* ===================================== */
        .content-area {
            padding: 2rem;
            flex: 1;
        }

        /* ===================================== */
        /* 5. التصميم المتجاوب (Responsive)      */
        /* ===================================== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-right: 0 !important;
                margin-left: 0 !important;
                width: 100%;
            }

            .toggle-sidebar-btn {
                display: block;
            }
        }

        /* خلفية ضبابية عند فتح القائمة في الموبايل */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity var(--transition-speed);
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="brand-logo">
                <i class="fa-solid fa-building-shield" style="color:var(--primary-red);"></i>
                <span>إدارة البرلسي</span>
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item active">
                <a href="#" class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-chart-pie menu-icon"></i>
                        <span>لوحة القيادة</span>
                    </div>
                </a>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-city menu-icon"></i>
                        <span>المشاريع العقارية</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.projects.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.projects.index') ? 'active' : '' }}">
                            جميع المشاريع
                        </a>
                    </li>
                    <li><a href="#" class="submenu-link">الوحدات العقارية</a></li>
                    <li><a href="#" class="submenu-link">القطاعات</a></li>
                    <li><a href="#" class="submenu-link">خطط السداد والدفع</a></li>
                </ul>
            </li>

            <li class="menu-item has-submenu">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-pager menu-icon"></i>
                        <span>إدارة المحتوى (CMS)</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li><a href="#" class="submenu-link">الصفحة الرئيسية</a></li>
                    <li><a href="#" class="submenu-link">واجهة الموقع (Hero)</a></li>
                    <li><a href="#" class="submenu-link">معرض الصور</a></li>
                    <li><a href="#" class="submenu-link">المركز الإعلامي والأخبار</a></li>
                    <li><a href="#" class="submenu-link">عن الشركة والتاريخ</a></li>
                    <li><a href="#" class="submenu-link">فريق العمل</a></li>
                </ul>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-users-gear menu-icon"></i>
                        <span>إدارة العملاء (CRM)</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li><a href="#" class="submenu-link">العملاء المحتملين (Leads)</a></li>
                    <li>
                        <a href="{{ route('admin.clients.index') }}" class="submenu-link">
                            العملاء الفعليين
                        </a>
                    </li>
                    <li><a href="#" class="submenu-link">طلبات التواصل الواردة</a></li>
                    <li><a href="#" class="submenu-link smart-card-feature">الكروت الذكية ✦</a></li>
                </ul>
            </li>

            <div class="menu-divider"></div>

            <li class="menu-item has-submenu">
                <div class="menu-link">
                    <div class="menu-title">
                        <i class="fa-solid fa-gears menu-icon"></i>
                        <span>إدارة النظام</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon"></i>
                </div>
                <ul class="submenu">
                    <li><a href="#" class="submenu-link">المستخدمين، الأدوار والصلاحيات</a></li>
                </ul>
            </li>
        </ul>
    </aside>

    <main class="main-wrapper">

        <header class="topbar">
            <div class="topbar-right">
                <button class="toggle-sidebar-btn" id="toggleSidebar">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h3 class="topbar-title">لوحة التحكم السريعة</h3>
            </div>

            <div class="topbar-left">
                <button id="theme-switcher" class="theme-switcher-btn" title="تبديل المظهر">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>

                <div class="admin-profile">
                    <div class="admin-avatar">مش</div>
                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                        <span style="font-size: 0.9rem; font-weight: 700; color: var(--gold);">مدير النظام</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">فريق التسويق</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // 1. منطق القوائم المنسدلة الذكية (Accordion Menu)
            const menuItems = document.querySelectorAll('.has-submenu');

            menuItems.forEach(item => {
                const link = item.querySelector('.menu-link');
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    // إغلاق أي قائمة أخرى مفتوحة للحفاظ على المظهر المنظم
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('open')) {
                            otherItem.classList.remove('open');
                            otherItem.querySelector('.arrow-icon').style.transform =
                                'rotate(0deg)';
                        }
                    });

                    // تبديل حالة القائمة الحالية
                    item.classList.toggle('open');
                    const arrow = item.querySelector('.arrow-icon');
                    if (item.classList.contains('open')) {
                        arrow.style.transform = 'rotate(180deg)';
                    } else {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            });

            // 2. إدارة فتح وإغلاق القائمة الجانبية على الشاشات الصغيرة (Mobile Responsiveness)
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            toggleBtn?.addEventListener('click', toggleSidebar);
            overlay?.addEventListener('click', toggleSidebar);

            // 3. محول الثيم الذكي (Theme Switcher)
            const themeBtn = document.getElementById('theme-switcher');
            themeBtn?.addEventListener('click', () => {
                // يدعم تبديل الثيم إذا كان مسجلاً في الكود الأساسي للمشروع عبر الـ preference
                if (window.preferences?.toggleTheme) {
                    window.preferences.toggleTheme();
                } else {
                    // حل احتياطي سريع للـ Switcher العادي في حال عدم وجود Preference Object خارجي
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                }
            });
        });
    </script>

</body>

</html>
