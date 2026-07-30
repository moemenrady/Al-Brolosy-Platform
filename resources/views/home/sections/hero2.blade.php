@include('home.styles.hero2')

<section class="focused-project-section" id="focused-masterpiece" x-data="{ activeTab: 'residential' }">
    
    <div class="project-video-bg-wrapper">
        <video id="project-focused-video" src="{{ asset('videos/albrolosy-section2.mp4') }}" muted loop autoplay playsinline></video>
        <div class="project-video-overlay"></div>
    </div>

    <div class="project-luxury-container">
        <div class="project-glamour-header">
            <div class="glamour-title-block">
                <span class="project-badge-premium" data-en="FEATURED MASTERPIECE" data-ar="التحفة المعمارية المختارة">FEATURED MASTERPIECE</span>
                <h2 class="project-huge-title" data-en="SANA TOWER" data-ar="سانا تاور">SANA TOWER</h2>
                <div class="project-geo-location">
                    <svg class="geo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2a8 8 0 00-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 00-8-8z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span data-en="New Mansoura, Waterfront" data-ar="شاطئ البحر، المنصورة الجديدة">New Mansoura, Waterfront</span>
                    <span class="geo-coords">31.435250° N, 31.653600° E</span>
                </div>
            </div>
            
            <div class="project-brand-stamp">
                <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Luxury Stamp" class="stamp-img">
                <div class="stamp-glow"></div>
            </div>
        </div>

        <div class="project-main-grid">
            
            <div class="project-info-narrative">
                <p class="project-description-text" 
                   data-en="An iconic residential, commercial, and hotel masterpiece gracing the shores of New Mansoura. Built on 46,000 sqm with an exclusive 25,000 sqm private beach, offering an uncompromised luxury lifestyle right in front of Zahrat Al-Mawraq villas." 
                   data-ar="أيقونة معمارية وسياحية فريدة تجمع بين السكن الفاخر، التسوق الذكي، والضيافة الفندقية العالمية مباشرة على شاطئ البحر بالمنصورة الجديدة (قطعة 4 أمام فيلات زهرة المورق). يمتد المشروع على مساحة 46 ألف متر مربع مصحوباً بشاطئ خاص ساحر بمساحة 25 ألف متر مربع لتجربة حياة لا تُنسى.">
                   An iconic residential, commercial, and hotel masterpiece gracing the shores of New Mansoura.
                </p>

                <div class="project-quick-metrics">
                    <div class="metric-card">
                        <small data-en="Project Status" data-ar="حالة المشروع">Project Status</small>
                        <strong data-en="Under Construction" data-ar="تحت الإنشاء">Under Construction</strong>
                    </div>
                    <div class="metric-card">
                        <small data-en="Delivery Horizon" data-ar="موعد التسليم">Delivery Horizon</small>
                        <strong data-en="3.5 Years" data-ar="٣.٥ سنوات">3.5 Years</strong>
                    </div>
                    <div class="metric-card">
                        <small data-en="Starting From" data-ar="الأسعار تبدأ من">Starting From</small>
                        <strong class="text-highlight">2,450,000 EGP</strong>
                    </div>
                </div>

                <div class="luxury-payment-panel">
                    <h3 class="panel-inside-title" data-en="Investment & Payment Plans" data-ar="خطط السداد والاستثمار">Investment & Payment Plans</h3>
                    <div class="payment-metrics-flex">
                        <div class="pay-item">
                            <span data-en="Down Payment" data-ar="المقدم">Down Payment</span>
                            <p>5% / 10% / 15% / 25%</p>
                        </div>
                        <div class="pay-item">
                            <span data-en="Installments Period" data-ar="فترة التقسيط">Installments Period</span>
                            <p data-en="Up to 8 Years" data-ar="تصل إلى ٨ سنوات">Up to 8 Years</p>
                        </div>
                        <div class="pay-item">
                            <span data-en="Maintenance" data-ar="وديعة الصيانة">Maintenance</span>
                            <p>10%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="project-interactive-specs-panel">
                <div class="specs-tabs-header">
                    <button type="button" class="spec-tab-trigger" :class="{ 'active': activeTab === 'residential' }" @click="activeTab = 'residential'" data-en="Residential Units" data-ar="الوحدات السكنية">Residential Units</button>
                    <button type="button" class="spec-tab-trigger" :class="{ 'active': activeTab === 'commercial' }" @click="activeTab = 'commercial'" data-en="Commercial Spaces" data-ar="المساحات التجارية">Commercial Spaces</button>
                    <button type="button" class="spec-tab-trigger" :class="{ 'active': activeTab === 'hotel' }" @click="activeTab = 'hotel'" data-en="Luxury Hotel Suites" data-ar="الأجنحة الفندقية">Luxury Hotel Suites</button>
                </div>

                <div class="specs-tabs-content">
                    <div class="tab-pane-luxury" x-show="activeTab === 'residential'" x-transition:enter="pane-fade-in">
                        <div class="spec-feature-line">
                            <span data-en="Available Floors" data-ar="الأدوار المتاحة">Available Floors</span>
                            <strong>First, Second, Third & Fourth</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Area Range" data-ar="نطاق المساحات">Area Range</span>
                            <strong>59M² - 183M²</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Price Per Meter" data-ar="سعر المتر">Price Per Meter</span>
                            <strong class="text-highlight">45,000 - 70,000 EGP</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Finishing Standard" data-ar="مستوى التشطيب">Finishing Standard</span>
                            <strong data-en="Premium Semi-Finished" data-ar="نصف تشطيب فاخر">Premium Semi-Finished</strong>
                        </div>
                        <div class="spec-feature-line border-none">
                            <span data-en="Unit Price Range" data-ar="إجمالي سعر الوحدة">Unit Price Range</span>
                            <strong class="total-badge">2.65M — 12.85M EGP</strong>
                        </div>
                    </div>

                    <div class="tab-pane-luxury" x-show="activeTab === 'commercial'" x-transition:enter="pane-fade-in">
                        <div class="spec-feature-line">
                            <span data-en="Available Floors" data-ar="الأدوار المتاحة">Available Floors</span>
                            <strong data-en="Ground & First Floor" data-ar="الأرضي والأول">Ground & First Floor</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Area Range" data-ar="نطاق المساحات">Area Range</span>
                            <strong>25M² - 500M²</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Price Per Meter" data-ar="سعر المتر">Price Per Meter</span>
                            <strong class="text-highlight">120,000 - 250,000 EGP</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Finishing Standard" data-ar="مستوى التشطيب">Finishing Standard</span>
                            <strong data-en="Core & Shell" data-ar="بدون تشطيب (طوب أحمر)">Core & Shell</strong>
                        </div>
                        <div class="spec-feature-line border-none">
                            <span data-en="Unit Price Range" data-ar="إجمالي سعر الوحدة">Unit Price Range</span>
                            <strong class="total-badge">3.00M — 18.00M EGP</strong>
                        </div>
                    </div>

                    <div class="tab-pane-luxury" x-show="activeTab === 'hotel'" x-transition:enter="pane-fade-in">
                        <div class="spec-feature-line">
                            <span data-en="Available Floors" data-ar="الأدوار المتاحة">Available Floors</span>
                            <strong>First, Second, Third & Fourth</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Area Range" data-ar="نطاق المساحات">Area Range</span>
                            <strong>45M² - 60M²</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Price Per Meter" data-ar="سعر المتر">Price Per Meter</span>
                            <strong class="text-highlight">54,000 - 70,000 EGP</strong>
                        </div>
                        <div class="spec-feature-line">
                            <span data-en="Finishing Standard" data-ar="مستوى التشطيب">Finishing Standard</span>
                            <strong data-en="Ultra Luxury Fully Finished" data-ar="تشطيب كامل ألترا لوكس">Ultra Luxury Fully Finished</strong>
                        </div>
                        <div class="spec-feature-line border-none">
                            <span data-en="Unit Price Range" data-ar="إجمالي سعر الوحدة">Unit Price Range</span>
                            <strong class="total-badge">2.45M — 3.50M EGP</strong>
                        </div>
                    </div>
                </div>

                <div class="specs-panel-actions">
                    <a href="https://maps.google.com/?q=31.435250,31.653600" target="_blank" class="btn-luxury-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/>
                            <line x1="9" y1="3" x2="9" y2="18"/>
                            <line x1="15" y1="6" x2="15" y2="21"/>
                        </svg>
                        <span data-en="Location on Map" data-ar="تحديد الموقع على الخريطة">Location on Map</span>
                    </a>
                    <a href="#consultation" class="btn-luxury-primary">
                        <span data-en="Inquire Now" data-ar="تواصل ومناقشة الاستثمار">Inquire Now</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>