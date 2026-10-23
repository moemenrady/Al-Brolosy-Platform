@extends('layouts.admin')

@section('content')
    <style>
        /* ========================================= */
        /* تنسيقات إضافية للوحة النموذج المدمجة والتجاوب */
        /* ========================================= */

        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2.5rem;
            display: none;
            /* مخفي افتراضياً ويظهر بسلاسة عند الطلب */
            overflow: hidden;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            padding: 1.5rem;
            background: linear-gradient(to right, rgba(180, 0, 0, 0.03), rgba(212, 175, 55, 0.03));
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-tabs {
            display: flex;
            gap: 5px;
            background: rgba(0, 0, 0, 0.05);
            padding: 5px;
            border-radius: 10px;
            margin: 1.5rem;
            overflow-x: auto;
        }

        html[data-theme="dark"] .form-tabs {
            background: rgba(255, 255, 255, 0.02);
        }

        .tab-btn {
            flex: 1;
            min-width: 120px;
            padding: 0.8rem;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            cursor: pointer;
            border-radius: 8px;
            transition: all var(--transition-speed);
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .tab-btn.active {
            background: var(--bg-card);
            color: var(--gold);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--glass-border);
        }

        .tab-content {
            padding: 1.5rem;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* شبكة الحقول الاحترافية */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .form-control {
            background: rgba(0, 0, 0, 0.02);
            border: 1px solid var(--glass-border);
            padding: 0.8rem 1rem;
            border-radius: 8px;
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.95rem;
            transition: all var(--transition-speed);
            width: 100%;
        }

        html[data-theme="dark"] .form-control {
            background: rgba(255, 255, 255, 0.02);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.1);
        }

        /* أقسام الإدخال الديناميكي المتجاوبة (الوحدات، خطط السداد..) */
        .dynamic-section {
            background: rgba(0, 0, 0, 0.01);
            border: 1px dashed var(--glass-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        html[data-theme="dark"] .dynamic-section {
            background: rgba(255, 255, 255, 0.005);
        }

        .dynamic-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)) 45px;
            gap: 1rem;
            align-items: end;
            background: var(--bg-card);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid var(--glass-border);
        }

        .btn-action-red {
            background: rgba(180, 0, 0, 0.1);
            color: var(--primary-red);
            border: 1px solid rgba(180, 0, 0, 0.2);
            width: 42px;
            height: 42px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed);
        }

        .btn-action-red:hover {
            background: var(--primary-red);
            color: #fff;
        }

        .btn-secondary-outline {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            transition: all var(--transition-speed);
        }

        .btn-secondary-outline:hover {
            background: var(--admin-hover);
        }

        /* معاينة الصور الحالية للمشروع عند التعديل */
        .img-preview-box {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .img-thumb-wrapper {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
        }

        .img-thumb-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* تنسيقات الجدول والصفحة الحالية */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .btn-gold {
            background: var(--gold);
            color: #000;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all var(--transition-speed);
            border: none;
            cursor: pointer;
        }

        .btn-gold:hover {
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .premium-table th,
        .premium-table td {
            padding: 1.2rem 1.5rem;
            text-align: start;
            border-bottom: 1px solid var(--glass-border);
        }

        html[dir="rtl"] .premium-table th,
        html[dir="rtl"] .premium-table td {
            text-align: right;
        }

        .premium-table th {
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            background: rgba(15, 23, 42, 0.02);
        }

        .premium-table tbody tr {
            transition: background var(--transition-speed);
        }

        .premium-table tbody tr:hover {
            background: var(--admin-hover);
        }

        .project-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .project-thumb {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: var(--admin-accent);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .project-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-sector {
            background: var(--admin-accent);
            color: var(--text-main);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            border: 1px solid var(--glass-border);
            font-weight: 500;
        }

        .action-group {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            border: 1px solid var(--glass-border);
            background: transparent;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed);
            text-decoration: none;
        }

        .btn-icon:hover {
            background: var(--admin-hover);
            color: var(--gold);
            border-color: var(--gold);
        }

        .btn-icon.delete:hover {
            color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .toggle-featured-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--glass-border);
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .toggle-featured-btn.active {
            color: var(--gold);
            text-shadow: 0 0 12px rgba(212, 175, 55, 0.6);
        }

        /* توافق شاشات الموبايل الصغيرة جداً للـ Form الخارجي */
        @media (max-width: 576px) {
            .dynamic-row {
                grid-template-columns: 1fr;
                gap: 0.8rem;
            }

            .btn-action-red {
                width: 100%;
            }

            .form-tabs {
                flex-direction: row;
            }
        }
    </style>

    <div class="page-header">
        <div>
            <h2 style="font-family: 'Playfair Display', serif; color: var(--gold); margin-bottom: 0.5rem;"
                data-en="Real Estate Projects" data-ar="المشاريع العقارية">Real Estate Projects</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem;"
                data-en="Manage all your projects, units, and inventory seamlessly."
                data-ar="إدارة جميع مشاريعك، الوحدات، والمخزون العقاري بسهولة.">
                Manage all your projects, units, and inventory seamlessly.
            </p>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="btn-gold" id="topActionBtn">
            <i class="fa-solid fa-plus"></i>
            <span data-en="Add New Project" data-ar="إضافة مشروع جديد">إضافة مشروع جديد</span>
        </a>
    </div>

    @if (session('success'))
        <div
            style="background: rgba(46, 204, 113, 0.1); border-left: 4px solid #2ecc71; padding: 1rem; margin-bottom: 2rem; border-radius: 4px; color: #2ecc71;">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="form-card" id="projectFormPanel">
        <div class="form-header">
            <h3 id="formPanelTitle" style="color: var(--gold);" data-en="Create New Project" data-ar="إضافة مشروع جديد">
                إضافة مشروع جديد</h3>
            <button type="button" class="btn-icon delete" onclick="closeFormPanel()" title="Close"><i
                    class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="form-tabs">
            <button type="button" class="tab-btn active" onclick="switchFormTab(this, 'basic-tab')" data-en="Basic Info"
                data-ar="البيانات الأساسية">البيانات الأساسية</button>
            <button type="button" class="tab-btn" onclick="switchFormTab(this, 'media-tab')" data-en="Media Assets"
                data-ar="الوسائط والصور">الوسائط والصور</button>
            <button type="button" class="tab-btn" onclick="switchFormTab(this, 'units-tab')" data-en="Units (Inventory)"
                data-ar="الوحدات والمخزون">الوحدات والمخزون</button>
            <button type="button" class="tab-btn" onclick="switchFormTab(this, 'plans-tab')" data-en="Payment & Features"
                data-ar="خطط السداد والمميزات">خطط السداد والمميزات</button>
        </div>

        <form id="projectCrudForm" action="{{ route('admin.projects.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formActionMethod" value="POST">

            <div id="basic-tab" class="tab-content active">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" data-en="Sector" data-ar="القطاع المطلوب">القطاع</label>
                        <select name="sector_id" id="field_sector_id" class="form-control" required>
                            <option value="">-- Select Sector --</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}">
                                    {{ app()->getLocale() == 'ar' ? $sector->name_ar : $sector->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Project Name (AR)" data-ar="اسم المشروع بالكامل (عربي)">اسم
                            المشروع (عربي)</label>
                        <input type="text" name="name_ar" id="field_name_ar" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Project Name (EN)" data-ar="اسم المشروع بالكامل (إنجليزي)">اسم
                            المشروع (إنجليزي)</label>
                        <input type="text" name="name_en" id="field_name_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Location (AR)" data-ar="الموقع بالتفصيل (عربي)">الموقع
                            (عربي)</label>
                        <input type="text" name="location_ar" id="field_location_ar" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Location (EN)" data-ar="الموقع بالتفصيل (إنجليزي)">الموقع
                            (إنجليزي)</label>
                        <input type="text" name="location_en" id="field_location_en" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Latitude"
                            data-ar="إحداثيات خط العرض (GPS Latitude)">Latitude</label>
                        <input type="number" step="any" name="latitude" id="field_latitude" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Longitude"
                            data-ar="إحداثيات خط الطول (GPS Longitude)">Longitude</label>
                        <input type="number" step="any" name="longitude" id="field_longitude"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Price Budget" data-ar="ميزانية السعر البدائي">الميزانية /
                            السعر</label>
                        <input type="text" name="price_budget" id="field_price_budget" class="form-control"
                            placeholder="e.g. 3,000,000 EGP">
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Project Status"
                            data-ar="حالة المشروع الإنشائية">الحالة</label>
                        <select name="status" id="field_status" class="form-control">
                            <option value="coming_soon">Coming Soon</option>
                            <option value="launched">Launched</option>
                            <option value="under_construction">Under Construction</option>
                            <option value="immediate">Immediate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Delivery Time" data-ar="تاريخ أو مدة التسليم">موعد
                            التسليم</label>
                        <input type="text" name="delivery_time" id="field_delivery_time" class="form-control"
                            placeholder="e.g. 2027 / 3 Years">
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Sort Order" data-ar="ترتيب العرض">ترتيب العرض</label>
                        <input type="number" name="sort_order" id="field_sort_order" value="0"
                            class="form-control">
                    </div>
                    <div class="form-group" style="flex-direction:row; gap:20px; align-items:center; margin-top:25px;">
                        <label><input type="checkbox" name="featured" id="field_featured" value="1"> <span
                                data-en="Featured" data-ar="تميز المشروع">تميز المشروع</span></label>
                        <label><input type="checkbox" name="is_active" id="field_is_active" value="1" checked>
                            <span data-en="Active" data-ar="تفعيل المشروع">نشط</span></label>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" data-en="Description (AR)" data-ar="وصف تفصيلي للمشروع (عربي)">الوصف
                            (عربي)</label>
                        <textarea name="description_ar" id="field_description_ar" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" data-en="Description (EN)" data-ar="وصف تفصيلي للمشروع (إنجليزي)">الوصف
                            (إنجليزي)</label>
                        <textarea name="description_en" id="field_description_en" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" data-en="Copyright Sentence (AR)"
                            data-ar="جملة الحقوق مخصصة (عربي)">جملة الحقوق (عربي)</label>
                        <input type="text" name="copyright_sentence_ar" id="field_copyright_sentence_ar"
                            class="form-control">
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" data-en="Copyright Sentence (EN)"
                            data-ar="جملة الحقوق مخصصة (إنجليزي)">جملة الحقوق (إنجليزي)</label>
                        <input type="text" name="copyright_sentence_en" id="field_copyright_sentence_en"
                            class="form-control">
                    </div>
                </div>
            </div>

            <div id="media-tab" class="tab-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" data-en="Main Image" data-ar="الصورة الرئيسية للمشروع">الصورة
                            الرئيسية</label>
                        <input type="file" name="image" class="form-control">
                        <div id="preview_image" class="img-preview-box"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Hover Image" data-ar="صورة التأثير عند التمرير (Hover)">صورة
                            التمرير (Hover)</label>
                        <input type="file" name="hover_image" class="form-control">
                        <div id="preview_hover_image" class="img-preview-box"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" data-en="Project Logo" data-ar="شعار أو لوجو المشروع">اللوجو</label>
                        <input type="file" name="logo" class="form-control">
                        <div id="preview_logo" class="img-preview-box"></div>
                    </div>
                </div>

                <hr style="border:0; border-top:1px solid var(--glass-border); margin:2rem 0;">

                <div class="dynamic-section">
                    <h4 style="margin-bottom:1rem; color:var(--gold);" data-en="Project Gallery (Multiple Images)"
                        data-ar="معرض صور المشروع الإضافية">معرض الصور الإضافية</h4>
                    <div id="gallery-container"></div>
                    <button type="button" class="btn-secondary-outline" onclick="addGalleryRow()">
                        <i class="fa-solid fa-plus"></i> <span data-en="Add Image To Gallery"
                            data-ar="إضافة صورة للمعرض">إضافة صورة</span>
                    </button>
                </div>
            </div>

            <div id="units-tab" class="tab-content">
                <div class="dynamic-section">
                    <h4 style="margin-bottom:1rem; color:var(--gold);" data-en="Project Units Inventory"
                        data-ar="الوحدات العقارية والمخزون الخاص بالمشروع">إدارة الوحدات</h4>
                    <div id="units-container"></div>
                    <button type="button" class="btn-secondary-outline" onclick="addUnitRow()">
                        <i class="fa-solid fa-door-open"></i> <span data-en="Add New Unit"
                            data-ar="إضافة وحدة جديدة للمخزون">إضافة وحدة جديدة</span>
                    </button>
                </div>
            </div>

            <div id="plans-tab" class="tab-content">
                <div class="dynamic-section">
                    <h4 style="margin-bottom:1rem; color:var(--gold);" data-en="Payment Plans"
                        data-ar="أنظمة الدفع وخطط السداد">خطط السداد</h4>
                    <div id="plans-container"></div>
                    <button type="button" class="btn-secondary-outline" onclick="addPlanRow()">
                        <i class="fa-solid fa-wallet"></i> <span data-en="Add Payment Plan"
                            data-ar="إضافة نظام سداد جديد">إضافة خطة سداد</span>
                    </button>
                </div>

                <div class="dynamic-section" style="margin-top:2rem;">
                    <h4 style="margin-bottom:1rem; color:var(--gold);" data-en="Project Features & Amenities"
                        data-ar="ميزات المشروع وخدماته المرفقة">ميزات المشروع</h4>
                    <div id="features-container"></div>
                    <button type="button" class="btn-secondary-outline" onclick="addFeatureRow()">
                        <i class="fa-solid fa-star"></i> <span data-en="Add Feature" data-ar="إضافة ميزة مخصصة">إضافة
                            ميزة</span>
                    </button>
                </div>
            </div>

            <div
                style="padding:1.5rem; border-top:1px solid var(--glass-border); display:flex; justify-content:flex-end; gap:10px; background:rgba(0,0,0,0.02)">
                <button type="button" class="btn-secondary-outline" onclick="closeFormPanel()" data-en="Cancel"
                    data-ar="إلغاء">إلغاء</button>
                <button type="submit" class="btn-gold">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span id="submitBtnText" data-en="Save Changes" data-ar="حفظ المشروع الآن">حفظ البيانات</span>
                </button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th data-en="Project Details" data-ar="تفاصيل المشروع">Project Details</th>
                        <th data-en="Sector" data-ar="القطاع">Sector</th>
                        <th data-en="Inventory" data-ar="المخزون العقاري">Inventory</th>
                        <th data-en="Featured" data-ar="مميز">Featured</th>
                        <th data-en="Actions" data-ar="الإجراءات">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>
                                <div class="project-info">
                                    <div class="project-thumb">
                                        @if ($project->image)
                                            <img src="{{ asset('images/projects/' . $project->image) }}" alt="Thumbnail">
                                        @else
                                            <i class="fa-solid fa-city"
                                                style="color: var(--text-muted); font-size: 1.5rem;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong style="display: block; color: var(--text-main); font-size: 1.05rem;">
                                            {{ $project->name ?? 'Untitled Project' }}
                                        </strong>
                                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                                            <i class="fa-solid fa-hashtag" style="font-size: 0.7rem;"></i>
                                            {{ $project->id }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge-sector">
                                    {{ $project->sector->name ?? '--' }}
                                </span>
                            </td>

                            <td>
                                <div style="display: flex; gap: 15px; font-size: 0.9rem; color: var(--text-muted);">
                                    <span title="Units Count" style="display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-door-open" style="color: var(--gold);"></i>
                                        <b style="color: var(--text-main);">{{ $project->units->count() ?? 0 }}</b>
                                    </span>
                                    <span title="Payment Plans" style="display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-file-invoice-dollar" style="color: #2ecc71;"></i>
                                        <b style="color: var(--text-main);">{{ $project->paymentPlans->count() ?? 0 }}</b>
                                    </span>
                                </div>
                            </td>

                            <td>
                                <form action="{{ route('admin.projects.toggle-featured', $project->id) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="toggle-featured-btn {{ $project->featured ? 'active' : '' }}"
                                        title="Toggle Featured">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                </form>
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="{{ route('projects.show', $project->id) }}" target="_blank" class="btn-icon" title="عرض في المنصة" style="color: var(--gold);">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>

                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn-icon" title="تعديل المشروع الشامل">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المشروع؟ لا يمكن التراجع عن هذا الإجراء.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="حذف المشروع">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 4rem 1rem;">
                                <i class="fa-solid fa-folder-open"
                                    style="font-size: 3.5rem; color: var(--glass-border); margin-bottom: 1.5rem; display: block;"></i>
                                <h4 style="color: var(--text-main); margin-bottom: 0.5rem;" data-en="No Projects Found"
                                    data-ar="لا توجد مشاريع مضافة">No Projects Found</h4>
                                <p style="color: var(--text-muted);"
                                    data-en="Click 'Add New Project' to start building your portfolio."
                                    data-ar="اضغط على 'إضافة مشروع جديد' للبدء.">
                                    Click 'Add New Project' to start building your portfolio.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($projects->hasPages())
            <div
                style="padding: 1.5rem; border-top: 1px solid var(--glass-border); display: flex; justify-content: center;">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

    <script>
        // التبديل بين التابات الداخلية للـ Form
        function switchFormTab(btn, tabId) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

        // فتح اللوحة في وضعية الإضافة الجديدة
        function openCreateForm() {
            const panel = document.getElementById('projectFormPanel');
            const form = document.getElementById('projectCrudForm');

            form.reset();
            document.getElementById('formActionMethod').value = "POST";
            form.action = "{{ route('admin.projects.store') }}";

            // مسح معاينات الصور السابقة والصفوف القديمة
            clearPreviewsAndContainers();

            document.getElementById('formPanelTitle').innerText = document.documentElement.getAttribute('dir') === 'rtl' ?
                'إنشاء مشروع جديد' : 'Create New Project';
            panel.style.display = 'block';
            panel.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // إغلاق لوحة التحكم بالكامل
        function closeFormPanel() {
            document.getElementById('projectFormPanel').style.display = 'none';
        }

        function clearPreviewsAndContainers() {
            document.getElementById('preview_image').innerHTML = '';
            document.getElementById('preview_hover_image').innerHTML = '';
            document.getElementById('preview_logo').innerHTML = '';
            document.getElementById('units-container').innerHTML = '';
            document.getElementById('plans-container').innerHTML = '';
            document.getElementById('features-container').innerHTML = '';
            document.getElementById('gallery-container').innerHTML = '';
        }

        // تعبئة البيانات والمصفوفات الفرعية لحظياً عند الضغط على "تعديل"
        function populateEditForm(project) {
            openCreateForm(); // لتصفير وإظهار اللوحة أولاً

            const form = document.getElementById('projectCrudForm');
            document.getElementById('formActionMethod').value = "PUT";
            form.action = `/admin/projects/${project.id}`; // مسار الـ Update بالباك إند

            document.getElementById('formPanelTitle').innerText = document.documentElement.getAttribute('dir') === 'rtl' ?
                `تعديل مشروع: ${project.name_ar}` : `Edit Project: ${project.name_en}`;

            // ملء الحقول الأساسية
            document.getElementById('field_sector_id').value = project.sector_id;
            document.getElementById('field_name_ar').value = project.name_ar;
            document.getElementById('field_name_en').value = project.name_en;
            document.getElementById('field_location_ar').value = project.location_ar || '';
            document.getElementById('field_location_en').value = project.location_en || '';
            document.getElementById('field_latitude').value = project.latitude || '';
            document.getElementById('field_longitude').value = project.longitude || '';
            document.getElementById('field_price_budget').value = project.price_budget || '';
            document.getElementById('field_status').value = project.status;
            document.getElementById('field_delivery_time').value = project.delivery_time || '';
            document.getElementById('field_sort_order').value = project.sort_order;
            document.getElementById('field_featured').checked = project.featured == 1;
            document.getElementById('field_is_active').checked = project.is_active == 1;
            document.getElementById('field_description_ar').value = project.description_ar || '';
            document.getElementById('field_description_en').value = project.description_en || '';
            document.getElementById('field_copyright_sentence_ar').value = project.copyright_sentence_ar || '';
            document.getElementById('field_copyright_sentence_en').value = project.copyright_sentence_en || '';

            // عرض مصغرات الصور المرفوعة مسبقاً للباك إند
            if (project.image) {
                document.getElementById('preview_image').innerHTML =
                    `<div class="img-thumb-wrapper"><img src="/images/projects/${project.image}"></div>`;
            }
            if (project.hover_image) {
                document.getElementById('preview_hover_image').innerHTML =
                    `<div class="img-thumb-wrapper"><img src="/images/projects/${project.hover_image}"></div>`;
            }
            if (project.logo) {
                document.getElementById('preview_logo').innerHTML =
                    `<div class="img-thumb-wrapper"><img src="/images/projects/${project.logo}"></div>`;
            }

            // بناء صفوف الوحدات المخزنة قادمة من الباك إند
            if (project.unit_types && project.unit_types.length > 0) {
                project.unit_types.forEach(unit => addUnitRow(unit));
            }
            // بناء صفوف خطط السداد المخزنة
            if (project.payment_plans && project.payment_plans.length > 0) {
                project.payment_plans.forEach(plan => addPlanRow(plan));
            }
            // بناء صفوف الميزات المخزنة
            if (project.features && project.features.length > 0) {
                project.features.forEach(feat => addFeatureRow(feat));
            }
            // بناء معرض الصور القديمة المخزنة
            if (project.images && project.images.length > 0) {
                project.images.forEach(imgData => addGalleryRow(imgData));
            }
        }

        /* ======================================================== */
        /* مولدات الصفوف الديناميكية (Dynamic Rows Components) */
        /* ======================================================== */

        // 1. إضافة صف للوحدات العقارية
        function addUnitRow(data = null) {
            const container = document.getElementById('units-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.innerHTML = `
            <div class="form-group">
                <label class="form-label">النوع Unit Type</label>
                <input type="text" name="units[${index}][unit_type]" value="${data ? data.unit_type : ''}" class="form-control" placeholder="Residential / Admin" required>
            </div>
            <div class="form-group">
                <label class="form-label">الدور Floor</label>
                <input type="text" name="units[${index}][floor]" value="${data ? (data.floor || '') : ''}" class="form-control" placeholder="Ground / 1st">
            </div>
            <div class="form-group">
                <label class="form-label">المساحة Area</label>
                <input type="text" name="units[${index}][start_area]" value="${data ? (data.start_area || '') : ''}" class="form-control" placeholder="e.g. 120m">
            </div>
            <div class="form-group">
                <label class="form-label">سعر المتر Price/M</label>
                <input type="text" name="units[${index}][price_per_meter]" value="${data ? (data.price_per_meter || '') : ''}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">إجمالي السعر Price</label>
                <input type="text" name="units[${index}][unit_price]" value="${data ? (data.unit_price || '') : ''}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">التشطيب Finishing</label>
                <input type="text" name="units[${index}][finishing_type]" value="${data ? (data.finishing_type || '') : ''}" class="form-control" placeholder="Core / Full">
            </div>
            <button type="button" class="btn-action-red" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
        `;
            container.appendChild(div);
        }

        // 2. إضافة صف لخطط السداد والدفع
        function addPlanRow(data = null) {
            const container = document.getElementById('plans-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.innerHTML = `
            <div class="form-group">
                <label class="form-label">المقدم Down Payment</label>
                <input type="text" name="plans[${index}][down_payment]" value="${data ? (data.down_payment || '') : ''}" class="form-control" placeholder="e.g. 10%">
            </div>
            <div class="form-group">
                <label class="form-label">سنوات التقسيط Years</label>
                <input type="text" name="plans[${index}][installment_years]" value="${data ? (data.installment_years || '') : ''}" class="form-control" placeholder="e.g. 7 Years">
            </div>
            <div class="form-group">
                <label class="form-label">وديعة الصيانة Maintenance</label>
                <input type="text" name="plans[${index}][maintenance]" value="${data ? (data.maintenance || '') : ''}" class="form-control" placeholder="e.g. 8%">
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label">ملاحظات Notes</label>
                <input type="text" name="plans[${index}][notes]" value="${data ? (data.notes || '') : ''}" class="form-control">
            </div>
            <button type="button" class="btn-action-red" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
        `;
            container.appendChild(div);
        }

        // 3. إضافة صف للميزات والخدمات
        function addFeatureRow(data = null) {
            const container = document.getElementById('features-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.innerHTML = `
            <div class="form-group">
                <label class="form-label">الميزة بالعربية Title (AR)</label>
                <input type="text" name="features[${index}][title_ar]" value="${data ? data.title_ar : ''}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">الميزة بالإنجليزي Title (EN)</label>
                <input type="text" name="features[${index}][title_en]" value="${data ? data.title_en : ''}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">القيمة أو الرقم Value (Optional)</label>
                <input type="text" name="features[${index}][value]" value="${data ? (data.value || '') : ''}" class="form-control" placeholder="e.g. Yes / 24/7">
            </div>
            <button type="button" class="btn-action-red" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>
        `;
            container.appendChild(div);
        }

        // 4. إضافة حقل صور للمعرض الإضافي
        function addGalleryRow(data = null) {
            const container = document.getElementById('gallery-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.gridTemplateColumns = data ? "1fr 80px 45px" : "1fr 45px";

            let htmlContent = `
            <div class="form-group">
                <label class="form-label">اختار ملف الصورة Select Gallery Image</label>
                <input type="file" name="gallery_images[${index}]" class="form-control" ${data ? '' : 'required'}>
            </div>
        `;

            if (data) {
                htmlContent += `
                <div class="img-thumb-wrapper" style="margin-bottom:0;">
                    <img src="/images/projects/${data.image}">
                </div>
            `;
            }

            htmlContent +=
                `<button type="button" class="btn-action-red" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></button>`;
            div.innerHTML = htmlContent;
            container.appendChild(div);
        }
    </script>
@endsection
