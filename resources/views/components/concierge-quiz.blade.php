@php
    $activeSteps = \App\Models\ConciergeStep::active()->get();

    // في حال عدم وجود خطوات في قاعدة البيانات، يتم استخدام الافتراضيات بأمان تام
    if ($activeSteps->isEmpty()) {
        $activeSteps = collect([
            (object)[
                'id' => 1,
                'sort_order' => 1,
                'title_ar' => 'ما هو غرضك الأساسي من البحث؟',
                'subtitle_ar' => 'اختر ما يناسب تطلعاتك لنرشح لك الفرص الأكثر دقة وربحية.',
                'step_type' => 'options_grid',
                'target_field' => 'purpose',
                'options' => [
                    ['title_ar' => 'سكن فاخر', 'value' => 'residential', 'icon' => '🏡', 'extra_values' => ['unit_type' => 'apartment']],
                    ['title_ar' => 'استثمار تجاري', 'value' => 'investment', 'icon' => '📈', 'extra_values' => ['unit_type' => 'shop']],
                    ['title_ar' => 'عيادة طبية', 'value' => 'clinic', 'icon' => '🩺', 'extra_values' => ['unit_type' => 'clinic']],
                    ['title_ar' => 'مقر إداري', 'value' => 'office', 'icon' => '💼', 'extra_values' => ['unit_type' => 'office']],
                    ['title_ar' => 'مصيف وساحلي', 'value' => 'summer', 'icon' => '🏖️', 'extra_values' => ['unit_type' => 'chalet']]
                ]
            ],
            (object)[
                'id' => 2,
                'sort_order' => 2,
                'title_ar' => 'أين تفضل موقع وحدتك القادمة؟',
                'subtitle_ar' => 'نغطي أفضل المواقع الاستراتيجية الواعدة بأعلى عائد استثماري.',
                'step_type' => 'options_grid',
                'target_field' => 'project_or_city',
                'options' => [
                    ['title_ar' => 'القاهرة الجديدة', 'value' => 'القاهرة الجديدة', 'icon' => '🏙️'],
                    ['title_ar' => 'الشيخ زايد', 'value' => 'الشيخ زايد', 'icon' => '🌲'],
                    ['title_ar' => 'العاصمة الإدارية', 'value' => 'العاصمة الإدارية', 'icon' => '🏛️'],
                    ['title_ar' => 'الساحل الشمالي', 'value' => 'الساحل الشمالي', 'icon' => '🌊'],
                    ['title_ar' => 'أبراج سانا تاور', 'value' => 'سانا تاور', 'icon' => '⭐']
                ]
            ],
            (object)[
                'id' => 3,
                'sort_order' => 3,
                'title_ar' => 'ما هي الميزانية المناسبة لك؟',
                'subtitle_ar' => 'تسهيلات سداد مريحة بدون فوائد مع مرونة كاملة في الدفعات.',
                'step_type' => 'options_grid',
                'target_field' => 'budget',
                'options' => [
                    ['title_ar' => '2 - 4 مليون', 'value' => '2_4m', 'icon' => '💵'],
                    ['title_ar' => '4 - 6 مليون', 'value' => '4_6m', 'icon' => '💰'],
                    ['title_ar' => '6 - 10 مليون', 'value' => '6_10m', 'icon' => '💎'],
                    ['title_ar' => '10 - 20 مليون', 'value' => '10_20m', 'icon' => '👑'],
                    ['title_ar' => 'أكثر من 20 مليون', 'value' => 'gt_20m', 'icon' => '🏛️']
                ]
            ],
            (object)[
                'id' => 4,
                'sort_order' => 4,
                'title_ar' => 'وجدنا وحدات مطابقة لمواصفاتك تماماً!',
                'subtitle_ar' => 'أدخل اسمك ورقم هاتفك لنرسل لك ملف ترشيحات الوحدات المتاحة فوراً.',
                'step_type' => 'lead_form',
                'target_field' => 'contact_info',
                'options' => null
            ]
        ]);
    }

    $totalStepsCount = $activeSteps->count();

    // فحص معرفة بيانات المستخدم
    $currentIdentity = request()->attributes->get('identity');
    $isKnownUser = false;
    if ($currentIdentity && \App\Models\Client::where('identity_id', $currentIdentity->id)->exists()) {
        $isKnownUser = true;
    }
    if (auth()->check()) {
        $isKnownUser = true;
    }
