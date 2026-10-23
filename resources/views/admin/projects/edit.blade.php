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

    .thumb-preview-box {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
        background: rgba(0, 0, 0, 0.25);
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid var(--glass-border);
    }

    .thumb-preview-box img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--gold);
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
                <i class="fa-solid fa-pen-to-square" style="color:var(--gold);"></i>
                <span>تعديل مشروع: {{ $project->name_ar }}</span>
            </h1>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-top:4px;">
                قم بتحديث بيانات المشروع، أرقام الحجز، الصور، الوحدات وخطط السداد.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('projects.show', $project->id) }}" target="_blank" class="btn-lux btn-lux-gold">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>معاينة في المنصة</span>
            </a>
            <a href="{{ route('admin.projects.index') }}" class="btn-lux btn-lux-secondary">
                <i class="fa-solid fa-arrow-right"></i>
                <span>العودة للمشاريع</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" id="projectEditForm">
        @csrf
        @method('PUT')

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
            <button type="button" class="tab-btn" onclick="switchTab('units-tab', this)">
                <i class="fa-solid fa-door-open"></i> 4. أنواع الوحدات ({{ $project->unitTypes->count() }})
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('plans-tab', this)">
                <i class="fa-solid fa-file-invoice-dollar"></i> 5. أنظمة السداد ({{ $project->paymentPlans->count() }})
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('features-tab', this)">
                <i class="fa-solid fa-star"></i> 6. المميزات والخدمات ({{ $project->features->count() }})
            </button>
        </div>

        {{-- تاب 1: البيانات الأساسية --}}
        <div class="tab-pane active" id="basic-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-building"></i>
                    <span>معلومات المشروع الرئيسية</span>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">القطاع العقاري <span style="color:var(--primary-red);">*</span></label>
                        <select name="sector_id" class="form-control-lux" required>
                            <option value="">-- اختر القطاع --</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ old('sector_id', $project->sector_id) == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name_ar }} ({{ $sector->name_en }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">اسم المشروع (عربي) <span style="color:var(--primary-red);">*</span></label>
                        <input type="text" name="name_ar" class="form-control-lux" value="{{ old('name_ar', $project->name_ar) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">اسم المشروع (إنجليزي) <span style="color:var(--primary-red);">*</span></label>
                        <input type="text" name="name_en" class="form-control-lux" value="{{ old('name_en', $project->name_en) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">مستوى الأسعار / الميزانية التقديرية</label>
                        <input type="text" name="price_budget" class="form-control-lux" value="{{ old('price_budget', $project->price_budget) }}" placeholder="مثال: يبدأ من 4,500,000 ج.م">
                    </div>

                    <div class="form-group">
                        <label class="form-label">موعد التسليم</label>
                        <input type="text" name="delivery_time" class="form-control-lux" value="{{ old('delivery_time', $project->delivery_time) }}" placeholder="مثال: 2026 أو تسليم فوري">
                    </div>

                    <div class="form-group">
                        <label class="form-label">حالة المشروع</label>
                        <select name="status" class="form-control-lux">
                            <option value="launched" {{ old('status', $project->status) == 'launched' ? 'selected' : '' }}>متاح للحجز والبيع (Launched)</option>
                            <option value="under_construction" {{ old('status', $project->status) == 'under_construction' ? 'selected' : '' }}>تحت الإنشاء (Under Construction)</option>
                            <option value="ready" {{ old('status', $project->status) == 'ready' ? 'selected' : '' }}>جاهز للتسليم (Ready to Move)</option>
                            <option value="sold_out" {{ old('status', $project->status) == 'sold_out' ? 'selected' : '' }}>تم البيع بالكامل (Sold Out)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ترتيب الظهور</label>
                        <input type="number" name="sort_order" class="form-control-lux" value="{{ old('sort_order', $project->sort_order) }}" min="0">
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group" style="display:flex; align-items:center; gap:12px; margin-top:1.5rem;">
                        <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }} style="width:20px; height:20px; accent-color:var(--gold); cursor:pointer;">
                        <label for="featured" style="cursor:pointer; font-weight:700; color:var(--text-main);">مشروع مميز (يظهر في صدارة الموقع)</label>
                    </div>

                    <div class="form-group" style="display:flex; align-items:center; gap:12px; margin-top:1.5rem;">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }} style="width:20px; height:20px; accent-color:var(--primary-red); cursor:pointer;">
                        <label for="is_active" style="cursor:pointer; font-weight:700; color:var(--text-main);">تفعيل المشروع (نشط ومعروض للجمهور)</label>
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label">وصف المشروع الكامل (عربي)</label>
                        <textarea name="description_ar" rows="4" class="form-control-lux">{{ old('description_ar', $project->description_ar) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">وصف المشروع الكامل (إنجليزي)</label>
                        <textarea name="description_en" rows="4" class="form-control-lux">{{ old('description_en', $project->description_en) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- تاب 2: هاتف الحجز والواتساب والموقع --}}
        <div class="tab-pane" id="booking-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-headset"></i>
                    <span>إعدادات التواصل وحجز المشروع والموقع الجغرافي</span>
                </div>
                
                <div style="background:rgba(215, 182, 74, 0.08); border:1px solid rgba(215, 182, 74, 0.25); border-radius:12px; padding:1.2rem; margin-bottom:1.5rem;">
                    <h4 style="color:var(--gold); font-size:1rem; margin-bottom:6px;"><i class="fa-solid fa-bolt"></i> تحكم إدارة المنصة في رقم الحجز</h4>
                    <p style="font-size:0.88rem; color:var(--text-muted); margin:0;">
                        إذا تركت هذا الحقل فارغاً، سيتم تلقائياً استخدام رقم هاتف المنصة الافتراضي ({{ \App\Models\PlatformSetting::get('booking_whatsapp_number', '201032550422') }}). إذا أدخلت رقماً هنا فسيتم تخصيصه لهذا المشروع بالكامل.
                    </p>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">رقم هاتف الحجز والواتساب الخاص بالمشروع (مباشر)</label>
                        <input type="text" name="booking_phone" class="form-control-lux" value="{{ old('booking_phone', $project->booking_phone) }}" placeholder="مثال: 201032550422 أو 01012345678" dir="ltr" style="text-align:left;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">جملة الحقوق والترخيص (عربي)</label>
                        <input type="text" name="copyright_sentence_ar" class="form-control-lux" value="{{ old('copyright_sentence_ar', $project->copyright_sentence_ar) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">جملة الحقوق والترخيص (إنجليزي)</label>
                        <input type="text" name="copyright_sentence_en" class="form-control-lux" value="{{ old('copyright_sentence_en', $project->copyright_sentence_en) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">الموقع الجغرافي / المدينة (عربي)</label>
                        <input type="text" name="location_ar" class="form-control-lux" value="{{ old('location_ar', $project->location_ar) }}" placeholder="مثال: التجمع الخامس، القاهرة الجديدة">
                    </div>

                    <div class="form-group">
                        <label class="form-label">الموقع الجغرافي / المدينة (إنجليزي)</label>
                        <input type="text" name="location_en" class="form-control-lux" value="{{ old('location_en', $project->location_en) }}" placeholder="e.g. New Cairo, 5th Settlement">
                    </div>

                    <div class="form-group">
                        <label class="form-label">إحداثيات خط العرض (Latitude)</label>
                        <input type="text" name="latitude" class="form-control-lux" value="{{ old('latitude', $project->latitude) }}" placeholder="مثال: 30.0131">
                    </div>

                    <div class="form-group">
                        <label class="form-label">إحداثيات خط الطول (Longitude)</label>
                        <input type="text" name="longitude" class="form-control-lux" value="{{ old('longitude', $project->longitude) }}" placeholder="مثال: 31.4989">
                    </div>
                </div>
            </div>
        </div>

        {{-- تاب 3: الصور والوسائط --}}
        <div class="tab-pane" id="media-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-photo-film"></i>
                    <span>الصور والوسائط المرئية</span>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">الصورة الرئيسية للمشروع (Cover)</label>
                        <input type="file" name="image" class="form-control-lux" accept="image/*">
                        @if ($project->image)
                            <div class="thumb-preview-box">
                                <img src="{{ asset('images/projects/' . $project->image) }}" alt="Cover">
                                <span style="font-size:0.85rem; color:var(--text-muted);">الصورة الحالية مستخدمة كغلاف للمشروع</span>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">صورة التمرير (Hover Image)</label>
                        <input type="file" name="hover_image" class="form-control-lux" accept="image/*">
                        @if ($project->hover_image)
                            <div class="thumb-preview-box">
                                <img src="{{ asset('images/projects/' . $project->hover_image) }}" alt="Hover">
                                <span style="font-size:0.85rem; color:var(--text-muted);">الصورة البديلة الحالية</span>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">شعار المشروع (Logo)</label>
                        <input type="file" name="logo" class="form-control-lux" accept="image/*">
                        @if ($project->logo)
                            <div class="thumb-preview-box">
                                <img src="{{ asset('images/projects/' . $project->logo) }}" alt="Logo">
                                <span style="font-size:0.85rem; color:var(--text-muted);">شعار المشروع الحالي</span>
                            </div>
                        @endif
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">إضافة صور لمعرض المشروع (Gallery Images)</label>
                        <input type="file" name="gallery[]" class="form-control-lux" multiple accept="image/*">
                        @if ($project->images && $project->images->count() > 0)
                            <div style="margin-top:12px;">
                                <div style="font-size:0.85rem; color:var(--gold); margin-bottom:8px;">معرض الصور الحالي ({{ $project->images->count() }} صورة):</div>
                                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                    @foreach ($project->images as $pImg)
                                        <div style="width:70px; height:70px; border-radius:8px; overflow:hidden; border:1px solid var(--glass-border);">
                                            <img src="{{ asset($pImg->image) }}" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- تاب 4: أنواع الوحدات والمخزون --}}
        <div class="tab-pane" id="units-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-shapes"></i>
                    <span>أنواع الوحدات المتاحة بالمشروع</span>
                </div>
                <div id="units-repeater-container">
                    @forelse($project->unitTypes as $idx => $u)
                        <div class="repeater-row" data-row-index="{{ $idx }}">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:var(--gold); font-size:0.95rem;">وحدة #{{ $idx + 1 }}</strong>
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">نوع الوحدة</label>
                                    <input type="text" name="units[{{ $idx }}][unit_type]" class="form-control-lux" value="{{ $u->unit_type }}" placeholder="مثال: شقة سكنية / دوبلكس / بنتهاوس / فيلا">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">المساحة تبدأ من (م²)</label>
                                    <input type="text" name="units[{{ $idx }}][start_area]" class="form-control-lux" value="{{ $u->area }}" placeholder="مثال: 145 م²">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">الدور / الطابق</label>
                                    <input type="text" name="units[{{ $idx }}][floor]" class="form-control-lux" value="{{ $u->floor }}" placeholder="مثال: من الأول حتى الخامس">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">سعر المتر التقديري</label>
                                    <input type="text" name="units[{{ $idx }}][price_per_meter]" class="form-control-lux" value="{{ $u->price_per_meter }}" placeholder="مثال: 32,000 ج.م">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">سعر الوحدة الإجمالي (يبدأ من)</label>
                                    <input type="text" name="units[{{ $idx }}][unit_price]" class="form-control-lux" value="{{ $u->unit_price }}" placeholder="مثال: 4,640,000 ج.م">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">نوع التشطيب</label>
                                    <input type="text" name="units[{{ $idx }}][finishing_type]" class="form-control-lux" value="{{ $u->finishing_type }}" placeholder="مثال: تشطيب كامل سوبر لوكس / نصف تشطيب">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="repeater-row" data-row-index="0">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:var(--gold); font-size:0.95rem;">وحدة #1</strong>
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">نوع الوحدة</label>
                                    <input type="text" name="units[0][unit_type]" class="form-control-lux" placeholder="مثال: شقة سكنية / دوبلكس / بنتهاوس / فيلا">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">المساحة تبدأ من (م²)</label>
                                    <input type="text" name="units[0][start_area]" class="form-control-lux" placeholder="مثال: 145 م²">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">الدور / الطابق</label>
                                    <input type="text" name="units[0][floor]" class="form-control-lux" placeholder="مثال: من الأول حتى الخامس">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">سعر المتر التقديري</label>
                                    <input type="text" name="units[0][price_per_meter]" class="form-control-lux" placeholder="مثال: 32,000 ج.م">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">سعر الوحدة الإجمالي (يبدأ من)</label>
                                    <input type="text" name="units[0][unit_price]" class="form-control-lux" placeholder="مثال: 4,640,000 ج.م">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">نوع التشطيب</label>
                                    <input type="text" name="units[0][finishing_type]" class="form-control-lux" placeholder="مثال: تشطيب كامل سوبر لوكس / نصف تشطيب">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn-repeater-add" onclick="addUnitRow()">
                    <i class="fa-solid fa-plus"></i> إضافة نوع وحدة جديد
                </button>
            </div>
        </div>

        {{-- تاب 5: خطط السداد وتسهيلات الدفع --}}
        <div class="tab-pane" id="plans-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>خطط السداد والتقسيط المتاحة</span>
                </div>
                <div id="plans-repeater-container">
                    @forelse($project->paymentPlans as $idx => $p)
                        <div class="repeater-row" data-row-index="{{ $idx }}">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:var(--gold); font-size:0.95rem;">نظام سداد #{{ $idx + 1 }}</strong>
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">المقدم المطلوب (%)</label>
                                    <input type="text" name="plans[{{ $idx }}][down_payment]" class="form-control-lux" value="{{ $p->down_payment }}" placeholder="مثال: 10% أو 15%">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">سنوات التقسيط</label>
                                    <input type="text" name="plans[{{ $idx }}][installment_years]" class="form-control-lux" value="{{ $p->installment_years }}" placeholder="مثال: 7 سنوات أو 8 سنوات متساوية">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">وديعة الصيانة (%)</label>
                                    <input type="text" name="plans[{{ $idx }}][maintenance]" class="form-control-lux" value="{{ $p->maintenance }}" placeholder="مثال: 8%">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ملاحظات خطة السداد</label>
                                    <input type="text" name="plans[{{ $idx }}][notes]" class="form-control-lux" value="{{ $p->notes }}" placeholder="مثال: أقساط ربع سنوية متساوية">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="repeater-row" data-row-index="0">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:var(--gold); font-size:0.95rem;">نظام سداد #1</strong>
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">المقدم المطلوب (%)</label>
                                    <input type="text" name="plans[0][down_payment]" class="form-control-lux" placeholder="مثال: 10% أو 15%">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">سنوات التقسيط</label>
                                    <input type="text" name="plans[0][installment_years]" class="form-control-lux" placeholder="مثال: 7 سنوات أو 8 سنوات متساوية">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">وديعة الصيانة (%)</label>
                                    <input type="text" name="plans[0][maintenance]" class="form-control-lux" placeholder="مثال: 8%">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ملاحظات خطة السداد</label>
                                    <input type="text" name="plans[0][notes]" class="form-control-lux" placeholder="مثال: أقساط ربع سنوية متساوية">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn-repeater-add" onclick="addPlanRow()">
                    <i class="fa-solid fa-plus"></i> إضافة نظام سداد جديد
                </button>
            </div>
        </div>

        {{-- تاب 6: المميزات والخدمات --}}
        <div class="tab-pane" id="features-tab">
            <div class="form-section-card">
                <div class="form-section-title">
                    <i class="fa-solid fa-star"></i>
                    <span>المميزات والخدمات المرفقة بالمشروع</span>
                </div>
                <div id="features-repeater-container">
                    @forelse($project->features as $idx => $f)
                        <div class="repeater-row" data-row-index="{{ $idx }}">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:var(--gold); font-size:0.95rem;">ميزة #{{ $idx + 1 }}</strong>
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">اسم الميزة (عربي)</label>
                                    <input type="text" name="features[{{ $idx }}][title_ar]" class="form-control-lux" value="{{ $f->title_ar }}" placeholder="مثال: مساحات خضراء شاسعة / حمامات سباحة">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">اسم الميزة (إنجليزي)</label>
                                    <input type="text" name="features[{{ $idx }}][title_en]" class="form-control-lux" value="{{ $f->title_en }}" placeholder="e.g. Green Spaces / Swimming Pools">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">القيمة أو التفاصيل (اختياري)</label>
                                    <input type="text" name="features[{{ $idx }}][value]" class="form-control-lux" value="{{ $f->value }}" placeholder="مثال: 70% من المساحة">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="repeater-row" data-row-index="0">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:var(--gold); font-size:0.95rem;">ميزة #1</strong>
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                    <i class="fa-solid fa-trash"></i> حذف
                                </button>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">اسم الميزة (عربي)</label>
                                    <input type="text" name="features[0][title_ar]" class="form-control-lux" placeholder="مثال: مساحات خضراء شاسعة / حمامات سباحة">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">اسم الميزة (إنجليزي)</label>
                                    <input type="text" name="features[0][title_en]" class="form-control-lux" placeholder="e.g. Green Spaces / Swimming Pools">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">القيمة أو التفاصيل (اختياري)</label>
                                    <input type="text" name="features[0][value]" class="form-control-lux" placeholder="مثال: 70% من المساحة">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn-repeater-add" onclick="addFeatureRow()">
                    <i class="fa-solid fa-plus"></i> إضافة ميزة جديدة
                </button>
            </div>
        </div>

        {{-- شريط الإجراءات السفلي --}}
        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:2rem; padding:1.5rem; background:var(--bg-card); border:1px solid var(--glass-border); border-radius:14px;">
            <a href="{{ route('admin.projects.index') }}" class="btn-lux btn-lux-secondary">
                <i class="fa-solid fa-xmark"></i> إلغاء
            </a>
            <button type="submit" class="btn-lux btn-lux-primary" style="font-size:1.05rem; padding:0.85rem 2.2rem;">
                <i class="fa-solid fa-cloud-arrow-up"></i> حفظ تحديثات المشروع الآن
            </button>
        </div>
    </form>
