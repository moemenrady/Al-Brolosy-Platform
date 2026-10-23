
    <script>
        // =====================================
        // WhatsApp Booking Logic & Dynamic Data
        // =====================================
        const bookingModal = document.getElementById('bookingModalOverlay');
        const bookingForm = document.getElementById('bookingMicroForm');
        const bookingSuccessMsg = document.getElementById('bookingSuccessMessage');
        const WHATSAPP_NUMBER = "201032550422";

        // إغلاق المودال عند الضغط خارجه
        bookingModal.addEventListener('click', function(e) {
            if (e.target === bookingModal) closeBookingModal();
        });

        function openBookingModal() {
            bookingForm.style.display = 'block';
            bookingSuccessMsg.style.display = 'none';
            bookingModal.classList.remove('hidden-overlay');

            // ترجمة البيانات لحظياً إن وجدت كلاسات اللغة
            if (window.preferences && typeof window.preferences.translate === 'function') {
                window.preferences.translate();
            }
        }

        function closeBookingModal(e) {
            if (e) e.preventDefault();
            bookingModal.classList.add('hidden-overlay');
        }

        // إرسال البيانات تلقائياً دون Reload للصفحة (Frontend Submission)
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('booking_name').value.trim();
            const phone = document.getElementById('booking_phone').value.trim();

            const unitSelect = document.getElementById('booking_unit_type');
            const unitValues = unitSelect.value.split('|');
            const unitAr = unitValues[0];
            const unitEn = unitValues[1] || unitValues[0];

            const projectAr = document.getElementById('booking_project_ar').value;
            const projectEn = document.getElementById('booking_project_en').value;

            // الاعتماد على اللغة الحالية المحددة عبر HTML Tag (من كلاس Preferences)
            const currentLang = document.documentElement.lang || 'en';

            let message = "";
            if (currentLang === 'ar') {
                message = `مرحباً،\nأنا مهتم بحجز وحدة في مشروع: *${projectAr}*\n\n` +
                    `📌 *نوع الوحدة المطلوبة:* ${unitAr}\n` +
                    `👤 *الاسم:* ${name}\n` +
                    `📱 *رقم الهاتف:* ${phone}\n\n` +
                    `برجاء التواصل معي لإتمام التفاصيل.`;
            } else {
                message = `Hello,\nI am interested in booking a unit in: *${projectEn}*\n\n` +
                    `📌 *Requested Unit:* ${unitEn}\n` +
                    `👤 *Name:* ${name}\n` +
                    `📱 *Phone:* ${phone}\n\n` +
                    `Please contact me to proceed.`;
            }

            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodedMessage}`;

            // فتح الواتساب
            window.open(whatsappUrl, '_blank');

            // إخفاء النموذج وإظهار رسالة النجاح بالأنيميشن
            bookingForm.style.display = 'none';
            bookingSuccessMsg.style.display = 'block';
        });

        // لتحديث نص الخيارات داخل السيلكت ديناميكياً بناءً على تغيير اللغة 
        window.addEventListener("preferencesChanged", function(e) {
            const lang = e.detail.lang;
            const select = document.getElementById('booking_unit_type');

            Array.from(select.options).forEach(option => {
                if (option.value === "") return;
                const vals = option.value.split('|');
                if (vals.length > 1) {
                    const unitTypeText = option.text.match(/\(.*\)/);
                    option.text = (lang === 'ar' ? vals[0] : vals[1]) + (unitTypeText ?
                        ` ${unitTypeText[0]}` : '');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Format Currency Helper
            const formatCurrency = (number) => {
                return new Intl.NumberFormat('en-US').format(number) + ' EGP';
            };

            // 2. Units Filtering System (Client-Side for Performance & Smooth UX)
            const filterBtns = document.querySelectorAll('.filter-btn');
            const unitItems = document.querySelectorAll('.actual-unit-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const filterValue = btn.getAttribute('data-value');

                    unitItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-status') ===
                            filterValue) {
                            item.classList.remove('hidden');
                            // Small animation hack
                            item.style.animation = 'none';
                            item.offsetHeight; /* trigger reflow */
                            item.style.animation = null;
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });

            // 3. Calculator Logic
            const priceInput = document.getElementById('calc-price');
            const planSelect = document.getElementById('calc-plan');
            const resultBox = document.getElementById('calc-result-box');

            const resTotal = do > cument.getElementById('res-total-price');
                const resDownPayment = document.getElementById('res-down-payment');
            const resRemaining = document.getElementById('res-remaining');
            const resInstallment = document.getElementById('res-installment');

            function calculateInstallments() {
                const price = parseFloat(priceInput.value);
                const selectedOption = planSelect.options[planSelect.selectedIndex];
                const downPaymentStr = selectedOption.value; // e.g. "10%"
                const yearsStr = selectedOption.getAttribute('data-years'); // e.g. "5"

                if (price > 0 && downPaymentStr) {
                    resultBox.style.display = 'block';

                    // Extract percentage safely
                    const downPaymentPercent = parseFloat(downPaymentStr.replace(/[^\d.]/g, '')) || 0;
                    const years = parseFloat(yearsStr.replace(/[^\d.]/g, '')) || 1;

                    const downPaymentValue = (price * downPaymentPercent) / 100;
                    const remainingValue = price - downPaymentValue;
                    const yearlyInstallment = remainingValue / years;

                    resTotal.textContent = formatCurrency(price);
                    resDownPayment.textContent = formatCurrency(downPaymentValue) + ` (${downPaymentPercent}%)`;
                    resRemaining.textContent = formatCurrency(remainingValue);
                    resInstallment.textContent = formatCurrency(yearlyInstallment) +
                        ` / {{ app()->getLocale() == 'ar' ? 'سنة' : 'Year' }}`;
                } else {
                    resultBox.style.display = 'none';
                }
            }

            priceInput.addEventListener('input', calculateInstallments);
            planSelect.addEventListener('change', calculateInstallments);
        });

        // Scroll & auto-fill calculator from unit card
        function scrollToCalculator(price) {
            const calcInput = document.getElementById('calc-price');
            calcInput.value = price;
            document.getElementById('reservation').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            // Trigger event to recalculate if plan is already selected
            calcInput.dispatchEvent(new Event('input'));
        }
    </script>
