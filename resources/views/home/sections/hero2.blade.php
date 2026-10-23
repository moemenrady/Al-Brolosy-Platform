@include('home.styles.hero2')
<section class="focused-project-section" id="focused-masterpiece" x-data="{ activeTab: 'residential' }">

    <!-- خلفية الفيديو المدمجة مع التحميل الديناميكي حسب نوع الجهاز -->
    <div class="project-video-bg-wrapper">
        <video id="d_hero2-video" class="project-hero-video" muted loop playsinline preload="none"
            poster="{{ \App\Models\PlatformSetting::mediaUrl('hero2_desktop_poster', 'images/d_hero-poster.webp') }}" 
            data-src="{{ \App\Models\PlatformSetting::mediaUrl('hero2_desktop_video', 'videos/d_hero2.mp4') }}">
        </video>
        <video id="m_hero2-video" class="project-hero-video" muted loop playsinline preload="none"
            poster="{{ \App\Models\PlatformSetting::mediaUrl('hero2_mobile_poster', 'images/d_hero-poster.webp') }}" 
            data-src="{{ \App\Models\PlatformSetting::mediaUrl('hero2_mobile_video', 'videos/m_hero2.mp4') }}">
        </video>
        
        <!-- طبقة التعتيم والتدرج السينمائي لتعزيز التباين -->
        <div class="project-video-overlay"></div>
    </div>

    <div class="project-luxury-container">
        <!-- الهيدر والوسم الرئيسي -->
        <div class="project-glamour-header">
            <div class="glamour-title-block">
                <span class="project-badge-premium" data-en="FEATURED MASTERPIECE"
                    data-ar="التحفة المعمارية المختارة">التحفة المعمارية المختارة</span>
                <h2 class="project-huge-title" data-en="SANA TOWER" data-ar="سانا تاور">SANA TOWER</h2>
                <div class="project-geo-location">
                    <svg class="geo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a8 8 0 00-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 00-8-8z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <span class="geo-coords" data-en="New Mansoura, Waterfront" data-ar="شاطئ البحر، المنصورة الجديدة">شاطئ البحر، المنصورة الجديدة</span>
                </div>
            </div>

            <div class="project-brand-stamp">
                <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Luxury Stamp" class="stamp-img">
                <div class="stamp-glow"></div>
            </div>
        </div>

        <!-- الشبكة الرئيسية للبيانات -->
        <div class="project-main-grid">

            <!-- العمود الأول: السرد والمعلومات والأسعار -->
            <div class="project-info-narrative">
                <div class="narrative-card-wrapper">
                    <p class="project-description-text"
                        data-en="An iconic residential, commercial, and hotel masterpiece gracing the shores of New Mansoura. Built on 46,000 sqm with an exclusive 25,000 sqm private beach, offering an uncompromised luxury lifestyle right in front of Zahrat Al-Mawraq villas."
                        data-ar="أيقونة معمارية وسياحية فريدة تجمع بين السكن الفاخر، التسوق الذكي، والضيافة الفندقية العالمية مباشرة على شاطئ البحر بالمنصورة الجديدة (قطعة 4 أمام فيلات زهرة المورق). يمتد المشروع على مساحة 46 ألف متر مربع مصحوباً بشاطئ خاص ساحر بمساحة 25 ألف متر مربع لتجربة حياة لا تُنسى.">
                        أيقونة معمارية وسياحية فريدة تجمع بين السكن الفاخر، التسوق الذكي، والضيافة الفندقية العالمية مباشرة على شاطئ البحر بالمنصورة الجديدة (قطعة 4 أمام فيلات زهرة المورق).
                    </p>

                    <!-- المؤشرات السريعة -->
                    <div class="project-quick-metrics">
                        <div class="metric-card">
                            <small data-en="Project Status" data-ar="حالة المشروع">حالة المشروع</small>
                            <strong data-en="Under Construction" data-ar="تحت الإنشاء">تحت الإنشاء</strong>
                        </div>
                        <div class="metric-card">
                            <small data-en="Delivery Horizon" data-ar="موعد التسليم">موعد التسليم</small>
                            <strong data-en="3.5 Years" data-ar="٣.٥ سنوات">٣.٥ سنوات</strong>
                        </div>
                        <div class="metric-card highlight-card">
                            <small data-en="Starting From" data-ar="الأسعار تبدأ من">الأسعار تبدأ من</small>
                            <strong class="text-highlight">2,450,000 EGP</strong>
                        </div>
                    </div>

                    <!-- لوحة خطط السداد -->
                    <div class="luxury-payment-panel">
                        <h3 class="panel-inside-title" data-en="Investment & Payment Plans" data-ar="خطط السداد والاستثمار">
                            خطط السداد والاستثمار</h3>
                        <div class="payment-metrics-flex">
                            <div class="pay-item">
                                <span data-en="Down Payment" data-ar="المقدم">المقدم</span>
                                <p>5% / 10% / 15% / 25%</p>
                            </div>
                            <div class="pay-item">
                                <span data-en="Installments Period" data-ar="فترة التقسيط">فترة التقسيط</span>
                                <p data-en="Up to 8 Years" data-ar="تصل إلى ٨ سنوات">تصل إلى ٨ سنوات</p>
                            </div>
                            <div class="pay-item">
                                <span data-en="Maintenance" data-ar="وديعة الصيانة">وديعة الصيانة</span>
                                <p>10%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- العمود الثاني: لوحة التبويبات والمواصفات التفاعلية -->
            <div class="project-interactive-specs-panel">
                <div class="specs-tabs-header">
                    <button type="button" class="spec-tab-trigger" :class="{ 'active': activeTab === 'residential' }"
                        @click="activeTab = 'residential'" data-en="Residential Units"
                        data-ar="الوحدات السكنية">الوحدات السكنية</button>
                    <button type="button" class="spec-tab-trigger" :class="{ 'active': activeTab === 'commercial' }"
                        @click="activeTab = 'commercial'" data-en="Commercial Spaces"
                        data-ar="المساحات التجارية">المساحات التجارية</button>
                    <button type="button" class="spec-tab-trigger" :class="{ 'active': activeTab === 'hotel' }"
                        @click="activeTab = 'hotel'" data-en="Luxury Hotel Suites" data-ar="الأجنحة الفندقية">الأجنحة الفندقية</button>
                </div>

                <div class="specs-tabs-content">
                    <!-- التبويب الأول: السكني -->
                    <div class="tab-pane-luxury" x-show="activeTab === 'residential'" x-transition:enter="pane-fade-in">
                        <div class="spec-feature-line">
                            <span data-en="Available Floors" data-ar="الأدوار المتاحة">الأدوار المتاحة</span>
                            <strong>الأول، الثاني، الثالث والرابع</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Area Range" data-ar="نطاق المساحات">نطاق المساحات</span>
                            <strong>59M² - 183M²</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Price Per Meter" data-ar="سعر المتر">سعر المتر</span>
                            <strong class="text-highlight">45,000 - 70,000 EGP</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Finishing Standard" data-ar="مستوى التشطيب">مستوى التشطيب</span>
                            <strong data-en="Premium Semi-Finished" data-ar="نصف تشطيب فاخر">نصف تشطيب فاخر</strong>
                        </div>
                        <div class="spec-feature-line border-none">
                            <span data-en="Unit Price Range" data-ar="إجمالي سعر الوحدة">إجمالي سعر الوحدة</span>
                            <strong class="total-badge">2.65M — 12.85M EGP</strong>
                        </div>
                    </div>

                    <!-- التبويب الثاني: التجاري -->
                    <div class="tab-pane-luxury" x-show="activeTab === 'commercial'" x-transition:enter="pane-fade-in">
                        <div class="spec-feature-line">
                            <span data-en="Available Floors" data-ar="الأدوار المتاحة">الأدوار المتاحة</span>
                            <strong data-en="Ground & First Floor" data-ar="الأرضي والأول">الأرضي والأول</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Area Range" data-ar="نطاق المساحات">نطاق المساحات</span>
                            <strong>25M² - 500M²</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Price Per Meter" data-ar="سعر المتر">سعر المتر</span>
                            <strong class="text-highlight">120,000 - 250,000 EGP</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Finishing Standard" data-ar="مستوى التشطيب">مستوى التشطيب</span>
                            <strong data-en="Core & Shell" data-ar="بدون تشطيب (طوب أحمر)">بدون تشطيب (طوب أحمر)</strong>
                        </div>
                        <div class="spec-feature-line border-none">
                            <span data-en="Unit Price Range" data-ar="إجمالي سعر الوحدة">إجمالي سعر الوحدة</span>
                            <strong class="total-badge">3.00M — 18.00M EGP</strong>
                        </div>
                    </div>

                    <!-- التبويب الثالث: الفندقي -->
                    <div class="tab-pane-luxury" x-show="activeTab === 'hotel'" x-transition:enter="pane-fade-in">
                        <div class="spec-feature-line">
                            <span data-en="Available Floors" data-ar="الأدوار المتاحة">الأدوار المتاحة</span>
                            <strong>الأول، الثاني، الثالث والرابع</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Area Range" data-ar="نطاق المساحات">نطاق المساحات</span>
                            <strong>45M² - 60M²</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Price Per Meter" data-ar="سعر المتر">سعر المتر</span>
                            <strong class="text-highlight">54,000 - 70,000 EGP</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Finishing Standard" data-ar="مستوى التشطيب">مستوى التشطيب</span>
                            <strong data-en="Ultra Luxury Fully Finished" data-ar="تشطيب كامل ألترا لوكس">تشطيب كامل ألترا لوكس</strong>
                        </div>
                        <div class="spec-feature-line border-none">
                            <span data-en="Unit Price Range" data-ar="إجمالي سعر الوحدة">إجمالي سعر الوحدة</span>
                            <strong class="total-badge">2.45M — 3.50M EGP</strong>
                        </div>
                    </div>
                </div>

                <div class="specs-panel-actions">
                    <a href="https://maps.google.com/?q=31.435250,31.653600" target="_blank" class="btn-luxury-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21" />
                            <line x1="9" y1="3" x2="9" y2="18" />
                            <line x1="15" y1="6" x2="15" y2="21" />
                        </svg>
                        <span data-en="Location on Map" data-ar="تحديد الموقع على الخريطة">تحديد الموقع على الخريطة</span>
                    </a>
                    <a href="#consultation" class="btn-luxury-primary">
                        <span data-en="Inquire Now" data-ar="تواصل ومناقشة الاستثمار">تواصل ومناقشة الاستثمار</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@include('home.scripts.hero2')