@include('home.styles.sectors')
<section class="portfolio-section" id="sectors">
    <div class="portfolio-container">

        <div class="portfolio-header">
            <div class="section-title-box">
                <span class="section-subtitle" data-en="Our Portfolio" data-ar="محفظتنا العقارية">Our Portfolio</span>
                <h2 class="section-main-title" data-en="Exclusive Sectors & Projects"
                    data-ar="المشاريع والقطاعات الحصرية">Exclusive Sectors & Projects</h2>
            </div>

            <div class="portfolio-controls">
                <div class="filter-tabs-wrapper" id="multi-filter-container">
                    <button class="filter-tab action-btn" id="reset-filters" style="display: none;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16"
                            height="16">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                            <path d="M3 3v5h5" />
                        </svg>
                        <span data-en="Reset" data-ar="إعادة ضبط">Reset</span>
                    </button>

                    @foreach ($sectors as $sector)
                        <button class="filter-tab toggle-sector" data-filter="sector-{{ $sector->id }}">
                            <span data-en="{{ $sector->name_en }}" data-ar="{{ $sector->name_ar }}">
                                {{ app()->getLocale() == 'ar' ? $sector->name_ar : $sector->name_en }}
                            </span>
                        </button>
                    @endforeach
                </div>

                <div class="sorting-dropdowns">
                    <div class="select-custom-wrapper">
                        <select id="area-filter" class="premium-select">
                            <option value="all" data-en="All Areas" data-ar="كل المساحات">All Areas</option>
                            <option value="0-100" data-en="Up to 100 m²" data-ar="حتى 100 متر²">Up to 100 m²</option>
                            <option value="101-200" data-en="101 - 200 m²" data-ar="101 - 200 متر²">101 - 200 m²
                            </option>
                            <option value="201-99999" data-en="More than 200 m²" data-ar="أكثر من 200 متر²">More than
                                200 m²</option>
                        </select>
                    </div>

                    <div class="select-custom-wrapper">
                        <select id="price-filter" class="premium-select">
                            <option value="all" data-en="All Prices" data-ar="كل الأسعار">All Prices</option>
                            <option value="0-5000000" data-en="Under 5M" data-ar="أقل من 5 مليون">Under 5M</option>
                            <option value="5000001-15000000" data-en="5M - 15M" data-ar="5 مليون - 15 مليون">5M - 15M
                            </option>
                            <option value="15000001-999999999" data-en="Above 15M" data-ar="أكثر من 15 مليون">Above 15M
                            </option>
                        </select>
                    </div>

                    <div class="select-custom-wrapper">
                        <select id="project-sorter" class="premium-select">
                            <option value="default" data-en="Sort By" data-ar="ترتيب حسب">Sort By</option>
                            <option value="date-desc" data-en="Newest First" data-ar="الأحدث أولاً">Newest First
                            </option>
                            <option value="date-asc" data-en="Oldest First" data-ar="الأقدم أولاً">Oldest First</option>
                            <option value="price-asc" data-en="Price: Low to High" data-ar="السعر: من الأقل للأعلى">
                                Price: Low to High</option>
                            <option value="price-desc" data-en="Price: High to Low" data-ar="السعر: من الأعلى للأقل">
                                Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="projects-grid" id="luxury-projects-grid">
            @foreach ($projects as $project)
                @php
                    // استخراج الأرقام فقط للفلترة الذكية
                    $unitPrices = $project->unitTypes
                        ->pluck('unit_price')
                        ->map(function ($p) {
                            return (float) preg_replace('/[^0-9.]/', '', $p);
                        })
                        ->filter();
                    $minPrice =
                        $unitPrices->min() ?: ((float) preg_replace('/[^0-9.]/', '', $project->price_budget) ?: 0);
                    $maxPrice = $unitPrices->max() ?: $minPrice;

                    $unitAreas = $project->unitTypes
                        ->pluck('start_area')
                        ->map(function ($a) {
                            return (float) preg_replace('/[^0-9.]/', '', $a);
                        })
                        ->filter();
                    $minArea = $unitAreas->min() ?: 0;
                    $maxArea = $unitAreas->max() ?: 0;

                    $timestamp = $project->created_at->timestamp;
                @endphp

                <div class="project-card-item" data-sector="sector-{{ $project->sector_id }}"
                    data-min-price="{{ $minPrice }}" data-max-price="{{ $maxPrice }}"
                    data-min-area="{{ $minArea }}" data-max-area="{{ $maxArea }}"
                    data-date="{{ $timestamp }}">

                    <a href="{{ route('projects.show', $project->id) }}" class="project-card-link-wrapper">
                        <div class="project-card-media">
                            <img src="{{ asset('images/projects/' . $project->image) }}" alt="{{ $project->name_en }}"
                                loading="lazy" class="base-project-img">
                            <div class="project-status-badge {{ $project->status }}">
                                <span data-en="{{ ucfirst(str_replace('_', ' ', $project->status)) }}"
                                    data-ar="{{ $project->status == 'launched' ? 'تم الإطلاق' : ($project->status == 'coming_soon' ? 'قريباً' : ($project->status == 'under_construction' ? 'تحت الإنشاء' : 'تسليم فوري')) }}">
                                    {{ $project->status == 'launched' ? 'تم الإطلاق' : 'قريباً' }}
                                </span>
                            </div>
                            <div class="hover-cta-message">
                                <div class="hover-cta-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                    </svg>
                                </div>
                                <div class="hover-cta-text" data-en="Discover Details"
                                    data-ar="اكتشف تفاصيل المشروع">اكتشف تفاصيل المشروع</div>
                                <div class="hover-cta-subtext" data-en="Prices, Areas & Location"
                                    data-ar="الأسعار، المساحات، والموقع">الأسعار، المساحات، والموقع</div>
                            </div>
                        </div>
                        <div class="project-card-info">
                            <div class="project-meta-top">
                                @if ($project->logo)
                                    <img src="{{ asset('images/projects_logo/' . $project->logo) }}"
                                        alt="Project Logo" class="project-mini-logo">
                                @else
                                    <span class="sector-tag-name"
                                        data-en="{{ $project->sector->name_en ?? 'Real Estate' }}"
                                        data-ar="{{ $project->sector->name_ar ?? 'عقارات' }}">
                                        {{ app()->getLocale() == 'ar' ? $project->sector->name_ar ?? 'عقارات' : $project->sector->name_en ?? 'Real Estate' }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="project-title-name" data-en="{{ $project->name_en }}"
                                data-ar="{{ $project->name_ar }}">
                                {{ app()->getLocale() == 'ar' ? $project->name_ar : $project->name_en }}
                            </h3>
                            @if ($project->latitude && $project->longitude)
                                <object>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $project->latitude }},{{ $project->longitude }}"
                                        target="_blank" class="location-btn-prominent" title="Open in Google Maps">
                                        <div class="loc-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                            </svg>
                                        </div>
                                        <span class="loc-text" data-en="{{ $project->location_en }}"
                                            data-ar="{{ $project->location_ar }}">
                                            {{ app()->getLocale() == 'ar' ? $project->location_ar : $project->location_en }}
                                        </span>
                                        <span class="loc-arrow">↗</span>
                                    </a>
                                </object>
                            @else
                                <div class="location-btn-prominent" style="cursor: default; pointer-events: none;">
                                    <div class="loc-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                        </svg>
                                    </div>
                                    <span class="loc-text" data-en="{{ $project->location_en }}"
                                        data-ar="{{ $project->location_ar }}">
                                        {{ app()->getLocale() == 'ar' ? $project->location_ar : $project->location_en }}
                                    </span>
                                </div>
                            @endif
                            @php
                                $unitTypes = [
                                    'Residential' => 'سكني',
                                    'Commercial' => 'تجاري',
                                    'Administrative' => 'إداري',
                                    'Hotel Units' => 'وحدات فندقية',
                                    'Medical' => 'طبي',
                                ];
                            @endphp

                            @if ($project->unitTypes->count() > 0)
                                <div class="units-showcase-title" data-en="Available Units"
                                    data-ar="الوحدات المتاحة">
                                    {{ app()->getLocale() == 'ar' ? 'الوحدات المتاحة' : 'Available Units' }}
                                </div>
                                <div class="units-grid">
                                    @foreach ($project->unitTypes->take(3) as $unit)
                                        @php
                                            $unitPrice = $unit->unit_price;

                                            if (app()->getLocale() == 'ar' && $unitPrice) {
                                                $unitPrice = str_ireplace(' to ', ' إلى ', $unitPrice);
                                            }
                                        @endphp

                                        <div class="unit-block">
                                            <span class="unit-type">
                                                {{ app()->getLocale() == 'ar' ? $unitTypes[$unit->unit_type] ?? $unit->unit_type : $unit->unit_type }}
                                            </span>

                                            <span class="unit-val highlight">
                                                {{ $unit->start_area }}
                                                {{ app()->getLocale() == 'ar' ? 'م²' : 'm²' }}
                                            </span>

                                            @if ($unitPrice)
                                                <span class="unit-val" style="font-size:.8rem;margin-top:.2rem;">
                                                    {{ $unitPrice }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="project-specs-footer">
                                <div class="spec-item">
                                    <small data-en="Starting Price" data-ar="يبدأ من">Starting Price</small>
                                    <strong>{{ $project->price_budget ?? 'Contact Us' }}</strong>
                                </div>
                                @if ($project->paymentPlans->first())
                                    <div class="spec-item">
                                        <small data-en="Down Payment" data-ar="مقدم حجز">Down Payment</small>
                                        <strong>{{ $project->paymentPlans->first()->down_payment }}</strong>
                                    </div>
                                @endif
                                @php
                                    $delivery = $project->delivery_time;

                                    if (app()->getLocale() == 'ar' && $delivery) {
                                        $delivery = str_ireplace(
                                            [' years', ' year', 'immediate delivery'],
                                            [' سنوات', ' سنة', 'تسليم فوري'],
                                            $delivery,
                                        );
                                    }
                                @endphp
                                <div class="spec-item text-right" style="text-align: right;">
                                    <small data-en="Delivery" data-ar="التسليم">Delivery</small>
                                    <strong>{{ $delivery ?? 'N/A' }}</strong>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>
@include('home.scripts.sectors')
