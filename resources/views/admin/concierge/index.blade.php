@extends('layouts.admin')

@section('content')
<style>
    .concierge-page {
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 14px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .stat-val {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1;
    }

    .stat-lbl {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .table-container {
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .lux-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        text-align: right;
    }

    .lux-table th {
        background: rgba(228, 220, 199, 0.03);
        color: var(--text-muted);
        padding: 1.1rem 1rem;
        font-weight: 700;
        border-bottom: 1px solid var(--glass-border);
    }

    .lux-table td {
        padding: 1.1rem 1rem;
        border-bottom: 1px solid rgba(228, 220, 199, 0.05);
        color: var(--text-main);
        vertical-align: middle;
    }

    .lux-table tr:hover td {
        background: rgba(215, 182, 74, 0.02);
    }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-active { background: rgba(16, 185, 129, 0.15); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-inactive { background: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge-type { background: rgba(215, 182, 74, 0.15); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.3); }

    .opt-chip {
        display: inline-block;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--glass-border);
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.78rem;
        margin: 2px;
        color: var(--text-muted);
    }

    .btn-lux {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.65rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        white-space: nowrap;
    }

    .btn-lux-primary { background: var(--primary-red); color: #fff; }
    .btn-lux-primary:hover { background: #d80000; transform: translateY(-1px); }
    .btn-lux-gold { background: rgba(215, 182, 74, 0.2); color: var(--gold); border: 1px solid rgba(215, 182, 74, 0.4); }
    .btn-lux-gold:hover { background: var(--gold); color: #000; }
    .btn-lux-sm { padding: 0.4rem 0.8rem; font-size: 0.82rem; border-radius: 6px; }

    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px); z-index: 9999; display: none;
        align-items: center; justify-content: center; padding: 1.5rem;
    }

    .modal-card {
        background: var(--bg-card); border: 1px solid var(--glass-border);
        border-radius: 18px; width: 100%; max-width: 680px; max-height: 90vh;
        overflow-y: auto; padding: 2rem; position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-label {
        display: block; font-size: 0.85rem; font-weight: 700;
        color: var(--text-muted); margin-bottom: 0.4rem;
    }

    .form-control-lux {
        width: 100%; background: rgba(228, 220, 199, 0.05); border: 1px solid var(--glass-border);
        border-radius: 8px; padding: 0.75rem 1rem; color: var(--text-main); font-family: 'Cairo', sans-serif;
        font-size: 0.9rem; outline: none; transition: border-color 0.2s;
    }

    .form-control-lux:focus { border-color: var(--gold); background: rgba(228, 220, 199, 0.08); }

    .options-builder-box {
        background: rgba(0,0,0,0.3); border: 1px dashed var(--glass-border);
        border-radius: 12px; padding: 1rem; margin-top: 0.5rem;
    }

    .option-row {
        display: grid;
        grid-template-columns: 60px 1fr 1fr 1fr 40px;
        gap: 8px;
        align-items: center;
        margin-bottom: 8px;
        background: rgba(255,255,255,0.02);
        padding: 6px;
        border-radius: 8px;
    }

    .btn-remove-opt {
        background: rgba(239, 68, 68, 0.2); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.4);
        width: 34px; height: 34px; border-radius: 6px; cursor: pointer; display: flex;
        align-items: center; justify-content: center;
    }

    .btn-add-opt {
        background: rgba(215, 182, 74, 0.15); color: var(--gold); border: 1px dashed var(--gold);
        width: 100%; padding: 0.6rem; border-radius: 8px; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px; font-family: 'Cairo', sans-serif;
        margin-top: 8px;
    }
</style>

<div class="concierge-page">
    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #34d399; padding: 1rem 1.2rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <div><i class="fa-solid fa-circle-check ml-2"></i> {{ session('success') }}</div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:#34d399; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="page-head">
        <div>
            <h1 class="page-title">
                <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--gold);"></i>
                <span>منشئ ومحرر المستشار العقاري الذكي</span>
            </h1>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-top:4px;">
                تحكم ديناميكي كامل في تابات وأسئلة وخيارات أخذ بيانات العملاء، وترتيب ظهورها وتحديد حقولها المستهدفة دون أي كود برمجي.
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="button" class="btn-lux btn-lux-primary" onclick="openAddModal()">
                <i class="fa-solid fa-plus"></i>
                <span>إضافة تاب / خطوة جديدة</span>
            </button>
        </div>
    </div>

    {{-- إحصائيات الخطوات --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(215, 182, 74, 0.15); color: var(--gold);">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['total'] }}</div>
                <div class="stat-lbl">إجمالي التابات / الخطوات</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['active'] }}</div>
                <div class="stat-lbl">خطوات نشطة ومعروضة</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
            <div>
                <div class="stat-val">{{ $stats['inactive'] }}</div>
                <div class="stat-lbl">خطوات معطلة مؤقتاً</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6;">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
                <div class="stat-val" style="font-size:1.1rem; color:#3B82F6;">ديناميكي 100%</div>
                <div class="stat-lbl">أخذ بيانات ذكي غير مزعج</div>
            </div>
        </div>
    </div>

    {{-- جدول الخطوات --}}
    <div class="table-container">
        <div style="padding:1rem 1.2rem; border-bottom:1px solid var(--glass-border); display:flex; justify-content:space-between; align-items:center;">
            <div style="font-weight:700; color:var(--text-main);">
                <i class="fa-solid fa-list-check ml-2" style="color:var(--gold);"></i>
                ترتيب وسلسلة خطوات المستشار العقاري
            </div>
            <div style="font-size:0.8rem; color:var(--text-muted);">
                يتم عرض الخطوات للزائر بنفس الترتيب أدناه
            </div>
        </div>

        <div class="table-responsive">
            <table class="lux-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">الترتيب</th>
                        <th style="width: 80px;">الرقم</th>
                        <th>السؤال / عنوان التاب</th>
                        <th>نوع الخطوة</th>
                        <th>الحقل المستهدف في CRM</th>
                        <th>الخيارات المعرفة</th>
                        <th>الحالة</th>
                        <th style="text-align: left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="stepsTableBody">
                    @forelse($steps as $index => $step)
                        <tr>
                            <td>
                                <div style="display:flex; flex-direction:column; gap:2px; width:28px;">
                                    @if(!$loop->first)
                                        <button type="button" class="btn-lux btn-lux-sm" style="padding:2px 4px; font-size:0.7rem; justify-content:center;" onclick="moveStep('{{ $step->id }}', 'up')" title="تقديم للأعلى">▲</button>
                                    @endif
                                    @if(!$loop->last)
                                        <button type="button" class="btn-lux btn-lux-sm" style="padding:2px 4px; font-size:0.7rem; justify-content:center;" onclick="moveStep('{{ $step->id }}', 'down')" title="تأخير للأسفل">▼</button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="background:rgba(215,182,74,0.1); border:1px solid rgba(215,182,74,0.3); color:var(--gold); padding:4px 10px; border-radius:8px; font-weight:800;">
                                    #{{ $step->sort_order }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:700; color:var(--text-main); font-size:0.95rem;">
                                    {{ $step->title_ar }}
                                </div>
                                @if($step->title_en)
                                    <div style="font-size:0.78rem; color:var(--text-muted); font-family:sans-serif;">
                                        {{ $step->title_en }}
                                    </div>
                                @endif
                                @if($step->subtitle_ar)
                                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                                        {{ Str::limit($step->subtitle_ar, 60) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($step->step_type === 'options_grid')
                                    <span class="badge-pill badge-type">
                                        <i class="fa-solid fa-grip"></i> شبكة خيارات تفاعلية
                                    </span>
                                @elseif($step->step_type === 'lead_form')
                                    <span class="badge-pill badge-type" style="background:rgba(16,185,129,0.15); color:#10B981; border-color:rgba(16,185,129,0.3);">
                                        <i class="fa-solid fa-address-card"></i> نموذج بيانات العميل (اسم وهاتف)
                                    </span>
                                @else
                                    <span class="badge-pill badge-type" style="background:rgba(59,130,246,0.15); color:#3B82F6; border-color:rgba(59,130,246,0.3);">
                                        <i class="fa-solid fa-keyboard"></i> حقل إدخال نصي
                                    </span>
                                @endif
                            </td>
                            <td>
                                <code style="background:rgba(0,0,0,0.4); color:#d7b64a; padding:3px 8px; border-radius:6px; font-size:0.85rem;">
                                    {{ $step->target_field }}
                                </code>
                            </td>
                            <td>
                                @if(is_array($step->options) && count($step->options) > 0)
                                    <div style="display:flex; flex-wrap:wrap; max-width:280px;">
                                        @foreach($step->options as $opt)
                                            <span class="opt-chip">
                                                {{ $opt['icon'] ?? '•' }} {{ $opt['title_ar'] ?? $opt['value'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div style="font-size:0.72rem; color:var(--gold); margin-top:3px;">
                                        {{ count($step->options) }} خيارات متاحة
                                    </div>
                                @elseif($step->step_type === 'lead_form')
                                    <span style="color:#10B981; font-size:0.8rem;">التقاط الاسم ورقم الواتساب</span>
                                @else
                                    <span style="color:var(--text-muted); font-size:0.8rem;">إدخال مباشر</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.concierge-steps.toggle-active', $step) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background:none; border:none; cursor:pointer;" title="انقر لتغيير حالة التفعيل">
                                        @if($step->is_active)
                                            <span class="badge-pill badge-active"><i class="fa-solid fa-check"></i> مفعل</span>
                                        @else
                                            <span class="badge-pill badge-inactive"><i class="fa-solid fa-xmark"></i> معطل</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: left;">
                                <div style="display:inline-flex; gap:6px;">
                                    <button type="button" class="btn-lux btn-lux-gold btn-lux-sm" onclick='openEditModal(@json($step))'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>تعديل</span>
                                    </button>

                                    <form action="{{ route('admin.concierge-steps.destroy', $step) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا التاب من المستشار العقاري؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-lux btn-lux-sm" style="background:rgba(239, 68, 68, 0.2); color:#EF4444; border:1px solid rgba(239, 68, 68, 0.4);">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted);">
                                لا توجد خطوات مضافة حالياً. اضغط على "إضافة تاب / خطوة جديدة" للبدء.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- فورم إعادة الترتيب الخفي --}}
<form id="reorderForm" action="{{ route('admin.concierge-steps.reorder') }}" method="POST" style="display:none;">
    @csrf
    <div id="reorderInputs"></div>
</form>

{{-- ========================================== --}}
{{-- 1. مودال إضافة خطوة جديدة                   --}}
{{-- ========================================== --}}
<div class="modal-overlay" id="addStepModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; border-bottom:1px solid var(--glass-border); padding-bottom:1rem;">
            <h2 style="font-size:1.3rem; font-weight:800; color:var(--text-main); margin:0;">
                <i class="fa-solid fa-plus-circle" style="color:var(--gold);"></i>
                إضافة تاب / خطوة جديدة للمستشار الذكي
            </h2>
            <button type="button" onclick="closeModal('addStepModal')" style="background:none; border:none; color:var(--text-muted); font-size:1.2rem; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form action="{{ route('admin.concierge-steps.store') }}" method="POST" onsubmit="prepareOptionsForSubmit('add');">
            @csrf
            <input type="hidden" name="options_json" id="add_options_json">

            <div class="form-group">
                <label class="form-label">عنوان السؤال / التاب باللغة العربية *</label>
                <input type="text" name="title_ar" required placeholder="مثال: ما هو غرضك الأساسي من البحث؟" class="form-control-lux">
            </div>

            <div class="form-group">
                <label class="form-label">العنوان بالإنجليزية (اختياري)</label>
                <input type="text" name="title_en" placeholder="e.g. What is your primary purpose?" class="form-control-lux">
            </div>

            <div class="form-group">
                <label class="form-label">الوصف التوضيحي للخطوة (Arabic Subtitle)</label>
                <textarea name="subtitle_ar" rows="2" placeholder="مثال: اختر ما يناسب تطلعاتك لنرشح لك الفرص الأكثر دقة وربحية." class="form-control-lux"></textarea>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                <div class="form-group">
                    <label class="form-label">نوع الخطوة *</label>
                    <select name="step_type" id="add_step_type" class="form-control-lux" onchange="toggleOptionsBox('add', this.value)">
                        <option value="options_grid">شبكة كروت خيارات تفاعلية (Options Grid)</option>
                        <option value="lead_form">نموذج بيانات العميل (اسم + رقم هاتف)</option>
                        <option value="text_input">حقل إدخال نصي حر (Text Input)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">الحقل المستهدف في CRM *</label>
                    <select name="target_field" class="form-control-lux">
                        <option value="purpose">الغرض العقاري (purpose)</option>
                        <option value="unit_type">نوع الوحدة (unit_type)</option>
                        <option value="project_or_city">الموقع والمشروع المستهدف (project_or_city)</option>
                        <option value="budget">الميزانية (budget)</option>
                        <option value="payment_method">طريقة الدفع والتسهيلات (payment_method)</option>
                        <option value="contact_info">بيانات التواصل (contact_info)</option>
                        <option value="custom">حقل مخصص إضافي (custom)</option>
                    </select>
                </div>
            </div>

            {{-- صندوق بناء الخيارات التفاعلية --}}
            <div id="add_options_box" class="options-builder-box">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-weight:700; color:var(--gold); font-size:0.85rem;">
                        <i class="fa-solid fa-sliders ml-1"></i> خيارات الخطوة (الكروت التفاعلية):
                    </div>
                </div>

                <div id="add_options_rows_container"></div>

                <button type="button" class="btn-add-opt" onclick="addOptionRow('add')">
                    <i class="fa-solid fa-plus"></i> إضافة خيار / كارت جديد
                </button>
            </div>

            <div style="display:flex; gap:20px; margin-top:1.5rem; margin-bottom:1.5rem;">
                <label style="display:flex; align-items:center; gap:8px; color:var(--text-main); cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color:var(--gold);">
                    <span>تفعيل هذه الخطوة فوراً</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; color:var(--text-main); cursor:pointer;">
                    <input type="checkbox" name="is_required" value="1" checked style="accent-color:var(--gold);">
                    <span>إلزامية الإجابة للمتابعة</span>
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; border-top:1px solid var(--glass-border); padding-top:1.2rem;">
                <button type="button" class="btn-lux" style="background:rgba(255,255,255,0.08); color:var(--text-muted);" onclick="closeModal('addStepModal')">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">حفظ الخطوة</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================== --}}
{{-- 2. مودال تعديل خطوة                         --}}
{{-- ========================================== --}}
<div class="modal-overlay" id="editStepModal">
    <div class="modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; border-bottom:1px solid var(--glass-border); padding-bottom:1rem;">
            <h2 style="font-size:1.3rem; font-weight:800; color:var(--text-main); margin:0;">
                <i class="fa-solid fa-pen-to-square" style="color:var(--gold);"></i>
                تعديل تاب / خطوة المستشار الذكي
            </h2>
            <button type="button" onclick="closeModal('editStepModal')" style="background:none; border:none; color:var(--text-muted); font-size:1.2rem; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="editStepForm" method="POST" onsubmit="prepareOptionsForSubmit('edit');">
            @csrf
            @method('PUT')
            <input type="hidden" name="options_json" id="edit_options_json">

            <div class="form-group">
                <label class="form-label">عنوان السؤال / التاب باللغة العربية *</label>
                <input type="text" name="title_ar" id="edit_title_ar" required class="form-control-lux">
            </div>

            <div class="form-group">
                <label class="form-label">العنوان بالإنجليزية (اختياري)</label>
                <input type="text" name="title_en" id="edit_title_en" class="form-control-lux">
            </div>

            <div class="form-group">
                <label class="form-label">الوصف التوضيحي للخطوة (Arabic Subtitle)</label>
                <textarea name="subtitle_ar" id="edit_subtitle_ar" rows="2" class="form-control-lux"></textarea>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                <div class="form-group">
                    <label class="form-label">نوع الخطوة *</label>
                    <select name="step_type" id="edit_step_type" class="form-control-lux" onchange="toggleOptionsBox('edit', this.value)">
                        <option value="options_grid">شبكة كروت خيارات تفاعلية (Options Grid)</option>
                        <option value="lead_form">نموذج بيانات العميل (اسم + رقم هاتف)</option>
                        <option value="text_input">حقل إدخال نصي حر (Text Input)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">الحقل المستهدف في CRM *</label>
                    <select name="target_field" id="edit_target_field" class="form-control-lux">
                        <option value="purpose">الغرض العقاري (purpose)</option>
                        <option value="unit_type">نوع الوحدة (unit_type)</option>
                        <option value="project_or_city">الموقع والمشروع المستهدف (project_or_city)</option>
                        <option value="budget">الميزانية (budget)</option>
                        <option value="payment_method">طريقة الدفع والتسهيلات (payment_method)</option>
                        <option value="contact_info">بيانات التواصل (contact_info)</option>
                        <option value="custom">حقل مخصص إضافي (custom)</option>
                    </select>
                </div>
            </div>

            <div id="edit_options_box" class="options-builder-box">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-weight:700; color:var(--gold); font-size:0.85rem;">
                        <i class="fa-solid fa-sliders ml-1"></i> خيارات الخطوة (الكروت التفاعلية):
                    </div>
                </div>

                <div id="edit_options_rows_container"></div>

                <button type="button" class="btn-add-opt" onclick="addOptionRow('edit')">
                    <i class="fa-solid fa-plus"></i> إضافة خيار / كارت جديد
                </button>
            </div>

            <div style="display:flex; gap:20px; margin-top:1.5rem; margin-bottom:1.5rem;">
                <label style="display:flex; align-items:center; gap:8px; color:var(--text-main); cursor:pointer;">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="accent-color:var(--gold);">
                    <span>تفعيل هذه الخطوة</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; color:var(--text-main); cursor:pointer;">
                    <input type="checkbox" name="is_required" id="edit_is_required" value="1" style="accent-color:var(--gold);">
                    <span>إلزامية الإجابة للمتابعة</span>
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; border-top:1px solid var(--glass-border); padding-top:1.2rem;">
                <button type="button" class="btn-lux" style="background:rgba(255,255,255,0.08); color:var(--text-muted);" onclick="closeModal('editStepModal')">إلغاء</button>
                <button type="submit" class="btn-lux btn-lux-primary">تحديث التعديلات</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function toggleOptionsBox(prefix, stepType) {
        const box = document.getElementById(`${prefix}_options_box`);
        if (box) {
            box.style.display = (stepType === 'options_grid') ? 'block' : 'none';
        }
    }

    function addOptionRow(prefix, icon = '✨', title_ar = '', title_en = '', value = '') {
        const container = document.getElementById(`${prefix}_options_rows_container`);
        const rowId = 'opt_' + Math.random().toString(36).substring(2, 9);
        const row = document.createElement('div');
        row.className = 'option-row';
        row.id = rowId;
        row.innerHTML = `
            <input type="text" class="form-control-lux opt-icon" value="${icon}" placeholder="أيقونة" style="text-align:center; padding:0.4rem;">
            <input type="text" class="form-control-lux opt-title-ar" value="${title_ar}" placeholder="العنوان بالعربي" style="padding:0.4rem 0.6rem;">
            <input type="text" class="form-control-lux opt-title-en" value="${title_en}" placeholder="English Title" style="padding:0.4rem 0.6rem;">
            <input type="text" class="form-control-lux opt-value" value="${value}" placeholder="القيمة (value)" style="padding:0.4rem 0.6rem;">
            <button type="button" class="btn-remove-opt" onclick="document.getElementById('${rowId}').remove()" title="حذف">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        container.appendChild(row);
    }

    function openAddModal() {
        document.getElementById('add_options_rows_container').innerHTML = '';
        addOptionRow('add', '🏡', 'سكن فاخر', 'Luxury', 'residential');
        addOptionRow('add', '📈', 'استثمار تجاري', 'Commercial', 'investment');
        toggleOptionsBox('add', document.getElementById('add_step_type').value);
        openModal('addStepModal');
    }

    function openEditModal(step) {
        const form = document.getElementById('editStepForm');
        form.action = `/admin/concierge-steps/${step.id}`;

        document.getElementById('edit_title_ar').value = step.title_ar || '';
        document.getElementById('edit_title_en').value = step.title_en || '';
        document.getElementById('edit_subtitle_ar').value = step.subtitle_ar || '';
        document.getElementById('edit_step_type').value = step.step_type || 'options_grid';
        document.getElementById('edit_target_field').value = step.target_field || 'purpose';
        document.getElementById('edit_is_active').checked = !!step.is_active;
        document.getElementById('edit_is_required').checked = !!step.is_required;

        toggleOptionsBox('edit', step.step_type);

        const container = document.getElementById('edit_options_rows_container');
        container.innerHTML = '';

        if (Array.isArray(step.options)) {
            step.options.forEach(opt => {
                addOptionRow('edit', opt.icon || '•', opt.title_ar || '', opt.title_en || '', opt.value || '');
            });
        }

        openModal('editStepModal');
    }

    function prepareOptionsForSubmit(prefix) {
        const container = document.getElementById(`${prefix}_options_rows_container`);
        const rows = container.querySelectorAll('.option-row');
        const options = [];

        rows.forEach(r => {
            const icon = r.querySelector('.opt-icon').value.trim();
            const title_ar = r.querySelector('.opt-title-ar').value.trim();
            const title_en = r.querySelector('.opt-title-en').value.trim();
            let value = r.querySelector('.opt-value').value.trim();

            if (!value && title_ar) {
                value = title_ar.toLowerCase().replace(/\s+/g, '_');
            }

            if (title_ar || value) {
                options.push({ icon, title_ar, title_en, value });
            }
        });

        document.getElementById(`${prefix}_options_json`).value = JSON.stringify(options);
    }

    // تقديم وتأخير الخطوة
    const stepIds = @json($steps->pluck('id'));

    function moveStep(id, direction) {
        id = parseInt(id);
        const idx = stepIds.indexOf(id);
        if (idx === -1) return;

        if (direction === 'up' && idx > 0) {
            const temp = stepIds[idx];
            stepIds[idx] = stepIds[idx - 1];
            stepIds[idx - 1] = temp;
        } else if (direction === 'down' && idx < stepIds.length - 1) {
            const temp = stepIds[idx];
            stepIds[idx] = stepIds[idx + 1];
            stepIds[idx + 1] = temp;
        } else {
            return;
        }

        const container = document.getElementById('reorderInputs');
        container.innerHTML = '';
        stepIds.forEach(stepId => {
            container.innerHTML += `<input type="hidden" name="step_ids[]" value="${stepId}">`;
        });

        document.getElementById('reorderForm').submit();
    }
</script>
@endsection