@endphp

<style>
    /* ===================================================
       مستشارك العقاري الذكي - تجربة التقاط عملاء بدون ملل أو مفاجأة
       Frictionless Real Estate Lead Capture Concierge
       =================================================== */
    .concierge-floating-badge {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 9990;
        background: linear-gradient(135deg, #161619 0%, #0a0a0b 100%);
        border: 1px solid rgba(215, 182, 74, 0.4);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(215, 182, 74, 0.2);
        color: #d7b64a;
        padding: 12px 20px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        backdrop-filter: blur(10px);
    }

    .concierge-floating-badge:hover {
        transform: translateY(-4px) scale(1.03);
        border-color: #d7b64a;
        box-shadow: 0 15px 35px rgba(215, 182, 74, 0.3);
    }

    .concierge-floating-badge .sparkle-icon {
        font-size: 1.2rem;
        animation: pulseSparkle 2s infinite;
    }

    @keyframes pulseSparkle {
        0%, 100% { transform: scale(1) rotate(0deg); }
        50% { transform: scale(1.2) rotate(15deg); color: #fff; }
    }

    /* شاشة المودال التفاعلي */
    .quiz-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .quiz-modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .quiz-container {
        width: 100%;
        max-width: 620px;
        background: #0f0f12;
        border: 1px solid rgba(215, 182, 74, 0.3);
        border-radius: 24px;
        padding: clamp(1.8rem, 4vw, 2.6rem);
        position: relative;
        direction: rtl;
        font-family: 'Cairo', sans-serif;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 30px rgba(215, 182, 74, 0.1);
        animation: springPop 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes springPop {
        from { transform: scale(0.92) translateY(25px); opacity: 0; }
        to { transform: scale(1) translateY(0); opacity: 1; }
    }

    .quiz-close-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #8E8E93;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.2s;
    }

    .quiz-close-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border-color: rgba(239, 68, 68, 0.4);
    }

    .quiz-progress-wrapper {
        margin-bottom: 2rem;
    }

    .quiz-progress-track {
        height: 6px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 8px;
    }

    .quiz-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #d7b64a, #f3cf65);
        width: 25%;
        border-radius: 10px;
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .quiz-step {
        display: none;
    }

    .quiz-step.active {
        display: block;
        animation: fadeInStep 0.35s ease forwards;
    }

    @keyframes fadeInStep {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .quiz-header h3 {
        color: #F0F0F0;
        font-size: clamp(1.2rem, 2.5vw, 1.5rem);
        font-weight: 800;
        margin-bottom: 0.4rem;
    }

    .quiz-header p {
        color: #8E8E93;
        font-size: 0.9rem;
        margin-bottom: 1.6rem;
    }

    .quiz-options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(135px, 1fr));
        gap: 12px;
        margin-bottom: 2rem;
    }

    .quiz-option-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 1.2rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .quiz-option-card:hover {
        background: rgba(215, 182, 74, 0.08);
        border-color: rgba(215, 182, 74, 0.4);
        transform: translateY(-3px);
    }

    .quiz-option-card.selected {
        background: rgba(215, 182, 74, 0.15);
        border-color: #d7b64a;
        box-shadow: 0 0 20px rgba(215, 182, 74, 0.25);
    }

    .quiz-option-card .opt-icon {
        font-size: 1.8rem;
    }

    .quiz-option-card .opt-title {
        color: #F0F0F0;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .quiz-nav-btns {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .btn-quiz-next {
        flex: 1;
        background: linear-gradient(135deg, #d7b64a 0%, #b89832 100%);
        color: #000;
        font-weight: 800;
        font-size: 1rem;
        padding: 14px 24px;
        border-radius: 14px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        font-family: 'Cairo', sans-serif;
    }

    .btn-quiz-next:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
    }

    .btn-quiz-prev {
        background: rgba(255, 255, 255, 0.05);
        color: #8E8E93;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 14px 20px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Cairo', sans-serif;
    }

    .btn-quiz-prev:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .btn-quiz-dismiss {
        background: none;
        border: none;
        color: #6B7280;
        font-size: 0.85rem;
        cursor: pointer;
        font-family: 'Cairo', sans-serif;
        text-decoration: underline;
        margin-top: 1rem;
        display: block;
        width: 100%;
        text-align: center;
        transition: color 0.2s;
    }

    .btn-quiz-dismiss:hover {
        color: #9CA3AF;
    }

    .quiz-input-group {
        margin-bottom: 1.2rem;
        text-align: right;
    }

    .quiz-input-group label {
        display: block;
        color: #8E8E93;
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        font-weight: 600;
    }

    .quiz-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        padding: 14px 18px;
        color: #fff;
        font-size: 1rem;
        font-family: 'Cairo', sans-serif;
        outline: none;
        box-sizing: border-box;
    }

    .quiz-input:focus {
        border-color: #d7b64a;
        background: rgba(215, 182, 74, 0.05);
    }

    .match-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(215, 182, 74, 0.2);
        border-radius: 14px;
        padding: 1rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
