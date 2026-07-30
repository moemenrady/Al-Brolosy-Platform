<style>
    /* =========================================
   Visionaries Section (About Us)
   ========================================= */
    .visionaries-section {
        padding: 8rem 5%;
        background-color: var(--black);
        /* يتغير حسب الـ theme */
        color: var(--off-white);
        position: relative;
        overflow: hidden;
    }

    /* دعم الـ Light Theme إذا تم تفعيله بتغيير المتغيرات */
    html[data-theme="light"] .visionaries-section {
        background-color: var(--off-white);
        color: var(--black);
    }

    .visionaries-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--off-white);
        margin-bottom: 1rem;
    }

    html[data-theme="light"] .section-title {
        color: var(--black);
    }

    .title-line {
        width: 60px;
        height: 3px;
        background-color: var(--primary-red);
        margin: 0 auto;
        border-radius: 2px;
    }

    /* Grid Layout */
    .visionaries-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
    }

    @media (min-width: 992px) {
        .visionaries-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 4rem;
        }
    }

    /* Card Styling */
    .visionary-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        height: 550px;
        /* ارتفاع ثابت لضمان عدم اهتزاز الصفحة */
        background-color: #111;
        /* لون خلفية الكرت داكن */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        cursor: default;
        /* لعدم الإيحاء بأنه زر مالم يكن هناك رابط */
        transition: box-shadow 0.5s ease;
    }

    html[data-theme="light"] .visionary-card {
        background-color: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    /* Image Handling */
    .v-image-wrapper {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .v-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        transition: transform 1.2s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.8s ease, filter 0.8s ease;
    }

    .v-gradient-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0) 100%);
        transition: opacity 0.8s ease;
    }

    html[data-theme="light"] .v-gradient-overlay {
        background: linear-gradient(to top, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.5) 40%, rgba(255, 255, 255, 0) 100%);
    }

    /* Content Area */
    .v-content {
        position: absolute;
        inset: 0;
        z-index: 2;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        /* المحتوى بالأسفل في الوضع العادي */
    }

    .v-intro {
        transform: translateY(0);
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .v-name {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-red);
        margin-bottom: 0.5rem;
    }

    .v-title {
        font-size: 1.1rem;
        color: var(--off-white);
        font-weight: 500;
    }

    html[data-theme="light"] .v-title {
        color: var(--dark-gray);
    }

    /* Details Text Area (Hidden by default) */
    .v-details {
        height: 0;
        opacity: 0;
        visibility: hidden;
        overflow: hidden;
        transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .v-details-inner {
        padding-top: 1.5rem;
    }

    .v-details p {
        font-size: 0.95rem;
        line-height: 1.8;
        color: var(--warm-beige);
        margin-bottom: 1rem;
        text-align: justify;

        /* تجهيز حركة الظهور الاحترافية (تأثير الكتابة/الصعود) */
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    html[data-theme="light"] .v-details p {
        color: #444;
        /* لون مريح للقراءة في الوضع الفاتح */
    }

    /* =========================================
   Hover Effects (The Magic)
   ========================================= */

    /* 1. تأثير الصورة عند الهوفر */
    .visionary-card:hover .v-img {
        transform: scale(1.1);
        /* زووم بسيط */
        opacity: 0.05;
        /* إخفاء الصورة لتصبح مجرد طيف بالخلفية */
        filter: grayscale(100%) blur(5px);
    }

    html[data-theme="light"] .visionary-card:hover .v-img {
        opacity: 0.08;
    }

    /* 2. تحريك العنوان للأعلى */
    .visionary-card:hover .v-intro {
        transform: translateY(-20px);
    }

    /* 3. إظهار مساحة النص */
    .visionary-card:hover .v-details {
        height: 380px;
        /* مساحة كافية للنص */
        opacity: 1;
        visibility: visible;
    }

    /* 4. ظهور النص تدريجياً (الفقرات) - السلاسة والسرعة المريحة */
    .visionary-card:hover .v-details p {
        opacity: 1;
        transform: translateY(0);
    }

    /* تأخير الفقرات لتعطي إحساساً بالقراءة/الكتابة المتتالية */
    .visionary-card:hover .v-details p:nth-child(1) {
        transition-delay: 0.2s;
    }

    .visionary-card:hover .v-details p:nth-child(2) {
        transition-delay: 0.4s;
    }

    /* =========================================
   Mobile Optimization
   ========================================= */
    @media (max-width: 768px) {
        .visionary-card {
            height: auto;
            min-height: 450px;
        }

        .v-content {
            padding: 1.5rem;
        }

        .visionary-card:hover .v-details {
            height: auto;
            /* السماح بالتمدد في الموبايل */
            padding-bottom: 1rem;
        }

        .v-name {
            font-size: 1.6rem;
        }
    }
    /* =========================================
   Al-Brolosy Company Legacy Section
   ========================================= */
.company-legacy-section {
    position: relative;
    padding: 8rem 5%;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: var(--text-main, #F0F0F0);
}

/* Video Background & Dark Filter */
.video-bg-wrapper {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.legacy-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.video-dark-filter {
    position: absolute;
    inset: 0;
    /* فلتر داكن فخم مع تدرج لوني لدمجه مع باقي الصفحة */
    background: linear-gradient(
        to bottom, 
        rgba(0, 0, 0, 0.9) 0%, 
        rgba(13, 13, 15, 0.75) 50%, 
        rgba(0, 0, 0, 0.95) 100%
    );
    backdrop-filter: blur(3px); /* تمويه خفيف لزيادة الفخامة والتركيز على النص */
}

/* Content Container */
.legacy-content-container {
    position: relative;
    z-index: 10;
    max-width: 1300px;
    margin: 0 auto;
    width: 100%;
}

/* Header */
.legacy-header {
    text-align: center;
    margin-bottom: 5rem;
}

.legacy-title {
    font-size: 3rem;
    font-weight: 800;
    color: var(--warm-beige, #E4DCC7);
    margin-bottom: 1rem;
    letter-spacing: 1px;
}

.legacy-subtitle {
    font-size: 1.2rem;
    color: var(--text-main, #F0F0F0);
    max-width: 800px;
    margin: 0 auto 1.5rem;
    line-height: 1.8;
}

.legacy-line {
    width: 80px;
    height: 3px;
    background-color: var(--primary-red, #B40000);
    margin: 0 auto;
    border-radius: 2px;
}

/* Main Grid (History & Philosophy) */
.legacy-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
    margin-bottom: 5rem;
}

@media (min-width: 992px) {
    .legacy-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.legacy-card {
    background: rgba(13, 13, 15, 0.6);
    border: 1px solid rgba(228, 220, 199, 0.15);
    border-radius: 16px;
    padding: 3rem 2.5rem;
    backdrop-filter: blur(10px);
    transition: transform 0.5s ease, border-color 0.5s ease;
}

.legacy-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary-red, #B40000);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
}

.legacy-card-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-red, #B40000);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 15px;
}

.legacy-card-text {
    font-size: 1.1rem;
    line-height: 1.9;
    color: var(--text-muted, #aaacb0);
    text-align: justify;
}

/* Partnerships Section */
.partnerships-wrapper {
    background: linear-gradient(135deg, rgba(20, 20, 22, 0.9), rgba(0, 0, 0, 0.8));
    border: 1px solid rgba(228, 220, 199, 0.1);
    border-radius: 20px;
    padding: 4rem 3rem;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
}

.partnerships-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--cream-beige, #E6E0D0);
    text-align: center;
    margin-bottom: 3rem;
}

.partners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.partner-item {
    background: rgba(0, 0, 0, 0.5);
    border-left: 3px solid var(--primary-red, #B40000);
    padding: 1.5rem;
    border-radius: 8px;
    transition: background 0.3s ease;
}

html[dir="ltr"] .partner-item {
    border-left: 3px solid var(--primary-red, #B40000);
    border-right: none;
}
html[dir="rtl"] .partner-item {
    border-right: 3px solid var(--primary-red, #B40000);
    border-left: none;
}

.partner-item:hover {
    background: rgba(180, 0, 0, 0.1);
}

.partner-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--off-white, #F0F0F0);
    margin-bottom: 0.5rem;
}

.partner-desc {
    font-size: 0.95rem;
    color: var(--text-muted, #aaacb0);
}

/* Mobile Adjustments */
@media (max-width: 768px) {
    .company-legacy-section {
        padding: 5rem 5%;
    }
    .legacy-title {
        font-size: 2.2rem;
    }
    .partnerships-wrapper {
        padding: 2.5rem 1.5rem;
    }
    .legacy-card {
        padding: 2rem 1.5rem;
    }
}
</style>

