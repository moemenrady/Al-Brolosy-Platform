<style>
    /* ==========================================
   Join Our Team Section
   ========================================== */
    .join-team-section {
        position: relative;
        width: 100%;
        height: 85vh;
        /* ارتفاع مناسب يبرز الفخامة */
        min-height: 600px;
        background-color: var(--black);
        overflow: hidden;
    }

    .team-carousel-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    /* السلايدر والصور */
    .team-slider {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .team-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
        z-index: 1;
    }

    .team-slide.active {
        opacity: 1;
        z-index: 2;
    }

    .team-slide-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1);
        transition: transform 6s linear;
        /* حركة زووم بطيئة جداً (Ken Burns) */
    }

    .team-slide.active .team-slide-img {
        transform: scale(1.08);
    }

    /* طبقة التعتيم لجعل النص مقروء ولإضافة الفخامة */
    .team-dark-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom,
                rgba(0, 0, 0, 0.4) 0%,
                rgba(0, 0, 0, 0.7) 50%,
                rgba(0, 0, 0, 0.9) 100%);
        z-index: 3;
    }

    /* محتوى النصوص */
    .team-content-wrapper {
        position: relative;
        z-index: 4;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 0 5%;
    }

    .team-text-content {
        max-width: 800px;
        margin-top: auto;
        margin-bottom: auto;
    }

    .team-title {
        color: var(--warm-beige);
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .team-description {
        color: var(--off-white);
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    /* زر التصفح (متناسق مع الـ Hero) */
    .btn-browse-jobs {
        display: inline-block;
        border: 1px solid var(--primary-red);
        background-color: transparent;
        color: var(--warm-beige);
        padding: 0.8rem 2.5rem;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.4s ease;
        cursor: pointer;
    }

    .btn-browse-jobs:hover {
        background-color: var(--primary-red);
        color: var(--off-white);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(180, 0, 0, 0.2);
    }

    /* نقاط التحكم (Dots) */
    .team-slider-dots {
        display: flex;
        gap: 12px;
        margin-bottom: 3rem;
    }

    .team-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--light-gray);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .team-dot:hover {
        background-color: var(--warm-beige);
    }

    .team-dot.active {
        background-color: var(--primary-red);
        transform: scale(1.3);
    }

    /* استجابة الشاشات الصغيرة (Mobile) */
    @media (max-width: 768px) {
        .team-title {
            font-size: 2rem;
        }

        .team-description {
            font-size: 0.95rem;
            padding: 0 10px;
        }

        .btn-browse-jobs {
            padding: 0.7rem 2rem;
            font-size: 1rem;
        }

        .join-team-section {
            height: 70vh;
            min-height: 500px;
        }
    }
</style>
