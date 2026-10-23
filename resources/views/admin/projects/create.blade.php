@extends('layouts.admin')

@section('content')
<style>
    .project-form-page {
        direction: rtl;
        font-family: 'Cairo', sans-serif;
    }

    .page-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .page-title {
        font-size: clamp(1.3rem, 2vw, 1.8rem);
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-tabs {
        display: flex;
        gap: 8px;
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid var(--glass-border);
        padding: 6px;
        border-radius: 12px;
        margin-bottom: 2rem;
        overflow-x: auto;
    }

    .tab-btn {
        flex: 1;
        min-width: 140px;
        padding: 0.85rem 1rem;
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-weight: 700;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 0.95rem;
        font-family: 'Cairo', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .tab-btn.active {
        background: rgba(215, 182, 74, 0.15);
        color: var(--gold);
        border: 1px solid rgba(215, 182, 74, 0.35);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-section-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .form-section-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--gold);
        margin-bottom: 1.5rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px dashed var(--glass-border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .form-control-lux {
        width: 100%;
        background: #16161a !important;
        border: 1px solid rgba(215, 182, 74, 0.3) !important;
        border-radius: 10px;
        padding: 0.75rem 1.1rem;
        color: #ffffff !important;
        font-family: 'Cairo', sans-serif;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
    }

    .form-control-lux:focus {
        border-color: var(--gold) !important;
        box-shadow: 0 0 12px rgba(215, 182, 74, 0.25) !important;
        background: #1c1c22 !important;
    }

    select.form-control-lux option {
        background-color: #16161a !important;
        color: #ffffff !important;
        padding: 10px !important;
    }

    .repeater-row {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .btn-lux {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        font-family: 'Cairo', sans-serif;
    }

    .btn-lux-primary { background: var(--primary-red); color: #fff; }
    .btn-lux-primary:hover { background: #d80000; transform: translateY(-2px); }
    .btn-lux-gold { background: rgba(215, 182, 74, 0.2); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; }
    .btn-lux-secondary { background: rgba(255, 255, 255, 0.08); color: var(--text-muted); }

    .btn-repeater-add {
        background: rgba(215, 182, 74, 0.12);
        color: var(--gold);
        border: 1px dashed var(--gold);
        width: 100%;
        padding: 0.8rem;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'Cairo', sans-serif;
        margin-top: 10px;
        transition: all 0.2s;
    }

    .btn-repeater-add:hover {
        background: rgba(215, 182, 74, 0.25);
    }

    .btn-remove-row {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.4);
        padding: 4px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 700;
        font-family: 'Cairo', sans-serif;
    }
</style>

<div class="project-form-page">
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #EF4444; color: #fca5a5; padding: 1.2rem; border-radius: 12px; margin-bottom: 2rem;">
            <div style="font-weight: 800; margin-bottom: 8px;"><i class="fa-solid fa-triangle-exclamation ml-2"></i> يرجى مراجعة الأخطاء التالية:</div>
            <ul style="padding-right: 20px; font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-head">
        <div>
            <h1 class="page-title">
                <i class="fa-solid fa-city" style="color:var(--gold);"></i>
                <span>إضافة مشروع عقاري جديد</span>
            </h1>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-top:4px;">
                أدخل كافة بيانات المشروع بدقة من نصوص وصور وخطط سداد ووحدات ليتم عرضه للعملاء بالمنصة.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.projects.index') }}" class="btn-lux btn-lux-secondary">
                <i class="fa-solid fa-arrow-right"></i>
                <span>العودة للمشاريع</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" id="projectCreateForm">
        @csrf

        {{-- شريط التابات --}}
        <div class="form-tabs">
            <button type="button" class="tab-btn active" onclick="switchTab('basic-tab', this)">
                <i class="fa-solid fa-info-circle"></i> 1. البيانات الأساسية
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('booking-tab', this)">
                <i class="fa-solid fa-phone"></i> 2. هاتف الحجز والواتساب
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('media-tab', this)">
                <i class="fa-solid fa-images"></i> 3. الصور والوسائط
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('plans-tab', this)">
                <i class="fa-solid fa-credit-card"></i> 4. خطط السداد
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('units-tab', this)">
                <i class="fa-solid fa-building"></i> 5. نماذج الوحدات
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('features-tab', this)">
                <i class="fa-solid fa-star"></i> 6. المميزات والخدمات
            </button>
        </div>

        {{-- 1. البيانات الأساسية --}}
        <div class="tab-pane active" id="basic-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-layer-group"></i> القطاع وهوية المشروع
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">القطاع العقاري التابع له *</label>
                        <select name="sector_id" class="form-control-lux" required>
                            <option value="">-- اختر القطاع --</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ old('sector_id') == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name_ar }} ({{ $sector->name_en }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">حالة المشروع الإنشائية *</label>
                        <select name="status" class="form-control-lux" required>
                            <option value="launched" {{ old('status') == 'launched' ? 'selected' : '' }}>تم الإطلاق والفتح للبيع (Launched)</option>
                            <option value="coming_soon" {{ old('status') == 'coming_soon' ? 'selected' : '' }}>قريباً (Coming Soon)</option>
                            <option value="under_construction" {{ old('status') == 'under_construction' ? 'selected' : '' }}>قيد الإنشاء والتشييد (Under Construction)</option>
                            <option value="immediate" {{ old('status') == 'immediate' ? 'selected' : '' }}>استلام فوري وجاهز للسكن (Immediate Delivery)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">اسم المشروع باللغة العربية *</label>
                        <input type="text" name="name_ar" value="{{ old('name_ar') }}" required placeholder="مثال: كمبوند النرجس ريزيدنس" class="form-control-lux">
                    </div>

                    <div class="form-group">
                        <label class="form-label">اسم المشروع باللغة الإنجليزية *</label>
                        <input type="text" name="name_en" value="{{ old('name_en') }}" required placeholder="e.g. Al Narges Residence" class="form-control-lux" style="direction:ltr; text-align:left;">
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">نطاق الأسعار / الميزانية (Price Budget)</label>
                        <input type="text" name="price_budget" value="{{ old('price_budget') }}" placeholder="مثال: يبدأ من 4,500,000 ج.م" class="form-control-lux">
                    </div>

                    <div class="form-group">
                        <label class="form-label">موعد التسليم والاستلام (Delivery Time)</label>
                        <input type="text" name="delivery_time" value="{{ old('delivery_time') }}" placeholder="مثال: استلام 2026 أو استلام فوري" class="form-control-lux">
                    </div>

                    <div class="form-group">
                        <label class="form-label">الموقع الجغرافي بالعربي</label>
                        <input type="text" name="location_ar" value="{{ old('location_ar') }}" placeholder="مثال: التجمع الخامس، القاهرة الجديدة" class="form-control-lux">
                    </div>

                    <div class="form-group">
                        <label class="form-label">الموقع بالإنجليزي</label>
                        <input type="text" name="location_en" value="{{ old('location_en') }}" placeholder="e.g. New Cairo, Fifth Settlement" class="form-control-lux" style="direction:ltr; text-align:left;">
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">خط العرض (Latitude - للخريطة)</label>
                        <input type="text" name="latitude" value="{{ old('latitude') }}" placeholder="30.0131" class="form-control-lux" style="direction:ltr; text-align:left;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">خط الطول (Longitude - للخريطة)</label>
                        <input type="text" name="longitude" value="{{ old('longitude') }}" placeholder="31.4913" class="form-control-lux" style="direction:ltr; text-align:left;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">ترتيب ظهور المشروع (Sort Order)</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control-lux">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label">الوصف التفصيلي للمشروع (باللغة العربية)</label>
                    <textarea name="description_ar" rows="4" placeholder="اكتب تفاصيل وموقع وأهمية المشروع الاستثمارية والسكنية..." class="form-control-lux">{{ old('description_ar') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">الوصف بالإنجليزي (Description EN)</label>
                    <textarea name="description_en" rows="3" placeholder="Project detailed overview in English..." class="form-control-lux" style="direction:ltr; text-align:left;">{{ old('description_en') }}</textarea>
                </div>

                <div style="display:flex; gap:25px; margin-top:1.5rem;">
                    <label style="display:flex; align-items:center; gap:8px; color:var(--text-main); cursor:pointer; font-weight:700;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="accent-color:var(--gold); width:18px; height:18px;">
                        <span>تفعيل ونشر المشروع في المنصة</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:8px; color:var(--text-main); cursor:pointer; font-weight:700;">
                        <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} style="accent-color:var(--gold); width:18px; height:18px;">
                        <span>مشروع مميز يظهر في الصفحة الرئيسية (Featured)</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- 2. هاتف الحجز والواتساب الخاص بالمشروع --}}
        <div class="tab-pane" id="booking-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-headset"></i> رقم هاتف وواتساب الحجز المخصص للمشروع
                </div>
                <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:1.5rem;">
                    يمكنك هنا تخصيص رقم هاتف ومسؤول مبيعات محدد لتلقي حجوزات هذا المشروع عبر واتساب. في حال تركه فارغاً، سيتم استخدام الرقم الافتراضي للشركة تلقائياً:
                    <strong style="color:var(--gold); direction:ltr; display:inline-block;">+{{ \App\Models\PlatformSetting::get('booking_whatsapp_number', '201032550422') }}</strong>.
                </p>

                <div class="form-group" style="max-width: 500px;">
                    <label class="form-label">رقم هاتف الحجز والواتساب للمشروع (مع كود الدولة)</label>
                    <input type="text" name="booking_phone" value="{{ old('booking_phone') }}" placeholder="مثال: 201012345678" class="form-control-lux" style="direction:ltr; text-align:left;">
                    <small style="color:var(--text-muted); display:block; margin-top:4px;">
                        اكتب الرقم بدون علامة + أو مسافات (مثال: 2010xxxxxxxx للرقم المصري).
                    </small>
                </div>
            </div>
        </div>

        {{-- 3. الصور والوسائط --}}
        <div class="tab-pane" id="media-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-photo-film"></i> صور المشروع والبانر الرئيسي
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">الصورة الرئيسية للمشروع (Main Banner Image) *</label>
                        <input type="file" name="image" accept="image/*" class="form-control-lux">
                        <small style="color:var(--text-muted);">يفضل صورة أفقية عالية الجودة بدقة 1920x1080.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">صورة الهوفر عند التمرير (Hover Image)</label>
                        <input type="file" name="hover_image" accept="image/*" class="form-control-lux">
                    </div>

                    <div class="form-group">
                        <label class="form-label">لوجو المشروع الخاص (Project Logo)</label>
                        <input type="file" name="logo" accept="image/*" class="form-control-lux">
                        <small style="color:var(--text-muted);">يفضل لوجو شفاف بصيغة PNG أو SVG.</small>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label class="form-label">معرض صور المشروع الإضافية (Gallery Images)</label>
                    <input type="file" name="gallery[]" multiple accept="image/*" class="form-control-lux">
                    <small style="color:var(--text-muted);">يمكنك اختيار أكثر من صورة معاً لتظهر في ألبوم ومعرض المشروع.</small>
                </div>
            </div>
        </div>

        {{-- 4. خطط السداد --}}
        <div class="tab-pane" id="plans-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-money-bill-wave"></i> خطط وأنظمة السداد للمشروع
                </div>
                <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:1.5rem;">
                    أضف أنظمة الدفع والتقسيط المتاحة للمشروع ليتمكن العميل من رؤيتها في صفحة المشروع.
                </p>

                <div id="plansContainer">
                    <div class="repeater-row">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span style="font-weight:700; color:var(--gold);">خطة سداد #1</span>
                            <button type="button" class="btn-remove-row" onclick="this.closest('.repeater-row').remove()">حذف الخطة</button>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">نسبة المقدم (Down Payment)</label>
                                <input type="text" name="plans[0][down_payment]" value="10%" placeholder="مثال: 10%" class="form-control-lux">
                            </div>
                            <div class="form-group">
                                <label class="form-label">سنوات التقسيط (Installment Years)</label>
                                <input type="text" name="plans[0][installment_years]" value="7 سنوات متساوية" placeholder="مثال: 7 سنوات متساوية" class="form-control-lux">
                            </div>
                            <div class="form-group">
                                <label class="form-label">نسبة الصيانة (Maintenance)</label>
                                <input type="text" name="plans[0][maintenance]" value="8%" placeholder="مثال: 8%" class="form-control-lux">
                            </div>
                            <div class="form-group">
                                <label class="form-label">ملاحظات إضافية على الخطة</label>
                                <input type="text" name="plans[0][notes]" placeholder="خصم خاص للكاش" class="form-control-lux">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-repeater-add" onclick="addPlanRow()">
                    <i class="fa-solid fa-plus"></i> إضافة خطة سداد أخرى
                </button>
            </div>
        </div>

        {{-- 5. نماذج الوحدات --}}
        <div class="tab-pane" id="units-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-cubes"></i> نماذج ومساحات الوحدات المتاحة بالمشروع
                </div>
                <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:1.5rem;">
                    حدد أنواع الوحدات المتوفرة (سكني، تجاري، إداري، طبي) ومساحاتها وأسعار المتر.
                </p>

                <div id="unitsContainer">
                    <div class="repeater-row">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span style="font-weight:700; color:var(--gold);">نوع الوحدة #1</span>
                            <button type="button" class="btn-remove-row" onclick="this.closest('.repeater-row').remove()">حذف الوحدة</button>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">نوع الوحدة العقارية *</label>
                                <select name="units[0][unit_type]" class="form-control-lux">
                                    <option value="residential">شقة سكنية (Residential Apartment)</option>
                                    <option value="villa">فيلا مستقلة (Standalone Villa)</option>
                                    <option value="duplex">دوبلكس فاخر (Duplex)</option>
                                    <option value="penthouse">بنتهاوس (Penthouse)</option>
                                    <option value="clinic">عيادة طبية (Medical Clinic)</option>
                                    <option value="office">مكتب إداري (Office Space)</option>
                                    <option value="commercial_shop">محل تجاري (Commercial Shop)</option>
                                    <option value="chalet">شاليه مصيفي (Chalet)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">الدور / الطابق</label>
                                <input type="text" name="units[0][floor]" placeholder="الأرضي / المتكرر" class="form-control-lux">
                            </div>

                            <div class="form-group">
                                <label class="form-label">المساحة المبدئية (م²)</label>
                                <input type="number" step="0.01" name="units[0][start_area]" placeholder="140" class="form-control-lux">
                            </div>

                            <div class="form-group">
                                <label class="form-label">سعر المتر التقريبي (ج.م)</label>
                                <input type="number" step="0.01" name="units[0][price_per_meter]" placeholder="45000" class="form-control-lux">
                            </div>

                            <div class="form-group">
                                <label class="form-label">السعر الإجمالي للوحدة (ج.م)</label>
                                <input type="number" step="0.01" name="units[0][unit_price]" placeholder="6300000" class="form-control-lux">
                            </div>

                            <div class="form-group">
                                <label class="form-label">نوع التشطيب</label>
                                <input type="text" name="units[0][finishing_type]" placeholder="تشطيب فاخر كامل" class="form-control-lux">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-repeater-add" onclick="addUnitRow()">
                    <i class="fa-solid fa-plus"></i> إضافة نموذج وحدة أخرى
                </button>
            </div>
        </div>

        {{-- 6. المميزات والخدمات --}}
        <div class="tab-pane" id="features-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-gem"></i> مميزات وخدمات المشروع (Features & Amenities)
                </div>

                <div id="featuresContainer">
                    <div class="repeater-row">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span style="font-weight:700; color:var(--gold);">ميزة #1</span>
                            <button type="button" class="btn-remove-row" onclick="this.closest('.repeater-row').remove()">حذف الميزة</button>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">اسم الميزة بالعربي</label>
                                <input type="text" name="features[0][title_ar]" value="أمن وحراسة 24/7" placeholder="أمن وحراسة 24/7" class="form-control-lux">
                            </div>
                            <div class="form-group">
                                <label class="form-label">اسم الميزة بالإنجليزي</label>
                                <input type="text" name="features[0][title_en]" value="24/7 Security" placeholder="24/7 Security" class="form-control-lux" style="direction:ltr; text-align:left;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">القيمة أو التفاصيل</label>
                                <input type="text" name="features[0][value]" value="مراقبة بكاميرات ذكية" placeholder="مراقبة بكاميرات ذكية" class="form-control-lux">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-repeater-add" onclick="addFeatureRow()">
                    <i class="fa-solid fa-plus"></i> إضافة ميزة أخرى
                </button>
            </div>
        </div>

        {{-- أزرار الإجراءات السفلية الثابتة --}}
        <div style="display:flex; justify-content:flex-end; gap:15px; margin-top:2rem; padding:1.5rem; background:var(--bg-card); border:1px solid var(--glass-border); border-radius:14px;">
            <a href="{{ route('admin.projects.index') }}" class="btn-lux btn-lux-secondary">إلغاء</a>
            <button type="submit" class="btn-lux btn-lux-primary" style="padding:0.85rem 2.2rem; font-size:1.05rem;">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>حفظ ونشر المشروع العقاري</span>
            </button>
        </div>
    </form>
</div>

<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

        btn.classList.add('active');
        const target = document.getElementById(tabId);
        if (target) target.classList.add('active');
    }

    let planIndex = 1;
    function addPlanRow() {
        const container = document.getElementById('plansContainer');
        const html = `
            <div class="repeater-row">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <span style="font-weight:700; color:var(--gold);">خطة سداد #${planIndex + 1}</span>
                    <button type="button" class="btn-remove-row" onclick="this.closest('.repeater-row').remove()">حذف الخطة</button>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">نسبة المقدم (Down Payment)</label>
                        <input type="text" name="plans[${planIndex}][down_payment]" placeholder="مثال: 15%" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">سنوات التقسيط (Installment Years)</label>
                        <input type="text" name="plans[${planIndex}][installment_years]" placeholder="مثال: 8 سنوات" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">نسبة الصيانة (Maintenance)</label>
                        <input type="text" name="plans[${planIndex}][maintenance]" placeholder="مثال: 8%" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">ملاحظات إضافية على الخطة</label>
                        <input type="text" name="plans[${planIndex}][notes]" class="form-control-lux">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        planIndex++;
    }

    let unitIndex = 1;
    function addUnitRow() {
        const container = document.getElementById('unitsContainer');
        const html = `
            <div class="repeater-row">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <span style="font-weight:700; color:var(--gold);">نوع الوحدة #${unitIndex + 1}</span>
                    <button type="button" class="btn-remove-row" onclick="this.closest('.repeater-row').remove()">حذف الوحدة</button>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">نوع الوحدة العقارية *</label>
                        <select name="units[${unitIndex}][unit_type]" class="form-control-lux">
                            <option value="residential">شقة سكنية (Residential Apartment)</option>
                            <option value="villa">فيلا مستقلة (Standalone Villa)</option>
                            <option value="duplex">دوبلكس فاخر (Duplex)</option>
                            <option value="penthouse">بنتهاوس (Penthouse)</option>
                            <option value="clinic">عيادة طبية (Medical Clinic)</option>
                            <option value="office">مكتب إداري (Office Space)</option>
                            <option value="commercial_shop">محل تجاري (Commercial Shop)</option>
                            <option value="chalet">شاليه مصيفي (Chalet)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">الدور / الطابق</label>
                        <input type="text" name="units[${unitIndex}][floor]" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">المساحة المبدئية (م²)</label>
                        <input type="number" step="0.01" name="units[${unitIndex}][start_area]" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">سعر المتر التقريبي (ج.م)</label>
                        <input type="number" step="0.01" name="units[${unitIndex}][price_per_meter]" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">السعر الإجمالي للوحدة (ج.م)</label>
                        <input type="number" step="0.01" name="units[${unitIndex}][unit_price]" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">نوع التشطيب</label>
                        <input type="text" name="units[${unitIndex}][finishing_type]" class="form-control-lux">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        unitIndex++;
    }

    let featureIndex = 1;
    function addFeatureRow() {
        const container = document.getElementById('featuresContainer');
        const html = `
            <div class="repeater-row">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <span style="font-weight:700; color:var(--gold);">ميزة #${featureIndex + 1}</span>
                    <button type="button" class="btn-remove-row" onclick="this.closest('.repeater-row').remove()">حذف الميزة</button>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">اسم الميزة بالعربي</label>
                        <input type="text" name="features[${featureIndex}][title_ar]" class="form-control-lux">
                    </div>
                    <div class="form-group">
                        <label class="form-label">اسم الميزة بالإنجليزي</label>
                        <input type="text" name="features[${featureIndex}][title_en]" class="form-control-lux" style="direction:ltr; text-align:left;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">القيمة أو التفاصيل</label>
                        <input type="text" name="features[${featureIndex}][value]" class="form-control-lux">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        featureIndex++;
    }
</script>
@endsection
