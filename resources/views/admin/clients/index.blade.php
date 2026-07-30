@extends('layouts.admin')

@section('content')
@php
    // قواميس الترجمة والتحويل الاحترافي من الإنجليزية للعربية
    $statusMap = [
        'new' => 'جديد ومستهدف', 'contacted' => 'تم التواصل معه', 'qualified' => 'عميل مؤهل جاد',
        'proposal_sent' => 'تم تقديم عرض سعر', 'negotiation' => 'مرحلة التفاوض', 
        'reserved' => 'تم الحجز المبدئي', 'won' => 'تم التعاقد والبيع ✓', 'lost' => 'مستبعد / ملغي ✗'
    ];

    $sourceMap = [
        'facebook' => 'فيسبوك', 'instagram' => 'إنستغرام', 'google' => 'جوجل', 'tiktok' => 'تيك توك',
        'website' => 'الموقع الإلكتروني', 'whatsapp' => 'واتساب مباشر', 'referral' => 'ترشيح وعملاء سابقين',
        'broker' => 'بروكر / وسيط خارجي', 'walk_in' => 'زيارة مقر الشركة', 'other' => 'مصادر أخرى'
    ];

    $purposeMap = [
        'residential' => 'سكني للإقامة', 'investment' => 'استثماري مالي', 'summer' => 'مصيف وموسمي',
        'clinic' => 'مقر طبي / عيادة', 'office' => 'مقر إداري / مكتب', 'commercial_shop' => 'تجاري / محل'
    ];

    $unitTypeMap = [
        'apartment' => 'شقة فاخرة', 'villa' => 'فيلا مستقلة', 'townhouse' => 'تاون هاوس', 
        'twinhouse' => 'توين هاوس', 'duplex' => 'دوبلكس', 'penthouse' => 'بنتهاوس', 
        'studio' => 'استوديو', 'chalet' => 'شاليه ساحلي', 'clinic' => 'عيادة طبية', 
        'office' => 'مكتب إداري', 'shop' => 'محل تجاري'
    ];

    $budgetMap = [
        'lt_2m' => 'أقل من 2 مليون ج.م', '2_4m' => 'من 2 إلى 4 مليون ج.م', '4_6m' => 'من 4 إلى 6 مليون ج.م',
        '6_10m' => 'من 6 إلى 10 مليون ج.م', '10_20m' => 'من 10 إلى 20 مليون ج.م', 'gt_20m' => 'أكثر من 20 مليون ج.م'
    ];

    $paymentMap = ['cash' => 'دفع كاش بالكامل', 'installments' => 'تسهيلات وسداد أقساط', 'either' => 'مرونة (كاش أو قسط)'];
    $purchaseTimeMap = ['immediately' => 'شراء فوري عاجل', '3_months' => 'خلال 3 أشهر', '6_months' => 'خلال 6 أشهر', '1_year' => 'خلال سنة', 'more_than_year' => 'تخطيط بعيد المدى'];
    $contactMap = ['call' => 'اتصال هاتفي مباشر', 'whatsapp' => 'محادثة واتساب', 'email' => 'بريد إلكتروني معتمد'];
    $contactTimeMap = ['morning' => 'الفترة الصباحية', 'afternoon' => 'فترة الظهيرة', 'evening' => 'الفترة المسائية', 'anytime' => 'متاح في أي وقت'];
    
    $cardStatusMap = [
        'pending' => 'ينتظر المراجعة والإصدار', 'under_review' => 'قيد فحص المستندات', 'approved' => 'تمت الموافقة (جاهز للتسليم)',
        'active' => 'البطاقة مفعلة ونشطة VIP', 'rejected' => 'تم رفض الطلب سبباً', 'blocked' => 'البطاقة محظورة وموقوفة',
        'expired' => 'منتهية الصلاحية', 'cancelled' => 'تم الإلغاء من العميل'
    ];

    $priorityMap = ['low' => 'منخفضة', 'medium' => 'متوسطة الاهتمام', 'high' => 'أهمية مرتفعة', 'urgent' => 'طارئ جداً (حسم الصفقة)'];
@endphp

