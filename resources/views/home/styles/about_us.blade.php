@push('styles')
<style>
    :root {
        --olive-dark: #4E5146;
        --sage: #8F957D;
        --bg-soft: #F3F4EF;
        --text-main: #2B2E26;
        --cream: #E6E1D5;
        --gold-soft: #CBBF9A;
    }

    .about-us-section {
        position: relative;
        padding: 120px 0;
        overflow: hidden;
        /* تحديث الألوان لدرجات الزيتوني والساج لإعطاء مظهر فخم وهادئ */
        background: linear-gradient(-45deg, 
            var(--olive-dark), 
            #5d6154, 
            var(--sage), 
            var(--olive-dark)
        );
        background-size: 400% 400%;
        animation: gradientMove 12s ease infinite;
        color: white;
    }

    /* تأثير الأمواج بلون الكريمي الشفاف */
    .section-wave {
        position: absolute;
        bottom: -50px;
        left: 0;
        width: 200%;
        height: 200px;
        background: rgba(230, 225, 213, 0.08); /* لون Cream شفاف */
        border-radius: 40%;
        animation: waveMove 15s linear infinite;
        pointer-events: none;
    }

    .section-wave:nth-child(2) {
        bottom: -20px;
        opacity: 0.04;
        animation-duration: 20s;
    }

    .about-content-card {
        padding: 40px;
        /* تأثير زجاجي يميل للزيتوني الغامق */
        background: rgba(43, 46, 38, 0.25); 
        backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(203, 191, 154, 0.2); /* حدود بلون الذهب الناعم */
        transform: translateX(-50px);
        opacity: 0;
        transition: all 1s ease-out;
    }

    .about-us-section.visible .about-content-card {
        transform: translateX(0);
        opacity: 1;
    }

    .about-content-card h2 {
        font-size: clamp(30px, 4vw, 50px);
        font-weight: 800;
        margin: 15px 0;
        color: var(--cream);
    }

    .about-content-card h2 span {
        color: var(--gold-soft); /* استخدام الذهب بتاعك هنا */
    }

    .sub-title {
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 14px;
        color: var(--gold-soft);
        font-weight: 600;
    }

    .about-features {
        display: flex;
        gap: 30px;
        margin-top: 30px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        color: var(--cream);
    }

    .feature-item i {
        color: var(--gold-soft);
    }

    .about-visual {
        position: relative;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transform: scale(0.8);
        transition: all 1s ease-out 0.3s;
    }

    .about-us-section.visible .about-visual {
        opacity: 1;
        transform: scale(1);
    }

    .abstract-shape {
        width: 300px;
        height: 300px;
        background: rgba(203, 191, 154, 0.1);
        border: 2px dashed rgba(203, 191, 154, 0.3);
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        animation: morphing 10s infinite alternate;
    }

    .floating-badge {
        position: absolute;
        top: 20%;
        right: 10%;
        background: var(--cream);
        color: var(--olive-dark);
        padding: 20px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        animation: floating 3s ease-in-out infinite;
        z-index: 2;
        border: 2px solid var(--gold-soft);
    }

    .floating-badge .number {
        font-weight: 800;
        font-size: 20px;
    }
.social-connect {
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid rgba(203, 191, 154, 0.2);
    }

    .connect-text {
        font-size: 14px;
        color: var(--gold-soft);
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

   /* تنسيق عام لأزرار السوشيال */
    .social-links {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .social-btn {
        display: flex;
        align-items: center;
        gap: 10px; /* المسافة بين الأيقونة والنص */
        padding: 12px 20px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(203, 191, 154, 0.2);
        color: var(--cream);
        text-decoration: none !important;
        transition: all 0.3s ease;
    }

    /* حجم ولون الأيقونة */
    .social-btn i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    /* تأثيرات الـ Hover */
    .social-btn:hover {
        transform: translateY(-3px);
        color: #fff;
        background: rgba(255, 255, 255, 0.15);
    }

    .social-btn:hover i {
        transform: rotate(15deg) scale(1.2);
    }

    /* ألوان البراندات عند المرور بالماوس */
    .instagram:hover {
        border-color: #E1306C;
        box-shadow: 0 5px 15px rgba(225, 48, 108, 0.3);
    }

    .instagram-kids:hover {
        border-color: #fccc63; /* لون يميل لبهجة الأطفال */
        box-shadow: 0 5px 15px rgba(252, 204, 99, 0.3);
    }

    .facebook:hover {
        border-color: #1877F2;
        box-shadow: 0 5px 15px rgba(24, 119, 242, 0.3);
    }

    /* للموبايل نخليهم تحت بعض لو المساحة ضيقة */
    @media (max-width: 480px) {
        .social-links {
            flex-direction: column;
        }
        .social-btn {
            width: 100%;
            justify-content: center;
        }
    }
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes morphing {
        0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        100% { border-radius: 50% 50% 20% 80% / 25% 80% 20% 75%; }
    }

    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes waveMove {
        from { transform: translateX(0) rotate(0); }
        to { transform: translateX(-50%) rotate(360deg); }
    }
    
</style>
@endpush