</div>

<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        const targetPane = document.getElementById(tabId);
        if (targetPane) {
            targetPane.classList.add('active');
        }
        btn.classList.add('active');
    }

    let unitCount = {{ max(1, $project->unitTypes->count()) }};
    function addUnitRow() {
        const container = document.getElementById('units-repeater-container');
        const div = document.createElement('div');
        div.className = 'repeater-row';
        div.dataset.rowIndex = unitCount;
        div.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <strong style="color:var(--gold); font-size:0.95rem;">وحدة #${unitCount + 1}</strong>
                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                    <i class="fa-solid fa-trash"></i> حذف
                </button>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">نوع الوحدة</label>
                    <input type="text" name="units[${unitCount}][unit_type]" class="form-control-lux" placeholder="مثال: شقة سكنية / دوبلكس / بنتهاوس / فيلا">
                </div>
                <div class="form-group">
                    <label class="form-label">المساحة تبدأ من (م²)</label>
                    <input type="text" name="units[${unitCount}][start_area]" class="form-control-lux" placeholder="مثال: 145 م²">
                </div>
                <div class="form-group">
                    <label class="form-label">الدور / الطابق</label>
                    <input type="text" name="units[${unitCount}][floor]" class="form-control-lux" placeholder="مثال: من الأول حتى الخامس">
                </div>
                <div class="form-group">
                    <label class="form-label">سعر المتر التقديري</label>
                    <input type="text" name="units[${unitCount}][price_per_meter]" class="form-control-lux" placeholder="مثال: 32,000 ج.م">
                </div>
                <div class="form-group">
                    <label class="form-label">سعر الوحدة الإجمالي (يبدأ من)</label>
                    <input type="text" name="units[${unitCount}][unit_price]" class="form-control-lux" placeholder="مثال: 4,640,000 ج.م">
                </div>
                <div class="form-group">
                    <label class="form-label">نوع التشطيب</label>
                    <input type="text" name="units[${unitCount}][finishing_type]" class="form-control-lux" placeholder="مثال: تشطيب كامل سوبر لوكس / نصف تشطيب">
                </div>
            </div>
        `;
        container.appendChild(div);
        unitCount++;
    }

    let planCount = {{ max(1, $project->paymentPlans->count()) }};
    function addPlanRow() {
        const container = document.getElementById('plans-repeater-container');
        const div = document.createElement('div');
        div.className = 'repeater-row';
        div.dataset.rowIndex = planCount;
        div.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <strong style="color:var(--gold); font-size:0.95rem;">نظام سداد #${planCount + 1}</strong>
                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                    <i class="fa-solid fa-trash"></i> حذف
                </button>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">المقدم المطلوب (%)</label>
                    <input type="text" name="plans[${planCount}][down_payment]" class="form-control-lux" placeholder="مثال: 10% أو 15%">
                </div>
                <div class="form-group">
                    <label class="form-label">سنوات التقسيط</label>
                    <input type="text" name="plans[${planCount}][installment_years]" class="form-control-lux" placeholder="مثال: 7 سنوات أو 8 سنوات متساوية">
                </div>
                <div class="form-group">
                    <label class="form-label">وديعة الصيانة (%)</label>
                    <input type="text" name="plans[${planCount}][maintenance]" class="form-control-lux" placeholder="مثال: 8%">
                </div>
                <div class="form-group">
                    <label class="form-label">ملاحظات خطة السداد</label>
                    <input type="text" name="plans[${planCount}][notes]" class="form-control-lux" placeholder="مثال: أقساط ربع سنوية متساوية">
                </div>
            </div>
        `;
        container.appendChild(div);
        planCount++;
    }

    let featureCount = {{ max(1, $project->features->count()) }};
    function addFeatureRow() {
        const container = document.getElementById('features-repeater-container');
        const div = document.createElement('div');
        div.className = 'repeater-row';
        div.dataset.rowIndex = featureCount;
        div.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <strong style="color:var(--gold); font-size:0.95rem;">ميزة #${featureCount + 1}</strong>
                <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                    <i class="fa-solid fa-trash"></i> حذف
                </button>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">اسم الميزة (عربي)</label>
                    <input type="text" name="features[${featureCount}][title_ar]" class="form-control-lux" placeholder="مثال: مساحات خضراء شاسعة / حمامات سباحة">
                </div>
                <div class="form-group">
                    <label class="form-label">اسم الميزة (إنجليزي)</label>
                    <input type="text" name="features[${featureCount}][title_en]" class="form-control-lux" placeholder="e.g. Green Spaces / Swimming Pools">
                </div>
                <div class="form-group">
                    <label class="form-label">القيمة أو التفاصيل (اختياري)</label>
                    <input type="text" name="features[${featureCount}][value]" class="form-control-lux" placeholder="مثال: 70% من المساحة">
                </div>
            </div>
        `;
        container.appendChild(div);
        featureCount++;
    }

    function removeRow(btn) {
        const row = btn.closest('.repeater-row');
        if (row) {
            row.remove();
        }
    }
</script>
@endsection