<style>
    /* الإعدادات البصرية المتوافقة مع ثيم شركة البرلسي */
    .crm-wrapper {
        direction: rtl;
        font-family: 'Cairo', sans-serif;
        color: #F0F0F0;
        padding: 1.5rem;
    }

    /* كروت المؤشرات العلوية للـ CRM */
    .stats-grid-crm {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card-crm {
        background: #111113;
        border: 1px solid rgba(228, 220, 199, 0.1);
        padding: 1.5rem;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
    }

    .stat-card-crm::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0; width: 40px; height: 3px;
        background: var(--primary-red, #B40000);
    }

    .stat-card-crm.won::after { background: #00e676; }
    .stat-card-crm.new::after { background: #00b0ff; }

    .stat-title { font-size: 0.85rem; color: #76767A; margin-bottom: 0.5rem; }
    .stat-number { font-size: 1.8rem; font-weight: 700; color: #E6E0D0; }

    /* منطقة الفلاتر والبحث */
    .filter-panel-lux {
        background: #0d0d0f;
        border: 1px solid rgba(228, 220, 199, 0.08);
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        flex: 1;
        min-width: 200px;
    }

    .filter-group label { font-size: 0.8rem; color: #76767A; }
    
    .input-lux {
        background: #16161a;
        border: 1px solid rgba(228, 220, 199, 0.15);
        color: #F0F0F0;
        padding: 0.65rem 1rem;
        border-radius: 6px;
        font-family: inherit;
        outline: none;
        transition: 0.3s;
    }

    .input-lux:focus { border-color: #B40000; }

    .btn-submit-lux {
        background: #B40000;
        color: #fff;
        border: none;
        padding: 0.7rem 1.8rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-submit-lux:hover { background: #e50000; }

    /* جدول عرض العملاء الفاخر */
    .table-container-lux {
        background: #0d0d0f;
        border: 1px solid rgba(228, 220, 199, 0.08);
        border-radius: 12px;
        overflow-x: auto;
        box-shadow: 0 15px 35px rgba(0,0,0,0.6);
    }

    .table-lux {
        width: 100%;
        border-collapse: collapse;
        text-align: right;
    }

    .table-lux th {
        background: #111113;
        color: #E4DCC7;
        padding: 1.2rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-bottom: 1px solid rgba(228, 220, 199, 0.1);
    }

    .table-lux td {
        padding: 1.1rem 1rem;
        border-bottom: 1px solid rgba(228, 220, 199, 0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .table-lux tr:hover td { background: rgba(180, 0, 0, 0.02); }

    .avatar-cell {
        width: 42px; height: 42px; border-radius: 50%;
        object-fit: cover; border: 1px solid #B40000;
        background: #222;
    }

    /* الحالات الملونة للـ CRM */
    .badge-lux {
        display: inline-block;
        padding: 0.25rem 0.65rem;
        font-size: 0.75rem;
        border-radius: 4px;
        font-weight: 600;
    }
    .status-new { background: rgba(0, 176, 255, 0.1); color: #00b0ff; border: 1px solid rgba(0, 176, 255, 0.2); }
    .status-negotiation { background: rgba(255, 145, 0, 0.1); color: #ff9100; border: 1px solid rgba(255, 145, 0, 0.2); }
    .status-won { background: rgba(0, 230, 118, 0.1); color: #00e676; border: 1px solid rgba(0, 230, 118, 0.2); }
    .status-lost { background: rgba(118, 118, 122, 0.1); color: #76767A; border: 1px solid rgba(118, 118, 122, 0.2); }
    .status-default { background: rgba(228, 220, 199, 0.1); color: #E4DCC7; border: 1px solid rgba(228, 220, 199, 0.2); }

    .btn-action-view {
        background: transparent;
        border: 1px solid rgba(228, 220, 199, 0.2);
        color: #E6E0D0;
        padding: 0.4rem 0.9rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
        transition: 0.3s;
    }

    .btn-action-view:hover {
        border-color: #B40000;
        color: #B40000;
        background: rgba(180, 0, 0, 0.05);
    }

    /* ===================================== */
    /* درج استعراض الملف الشامل (CRM Drawer) */
    /* ===================================== */
    .crm-drawer-overlay {
        position: fixed;
        inset: 0; background: rgba(0,0,0,0.85);
        z-index: 9999; display: none;
        justify-content: flex-end;
        backdrop-filter: blur(8px);
    }

    .crm-drawer {
        width: 100%; max-width: 750px;
        background: #000000;
        border-left: 1px solid rgba(228, 220, 199, 0.15);
        height: 100%; overflow-y: auto;
        padding: 2.5rem 2rem;
        box-shadow: -10px 0 40px rgba(0,0,0,0.9);
        animation: slideIn 0.4s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    @keyframes slideIn {
        from { transform: translateX(-100%); }
        to { transform: translateX(0); }
    }

    .drawer-header {
        display: flex; justify-content: space-between;
        align-items: center; border-bottom: 1px solid rgba(228, 220, 199, 0.1);
        padding-bottom: 1.5rem; margin-bottom: 2rem;
    }

    .close-drawer-btn {
        background: transparent; border: none; color: #76767A;
        font-size: 1.5rem; cursor: pointer; transition: 0.3s;
    }
    .close-drawer-btn:hover { color: #B40000; }

    .section-title-lux {
        font-size: 1.05rem; color: #E4DCC7;
        margin: 2rem 0 1rem 0; padding-bottom: 0.4rem;
        border-bottom: 1px dashed rgba(228, 220, 199, 0.15);
        display: flex; align-items: center; gap: 0.5rem;
    }

    .drawer-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
    }

    .drawer-field-box {
        background: #0d0d0f; border: 1px solid rgba(228, 220, 199, 0.05);
        padding: 1rem; border-radius: 6px;
    }

    .field-label { font-size: 0.75rem; color: #76767A; margin-bottom: 0.25rem; }
    .field-value { font-size: 0.95rem; color: #F0F0F0; font-weight: 600; }

    /* تايم لاين حركات العميل المدمج للـ CRM */
    .crm-timeline {
        border-right: 2px solid rgba(180, 0, 0, 0.3);
        padding-right: 1.5rem; margin-top: 1rem;
    }
    .crm-timeline-item { position: relative; margin-bottom: 1.5rem; }
    .crm-timeline-item::before {
        content: ''; position: absolute; right: calc(-1.5rem - 6px); top: 4px;
        width: 10px; height: 10px; border-radius: 50%; background: #B40000;
    }
    .timeline-meta { font-size: 0.75rem; color: #76767A; }
    .timeline-content-txt { font-size: 0.85rem; color: #E6E0D0; margin-top: 0.2rem; }
</style>

<div class="crm-wrapper">
    
    <div class="stats-grid-crm">
        <div class="stat-card-crm">
            <div class="stat-title">إجمالي قاعدة بيانات العملاء</div>
            <div class="stat-number">{{ $stats['total'] }} عميل</div>
        </div>
        <div class="stat-card-crm new">
            <div class="stat-title">عملاء مستهدفين جدد (New Leads)</div>
            <div class="stat-number">{{ $stats['new'] }}</div>
        </div>
        <div class="stat-card-crm">
            <div class="stat-title">عملاء قيد التفاوض والمناقشة</div>
            <div class="stat-number">{{ $stats['negotiation'] }}</div>
        </div>
        <div class="stat-card-crm won">
            <div class="stat-title">تعاقدات ناجحة مكتملة (Won)</div>
            <div class="stat-number">{{ $stats['won'] }} صفقة</div>
        </div>
    </div>

    <div class="filter-panel-lux">
        <form action="{{ route('admin.clients.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label>البحث السريع عن العميل</label>
                <input type="text" name="search" value="{{ request('search') }}" class="input-lux" placeholder="الاسم، الهاتف، البريد الالكتروني...">
            </div>
            <div class="filter-group">
                <label>الحالة البيعية للـ Lead</label>
                <select name="status" class="input-lux">
                    <option value="">كل الحالات</option>
                    @foreach($statusMap as $key => $val)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>الغرض الاستثماري</label>
                <select name="purpose" class="input-lux">
                    <option value="">كل الأغراض</option>
                    @foreach($purposeMap as $key => $val)
                        <option value="{{ $key }}" {{ request('purpose') == $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-submit-lux">تطبيق الفلاتر</button>
            @if(request()->hasAny(['search', 'status', 'purpose']))
                <a href="{{ route('admin.clients.index') }}" class="input-lux" style="text-decoration:none; text-align:center;">إعادة تعيين</a>
            @endif
        </form>
    </div>

    <div class="table-container-lux">
        <table class="table-lux">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>اسم العميل الشامل</th>
                    <th>رقم الهاتف</th>
                    <th>المحافظة والمدينة</th>
                    <th>الحالة الحالية البيعية</th>
                    <th>الوحدة المهتم بها</th>
                    <th>الميزانية المرصودة</th>
                    <th>إجراءات CRM</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    @php
                        $leadStatusClass = in_array($client->lead_status, ['new','negotiation','won','lost']) ? 'status-'.$client->lead_status : 'status-default';
                    @endphp
                    <tr>
                        <td>
                            <img src="{{ $client->photo ? asset($client->photo) : 'https://www.w3schools.com/howto/img_avatar.png' }}" class="avatar-cell" alt="">
                        </td>
                        <td style="font-weight: 600; color: #E6E0D0;">{{ $client->full_name }}</td>
                        <td dir="ltr">{{ $client->phone }}</td>
                        <td>{{ $client->governorate }} @if($client->city) - {{ $client->city }} @endif</td>
                        <td>
                            <span class="badge-lux {{ $leadStatusClass }}">
                                {{ $statusMap[$client->lead_status] ?? $client->lead_status }}
                            </span>
                        </td>
                        <td>{{ $unitTypeMap[$client->unit_type] ?? 'غير محدد' }}</td>
                        <td style="color: #E4DCC7;">{{ $budgetMap[$client->budget] ?? 'قيد النقاش' }}</td>
                        <td>
                            <button type="button" class="btn-action-view" onclick="openClientDrawer({{ json_encode($client) }}, {{ json_encode($client->activeSmartCard) }}, {{ json_encode($client->histories) }})">
                                فتح الملف الشامل 👁
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #76767A; padding: 3rem;">لا يوجد عملاء يطابقون خيارات البحث المحددة حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $clients->links() }}
    </div>
</div>

<div id="clientCrmDrawerOverlay" class="crm-drawer-overlay" onclick="closeClientDrawer(event)">
    <div class="crm-drawer" onclick="event.stopPropagation()">
        
        <div class="drawer-header">
            <div>
                <h3 id="drawer_full_name" style="color: #E4DCC7; font-size: 1.4rem;"></h3>
                <p id="drawer_lead_status_badge" style="margin-top:0.3rem;"></p>
            </div>
            <button class="close-drawer-btn" onclick="closeClientDrawer(null)">✕ إغلاق</button>
        </div>

        <div class="section-title-lux">✦ بيانات العميل العامة والاتصال</div>
        <div class="drawer-grid">
            <div class="drawer-field-box"><div class="field-label">رقم الهاتف</div><div class="field-value" id="df_phone"></div></div>
            <div class="drawer-field-box"><div class="field-label">البريد الإلكتروني</div><div class="field-value" id="df_email"></div></div>
            <div class="drawer-field-box"><div class="field-label">النطاق الجغرافي للعميل</div><div class="field-value" id="df_geo"></div></div>
            <div class="drawer-field-box"><div class="field-label">حجم الأسرة والحالة الاجتماعية</div><div class="field-value" id="df_social"></div></div>
        </div>

        <div class="section-title-lux">✦ الاهتمامات والاحتياجات العقارية للـ Lead</div>
        <div class="drawer-grid">
            <div class="drawer-field-box"><div class="field-label">الهدف الأساسي من الشراء</div><div class="field-value" id="df_purpose"></div></div>
            <div class="drawer-field-box"><div class="field-label">نوع الوحدة والمنشأة</div><div class="field-value" id="df_unit_type"></div></div>
            <div class="drawer-field-box"><div class="field-label">المنطقة أو المشروع المستهدف</div><div class="field-value" id="df_project"></div></div>
            <div class="drawer-field-box"><div class="field-label">المساحة المطلوبة / غرف النوم</div><div class="field-value" id="df_space_rooms"></div></div>
        </div>

        <div class="section-title-lux">✦ الموقف المالي والجدول الزمني المستهدف</div>
        <div class="drawer-grid">
            <div class="drawer-field-box"><div class="field-label">القدرة المالية والميزانية المرصودة</div><div class="field-value" id="df_budget"></div></div>
            <div class="drawer-field-box"><div class="field-label">نظام السداد والتدفق المفضّل</div><div class="field-value" id="df_payment_method"></div></div>
            <div class="drawer-field-box"><div class="field-label">المقدم النقدي المتاح دفعه متوقعاً</div><div class="field-value" id="df_down_payment" style="color:#00e676;"></div></div>
            <div class="drawer-field-box"><div class="field-label">الوقت المجدول لإبرام الصفقة وتوقيع العقد</div><div class="field-value" id="df_purchase_time"></div></div>
        </div>

        <div class="section-title-lux">✦ تفاصيل الاستحواذ والتفضيلات الترويجية للنظام</div>
        <div class="drawer-grid">
            <div class="drawer-field-box"><div class="field-label">قناة وقناة جلب العميل (Source)</div><div class="field-value" id="df_lead_source"></div></div>
            <div class="drawer-field-box"><div class="field-label">قناة التواصل المفضلة وأفضل توقيت لها</div><div class="field-value" id="df_pref_contact"></div></div>
            <div class="drawer-field-box"><div class="field-label">تاريخ آخر تواصل مجدول وموعد المتابعة القادمة</div><div class="field-value" id="df_dates"></div></div>
            <div class="drawer-field-box"><div class="field-label">موافقة العميل الاستلام لرسائل التسويق وعروضنا</div><div class="field-value" id="df_marketing_agree"></div></div>
        </div>

        <div class="section-title-lux">✦ حالة بطاقة الذكية المرتبطة بنظام VIP للبرلسي</div>
        <div class="drawer-grid" id="smart_card_section">
            </div>

        <div class="section-title-lux">✦ الملاحظات الخاصة بالإدارة والـ Sales الملحقة بالملف</div>
        <div class="drawer-field-box" style="background:#111113;">
            <p id="df_notes" style="font-size: 0.9rem; color: #76767A; line-height: 1.6; white-space: pre-line;"></p>
        </div>

        <div class="section-title-lux">✦ سجل الإجراءات والمتابعات التفاعلية الكاملة للـ CRM</div>
        <div class="crm-timeline" id="history_timeline_section">
            </div>

    </div>
</div>

<script>
    // تمرير كافة قواميس الترجمة المجهزة للفرونت إند لمنع ظهور أي نصوص إنجليزية للآدمن
    const statusMap = @json($statusMap);
    const sourceMap = @json($sourceMap);
    const purposeMap = @json($purposeMap);
    const unitTypeMap = @json($unitTypeMap);
    const budgetMap = @json($budgetMap);
    const paymentMap = @json($paymentMap);
    const purchaseTimeMap = @json($purchaseTimeMap);
    const contactMap = @json($contactMap);
    const contactTimeMap = @json($contactTimeMap);
    const cardStatusMap = @json($cardStatusMap);
    const priorityMap = @json($priorityMap);

    function openClientDrawer(client, activeCard, histories) {
        document.getElementById('drawer_full_name').innerText = client.full_name;
        
        // شارة الحالة
        const statusText = statusMap[client.lead_status] || client.lead_status;
        document.getElementById('drawer_lead_status_badge').innerHTML = `<span class="badge-lux status-negotiation">${statusText}</span>`;
        
        // الحقول الأساسية وتعديل النصوص
        document.getElementById('df_phone').innerText = client.phone;
        document.getElementById('df_email').innerText = client.email || 'غير مسجل بريد إلكتروني';
        document.getElementById('df_geo').innerText = `${client.governorate} - ${client.city || 'بدون تحديد مدينة'}`;
        
        const marital = client.marital_status ? client.marital_status : 'غير محدد';
        const fSize = client.family_size ? `(حجم الأسرة: ${client.family_size})` : '';
        document.getElementById('df_social').innerText = `${marital} ${fSize}`;

        document.getElementById('df_purpose').innerText = purposeMap[client.purpose] || 'غير محدد';
        document.getElementById('df_unit_type').innerText = unitTypeMap[client.unit_type] || 'غير محدد';
        document.getElementById('df_project').innerText = client.project_or_city || 'يبحث في كافة المشاريع الحالية';
        
        const area = client.required_area ? `${client.required_area} م²` : 'المساحة غير محددة';
        const beds = client.bedrooms ? `/ عدد ${client.bedrooms} غرف` : '';
        document.getElementById('df_space_rooms').innerText = `${area} ${beds}`;

        document.getElementById('df_budget').innerText = budgetMap[client.budget] || 'تحت النقاش المالي';
        document.getElementById('df_payment_method').innerText = paymentMap[client.payment_method] || 'مرن';
        
        const downPaymentFormatted = client.expected_down_payment ? Number(client.expected_down_payment).toLocaleString('ae-EG') + ' ج.م' : 'لم يحدد مبلغ محدد';
        document.getElementById('df_down_payment').innerText = downPaymentFormatted;
        document.getElementById('df_purchase_time').innerText = purchaseTimeMap[client.purchase_time] || 'قيد فحص جدول الشراء';

        document.getElementById('df_lead_source').innerText = sourceMap[client.lead_source] || 'غير معروف';
        
        const prefContact = contactMap[client.preferred_contact] || 'مكالمة';
        const prefTime = contactTimeMap[client.contact_time] || 'أي وقت';
        document.getElementById('df_pref_contact').innerText = `${prefContact} (${prefTime})`;

        const lastContact = client.last_contact_at ? new Date(client.last_contact_at).toLocaleDateString('ar-EG') : 'لا يوجد اتصال مسبق';
        const nextFollow = client.next_follow_up_at ? new Date(client.next_follow_up_at).toLocaleDateString('ar-EG') : 'غير مجدول حالياً';
        document.getElementById('df_dates').innerText = `آخر اتصال: ${lastContact} / المتابعة القادمة: ${nextFollow}`;

        document.getElementById('df_marketing_agree').innerText = client.agree_marketing ? 'نعم، يوافق على تلقي النشرات والحملات الإعلانية' : 'لا يوافق / يرفض الاستقبال ترويجياً';
        document.getElementById('df_notes').innerText = client.notes || 'لا يوجد أي ملاحظات ملحقة بملف العميل من قبل المبيعات حتى الآن.';

        // تعبئة قسم البطاقة الذكية للعميل
        const cardSection = document.getElementById('smart_card_section');
        if(activeCard) {
            cardSection.innerHTML = `
                <div class="drawer-field-box" style="width:100%; border-color:#d4af37;"><div class="field-label">رقم بطاقة العضوية VIP الذكية</div><div class="field-value" style="letter-spacing:1px; color:#d4af37;">${activeCard.card_number}</div></div>
                <div class="drawer-field-box"><div class="field-label">حالة الكارت الحالية بالنظام</div><div class="field-value">${cardStatusMap[activeCard.status] || activeCard.status}</div></div>
                <div class="drawer-field-box"><div class="field-label">ملاحظة موظف الفحص للكارت</div><div class="field-value">${activeCard.status_note || 'لا يوجد ملاحظات ملحقة'}</div></div>
            `;
        } else {
            cardSection.innerHTML = `<div class="drawer-field-box" style="width:100%; text-align:center; color:#76767A;">لم يقم هذا العميل بتقديم أي طلب للحصول على البطاقة الذكية حتى اللحظة.</div>`;
        }

        // بناء تايم لاين كامل بكافة السجلات والحركات التفاعلية للـ CRM
        const timelineSection = document.getElementById('history_timeline_section');
        timelineSection.innerHTML = '';
        if(histories && histories.length > 0) {
            histories.forEach(h => {
                const dateStr = new Date(h.created_at).toLocaleString('ar-EG');
                const priorityTxt = priorityMap[h.priority] || 'عادية';
                timelineSection.innerHTML += `
                    <div class="crm-timeline-item">
                        <div class="timeline-meta">⏱ التاريخ: ${dateStr} | الأولوية: <span style="color:#B40000;">${priorityTxt}</span></div>
                        <div style="font-weight:600; color:#E4DCC7; font-size:0.9rem; margin-top:0.2rem;">${h.title}</div>
                        <div class="timeline-content-txt">${h.description || 'إجراء نظام تلقائي مكتمل.'}</div>
                    </div>
                `;
            });
        } else {
            timelineSection.innerHTML = `<p style="color:#76767A; text-align:center; font-size:0.85rem; padding:1rem 0;">لا يوجد سجل تفاعلات مدوّن مسبقاً لهذا العميل.</p>`;
        }

        // إظهار اللوحة الجانبية
        document.getElementById('clientCrmDrawerOverlay').style.display = 'flex';
    }

    function closeClientDrawer(e) {
        if (!e || e.target === document.getElementById('clientCrmDrawerOverlay')) {
            document.getElementById('clientCrmDrawerOverlay').style.display = 'none';
        }
    }
</script>
@endsection