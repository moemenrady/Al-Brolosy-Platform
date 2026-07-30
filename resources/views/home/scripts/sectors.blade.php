<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sectorBtns = document.querySelectorAll('.toggle-sector');
        const resetBtn = document.getElementById('reset-filters');
        const projectCards = Array.from(document.querySelectorAll('.project-card-item'));
        const projectSorter = document.getElementById('project-sorter');
        const priceFilter = document.getElementById('price-filter');
        const areaFilter = document.getElementById('area-filter');

        let activeSectors = [];

        const isValueInRange = (minCard, maxCard, filterRange) => {
            if (filterRange === 'all') return true;
            const [filterMin, filterMax] = filterRange.split('-').map(Number);
            
            // If the card has any value that falls within the filter range
            return (minCard <= filterMax && maxCard >= filterMin);
        };

        const updateGrid = () => {
            const sortValue = projectSorter.value;
            const priceRange = priceFilter.value;
            const areaRange = areaFilter.value;

            // 1. Filtering
            projectCards.forEach(card => {
                const cardSector = card.getAttribute('data-sector');
                const cMinPrice = parseFloat(card.getAttribute('data-min-price'));
                const cMaxPrice = parseFloat(card.getAttribute('data-max-price'));
                const cMinArea = parseFloat(card.getAttribute('data-min-area'));
                const cMaxArea = parseFloat(card.getAttribute('data-max-area'));

                const matchSector = activeSectors.length === 0 || activeSectors.includes(cardSector);
                const matchPrice = isValueInRange(cMinPrice, cMaxPrice, priceRange);
                const matchArea = isValueInRange(cMinArea, cMaxArea, areaRange);

                if (matchSector && matchPrice && matchArea) {
                    card.classList.remove('hidden-card');
                    card.style.position = 'relative';
                } else {
                    card.classList.add('hidden-card');
                    setTimeout(() => {
                        if (card.classList.contains('hidden-card')) card.style.position = 'absolute';
                    }, 400);
                }
            });

            // 2. Sorting using CSS order (Hardware Accelerated)
            if (sortValue !== 'default') {
                let cardsToSort = [...projectCards];
                cardsToSort.sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute('data-min-price'));
                    const priceB = parseFloat(b.getAttribute('data-min-price'));
                    const dateA = parseInt(a.getAttribute('data-date'));
                    const dateB = parseInt(b.getAttribute('data-date'));

                    if (sortValue === 'price-asc') return priceA - priceB;
                    if (sortValue === 'price-desc') return priceB - priceA;
                    if (sortValue === 'date-desc') return dateB - dateA;
                    if (sortValue === 'date-asc') return dateA - dateB;
                    return 0;
                });

                cardsToSort.forEach((card, index) => {
                    card.style.order = index;
                });
            } else {
                projectCards.forEach(card => {
                    card.style.order = 0;
                });
            }

            // Show/Hide Reset Button
            resetBtn.style.display = (activeSectors.length > 0 || sortValue !== 'default' || priceRange !== 'all' || areaRange !== 'all') ? 'flex' : 'none';
        };

        // Events
        sectorBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const sector = this.getAttribute('data-filter');
                if (activeSectors.includes(sector)) {
                    activeSectors = activeSectors.filter(s => s !== sector);
                    this.classList.remove('active');
                } else {
                    activeSectors.push(sector);
                    this.classList.add('active');
                }
                updateGrid();
            });
        });

        projectSorter.addEventListener('change', updateGrid);
        priceFilter.addEventListener('change', updateGrid);
        areaFilter.addEventListener('change', updateGrid);

        // Reset
        resetBtn.addEventListener('click', () => {
            activeSectors = [];
            sectorBtns.forEach(btn => btn.classList.remove('active'));
            projectSorter.value = 'default';
            priceFilter.value = 'all';
            areaFilter.value = 'all';
            updateGrid();
        });
    });
</script>