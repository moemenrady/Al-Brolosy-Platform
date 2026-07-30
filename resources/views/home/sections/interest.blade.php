@include('home.styles.interest')

<section id="consultation" class="interest-section">
    <div class="interest-container">

        <div class="section-header text-center">
            @if (isset($client))
                <h2 class="section-title" data-en="Your Real Estate Profile" data-ar="ملفك العقاري لدى البرلسي">ملفك
                    العقاري لدى البرلسي</h2>
                <p class="section-subtitle"
                    data-en="Review and update your preferences to get the best tailored offers easily."
                    data-ar="مرحباً بك مجدداً. حدّث تفضيلاتك العقارية بنقرات بسيطة للحصول على الفرص الأنسب لك.">مرحباً بك
                    مجدداً. حدّث تفضيلاتك العقارية بنقرات بسيطة للحصول على الفرص الأنسب لك.</p>
            @else
                <h2 class="section-title" data-en="Register Your Interest" data-ar="سجل اهتماماتك العقارية">سجل
                    اهتماماتك العقارية</h2>
                <p class="section-subtitle"
                    data-en="Select your preferences effortlessly. No typing required except for your basic info."
                    data-ar="انضم لنخب عملاء البرلسي. حدد تفضيلاتك بكل سهولة دون الحاجة للكتابة باستثناء بياناتك الأساسية.">
                    انضم لنخب عملاء البرلسي. حدد تفضيلاتك بكل سهولة دون الحاجة للكتابة باستثناء بياناتك الأساسية.</p>
            @endif
        </div>

        <div class="form-progress-wrapper">
            <div class="progress-track">
                <div class="progress-bar" id="form-progress"></div>
            </div>
            <div class="progress-steps">
                <span class="step-indicator active" data-step="1">1</span>
                <span class="step-indicator" data-step="2">2</span>
                <span class="step-indicator" data-step="3">3</span>
            </div>
        </div>
        @if (isset($client) && $client)
            <div class="client-profile-banner">

                <div class="profile-info">

                    <div class="profile-avatar">

                        <img src="{{ $client->photo ? asset($client->photo) : asset('images/default-avatar.png') }}"
                            alt="{{ $client->full_name }}">

                    </div>

                    <div class="profile-content">

                        <span class="profile-badge">
                            <i class="fas fa-check-circle"></i>

                            <span data-ar="تم إنشاء ملفك الشخصي" data-en="Your profile is ready">
                                تم إنشاء ملفك الشخصي
                            </span>

                        </span>

                        <h3>

                            <span data-ar="مرحباً" data-en="Welcome">
                                مرحباً
                            </span>

                            {{ $client->full_name }}

                        </h3>

                        <p data-ar="يمكنك الآن متابعة حالة طلباتك، بطاقة العميل الذكية، سجل التعاملات، وتحديث بياناتك من خلال ملفك الشخصي."
                            data-en="Access your smart card, follow-up history, requests and update your information from your client profile.">

                            يمكنك الآن متابعة حالة طلباتك، بطاقة العميل الذكية، سجل التعاملات، وتحديث بياناتك من خلال
                            ملفك الشخصي.

                        </p>

                    </div>

                </div>

                <div class="profile-actions">

                    <a href="{{ route('client.profile') }}" class="btn-profile">

                        <i class="fas fa-user-circle"></i>

                        <span data-ar="الذهاب إلى الملف الشخصي" data-en="Open Client Profile">

                            الذهاب إلى الملف الشخصي

                        </span>

                    </a>

                </div>

            </div>
        @endif
        <form id="smart-interest-form" class="smart-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lead_source" value="website">

            <div class="form-step active" data-step="1">
                <div class="step-title" data-en="Basic Information" data-ar="البيانات الأساسية">البيانات الأساسية</div>
                <div class="inputs-grid">
                    <div class="input-wrapper">
                        <label data-en="Full Name *" data-ar="الاسم بالكامل *">الاسم بالكامل *</label>
                        <input type="text" name="full_name" required value="{{ $client->full_name ?? '' }}"
                            placeholder="John Doe" data-placeholder-ar="الاسم ثلاثي أو ثنائي"
                            data-placeholder-en="John Doe">
                    </div>
                    <div class="input-wrapper">
                        <label data-en="Phone Number *" data-ar="رقم الهاتف *">رقم الهاتف *</label>
                        <input type="tel" name="phone" required value="{{ $client->phone ?? '' }}"
                            placeholder="+20 100..." data-placeholder-ar="+20 100..." data-placeholder-en="+20 100...">
                    </div>
                    <div class="input-wrapper">
                        <label data-en="Governorate *" data-ar="المحافظة *">المحافظة *</label>
                        <input type="text" name="governorate" required value="{{ $client->governorate ?? '' }}"
                            placeholder="Cairo" data-placeholder-ar="مثال: القاهرة، الجيزة"
                            data-placeholder-en="e.g. Cairo">
                    </div>
                    <div class="input-wrapper">
                        <label class="group-label" data-en="City (Optional)"
                            data-ar="المدينة (اختياري)"><span>المدينة</span><span
                                class="label-optional">(اختياري)</span></label>
                        <input type="text" name="city" value="{{ $client->city ?? '' }}" placeholder="New Cairo"
                            data-placeholder-ar="مثال: التجمع الخامس" data-placeholder-en="e.g. New Cairo">
                    </div>
                    <div class="input-wrapper full-width">
                        <label class="group-label" data-en="Personal Photo (Optional)"
                            data-ar="الصورة الشخصية (اختياري)"><span>الصورة الشخصية</span><span
                                class="label-optional">(اختياري)</span></label>
                        <div class="file-upload-container">
                            <div class="file-upload-trigger">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <span id="file-upload-text" data-en="Choose Photo" data-ar="اضغط لاختيار صورة">اضغط
                                    لاختيار صورة</span>
                            </div>
                            <span class="file-name-preview" id="file-name-preview"></span>
                            <input type="file" name="photo" id="photo-input" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-step" data-step="2">
                <div class="step-title" data-en="Financial Profile" data-ar="الملف المادي والشخصي">الملف المادي
                    والشخصي</div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Marital Status (Optional)"
                        data-ar="الحالة الاجتماعية (اختياري)"><span>الحالة الاجتماعية</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="marital_status" value="single"
                                {{ isset($client) && $client->marital_status == 'single' ? 'checked' : '' }}><span
                                data-en="Single" data-ar="أعزب">أعزب</span></label>
                        <label class="badge-card"><input type="radio" name="marital_status" value="married"
                                {{ isset($client) && $client->marital_status == 'married' ? 'checked' : '' }}><span
                                data-en="Married" data-ar="متزوج">متزوج</span></label>
                        <label class="badge-card"><input type="radio" name="marital_status" value="divorced"
                                {{ isset($client) && $client->marital_status == 'divorced' ? 'checked' : '' }}><span
                                data-en="Divorced" data-ar="مطلق">مطلق</span></label>
                        <label class="badge-card"><input type="radio" name="marital_status" value="widowed"
                                {{ isset($client) && $client->marital_status == 'widowed' ? 'checked' : '' }}><span
                                data-en="Widowed" data-ar="أرمل">أرمل</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Family Size (Optional)"
                        data-ar="عدد أفراد الأسرة (اختياري)"><span>عدد أفراد الأسرة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="family_size" value="1"
                                {{ isset($client) && $client->family_size == '1' ? 'checked' : '' }}><span>1</span></label>
                        <label class="badge-card"><input type="radio" name="family_size" value="2-3"
                                {{ isset($client) && $client->family_size == '2-3' ? 'checked' : '' }}><span>2-3</span></label>
                        <label class="badge-card"><input type="radio" name="family_size" value="4-5"
                                {{ isset($client) && $client->family_size == '4-5' ? 'checked' : '' }}><span>4-5</span></label>
                        <label class="badge-card"><input type="radio" name="family_size" value="6+"
                                {{ isset($client) && $client->family_size == '6+' ? 'checked' : '' }}><span>+6</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Expected Budget (Optional)"
                        data-ar="الميزانية المتوقعة (اختياري)"><span>الميزانية المتوقعة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-5">
                        <label class="badge-card"><input type="radio" name="budget" value="lt_2m"
                                {{ isset($client) && $client->budget == 'lt_2m' ? 'checked' : '' }}><span
                                data-en="< 2M" data-ar="أقل من 2 مليون">أقل من 2 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="2_4m"
                                {{ isset($client) && $client->budget == '2_4m' ? 'checked' : '' }}><span
                                data-en="2M - 4M" data-ar="2 - 4 مليون">2 - 4 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="4_6m"
                                {{ isset($client) && $client->budget == '4_6m' ? 'checked' : '' }}><span
                                data-en="4M - 6M" data-ar="4 - 6 مليون">4 - 6 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="6_10m"
                                {{ isset($client) && $client->budget == '6_10m' ? 'checked' : '' }}><span
                                data-en="6M - 10M" data-ar="6 - 10 مليون">6 - 10 مليون</span></label>
                        <label class="badge-card"><input type="radio" name="budget" value="10_20m"
                                {{ isset($client) && $client->budget == '10_20m' ? 'checked' : '' }}><span
                                data-en="10M+" data-ar="10 مليون+">10 مليون+</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Payment Method (Optional)"
                        data-ar="طريقة الدفع (اختياري)"><span>طريقة الدفع</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-3">
                        <label class="badge-card"><input type="radio" name="payment_method" value="cash"
                                {{ isset($client) && $client->payment_method == 'cash' ? 'checked' : '' }}><span
                                data-en="Cash" data-ar="كاش">كاش</span></label>
                        <label class="badge-card"><input type="radio" name="payment_method" value="installments"
                                {{ isset($client) && $client->payment_method == 'installments' ? 'checked' : '' }}><span
                                data-en="Installments" data-ar="تقسيط">تقسيط</span></label>
                        <label class="badge-card"><input type="radio" name="payment_method" value="either"
                                {{ isset($client) && $client->payment_method == 'either' ? 'checked' : '' }}><span
                                data-en="Either" data-ar="كلاهما">كلاهما</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Expected Down Payment (Optional)"
                        data-ar="المقدم المتوقع (اختياري)">
                        <span>المقدم المتوقع</span>
                        <span class="label-optional">(اختياري)</span>
                    </label>

                    <div class="badges-grid cols-5">

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="1000000"
                                {{ isset($client) && $client->expected_down_payment == 1000000 ? 'checked' : '' }}>
                            <span data-en="Up to 1M" data-ar="حتى 1 مليون">
                                حتى 1 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="3000000"
                                {{ isset($client) && $client->expected_down_payment == 3000000 ? 'checked' : '' }}>
                            <span data-en="Up to 3M" data-ar="حتى 3 مليون">
                                حتى 3 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="5000000"
                                {{ isset($client) && $client->expected_down_payment == 5000000 ? 'checked' : '' }}>
                            <span data-en="Up to 5M" data-ar="حتى 5 مليون">
                                حتى 5 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="10000000"
                                {{ isset($client) && $client->expected_down_payment == 10000000 ? 'checked' : '' }}>
                            <span data-en="Up to 10M" data-ar="حتى 10 مليون">
                                حتى 10 مليون
                            </span>
                        </label>

                        <label class="badge-card">
                            <input type="radio" name="expected_down_payment" value="15000000"
                                {{ isset($client) && $client->expected_down_payment == 15000000 ? 'checked' : '' }}>
                            <span data-en="More than 10M" data-ar="أكثر من 10 مليون">
                                أكثر من 10 مليون
                            </span>
                        </label>

                    </div>
                </div>
            </div>

            <div class="form-step" data-step="3">
                <div class="step-title" data-en="Real Estate Preferences" data-ar="التفضيلات العقارية">التفضيلات
                    العقارية</div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Purpose (Optional)"
                        data-ar="الغرض من الشراء (اختياري)"><span>الغرض</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-3">
                        <label class="badge-card"><input type="radio" name="purpose" value="residential"
                                {{ isset($client) && $client->purpose == 'residential' ? 'checked' : '' }}><span
                                data-en="Residential" data-ar="سكني">سكني</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="investment"
                                {{ isset($client) && $client->purpose == 'investment' ? 'checked' : '' }}><span
                                data-en="Investment" data-ar="استثماري">استثماري</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="summer"
                                {{ isset($client) && $client->purpose == 'summer' ? 'checked' : '' }}><span
                                data-en="Summer/Coastal" data-ar="ساحلي">ساحلي</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="commercial_shop"
                                {{ isset($client) && $client->purpose == 'commercial_shop' ? 'checked' : '' }}><span
                                data-en="Commercial" data-ar="تجاري">تجاري</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="clinic"
                                {{ isset($client) && $client->purpose == 'clinic' ? 'checked' : '' }}><span
                                data-en="Medical" data-ar="طبي (عيادة)">طبي (عيادة)</span></label>
                        <label class="badge-card"><input type="radio" name="purpose" value="office"
                                {{ isset($client) && $client->purpose == 'office' ? 'checked' : '' }}><span
                                data-en="Administrative" data-ar="إداري (مكتب)">إداري (مكتب)</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Unit Type (Optional)"
                        data-ar="نوع الوحدة (اختياري)"><span>نوع الوحدة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-auto">
                        <label class="badge-card"><input type="radio" name="unit_type" value="apartment"
                                {{ isset($client) && $client->unit_type == 'apartment' ? 'checked' : '' }}><span
                                data-en="Apartment" data-ar="شقة">شقة</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="villa"
                                {{ isset($client) && $client->unit_type == 'villa' ? 'checked' : '' }}><span
                                data-en="Villa" data-ar="فيلا">فيلا</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="townhouse"
                                {{ isset($client) && $client->unit_type == 'townhouse' ? 'checked' : '' }}><span
                                data-en="Townhouse" data-ar="تاون هاوس">تاون هاوس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="twinhouse"
                                {{ isset($client) && $client->unit_type == 'twinhouse' ? 'checked' : '' }}><span
                                data-en="Twinhouse" data-ar="توين هاوس">توين هاوس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="duplex"
                                {{ isset($client) && $client->unit_type == 'duplex' ? 'checked' : '' }}><span
                                data-en="Duplex" data-ar="دوبلكس">دوبلكس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="penthouse"
                                {{ isset($client) && $client->unit_type == 'penthouse' ? 'checked' : '' }}><span
                                data-en="Penthouse" data-ar="بنتهاوس">بنتهاوس</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="studio"
                                {{ isset($client) && $client->unit_type == 'studio' ? 'checked' : '' }}><span
                                data-en="Studio" data-ar="ستوديو">ستوديو</span></label>
                        <label class="badge-card"><input type="radio" name="unit_type" value="chalet"
                                {{ isset($client) && $client->unit_type == 'chalet' ? 'checked' : '' }}><span
                                data-en="Chalet" data-ar="شاليه">شاليه</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Required Area (Optional)"
                        data-ar="المساحة المفضلة (اختياري)"><span>المساحة المفضلة</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="required_area" value="50"
                                {{ isset($client) && $client->required_area == 50 ? 'checked' : '' }}><span
                                data-en="Up to 90m" data-ar="حتى 90 م">حتى 90 م</span></label>
                        <label class="badge-card"><input type="radio" name="required_area" value="100"
                                {{ isset($client) && $client->required_area == 100 ? 'checked' : '' }}><span
                                data-en="100m - 150m" data-ar="100 - 150 م">100 - 150 م</span></label>
                        <label class="badge-card"><input type="radio" name="required_area" value="150"
                                {{ isset($client) && $client->required_area == 150 ? 'checked' : '' }}><span
                                data-en="150m - 200m" data-ar="150 - 200 م">150 - 200 م</span></label>
                        <label class="badge-card"><input type="radio" name="required_area" value="250"
                                {{ isset($client) && $client->required_area == 250 ? 'checked' : '' }}><span
                                data-en="200m+" data-ar="أكبر من 200 م">أكبر من 200 م</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Bedrooms (Optional)" data-ar="غرف النوم (اختياري)"><span>غرف
                            النوم</span><span class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-5">
                        <label class="badge-card"><input type="radio" name="bedrooms" value="1"
                                {{ isset($client) && $client->bedrooms == 1 ? 'checked' : '' }}><span>1</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="2"
                                {{ isset($client) && $client->bedrooms == 2 ? 'checked' : '' }}><span>2</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="3"
                                {{ isset($client) && $client->bedrooms == 3 ? 'checked' : '' }}><span>3</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="4"
                                {{ isset($client) && $client->bedrooms == 4 ? 'checked' : '' }}><span>4</span></label>
                        <label class="badge-card"><input type="radio" name="bedrooms" value="5"
                                {{ isset($client) && $client->bedrooms == 5 ? 'checked' : '' }}><span data-en="5+"
                                data-ar="5+">5+</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Time to Purchase (Optional)"
                        data-ar="موعد الشراء المتوقع (اختياري)"><span>موعد الشراء</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-4">
                        <label class="badge-card"><input type="radio" name="purchase_time" value="immediately"
                                {{ isset($client) && $client->purchase_time == 'immediately' ? 'checked' : '' }}><span
                                data-en="Immediately" data-ar="فوراً">فوراً</span></label>
                        <label class="badge-card"><input type="radio" name="purchase_time" value="3_months"
                                {{ isset($client) && $client->purchase_time == '3_months' ? 'checked' : '' }}><span
                                data-en="3 Months" data-ar="خلال 3 أشهر">خلال 3 أشهر</span></label>
                        <label class="badge-card"><input type="radio" name="purchase_time" value="6_months"
                                {{ isset($client) && $client->purchase_time == '6_months' ? 'checked' : '' }}><span
                                data-en="6 Months" data-ar="خلال 6 أشهر">خلال 6 أشهر</span></label>
                        <label class="badge-card"><input type="radio" name="purchase_time" value="1_year"
                                {{ isset($client) && $client->purchase_time == '1_year' ? 'checked' : '' }}><span
                                data-en="1 Year+" data-ar="خلال سنة أو أكثر">خلال سنة أو أكثر</span></label>
                    </div>
                </div>

                <div class="badge-selection-group">
                    <label class="group-label" data-en="Contact Preference (Optional)"
                        data-ar="التواصل المفضل (اختياري)"><span>التواصل المفضل</span><span
                            class="label-optional">(اختياري)</span></label>
                    <div class="badges-grid cols-3">
                        <label class="badge-card"><input type="radio" name="preferred_contact" value="call"
                                {{ isset($client) && $client->preferred_contact == 'call' ? 'checked' : '' }}><span
                                data-en="Phone Call" data-ar="اتصال هاتفي">اتصال هاتفي</span></label>
                        <label class="badge-card"><input type="radio" name="preferred_contact" value="whatsapp"
                                {{ isset($client) && $client->preferred_contact == 'whatsapp' ? 'checked' : '' }}><span
                                data-en="WhatsApp" data-ar="واتساب">واتساب</span></label>
                        <label class="badge-card"><input type="radio" name="contact_time" value="anytime"
                                {{ isset($client) && $client->contact_time == 'anytime' ? 'checked' : '' }}><span
                                data-en="Anytime" data-ar="في أي وقت">في أي وقت</span></label>
                    </div>
                </div>

                <div class="marketing-checkbox mt-4">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="agree_marketing" value="1"
                            {{ !isset($client) || $client->agree_marketing ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span class="checkbox-text" data-en="I agree to receive exclusive updates."
                            data-ar="أوافق على تلقي العروض والتحديثات الحصرية.">أوافق على تلقي العروض والتحديثات
                            الحصرية.</span>
                    </label>
                </div>
            </div>

            <div class="form-navigation-actions">
                <button type="button" id="btn-prev" class="btn-form-secondary hidden" data-en="Back"
                    data-ar="السابق">السابق</button>
                <button type="button" id="btn-next" class="btn-form-primary" data-en="Next Step"
                    data-ar="الخطوة التالية">الخطوة التالية</button>
                <button type="submit" id="btn-submit" class="btn-form-primary hidden"
                    data-en="{{ isset($client) ? 'Save Updates' : 'Submit' }}"
                    data-ar="{{ isset($client) ? 'حفظ التحديثات' : 'تأكيد وإرسال' }}">{{ isset($client) ? 'حفظ التحديثات' : 'تأكيد وإرسال' }}</button>
            </div>
        </form>

        <div id="form-success-overlay" class="form-success-overlay hidden">
            <div class="success-message-card">
                <div class="success-icon-animated">
                    <svg viewBox="0 0 52 52">
                        <circle class="success-circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="success-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                </div>
                <h3 data-en="Thank You!" data-ar="تم بنجاح!">تم بنجاح!</h3>
                <p data-en="Your preferences have been saved securely."
                    data-ar="تم حفظ تفضيلاتك بنجاح. سيقوم أحد مستشارينا بالتواصل معك.">تم حفظ تفضيلاتك بنجاح. سيقوم أحد
                    مستشارينا بالتواصل معك.</p>
            </div>
        </div>
    </div>
</section>

@include('home.scripts.interest')