</style>

{{-- زر التشغيل العائم (Floating Trigger) --}}
<div class="concierge-floating-badge" onclick="openConciergeModal('badge_click')" id="conciergeFloatingBadge" title="المستشار العقاري الذكي">
    <span class="sparkle-icon">✨</span>
    <span>المستشار الذكي</span>
</div>

{{-- نافذة المودال التفاعلي --}}
<div class="quiz-modal-overlay" id="conciergeModal">
    <div class="quiz-container">
        <button type="button" class="quiz-close-btn" onclick="dismissConciergeModal('close_btn')" title="إغلاق">✕</button>

        <div class="quiz-progress-wrapper">
            <div style="display:flex; justify-content:space-between; font-size:0.75rem; color:#8E8E93;">
                <span id="stepCounterText">الخطوة 1 من {{ $totalStepsCount }}</span>
                <span id="stepProgressPercent">25%</span>
            </div>
            <div class="quiz-progress-track">
                <div class="quiz-progress-fill" id="quizProgressFill"></div>
            </div>
        </div>

        {{-- توليد الخطوات والتابات بشكل ديناميكي من قاعدة البيانات --}}
        @foreach($activeSteps as $index => $step)
            @php
                $stepNumber = $index + 1;
                $isFirst = ($stepNumber === 1);
                $isLast = ($stepNumber === $totalStepsCount);
            @endphp

            <div class="quiz-step {{ $isFirst ? 'active' : '' }}" id="quizStep{{ $stepNumber }}" data-step-index="{{ $stepNumber }}" data-field="{{ $step->target_field }}">
                <div class="quiz-header">
                    <h3>{{ $step->title_ar }}</h3>
                    @if($step->subtitle_ar)
                        <p>{{ $step->subtitle_ar }}</p>
                    @endif
                </div>

                @if($step->step_type === 'options_grid')
                    {{-- شبكة الكروت التفاعلية --}}
                    <div class="quiz-options-grid">
                        @if(is_array($step->options))
                            @foreach($step->options as $optIdx => $opt)
                                @php
                                    $optVal = $opt['value'] ?? ($opt['title_ar'] ?? '');
                                    $extraJson = !empty($opt['extra_values']) ? json_encode($opt['extra_values']) : '{}';
                                @endphp
                                <div class="quiz-option-card {{ $optIdx === 0 ? 'selected' : '' }}"
                                     onclick="selectQuizDynamicOption('{{ $step->target_field }}', '{{ $optVal }}', this, {{ $extraJson }})">
                                    <div class="opt-icon">{{ $opt['icon'] ?? '🏡' }}</div>
                                    <div class="opt-title">{{ $opt['title_ar'] ?? $optVal }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="quiz-nav-btns">
                        @if(!$isFirst)
                            <button type="button" class="btn-quiz-prev" onclick="goToQuizStep({{ $stepNumber - 1 }})">رجوع</button>
                        @endif
                        <button type="button" class="btn-quiz-next" onclick="goToQuizStep({{ $stepNumber + 1 }})">
                            <span>متابعة</span>
                            <span>←</span>
                        </button>
                    </div>

                @elseif($step->step_type === 'lead_form')
                    {{-- نموذج الالتقاط السريع للبيانات الأساسية (اسم وهاتف) --}}
                    <form id="conciergeLeadForm" onsubmit="submitConciergeQuiz(event)">
                        <div class="quiz-input-group">
                            <label>الاسم الكريم *</label>
                            <input type="text" id="quiz_name" required placeholder="مثال: م. أحمد محمد" class="quiz-input">
                        </div>
                        <div class="quiz-input-group">
                            <label>رقم الهاتف (الواتساب) *</label>
                            <input type="tel" id="quiz_phone" required placeholder="01xxxxxxxxx" class="quiz-input">
                        </div>

                        <div class="quiz-nav-btns">
                            @if(!$isFirst)
                                <button type="button" class="btn-quiz-prev" onclick="goToQuizStep({{ $stepNumber - 1 }})">رجوع</button>
                            @endif
                            <button type="submit" class="btn-quiz-next" id="quizSubmitBtn">
                                <span id="quizSubmitText">عرض الترشيحات واستلام الكتالوج فوراً</span>
                                <i class="fa-brands fa-whatsapp"></i>
                            </button>
                        </div>
                    </form>

                    {{-- صندوق نتائج المطابقة بعد الإرسال --}}
                    <div id="quizMatchResults" class="match-results-box" style="display:none; margin-top:1rem;">
                        <div style="background:rgba(16,185,129,0.15); border:1px solid #10B981; color:#34d399; padding:0.9rem; border-radius:12px; text-align:center; margin-bottom:1rem; font-weight:700;">
                            ✓ تم تسجيل اهتمامك بنجاح! إليك أبرز المشاريع المتطابقة:
                        </div>
                        <div id="projectsMatchList"></div>
                    </div>

                @elseif($step->step_type === 'text_input')
                    {{-- حقل إدخال نصي حر --}}
                    <div class="quiz-input-group">
                        <label>{{ $step->title_ar }}</label>
                        <input type="text" id="quiz_custom_{{ $step->target_field }}"
                               placeholder="اكتب إجابتك هنا..."
                               class="quiz-input"
                               oninput="quizState['{{ $step->target_field }}'] = this.value">
                    </div>

                    <div class="quiz-nav-btns">
                        @if(!$isFirst)
                            <button type="button" class="btn-quiz-prev" onclick="goToQuizStep({{ $stepNumber - 1 }})">رجوع</button>
                        @endif
                        <button type="button" class="btn-quiz-next" onclick="goToQuizStep({{ $stepNumber + 1 }})">
                            <span>متابعة</span>
                            <span>←</span>
                        </button>
                    </div>
                @endif

                {{-- زر تخطي خفيف لا يزعج العميل --}}
                <button type="button" class="btn-quiz-dismiss" onclick="dismissConciergeModal('skip_link')">
                    تخطي الآن والمتابعة في تصفح الموقع لاحقاً
                </button>
            </div>
        @endforeach

    </div>
</div>

<script>
    // حالة إجابات العميل التفاعلية
    const quizState = {
        purpose: 'residential',
        unit_type: 'apartment',
        project_or_city: 'القاهرة الجديدة',
        budget: '4_6m',
        payment_method: 'installments'
    };

    const TOTAL_STEPS = {{ $totalStepsCount }};
    const IS_KNOWN_USER = {{ $isKnownUser ? 'true' : 'false' }};
    let currentQuizStep = 1;
    let autoOpenedFired = false;

    // فتح المودال يدوياً أو تلقائياً
    function openConciergeModal(source = 'manual') {
        const modal = document.getElementById('conciergeModal');
        if (!modal) return;
        modal.classList.add('active');
        trackBehaviorEvent('quiz_open', null, { source: source });
    }

    // إغلاق المودال مع الحفظ في الـ Session حتى لا ينبثق مجدداً في نفس الجلسة
    function dismissConciergeModal(reason = 'close') {
        const modal = document.getElementById('conciergeModal');
        if (!modal) return;
        modal.classList.remove('active');
        sessionStorage.setItem('albrolosy_concierge_dismissed', 'true');
        trackBehaviorEvent('quiz_dismiss', null, { reason: reason });
    }

    function selectQuizDynamicOption(field, value, element, extraValues = {}) {
        quizState[field] = value;

        // دمج أي قيم إضافية مرتبطة بالكارت (مثل unit_type)
        if (extraValues && typeof extraValues === 'object') {
            for (const [k, v] of Object.entries(extraValues)) {
                quizState[k] = v;
            }
        }

        if (element) {
            const siblings = element.parentElement.querySelectorAll('.quiz-option-card');
            siblings.forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
        }
    }

    function goToQuizStep(step) {
        if (step < 1 || step > TOTAL_STEPS) return;

        currentQuizStep = step;
        for (let i = 1; i <= TOTAL_STEPS; i++) {
            const el = document.getElementById(`quizStep${i}`);
            if (el) el.classList.remove('active');
        }

        const activeEl = document.getElementById(`quizStep${step}`);
        if (activeEl) activeEl.classList.add('active');

        // تحديث شريط التقدم
        const percent = Math.round((step / TOTAL_STEPS) * 100);
        document.getElementById('quizProgressFill').style.width = `${percent}%`;
        document.getElementById('stepCounterText').innerText = `الخطوة ${step} من ${TOTAL_STEPS}`;
        document.getElementById('stepProgressPercent').innerText = `${percent}%`;

        trackBehaviorEvent('quiz_step', null, { step: step, state: quizState });
    }

    async function submitConciergeQuiz(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('quizSubmitBtn');
        const submitText = document.getElementById('quizSubmitText');
        if (submitBtn) submitBtn.disabled = true;
        if (submitText) submitText.innerText = 'جاري مطابقة وترشيح الوحدات...';

        const payload = {
            full_name: document.getElementById('quiz_name')?.value.trim() || 'عميل مهتم',
            phone: document.getElementById('quiz_phone')?.value.trim() || '',
            purpose: quizState.purpose || 'residential',
            unit_type: quizState.unit_type || 'apartment',
            project_or_city: quizState.project_or_city || '',
            budget: quizState.budget || '4_6m',
            payment_method: quizState.payment_method || 'installments',
            custom_answers: quizState,
            _token: document.querySelector('meta[name="csrf-token"]')?.content
        };

        try {
            const response = await fetch('/api/v1/lead/quiz-submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': payload._token
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // حفظ أن العميل قام بالتسجيل حتى لا يفتح له النموذج مجدداً
                localStorage.setItem('albrolosy_lead_submitted', 'true');
                sessionStorage.setItem('albrolosy_concierge_dismissed', 'true');

                const form = document.getElementById('conciergeLeadForm');
                if (form) form.style.display = 'none';

                const resultsBox = document.getElementById('quizMatchResults');
                const listEl = document.getElementById('projectsMatchList');
                if (listEl) listEl.innerHTML = '';

                if (data.matching_projects && data.matching_projects.length > 0) {
                    data.matching_projects.forEach(p => {
                        listEl.innerHTML += `
                            <div class="match-card">
                                <div style="flex:1;">
                                    <div style="font-weight:800; color:#F0F0F0; font-size:1rem;">${p.name_ar}</div>
                                    <div style="font-size:0.8rem; color:#8E8E93;">📍 ${p.location_ar || 'موقع مميز'}</div>
                                    <a href="/projects/${p.id}" target="_blank" style="color:#d7b64a; font-size:0.85rem; font-weight:700; text-decoration:none; display:inline-block; margin-top:4px;">
                                        عرض تفاصيل المشروع والوحدات المتاحة ←
                                    </a>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    listEl.innerHTML = `<p style="color:#8E8E93; text-align:center;">سيتواصل معك مستشارك العقاري لترشيح أفضل قائمة وحدات مناسبة لاختياراتك.</p>`;
                }

                if (resultsBox) resultsBox.style.display = 'block';
            } else {
                alert(data.message || 'يرجى مراجعة البيانات المدخلة.');
                if (submitBtn) submitBtn.disabled = false;
                if (submitText) submitText.innerText = 'عرض الترشيحات واستلام الكتالوج فوراً';
            }
        } catch (err) {
            console.error('Quiz submit error:', err);
            if (submitBtn) submitBtn.disabled = false;
            if (submitText) submitText.innerText = 'عرض الترشيحات واستلام الكتالوج فوراً';
        }
    }

    // تتبع السلوك الخفيف
    function trackBehaviorEvent(eventType, projectId = null, metadata = {}) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            fetch('/api/v1/behavior/track', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    event_type: eventType,
                    project_id: projectId,
                    page_url: window.location.pathname,
                    page_title: document.title,
                    metadata: metadata
                })
            }).catch(() => {});
        } catch(e) {}
    }

    // إغلاق المودال عند النقر على الخلفية المعتمة
    document.getElementById('conciergeModal')?.addEventListener('click', function(e) {
        if (e.target === this) dismissConciergeModal('backdrop_click');
    });

    // ==============================================================
    // نظام الفتح التلقائي الذكي (Smart Non-Intrusive Scroll Auto-Open)
    // يفتح فقط لو بيانات المستخدم غير موجودة ومنعرفش عنه حاجة وبعد ما يفر شوية
    // ==============================================================
    (function initSmartAutoConcierge() {
        // إذا كان العميل معروفاً من الباك إند أو سبق وسجل في المتصفح أو أغلق النموذج في الجلسة الحالية: لا نفتح
        const isSubmitted = localStorage.getItem('albrolosy_lead_submitted') === 'true';
        const isDismissed = sessionStorage.getItem('albrolosy_concierge_dismissed') === 'true';

        if (IS_KNOWN_USER || isSubmitted || isDismissed) {
            return;
        }

        let hasScrolledEnough = false;

        function checkScrollTrigger() {
            if (autoOpenedFired || hasScrolledEnough) return;

            const scrollY = window.scrollY || window.pageYOffset;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? (scrollY / docHeight) : 0;

            // عندما يتصفح الزائر 30% من الصفحة أو يمر بـ 450 بكسل (بعد ما يفر شوية)
            if (scrollY > 450 || scrollPercent > 0.30) {
                hasScrolledEnough = true;
                window.removeEventListener('scroll', checkScrollTrigger);

                // تأخير لطيف لمدة ثانية واحدة لضمان تجربة سلسة بدون مباغتة
                setTimeout(() => {
                    if (!autoOpenedFired && !sessionStorage.getItem('albrolosy_concierge_dismissed')) {
                        autoOpenedFired = true;
                        sessionStorage.setItem('albrolosy_concierge_auto_opened', 'true');
                        openConciergeModal('auto_scroll_trigger');
                    }
                }, 1200);
            }
        }

        window.addEventListener('scroll', checkScrollTrigger, { passive: true });

        // بديل زمني: إذا أمضى الزائر 15 ثانية يتصفح الموقع وقام بأي حركة تمرير
        setTimeout(() => {
            if (!autoOpenedFired && !sessionStorage.getItem('albrolosy_concierge_dismissed')) {
                const scrollY = window.scrollY || window.pageYOffset;
                if (scrollY > 150) {
                    autoOpenedFired = true;
                    sessionStorage.setItem('albrolosy_concierge_auto_opened', 'true');
                    openConciergeModal('auto_time_trigger');
                }
            }
        }, 15000);
    })();
</script>
