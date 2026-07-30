<script>
   document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll('.team-slide');
    const dots = document.querySelectorAll('.team-dot');
    
    if(slides.length <= 1) return; // لو مفيش غير صورة واحدة مفيش داعي للسلايدر

    let currentSlide = 0;
    let slideInterval;
    const intervalTime = 5000; // 5 ثواني لكل صورة

    // دالة لتغيير الصورة
    const goToSlide = (index) => {
        // إزالة الكلاس active من كل الصور والنقاط
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // إضافة الكلاس active للصورة والنقطة المطلوبة
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    };

    // دالة للذهاب للصورة التالية تلقائياً
    const nextSlide = () => {
        let newIndex = currentSlide + 1;
        if (newIndex >= slides.length) {
            newIndex = 0;
        }
        goToSlide(newIndex);
    };

    // تشغيل العداد التلقائي
    const startSlide = () => {
        slideInterval = setInterval(nextSlide, intervalTime);
    };

    // إعادة تعيين العداد (علشان لو اليوزر داس بنفسه)
    const resetInterval = () => {
        clearInterval(slideInterval);
        startSlide();
    };

    // إضافة تفاعل النقاط (Dots)
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            resetInterval();
        });
    });

    // بدء السلايدر لأول مرة
    startSlide();
});
</script>