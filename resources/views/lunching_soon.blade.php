<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Hijabk Hena | قريبًا الإطلاق</title>

    <!-- SEO Meta -->
    <meta name="description"
        content="اكتشفي أحدث صيحات الحجاب والملابس الأنيقة والقماش الفاخر مع Hijabk Hena. متجر إلكتروني يقدم أفكار استايل مميزة لكل يوم.">
    <meta name="keywords"
        content="حجاب, هدوم, استايل, أزياء, ملابس محتشمة, كشمير, قماش فاخر, متجر إلكتروني, Hijabk Hena, موضة الحجاب">
    <meta name="author" content="Hijabk Hena">

    <!-- Open Graph -->
    <meta property="og:title" content="Hijabk Hena | حجاب وهدوم شيك وأنيق">
    <meta property="og:description"
        content="متجر إلكتروني يقدم أجمل تصاميم الحجاب والملابس المحتشمة بأحدث صيحات الاستايل.">
    <meta property="og:image"
        content="https://res.cloudinary.com/dofxvqq2w/image/upload/v1764089794/Screenshot_20251125_175737_Chrome_kenx49.jpg">
    <meta property="og:url" content="https://hijabk-hena.com">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Hijabk Hena | حجاب وهدوم شيك وأنيق">
    <meta name="twitter:description"
        content="متجر إلكتروني يقدم أجمل تصاميم الحجاب والملابس المحتشمة بأحدث صيحات الاستايل.">
    <meta name="twitter:image"
        content="https://res.cloudinary.com/dofxvqq2w/image/upload/v1764089794/Screenshot_20251125_175737_Chrome_kenx49.jpg">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --color-bg-light: #fff6ee;
            --color-primary-dark: #d7a7a4;
            --color-text-header: #9c7b74;
            --color-accent-decor: #624641;
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--color-bg-light);
            color: var(--color-primary-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Main container */
        .container {
            width: 100%;
            max-width: 500px;

            text-align: center;
            animation: appear 1s ease-out forwards;
        }

        .brand-logo {
            width: 200px;
            /* أكبر من قبل */
            height: 200px;
            /* يخليها دايرة متكاملة */
            border-radius: 50%;
            /* دايرة */
            object-fit: cover;
            /* لا يقص من الصورة */
            display: block;
            margin: 0 auto 10px auto;
            /* مركّز بالمنتصف */
            filter: none;
            /* إزالة أي ظل */
        }


        h1 {
            font-size: 2.2em;
            font-weight: 700;
        }

        .brand-header p {
            color: var(--color-primary-dark);
            opacity: 0.8;
        }

        /* Launch Section */
        .launch-message {
            color: #1a4139;
            margin: 25px 0;
        }

        .launch-message h2 {
            font-size: 1.8em;
        }

        /* Buttons */
        .social-links {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 30px;
        }

        .link-item {
            display: flex;
            justify-content: center;
            align-items: center;

            background: var(--color-accent-decor);

            padding: 12px;
            /* ↓↓ تقليل الطول (الارتفاع) ↓↓ */
            width: 100%;
            /* ياخد عرض الـcontainer بس */
            max-width: 380px;
            /* مايبقاش عريض قوي على الديسكتوب */
            margin: 0 auto;
            /* تظبيط للنص */

            border-radius: 14px;

            color: var(--color-bg-light);
            font-size: 1.1em;
            /* حجم خط أصغر شوية */
            font-weight: 600;
            text-decoration: none;

            opacity: 0;

            animation-name: appear, breathing;
            animation-duration: 0.8s, 4s;
            animation-delay: var(--delay), 1s;
            animation-timing-function: ease-out, ease-in-out;
            animation-fill-mode: forwards;
            animation-iteration-count: 1, infinite;
        }


        .link-item i {
            margin-left: 12px;
            font-size: 1.4em;
        }

        .link-item:hover {
            transform: scale(1.04);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.18);
        }

        /* Appear Animation */
        @keyframes appear {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            60% {
                opacity: 1;
                transform: translateY(-10px) scale(1.02);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Breathing Animation */
        @keyframes breathing {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Logo Pulse */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.06);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Background decorations */
        .decor {
            position: fixed;
            width: 180px;
            height: 180px;
            background: var(--color-accent-decor);
            opacity: 0.08;
            border-radius: 50%;
            animation: rotate 28s linear infinite, breathing 5s infinite ease-in-out;
            z-index: -1;
        }

        .decor1 {
            top: -60px;
            left: -60px;
        }



        .decor2 {
            bottom: -70px;
            right: -70px;
            animation: rotateReverse 28s linear infinite, breathing 5s infinite ease-in-out;
            animation-delay: 1.5s;
        }

        @keyframes rotateReverse {
            to {
                transform: rotate(-360deg);
            }
        }

        @keyframes rotate {
            to {
                transform: rotate(360deg);
            }
        }


        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
                /* بادنج يمين وشمال */
            }

            .link-item {
                max-width: 100%;
                /* على الموبايل ياخد عرض الـcontainer كله */
                padding: 12px;
                font-size: 1em;
            }
        }

        /* زر Get Start */
        .get-start-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #1a4139;
            color: #fff;
            font-weight: 700;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1em;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .get-start-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>

    <div class="decor decor1"></div>
    <div class="decor decor2"></div>
    <!-- زر Get Start -->
    <a href="{{ route('home.create') }}" class="get-start-btn">Get Start</a>

    <div class="container">
        <header class="brand-header">
            <img src="https://res.cloudinary.com/dofxvqq2w/image/upload/v1764089794/Screenshot_20251125_175737_Chrome_kenx49.jpg"
                class="brand-logo"
                alt="Hijabk Hena - حجاب شيك جميع الخامات والاستايلات ودرجات الالوان الي تحبيها من قماش فاخر">

            <h1>Hijabk Hena</h1>
            <p>CHIC & MODEST</p>
        </header>

        <section class="launch-message">
            <h2>🎉 Launching Soon! 🎉</h2>

            <p>We’re crafting something special to make your daily style easier, smarter, and truly effortless.</p>
        </section>

        <nav class="social-links">
            <a href="https://www.instagram.com/hijabk_hena" target="_blank" class="link-item" style="--delay:0.2s"
                title="تابعنا على إنستجرام لاكتشاف أحدث تصاميم الحجاب والملابس">
                <i class="fab fa-instagram"></i> Instagram
            </a>
            <a href="https://www.facebook.com/share/1S51MWNXd7/" target="_blank" class="link-item" style="--delay:0.3s"
                title="تابعنا على فيسبوك لأحدث تحديثات الموضة">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            <a href="#" class="link-item" style="--delay:0.4s"
                title="تابعنا على تيك توك لمقاطع استايل قصيرة ومميزة">
                <i class="fab fa-tiktok"></i> TikTok
            </a>
            <a href="https://wa.me/201094619040" target="_blank" class="link-item" style="--delay:0.1s"
                title="تواصل معنا مباشرة عبر واتساب لطلب الملابس والاستفسار">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </nav>

    </div>

</body>

</html>
