<style>
    /* ===================================== */
    /* 1. إعدادات المتغيرات والثيمات         */
    /* ===================================== */
    :root {
        --primary-red: #B40000;
        --black: #000000;
        --light-gray: #76767A;
        --dark-gray: #696969;
        --warm-beige: #E4DCC7;
        --cream-beige: #E6E0D0;
        --off-white: #F0F0F0;
    }

    /* ================================================= */
    /* تنسيقات سيكشن المشروع الفاخر (Focused Project)      */
    /* ================================================= */
    .focused-project-section {
        position: relative;
        width: 100%;
        min-height: 100vh;
        padding: 8rem 5% 6rem 5%;
        background-color: var(--bg-main);
        color: var(--text-main);
        overflow: hidden;
        display: flex;
        align-items: center;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    /* خلفية الفيديو الفاخرة المدمجة */
    .project-video-bg-wrapper {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .project-video-bg-wrapper video {
        opacity: 1;

    }

    /* طبقة تعتيم وتدرج لوني سينمائي يتداخل مع الأقسام السابقة والتالية */
    .project-video-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, var(--bg-main) 0%, transparent 30%, transparent 70%, var(--bg-main) 100%),
            linear-gradient(to right, rgba(0, 0, 0, 0.4) 0%, transparent 100%);
        z-index: 2;
    }

    /* حاوية المحتوى الرئيسية */
    .project-luxury-container {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* الهيدر الفخم المضيء للمشروع */
    .project-glamour-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 2.5rem;
        margin-bottom: 3.5rem;
    }

    .project-badge-premium {
        color: var(--primary-red);
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 4px;
        display: block;
        margin-bottom: 0.75rem;
    }

    .project-huge-title {
        font-size: 3.8rem;
        font-weight: 300;
        letter-spacing: 2px;
        color: var(--cream-beige);
        line-height: 1.1;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    html[data-theme="light"] .project-huge-title {
        color: var(--black);
        font-weight: 400;
    }

    /* إعدادات الموقع الجغرافي */
    .project-geo-location {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .geo-icon {
        width: 18px;
        height: 18px;
        stroke: var(--primary-red);
    }

    .geo-coords {
        font-family: 'Courier New', Courier, monospace;
        background: rgba(0, 0, 0, 0.1);
        color: #000;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-left: 0.5rem;
    }

    html[dir="rtl"] .geo-coords {
        margin-left: 0;
        margin-right: 0.5rem;
    }

    /* ختم الشعار البرولسي الفخم والوهج الدائري خلفه */
    .project-brand-stamp {
        position: relative;
        width: 110px;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stamp-img {
        max-width: 100%;
        height: auto;
        z-index: 5;
        filter: drop-shadow(0 0 10px rgba(228, 220, 199, 0.2));
    }

    .stamp-glow {
        position: absolute;
        width: 90px;
        height: 90px;
        background: var(--warm-beige);
        opacity: 0.1;
        filter: blur(25px);
        border-radius: 50%;
        z-index: 1;
    }

    /* تصميم الجريد الرئيسي */
    .project-main-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 4rem;
        align-items: start;
    }

    @media (min-width: 1024px) {
        .project-main-grid {
            grid-template-columns: 1.1fr 0.9fr;
        }
    }

    /* عمود السرد والوصف */
    .project-description-text {
        font-size: 1.25rem;
        line-height: 1.8;
        color: var(--text-main);
        opacity: 0.9;
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    /* كروت المؤشرات السريعة الفاخرة */
    .project-quick-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .metric-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        padding: 1.2rem;
        border-radius: 6px;
        backdrop-filter: blur(5px);
        transition: transform 0.3s;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary-red);
    }

    .metric-card small {
        display: block;
        color: var(--text-muted);
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
    }

    .metric-card strong {
        font-size: 1.15rem;
        color: var(--warm-beige);
        font-weight: 500;
    }

    html[data-theme="light"] .metric-card strong {
        color: var(--black);
    }

    .text-highlight {
        color: var(--primary-red) !important;
        font-weight: bold !important;
    }

    /* لوحة الاستثمار وخطط السداد */
    .luxury-payment-panel {
        background: linear-gradient(135deg, rgba(180, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0) 100%);
        border-left: 3px solid var(--primary-red);
        padding: 2rem;
        border-radius: 0 8px 8px 0;
    }

    html[dir="rtl"] .luxury-payment-panel {
        border-left: none;
        border-right: 3px solid var(--primary-red);
        border-radius: 8px 0 0 8px;
    }

    .panel-inside-title {
        font-size: 1.2rem;
        color: var(--cream-beige);
        margin-bottom: 1.5rem;
        font-weight: 400;
    }

    html[data-theme="light"] .panel-inside-title {
        color: var(--black);
    }

    .payment-metrics-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .pay-item span {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
    }

    .pay-item p {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
    }

    /* عمود التبويبات التفاعلي الزجاجي (لوحة الوحدات) */
    .project-interactive-specs-panel {
        background: rgba(20, 20, 22, 0.6);
        border: 1px solid rgba(228, 220, 199, 0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 12px;
        padding: 2.2rem;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
    }

    html[data-theme="light"] .project-interactive-specs-panel {
        background: rgba(255, 255, 255, 0.8);
        border-color: rgba(0, 0, 0, 0.08);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }

    /* التبويبات الفاخرة */
    .specs-tabs-header {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .spec-tab-trigger {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-size: 0.85rem;
        padding: 0.6rem 0.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        text-align: center;
    }

    .spec-tab-trigger.active {
        color: var(--primary-red);
        position: relative;
        font-weight: bold;
    }

    .spec-tab-trigger.active::after {
        content: '';
        position: absolute;
        bottom: -17px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary-red);
    }

    /* خطوط تفاصيل الوحدات */
    .tab-pane-luxury {
        display: flex;
        flex-direction: column;
    }

    .spec-feature-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.1rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    html[data-theme="light"] .spec-feature-line {
        border-bottom-color: rgba(0, 0, 0, 0.05);
    }

    .border-none {
        border-bottom: none !important;
    }

    .spec-feature-line span {
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .spec-feature-line strong {
        font-size: 1.05rem;
        color: var(--text-main);
        font-weight: 500;
    }

    .total-badge {
        background: rgba(180, 0, 0, 0.12);
        color: var(--primary-red) !important;
        padding: 0.4rem 1rem;
        border-radius: 4px;
        font-weight: bold !important;
        font-size: 1.1rem !important;
    }

    /* أزرار الإجراءات داخل اللوحة */
    .specs-panel-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-top: 2.5rem;
    }

    @media (min-width: 480px) {
        .specs-panel-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .btn-luxury-primary,
    .btn-luxury-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 1rem 1.5rem;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .btn-luxury-primary {
        background: var(--primary-red);
        color: #ffffff;
        border: 1px solid var(--primary-red);
    }

    .btn-luxury-primary:hover {
        background: #900000;
        border-color: #900000;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(180, 0, 0, 0.3);
    }

    .btn-luxury-secondary {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .btn-luxury-secondary:hover {
        background: rgba(255, 255, 255, 0.03);
        border-color: var(--primary-red);
        color: var(--primary-red);
        transform: translateY(-2px);
    }

    html[data-theme="light"] .btn-luxury-secondary:hover {
        background: rgba(0, 0, 0, 0.02);
    }

    /* حركة تباين الأنيميشن الناعم لـ Alpine JS */
    @keyframes pane-fade-in {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pane-fade-in {
        animation: pane-fade-in 0.4s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    /* ================================================= */
    /* الموبايل والـ Responsiveness وإصلاح الـ Layouts    */
    /* ================================================= */
    @media (max-width: 1023px) {
        .focused-project-section {
            padding-top: 6rem;
        }

        .project-glamour-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 2rem;
        }

        .project-brand-stamp {
            width: 80px;
            height: 80px;
            align-self: flex-start;
        }

        .project-huge-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 640px) {
        .project-huge-title {
            font-size: 2.1rem;
        }

        .specs-tabs-header {
            grid-template-columns: 1fr;
            gap: 0.2rem;
        }

        .spec-tab-trigger.active::after {
            display: none;
            /* إخفاء الخط السفلي لعدم ملاءمته لتصميم الأسطر الرأسية */
        }

        .spec-tab-trigger {
            text-align: start;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .spec-tab-trigger.active {
            background: rgba(180, 0, 0, 0.08);
            padding-left: 1.2rem;
        }

        html[dir="rtl"] .spec-tab-trigger.active {
            padding-left: 1rem;
            padding-right: 1.2rem;
        }

        .spec-feature-line {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.4rem;
        }

        .spec-feature-line strong {
            align-self: flex-end;
        }
    }
</style>

<style>
    /* ================================================= */
    /* 1. إعدادات السيكشن والخلفية الديناميكية           */
    /* ================================================= */
    .focused-project-section {
        position: relative;
        width: 100%;
        min-height: 100vh;
        padding: 7rem 5% 5rem 5%;
        background-color: var(--bg-main, #0b0c0e);
        color: var(--text-main, #ffffff);
        overflow: hidden;
        display: flex;
        align-items: center;
        transition: background-color 0.4s ease, color 0.4s ease;
    }

    /* حاوية الفيديو */
    .project-video-bg-wrapper {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .project-hero-video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        transform: translate(-50%, -50%);
        object-fit: cover;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }

    .project-hero-video.video-ready {
        opacity: 1;
    }

    .project-hero-video.video-inactive {
        display: none !important;
    }

    /* طبقة تعتيم عالية التباين تضمن وضوح القراءة فوق الفيديو */
    .project-video-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(10, 11, 14, 0.75) 0%, rgba(10, 11, 14, 0.45) 50%, rgba(10, 11, 14, 0.85) 100%),
            radial-gradient(circle at center, transparent 20%, rgba(0, 0, 0, 0.6) 100%);
        z-index: 2;
    }

    html[data-theme="light"] .project-video-overlay {
        background: #ffffff00
    }

    .project-luxury-container {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 1380px;
        margin: 0 auto;
    }

    /* ================================================= */
    /* 2. الهيدر والعناوين                              */
    /* ================================================= */
    .project-glamour-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-bottom: 1px solid rgba(228, 220, 199, 0.15);
        padding-bottom: 2rem;
        margin-bottom: 3rem;
    }

    html[data-theme="light"] .project-glamour-header {
        border-bottom-color: rgba(0, 0, 0, 0.12);
    }

    .project-badge-premium {
        color: var(--primary-red, #B40000);
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 3px;
        display: block;
        margin-bottom: 0.5rem;
    }

    .project-huge-title {
        font-size: 3.5rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #ffffff;
        line-height: 1.1;
        margin-bottom: 0.8rem;
        text-transform: uppercase;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
    }

    html[data-theme="light"] .project-huge-title {
        color: #111111;
        text-shadow: 0 2px 8px rgba(255, 255, 255, 0.8);
    }

    .project-geo-location {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.6rem;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
        font-weight: 500;
    }

    html[data-theme="light"] .project-geo-location {
        color: #333333;
    }

    .geo-coords {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;

        font-family: 'Inter', 'Segoe UI', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.5px;

        /* Light Mode */
        color: #242424;

        padding: 0.45rem 0.85rem;
        border-radius: 8px;

        background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.96),
                rgba(235, 232, 224, 0.82));

        border: 1px solid rgba(180, 0, 0, 0.18);

        box-shadow:
            0 4px 14px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.95);

        overflow: hidden;

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            border-color 0.3s ease,
            background 0.3s ease,
            color 0.3s ease;
    }


    /* ================================================= */
    /* DARK MODE */
    /* ================================================= */

    html[data-theme="dark"] .geo-coords {
        color: #ffffff;

        background: linear-gradient(135deg,
                #111111 0%,
                #050505 55%,
                #151515 100%);

        border: 1px solid rgba(255, 255, 255, 0.12);

        box-shadow:
            0 6px 18px rgba(0, 0, 0, 0.45),
            inset 0 1px 0 rgba(255, 255, 255, 0.07);
    }


    /* ================================================= */
    /* اللمعة */
    /* ================================================= */

    .geo-coords::before {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;

        width: 65%;
        height: 100%;

        background: linear-gradient(100deg,
                transparent 0%,
                rgba(255, 255, 255, 0.55) 50%,
                transparent 100%);

        transform: skewX(-20deg);
        transition: left 0.7s ease;

        pointer-events: none;
    }

    .geo-coords:hover::before {
        left: 140%;
    }


    /* ================================================= */
    /* LIGHT HOVER */
    /* ================================================= */

    html[data-theme="light"] .geo-coords:hover {
        transform: translateY(-1px);

        border-color: rgba(180, 0, 0, 0.35);

        box-shadow:
            0 7px 20px rgba(0, 0, 0, 0.12),
            0 0 18px rgba(180, 0, 0, 0.08),
            inset 0 1px 0 #ffffff;
    }


    /* ================================================= */
    /* DARK HOVER */
    /* ================================================= */

    html[data-theme="dark"] .geo-coords:hover {
        transform: translateY(-1px);

        border-color: rgba(255, 255, 255, 0.22);

        box-shadow:
            0 8px 24px rgba(0, 0, 0, 0.55),
            0 0 18px rgba(255, 255, 255, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.10);
    }


    /* ================================================= */
    /* LOCATION ICON */
    /* ================================================= */

    .geo-icon {
        width: 18px;
        height: 18px;

        stroke: var(--primary-red, #B40000);
        stroke-width: 1.8;

        filter: drop-shadow(0 0 4px rgba(180, 0, 0, 0.18));

        transition:
            transform 0.3s ease,
            filter 0.3s ease;
    }

    .geo-coords:hover .geo-icon {
        transform: scale(1.08);

        filter: drop-shadow(0 0 6px rgba(180, 0, 0, 0.28));
    }

    .project-brand-stamp {
        position: relative;
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stamp-img {
        max-width: 100%;
        height: auto;
        z-index: 5;
        filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.3));
    }

    /* ================================================= */
    /* 3. البطاقات والتباين لسهولة القراءة                */
    /* ================================================= */
    .project-main-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2.5rem;
        align-items: start;
    }

    @media (min-width: 1024px) {
        .project-main-grid {
            grid-template-columns: 1.1fr 0.9fr;
        }
    }

    /* حاوية النص الرئيسي بخلفية زجاجية عالية التباين */
    .narrative-card-wrapper {
        background: rgba(15, 17, 21, 0.82);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    html[data-theme="light"] .narrative-card-wrapper {
        background: rgba(255, 255, 255, 0.88);
        border-color: rgba(0, 0, 0, 0.08);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
    }

    .project-description-text {
        font-size: 1.15rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.92);
        margin-bottom: 2rem;
        font-weight: 400;
    }

    html[data-theme="light"] .project-description-text {
        color: #1f2937;
    }

    /* كروت المؤشرات السريعة */
    .project-quick-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 8px;
        transition: transform 0.25s, border-color 0.25s;
    }

    html[data-theme="light"] .metric-card {
        background: rgba(0, 0, 0, 0.03);
        border-color: rgba(0, 0, 0, 0.08);
    }

    .metric-card:hover {
        transform: translateY(-3px);
        border-color: var(--primary-red, #B40000);
    }

    .metric-card small {
        display: block;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.78rem;
        text-transform: uppercase;
        margin-bottom: 0.4rem;
    }

    html[data-theme="light"] .metric-card small {
        color: #6b7280;
    }

    .metric-card strong {
        font-size: 1.1rem;
        color: #ffffff;
        font-weight: 600;
    }

    html[data-theme="light"] .metric-card strong {
        color: #111827;
    }

    .text-highlight {
        color: var(--primary-red, #B40000) !important;
        font-weight: 700 !important;
    }

    /* لوحة خطط السداد */
    .luxury-payment-panel {
        background: rgba(180, 0, 0, 0.08);
        border-right: 4px solid var(--primary-red, #B40000);
        padding: 1.5rem;
        border-radius: 8px 0 0 8px;
    }

    html[dir="ltr"] .luxury-payment-panel {
        border-right: none;
        border-left: 4px solid var(--primary-red, #B40000);
        border-radius: 0 8px 8px 0;
    }

    .panel-inside-title {
        font-size: 1.1rem;
        color: #ffffff;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    html[data-theme="light"] .panel-inside-title {
        color: #111827;
    }

    .payment-metrics-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .pay-item span {
        display: block;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.65);
        margin-bottom: 0.2rem;
    }

    html[data-theme="light"] .pay-item span {
        color: #4b5563;
    }

    .pay-item p {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-main, #ffffff);
    }

    html[data-theme="light"] .pay-item p {
        color: #111827;
    }

    /* ================================================= */
    /* 4. لوحة التبويبات والمواصفات التفاعلية             */
    /* ================================================= */
    .project-interactive-specs-panel {
        background: rgba(15, 17, 21, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    }

    html[data-theme="light"] .project-interactive-specs-panel {
        background: rgba(255, 255, 255, 0.92);
        border-color: rgba(0, 0, 0, 0.08);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .specs-tabs-header {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    html[data-theme="light"] .specs-tabs-header {
        border-bottom-color: rgba(0, 0, 0, 0.08);
    }

    .spec-tab-trigger {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.88rem;
        padding: 0.6rem 0.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        text-align: center;
    }

    html[data-theme="light"] .spec-tab-trigger {
        color: #6b7280;
    }

    .spec-tab-trigger.active {
        color: var(--primary-red, #B40000);
        position: relative;
        font-weight: 700;
    }

    .spec-tab-trigger.active::after {
        content: '';
        position: absolute;
        bottom: -17px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: var(--primary-red, #B40000);
        border-radius: 2px;
    }

    .spec-feature-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    html[data-theme="light"] .spec-feature-line {
        border-bottom-color: rgba(0, 0, 0, 0.06);
    }

    .border-none {
        border-bottom: none !important;
    }

    .spec-feature-line span {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.65);
    }

    html[data-theme="light"] .spec-feature-line span {
        color: #4b5563;
    }

    .spec-feature-line strong {
        font-size: 1rem;
        color: #ffffff;
        font-weight: 600;
    }

    html[data-theme="light"] .spec-feature-line strong {
        color: #111827;
    }

    .total-badge {
        background: rgba(180, 0, 0, 0.15);
        color: var(--primary-red, #B40000) !important;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 700 !important;
        font-size: 1.05rem !important;
    }

    /* الأزرار داخل اللوحة */
    .specs-panel-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-top: 2rem;
    }

    @media (min-width: 480px) {
        .specs-panel-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .btn-luxury-primary,
    .btn-luxury-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.9rem 1.2rem;
        border-radius: 8px;
        font-size: 0.92rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-luxury-primary {
        background: var(--primary-red, #B40000);
        color: #ffffff !important;
        border: 1px solid var(--primary-red, #B40000);
    }

    .btn-luxury-primary:hover {
        background: #900000;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(180, 0, 0, 0.35);
    }

    .btn-luxury-secondary {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    html[data-theme="light"] .btn-luxury-secondary {
        border-color: rgba(0, 0, 0, 0.2);
        color: #111827;
    }

    .btn-luxury-secondary:hover {
        border-color: var(--primary-red, #B40000);
        color: var(--primary-red, #B40000);
        transform: translateY(-2px);
    }

    /* حركات التبديل */
    @keyframes pane-fade-in {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pane-fade-in {
        animation: pane-fade-in 0.35s ease-out forwards;
    }

    /* ================================================= */
    /* 5. التجاوب الشامل مع الهواتف للشاشات المختلفة     */
    /* ================================================= */
    @media (max-width: 1023px) {
        .focused-project-section {
            padding-top: 5.5rem;
        }

        .project-glamour-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }

        .project-brand-stamp {
            width: 75px;
            height: 75px;
        }

        .project-huge-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 640px) {
        .project-huge-title {
            font-size: 2rem;
        }

        .specs-tabs-header {
            grid-template-columns: 1fr;
            gap: 0.3rem;
        }

        .spec-tab-trigger.active::after {
            display: none;
        }

        .spec-tab-trigger {
            text-align: start;
            padding: 0.6rem 0.8rem;
            border-radius: 6px;
        }

        .spec-tab-trigger.active {
            background: rgba(180, 0, 0, 0.12);
        }

        .spec-feature-line {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.3rem;
        }

        .spec-feature-line strong {
            align-self: flex-end;
        }
    }
</style>
