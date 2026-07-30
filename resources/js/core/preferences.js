class Preferences {

    constructor() {

        this.lang = localStorage.getItem("lang") || "en";
        this.theme = localStorage.getItem("theme") || "light";

    }

    init() {

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", () => this.apply(), {
                once: true
            });
            return;
        }

        this.apply();

    }

    apply() {

        document.documentElement.lang = this.lang;

        document.documentElement.dir =
            this.lang == "ar" ? "rtl" : "ltr";

        document.documentElement.dataset.theme = this.theme;

        document.documentElement.classList.toggle(
            "dark",
            this.theme == "dark"
        );

        document.body?.classList.remove("ar", "en");
        document.body?.classList.add(this.lang);

        this.syncLocaleControls();
        this.translate();

        window.dispatchEvent(
            new CustomEvent("preferencesChanged", {
                detail: {
                    lang: this.lang,
                    theme: this.theme
                }
            })
        );

    }

    syncLocaleControls() {

        document.querySelectorAll(".lang-en, .lang-ar").forEach(el => {
            const isArabic = el.classList.contains("lang-ar");
            el.classList.toggle("active", this.lang == (isArabic ? "ar" : "en"));
        });

    }

    translate() {

        document.querySelectorAll("[data-ar][data-en]").forEach(el => {
            const value = this.lang == "ar" ? el.dataset.ar : el.dataset.en;
            if (el.tagName === "INPUT" || el.tagName === "TEXTAREA") {
                el.setAttribute("placeholder", value);
            } else {
                el.textContent = value;
            }
        });

        document.querySelectorAll("[data-placeholder-ar][data-placeholder-en]").forEach(el => {
            const value = this.lang == "ar"
                ? el.dataset.placeholderAr
                : el.dataset.placeholderEn;
            el.setAttribute("placeholder", value);
        });

    }

    setLanguage(lang) {

        this.lang = lang;

        localStorage.setItem("lang", lang);

        this.apply();

    }

    toggleLanguage() {

        this.setLanguage(
            this.lang == "ar" ? "en" : "ar"
        );

    }

    setTheme(theme) {

        this.theme = theme;

        localStorage.setItem("theme", theme);

        this.apply();

    }

    toggleTheme() {

        this.setTheme(
            this.theme == "dark" ? "light" : "dark"
        );

    }

}

export default new Preferences();