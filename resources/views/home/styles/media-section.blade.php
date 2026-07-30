<style>
    /* =========================================
   Theme Variables (Light & Dark)
========================================= */
    :root {
        /* الثيم الفاتح (الافتراضي) */
        --media-bg: #f8f9fa;
        --media-title-color: #333333;
        --media-subtitle-color: #666666;
        --media-card-bg: #ffffff;
        --media-card-border: rgba(0, 0, 0, 0.08);
        --media-card-shadow: rgba(0, 0, 0, 0.05);
        --media-card-shadow-hover: rgba(0, 0, 0, 0.15);
        --media-text-main: #222222;
        --media-text-muted: #777777;
        --media-badge-bg: rgba(255, 255, 255, 0.9);
        --media-badge-text: #b40000;

        --primary-red: #b40000;
        --warm-beige: #d4c5a9;
    }

    [data-theme="dark"] {
        /* الثيم الداكن */
        --media-bg: #121212;
        /* أو var(--black) لو معرف في مكان آخر */
        --media-title-color: var(--warm-beige);
        --media-subtitle-color: #a0a0a0;
        --media-card-bg: rgba(25, 25, 25, 0.8);
        --media-card-border: rgba(255, 255, 255, 0.05);
        --media-card-shadow: rgba(0, 0, 0, 0.2);
        --media-card-shadow-hover: rgba(0, 0, 0, 0.5);
        --media-text-main: #f4f4f4;
        /* أو var(--off-white) */
        --media-text-muted: #a0a0a0;
        /* أو var(--light-gray) */
        --media-badge-bg: rgba(0, 0, 0, 0.75);
        --media-badge-text: var(--warm-beige);
    }

    /* =========================================
   Section Layout & Typography
========================================= */
    .media-section {
        padding: 5rem 5%;
        background-color: var(--media-bg);
        transition: background-color 0.3s ease;
        position: relative;
    }

    .media-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 2.8rem);
        /* يتجاوب مع حجم الشاشة */
        color: var(--media-title-color);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .section-subtitle {
        color: var(--media-subtitle-color);
        font-size: clamp(1rem, 2vw, 1.15rem);
    }

    /* =========================================
   Filters
========================================= */
    .media-filters {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .filter-btn {
        background: transparent;
        border: 1px solid var(--media-card-border);
        color: var(--media-title-color);
        padding: 0.6rem 1.5rem;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
        color: #ffffff;
        box-shadow: 0 0 12px rgba(180, 0, 0, 0.3);
    }

    /* =========================================
   Grid & Cards
========================================= */
    .media-grid-wrapper {
        position: relative;
        min-height: 400px;
    }

    .media-grid {
        display: grid;
        /* التجاوب التلقائي للجريد بدون Media Queries إضافية */
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        transition: all 0.5s ease;
    }

    /* تأثير التركيز للديسكتوب فقط (لمنع مشاكل اللمس في الموبايل) */
    @media (hover: hover) {
        .media-grid:hover .media-card:not(:hover) {
            opacity: 0.5;
            filter: grayscale(40%) blur(1.5px);
        }
    }

    .media-card {
        display: flex;
        flex-direction: column;
        background: var(--media-card-bg);
        border: 1px solid var(--media-card-border);
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        box-shadow: 0 5px 15px var(--media-card-shadow);
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        position: relative;
    }

    .media-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px var(--media-card-shadow-hover);
        border-color: rgba(180, 0, 0, 0.3);
    }

    /* =========================================
   Card Image & Camera Effects
========================================= */
    .card-image-box {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .post-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .media-card:hover .post-img {
        transform: scale(1.08);
    }

    /* Camera Flash */
    .camera-flash {
        position: absolute;
        inset: 0;
        background-color: white;
        opacity: 0;
        z-index: 5;
        pointer-events: none;
    }

    .media-card:hover .camera-flash {
        animation: cinematicFlash 0.6s ease-out;
    }

    @keyframes cinematicFlash {
        0% {
            opacity: 0;
        }

        15% {
            opacity: 0.6;
        }

        100% {
            opacity: 0;
        }
    }

    /* Viewfinders */
    .viewfinder {
        position: absolute;
        width: 25px;
        height: 25px;
        border-color: var(--primary-red);
        border-style: solid;
        z-index: 6;
        opacity: 0;
        transition: all 0.4s ease;
    }

    /* باستخدام اتجاهات ثابتة هنا لأن زوايا الكاميرا متناظرة ولا تحتاج Flip في الـ RTL */
    .viewfinder.top-left {
        top: 15px;
        left: 15px;
        border-width: 3px 0 0 3px;
    }

    .viewfinder.top-right {
        top: 15px;
        right: 15px;
        border-width: 3px 3px 0 0;
    }

    .viewfinder.bottom-left {
        bottom: 15px;
        left: 15px;
        border-width: 0 0 3px 3px;
    }

    .viewfinder.bottom-right {
        bottom: 15px;
        right: 15px;
        border-width: 0 3px 3px 0;
    }

    .media-card:hover .viewfinder {
        opacity: 1;
    }

    .media-card:hover .viewfinder.top-left {
        top: 10px;
        left: 10px;
    }

    .media-card:hover .viewfinder.top-right {
        top: 10px;
        right: 10px;
    }

    .media-card:hover .viewfinder.bottom-left {
        bottom: 10px;
        left: 10px;
    }

    .media-card:hover .viewfinder.bottom-right {
        bottom: 10px;
        right: 10px;
    }

    /* Category Badge باستخدام Logical Properties لتدعم LTR/RTL معاً */
    .category-badge {
        position: absolute;
        inset-block-start: 15px;
        /* يعني Top */
        inset-inline-end: 15px;
        /* يعني Right في الـ LTR، و Left في الـ RTL */
        background: var(--media-badge-bg);
        color: var(--media-badge-text);
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: bold;
        border-radius: 4px;
        backdrop-filter: blur(5px);
        z-index: 10;
        transition: all 0.3s ease;
    }

    /* =========================================
   Card Content
========================================= */
    .card-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .post-meta {
        color: var(--media-text-muted);
        font-size: 0.85rem;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .post-title {
        color: var(--media-text-main);
        font-size: 1.25rem;
        margin-bottom: 0.8rem;
        line-height: 1.5;
        transition: color 0.3s;
    }

    .media-card:hover .post-title {
        color: var(--primary-red);
    }

    [data-theme="dark"] .media-card:hover .post-title {
        color: var(--warm-beige);
        /* في الدارك مود الألوان الدافئة أفضل للعين */
    }

    .post-desc {
        color: var(--media-text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }

    .read-more {
        color: var(--primary-red);
        font-weight: bold;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
        /* سيتم عكسه برمجياً للمسافات بفضل الـ flex */
        transition: gap 0.3s ease;
    }

    .media-card:hover .read-more {
        gap: 12px;
    }

    /* عكس السهم في اللغة العربية بناءً على الاتجاه العام للمستند */
    html[dir="rtl"] .rtl-flip {
        transform: scaleX(-1);
    }

    /* =========================================
   Loader
========================================= */
    .media-loader-overlay {
        position: absolute;
        inset: 0;
        background: rgba(var(--media-bg-rgb, 0, 0, 0), 0.7);
        /* يتكيف مع الخلفية */
        backdrop-filter: blur(5px);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    [data-theme="light"] .media-loader-overlay {
        background: rgba(255, 255, 255, 0.7);
    }

    [data-theme="dark"] .media-loader-overlay {
        background: rgba(0, 0, 0, 0.7);
    }

    /* =========================================
   Responsive Adjustments (Mobiles)
========================================= */
    @media (max-width: 768px) {
        .media-section {
            padding: 3rem 1rem;
        }

        .media-grid {
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .card-image-box {
            height: 180px;
        }

        .card-content {
            padding: 1.2rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
    }
</style>
