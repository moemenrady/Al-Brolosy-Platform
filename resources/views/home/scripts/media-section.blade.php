<script>
    document.addEventListener("DOMContentLoaded", () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const mediaCards = document.querySelectorAll('.media-card');
        const mediaLoader = document.getElementById('media-filter-loader');
        const filterLogo = document.getElementById('filter-logo');

        let activeFilters = [];

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const filterValue = this.getAttribute('data-filter');

                if (filterValue === 'all') {
                    activeFilters = [];
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                } else {
                    document.querySelector('.filter-btn[data-filter="all"]').classList.remove(
                        'active');

                    if (activeFilters.includes(filterValue)) {
                        activeFilters = activeFilters.filter(f => f !== filterValue);
                        this.classList.remove('active');
                    } else {
                        activeFilters.push(filterValue);
                        this.classList.add('active');
                    }

                    if (activeFilters.length === 0) {
                        document.querySelector('.filter-btn[data-filter="all"]').classList.add(
                            'active');
                    }
                }

                executeFilterWithAnimation();
            });
        });

        function executeFilterWithAnimation() {
            mediaLoader.style.display = 'flex';

            if (filterLogo) {
                filterLogo.classList.remove('spin-360');
                filterLogo.classList.add('spin-90');

                setTimeout(() => {
                    filterLogo.classList.remove('spin-90');
                    filterLogo.classList.add('spin-360');
                }, 300);
            }

            setTimeout(() => {
                mediaCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');

                    if (activeFilters.length === 0 || activeFilters.includes(cardCategory)) {
                        card.style.display = 'flex';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';

                        // Force Reflow
                        void card.offsetWidth;

                        setTimeout(() => {
                            card.style.transition = 'all 0.5s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.display = 'none';
                    }
                });

                mediaLoader.style.display = 'none';
            }, 600); // تقليل المدة لـ 0.6 ثانية لتجربة أسرع للمستخدم
        }
    });
</script>
