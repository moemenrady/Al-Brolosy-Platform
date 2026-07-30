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
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.25; /* تعتيم سينمائي ناعم للحفاظ على فخامة النصوص والقراءة */
    transition: opacity 0.5s ease;
}

/* طبقة تعتيم وتدرج لوني سينمائي يتداخل مع الأقسام السابقة والتالية */
.project-video-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, var(--bg-main) 0%, transparent 30%, transparent 70%, var(--bg-main) 100%),
                linear-gradient(to right, rgba(0,0,0,0.4) 0%, transparent 100%);
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
    background: rgba(180, 0, 0, 0.1);
    color: var(--primary-red);
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
    box-shadow: 0 30px 60px rgba(0,0,0,0.4);
}

html[data-theme="light"] .project-interactive-specs-panel {
    background: rgba(255, 255, 255, 0.8);
    border-color: rgba(0, 0, 0, 0.08);
    box-shadow: 0 20px 40px rgba(0,0,0,0.06);
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

.btn-luxury-primary, .btn-luxury-secondary {
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
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
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
        display: none; /* إخفاء الخط السفلي لعدم ملاءمته لتصميم الأسطر الرأسية */
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
