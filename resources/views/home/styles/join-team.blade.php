<style>
/* =========================================
   متغيرات الألوان للوضع الفاتح والداكن
   ========================================= */
:root {
    /* الوضع الفاتح (Light Mode) */
    --jt-bg-color: #f8f9fa;
    --jt-overlay-color: rgba(255, 255, 255, 0.85);
    --jt-text-primary: #333333;
    --jt-text-secondary: #555555;
    --jt-card-bg: #ffffff;
    --jt-card-border: rgba(100, 20, 30, 0.1);
    --jt-card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    --jt-btn-bg: #611122;
    --jt-btn-text: #ffffff;
    --jt-btn-hover: #4a0d1a;
    --jt-icon-color: #611122;
}

[data-theme="dark"] {
    /* الوضع الداكن (Dark Mode) - مطابق للصورة تماماً */
    --jt-bg-color: #1a0508;
    /* يمكنك وضع مسار صورة مباني هنا إذا توفرت لديك لتعطي نفس الإيحاء */
    --jt-bg-image: url('https://images.unsplash.com/photo-1449844908441-8829872d2607?q=80&w=2070&auto=format&fit=crop'); 
    --jt-overlay-color: linear-gradient(135deg, rgba(74, 14, 23, 0.85) 0%, rgba(20, 5, 8, 0.95) 100%);
    --jt-text-primary: #ffffff;
    --jt-text-secondary: #e0e0e0;
    --jt-card-bg: rgba(97, 17, 34, 0.4);
    --jt-card-border: rgba(255, 255, 255, 0.1);
    --jt-card-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    --jt-btn-bg: #ffffff;
    --jt-btn-text: #611122;
    --jt-btn-hover: #f0f0f0;
    --jt-icon-color: #ffffff;
}

/* =========================================
   تنسيقات السيكشن الأساسية
   ========================================= */
.jt-section {
    position: relative;
    padding: 80px 20px;
    background-color: var(--jt-bg-color);
    background-image: var(--jt-bg-image, none);
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 100vh;
    display: flex;
    align-items: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    overflow: hidden;
    transition: background-color 0.4s ease;
}

.jt-bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--jt-overlay-color);
    z-index: 1;
    transition: background 0.4s ease;
}

.jt-container {
    position: relative;
    z-index: 2;
    max-width: 1100px;
    margin: 0 auto;
    width: 100%;
}

/* =========================================
   الهيدر (العنوان والوصف)
   ========================================= */
.jt-header {
    text-align: center;
    margin-bottom: 50px;
}

.jt-header h2 {
    color: var(--jt-text-primary);
    font-size: 3rem;
    font-weight: 600;
    margin-bottom: 15px;
    font-family: 'Playfair Display', serif; /* خط كلاسيكي مطابق للصورة */
}

.jt-header p {
    color: var(--jt-text-secondary);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* =========================================
   الكروت (Cards)
   ========================================= */
.jt-cards-wrapper {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-bottom: 30px;
}

.jt-card {
    background: var(--jt-card-bg);
    border: 1px solid var(--jt-card-border);
    border-radius: 16px;
    padding: 50px 30px;
    text-align: center;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: var(--jt-card-shadow);
    transition: transform 0.3s ease, background 0.4s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.jt-card:hover {
    transform: translateY(-5px);
}

.jt-card-icon {
    width: 50px;
    height: 50px;
    margin-bottom: 20px;
    color: var(--jt-icon-color);
}

.jt-card h3 {
    color: var(--jt-text-primary);
    font-size: 1.8rem;
    margin-bottom: 15px;
    font-family: 'Playfair Display', serif;
}

.jt-card p {
    color: var(--jt-text-secondary);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 30px;
    flex-grow: 1; /* لجعل الزر في الأسفل دائماً */
}

/* =========================================
   الأزرار
   ========================================= */
.jt-btn {
    display: inline-block;
    background-color: var(--jt-btn-bg);
    color: var(--jt-btn-text) !important;
    text-decoration: none;
    padding: 12px 35px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
    width: 100%;
    max-width: 250px;
}

.jt-btn:hover {
    background-color: var(--jt-btn-hover);
    transform: scale(1.02);
}

/* =========================================
   شريط المميزات السفلي
   ========================================= */
.jt-features-bar {
    background: var(--jt-card-bg);
    border: 1px solid var(--jt-card-border);
    border-radius: 16px;
    padding: 30px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: var(--jt-card-shadow);
}

.jt-feature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 10px;
}

.jt-feature-item svg {
    width: 32px;
    height: 32px;
    color: var(--jt-icon-color);
}

.jt-feature-item span {
    color: var(--jt-text-primary);
    font-size: 0.95rem;
    font-weight: 500;
}

/* =========================================
   التجاوب مع الشاشات (Responsive)
   ========================================= */
@media (max-width: 992px) {
    .jt-header h2 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .jt-cards-wrapper {
        grid-template-columns: 1fr; /* الكروت تحت بعضها في الموبايل */
    }
    
    .jt-features-bar {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* المميزات 2 في كل صف */
        gap: 30px 15px;
        padding: 30px 15px;
    }
}

@media (max-width: 480px) {
    .jt-header h2 {
        font-size: 2rem;
    }
    
    .jt-card {
        padding: 40px 20px;
    }
    
    .jt-features-bar {
        grid-template-columns: 1fr; /* ميزة واحدة في كل صف للشاشات الصغيرة جداً */
    }
}
</style>
