 @include('home.styles.join-team')
 <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet"> 
<section id="join-team" class="jt-section">
    <!-- خلفية السيكشن مع تأثير اللون العنابي -->
    <div class="jt-bg-overlay"></div>
    
    <div class="jt-container">
        
        <!-- عنوان السيكشن -->
        <div class="jt-header">
            <h2 data-en="Join Our Team" data-ar="انضم إلى فريقنا">Join Our Team</h2>
            <p data-en="Love real estate? Build your career with a team that values growth, passion, and excellence. We offer a work environment that encourages innovation." 
               data-ar="هل تحب مجال العقارات؟ ابنِ مسيرتك المهنية مع فريق يقدر النمو والشغف والتميز. نحن نقدم بيئة عمل تشجع على الابتكار.">
                Love real estate? Build your career with a team that values growth, passion, and excellence. We offer a work environment that encourages innovation.
            </p>
        </div>

        <!-- الكروت (Cards) -->
        <div class="jt-cards-wrapper">
            
            <!-- الكارت الأول -->
            <div class="jt-card">
                <div class="jt-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.027-.392.05-.59.07m-15.59-1.077a2.18 2.18 0 01-.75-1.661V8.706c0-1.081.768-2.015 1.837-2.175a48.208 48.208 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" /></svg>
                </div>
                <h3 data-en="Work With Us" data-ar="اعمل معنا">Work With Us</h3>
                <p data-en="Join our amazing team and be part of something great. Opportunities are available for everyone to play an effective role." 
                   data-ar="انضم إلى فريقنا الرائع وكن جزءًا من شيء عظيم. تتاح الفرص لكل فرد ليكون له دور فعّال في مشاريع تحدث فرقًا.">
                    Join our amazing team and be part of something great. Opportunities are available for everyone to play an effective role.
                </p>
                <a href="{{ route('jobs.index') ?? '#' }}" class="jt-btn">
                    <span data-en="Explore Careers" data-ar="استكشف الوظائف">Explore Careers</span>
                </a>
            </div>

            <!-- الكارت الثاني -->
            <div class="jt-card">
                <div class="jt-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                </div>
                <h3 data-en="Grow With Us" data-ar="تطور معنا">Grow With Us</h3>
                <p data-en="We invest in people and support your growth. We offer professional development to shape the future of real estate." 
                   data-ar="نحن نستثمر في الأفراد وندعم نموك. نقدم تطويراً مهنياً لتشكيل مستقبل العقارات في المنطقة.">
                    We invest in people and support your growth. We offer professional development to shape the future of real estate.
                </p>
                <a href="{{ route('jobs.index') ?? '#' }}" class="jt-btn">
                    <span data-en="Open Positions" data-ar="الوظائف المتاحة">Open Positions</span>
                </a>
            </div>

        </div>

        <!-- شريط المميزات (Features) -->
        <div class="jt-features-bar">
            <div class="jt-feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                <span data-en="Great Environment" data-ar="بيئة رائعة">Great Environment</span>
            </div>
            <div class="jt-feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                <span data-en="Career Growth" data-ar="نمو وظيفي">Career Growth</span>
            </div>
            <div class="jt-feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>
                <span data-en="Training & Development" data-ar="تدريب وتطوير">Training & Development</span>
            </div>
            <div class="jt-feature-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                <span data-en="Competitive Benefits" data-ar="مزايا تنافسية">Competitive Benefits</span>
            </div>
        </div>
        
    </div>
</section>