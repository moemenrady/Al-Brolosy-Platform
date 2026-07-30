<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("smart-interest-form");
        const steps = document.querySelectorAll(".form-step");
        const stepIndicators = document.querySelectorAll(".step-indicator");
        const progressBar = document.getElementById("form-progress");
        const btnNext = document.getElementById("btn-next");
        const btnPrev = document.getElementById("btn-prev");
        const btnSubmit = document.getElementById("btn-submit");
        const successOverlay = document.getElementById("form-success-overlay");
        const photoInput = document.getElementById("photo-input");
        const fileNamePreview = document.getElementById("file-name-preview");
        const isUpdate = {{ isset($client) ? 'true' : 'false' }};

        let currentStep = 1;
        const totalSteps = steps.length;

        if (photoInput) {
            photoInput.addEventListener("change", (e) => {
                fileNamePreview.textContent = e.target.files.length > 0 ? e.target.files[0].name : "";
            });
        }

        function updateFormSteps() {
            steps.forEach(step => {
                step.classList.remove("active");
                if (parseInt(step.dataset.step) === currentStep) step.classList.add("active");
            });

            stepIndicators.forEach(indicator => {
                const stepNum = parseInt(indicator.dataset.step);
                indicator.classList.remove("active", "completed");
                if (stepNum === currentStep) indicator.classList.add("active");
                else if (stepNum < currentStep) indicator.classList.add("completed");
            });

            progressBar.style.width = `${((currentStep - 1) / (totalSteps - 1)) * 100}%`;

            btnPrev.classList.toggle("hidden", currentStep === 1);
            btnNext.classList.toggle("hidden", currentStep === totalSteps);
            btnSubmit.classList.toggle("hidden", currentStep !== totalSteps);
        }

        function validateStepInputs() {
            const activeStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
            const requiredInputs = activeStepEl.querySelectorAll("input[required]");
            let isValid = true;

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = "var(--primary-red, #B40000)";
                } else {
                    input.style.borderColor = "rgba(118, 118, 122, 0.3)";
                }
            });
            return isValid;
        }

        function adjustPlaceholders() {
            const lang = window.preferences?.lang || "ar";
            form.querySelectorAll("[data-placeholder-ar]").forEach(input => {
                input.placeholder = input.getAttribute(lang === "ar" ? "data-placeholder-ar" :
                    "data-placeholder-en");
            });
        }

        btnNext.addEventListener("click", () => {
            if (validateStepInputs() && currentStep < totalSteps) {
                currentStep++;
                updateFormSteps();
            }
        });

        btnPrev.addEventListener("click", () => {
            if (currentStep > 1) {
                currentStep--;
                updateFormSteps();
            }
        });

        window.addEventListener("preferencesChanged", adjustPlaceholders);
        adjustPlaceholders();

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            btnSubmit.disabled = true;

            const lang = window.preferences?.lang || "ar";
            btnSubmit.textContent = lang === "en" ? "Processing..." : "جاري الإرسال...";

            const formData = new FormData(form);
            formData.append("theme", window.preferences?.theme === "light" ? "light" : "dark");
            formData.append("lang", lang);
            formData.set("agree_marketing", form.agree_marketing.checked ? "1" : "0");

            try {
                const response = await fetch('/api/v1/client/register-interest', {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": formData.get("_token"),
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    successOverlay.classList.remove("hidden");
                    if (!isUpdate) {
                        form.reset();
                        if (fileNamePreview) fileNamePreview.textContent = "";
                    } else {
                        setTimeout(() => {
                            successOverlay.classList.add("hidden");
                            btnSubmit.disabled = false;
                            btnSubmit.textContent = lang === "en" ? "Save Updates" :
                                "حفظ التحديثات";
                        }, 2500);
                    }
                } else {
                    alert(result.errors ? Object.values(result.errors).flat().join("\n") : (result
                        .message || "حدث خطأ."));
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = lang === "en" ? "Submit" : "تأكيد وإرسال";
                }
            } catch (error) {
                alert(lang === "en" ? "Connection failed." : "فشل الاتصال بالخادم.");
                btnSubmit.disabled = false;
                btnSubmit.textContent = lang === "en" ? "Submit" : "تأكيد وإرسال";
            }
        });
    });
</script>
