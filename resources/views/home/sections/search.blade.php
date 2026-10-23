@include('home.styles.search')

<div id="search-overlay" class="search-overlay" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="search-modal-title">
    <div class="search-modal-container">
        <!-- شريط الإضاءة العلوي -->
        <div class="search-modal-glow"></div>

        <!-- زر الإغلاق -->
        <button id="close-search-modal" class="close-search-btn" aria-label="Close Search">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- رأس الموديل -->
        <div class="search-modal-header">
            <h2 id="search-modal-title" data-en="Find Your Dream Property" data-ar="ابحث عن عقار أحلامك">Find Your Dream
                Property</h2>
            <p data-en="Filter by project, sector, budget or area to find exactly what you need."
                data-ar="ابحث بالمشروع، القطاع، الميزانية أو المساحة للوصول لاهتماماتك بسهولة.">Filter by project,
                sector, budget or area to find exactly what you need.</p>
        </div>

        <!-- نموذج البحث والفلترة -->
        <form id="search-modal-form" action="{{ route('search.results') ?? '#' }}" method="GET"
            class="search-modal-form" onsubmit="event.preventDefault();">
            <div class="search-form-group full-width animate-item" style="--delay: 0.1s">
                <div class="input-with-icon">
                    <i class="fa-solid fa-magnifying-glass input-icon search-indicator-icon"></i>
                    <input type="text" name="keyword" class="search-input" id="search-keyword-input"
                        autocomplete="off"
                        data-placeholder-en="Type to search properties, projects, news... (Press '/' or 'Ctrl+K')"
                        data-placeholder-ar="اكتب للبحث عن العقارات، المشاريع، الأخبار... (اضغط '/' أو 'Ctrl+K')">

                    <button type="button" id="clear-search-input" class="clear-input-btn" aria-label="Clear Search"
                        style="display: none;">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                    <kbd class="keyboard-shortcut-hint">⌘K</kbd>
                </div>
            </div>

            <div class="search-filters-grid animate-item" style="--delay: 0.2s">
                <!-- القطاع -->
                <div class="search-form-group">
                    <label data-en="Sector" data-ar="القطاع">Sector</label>
                    <div class="custom-select-wrapper">
                        <select name="sector_id" class="search-select" id="filter-sector">
                            <option value="">{{ __('All Sectors') }}</option>
                            @foreach ($sectors ?? [] as $sector)
                                <option value="{{ $sector->id }}">
                                    {{ app()->getLocale() == 'ar' ? $sector->name_ar : $sector->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- نوع الوحدة -->
                <div class="search-form-group">
                    <label data-en="Unit Type" data-ar="نوع الوحدة">Unit Type</label>
                    <div class="custom-select-wrapper">
                        <select name="unit_type" class="search-select" id="filter-unit-type">
                            <option value="">{{ __('All Types') }}</option>
                            @foreach ($unitTypes ?? [] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- الميزانية -->
                <div class="search-form-group">
                    <label data-en="Budget Range" data-ar="الميزانية">Budget Range</label>
                    <div class="custom-select-wrapper">
                        <select name="budget" class="search-select" id="filter-budget">
                            <option value="" data-en="Any Budget" data-ar="أي ميزانية">Any Budget</option>
                            <option value="0-5M" data-en="Up to 5M EGP" data-ar="حتى ٥ مليون جنيه">Up to 5M EGP
                            </option>
                            <option value="5M-10M" data-en="5M - 10M EGP" data-ar="٥ مليون - ١٠ مليون جنيه">5M - 10M EGP
                            </option>
                            <option value="10M+" data-en="More than 10M EGP" data-ar="أكثر من ١٠ مليون جنيه">More than
                                10M EGP</option>
                        </select>
                    </div>
                </div>

                <!-- المساحة -->
                <div class="search-form-group">
                    <label data-en="Area (sqm)" data-ar="المساحة (متر مربع)">Area (sqm)</label>
                    <div class="custom-select-wrapper">
                        <select name="area" class="search-select" id="filter-area">
                            <option value="" data-en="Any Area" data-ar="أي مساحة">Any Area</option>
                            <option value="0-100" data-en="Up to 100 sqm" data-ar="حتى ١٠٠ متر مربع">Up to 100 sqm
                            </option>
                            <option value="100-200" data-en="100 - 200 sqm" data-ar="١٠٠ - ٢٠٠ متر مربع">100 - 200 sqm
                            </option>
                            <option value="200+" data-en="More than 200 sqm" data-ar="أكثر من ٢٠٠ متر مربع">More than
                                200 sqm</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <!-- مساحة عرض النتائج -->
        <div class="search-results-viewport animate-item" style="--delay: 0.3s" id="search-results-container">
            <!-- الحالة الافتراضية -->
            <div class="search-feedback-state active-state" id="initial-search-state">
                <div class="animated-icon-wrapper"><i
                        class="fa-solid fa-hand-pointer feedback-icon float-animation"></i></div>
                <h4 data-en="Start Typing to Discover" data-ar="ابدأ الكتابة للاكتشاف">Start Typing to Discover</h4>
                <p data-en="Search across our ultra-luxury projects, developments, and global premium listings."
                    data-ar="ابحث في جميع مشاريعنا الفاخرة، وعقاراتنا، وإعلاناتنا المتميزة.">Search across our
                    ultra-luxury projects, developments, and global premium listings.</p>
            </div>

            <!-- حالة التحميل (Skeleton) -->
            <div class="search-loading-skeleton" id="search-loading-skeleton" style="display: none;">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="skeleton-card">
                        <div class="skeleton-image-placeholder"></div>
                        <div class="skeleton-content">
                            <div class="skeleton-line skeleton-badge"></div>
                            <div class="skeleton-line skeleton-title"></div>
                            <div class="skeleton-line skeleton-subtitle"></div>
                            <div class="skeleton-line skeleton-description"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- قائمة النتائج -->
            <div class="search-results-list" id="search-results-list" role="listbox" aria-label="Search Results">
            </div>

            <!-- حالة عدم وجود نتائج -->
            <div class="search-feedback-state" id="empty-search-state" style="display: none;">
                <div class="animated-icon-wrapper"><i
                        class="fa-solid fa-magnifying-glass-minus feedback-icon pulse-animation"></i></div>
                <h4 data-en="No matching properties found" data-ar="لم نجد نتائج مطابقة">No matching properties found
                </h4>
                <p data-en="Try expanding your budget, checking other sectors, or correcting your search keyword."
                    data-ar="يرجى تجربة زيادة الميزانية المحددة، أو اختيار قطاعات أخرى، أو تعديل الكلمات المفتاحية.">
                    Try expanding your budget, checking other sectors, or correcting your search keyword.</p>
            </div>

            <!-- حالة الخطأ بالاتصال -->
            <div class="search-feedback-state error-state" id="error-search-state" style="display: none;">
                <div class="animated-icon-wrapper"><i
                        class="fa-solid fa-triangle-exclamation feedback-icon shake-animation"></i></div>
                <h4 data-en="Unable to connect to service" data-ar="فشل الاتصال بالخدمة">Unable to connect to service
                </h4>
                <p data-en="Please check your connection and try searching again."
                    data-ar="يرجى التحقق من اتصالك بالإنترنت وإعادة المحاولة.">Please check your connection and try
                    searching again.</p>
                <button type="button" class="btn-retry-search" id="btn-retry-search">
                    <span data-en="Retry Connection" data-ar="إعادة محاولة الاتصال">Retry Connection</span>
                </button>
            </div>
        </div>

        <!-- تذييل الموديل (الاختصارات) -->
        <div class="search-modal-footer animate-item" style="--delay: 0.4s">
            <div class="shortcut-tags">
                <span><kbd>↑↓</kbd> <span data-en="Navigate" data-ar="للتنقل">Navigate</span></span>
                <span><kbd>Enter</kbd> <span data-en="Select" data-ar="للاختيار">Select</span></span>
                <span><kbd>ESC</kbd> <span data-en="Close" data-ar="للإغلاق">Close</span></span>
            </div>
            <div class="results-meta-counter" id="results-meta-counter"></div>
        </div>
    </div>
</div>

@include('home.scripts.search')
