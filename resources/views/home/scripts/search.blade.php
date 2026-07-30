<script>
    document.addEventListener("DOMContentLoaded", () => {
        // DOM Element Mappings
        const searchToggleBtn = document.getElementById('search-toggle');
        const searchOverlay = document.getElementById('search-overlay');
        const closeSearchBtn = document.getElementById('close-search-modal');
        const searchForm = document.getElementById('search-modal-form');
        const searchInput = document.getElementById('search-keyword-input');
        const clearInputBtn = document.getElementById('clear-search-input');

        // Viewport and States
        const resultsContainer = document.getElementById('search-results-container');
        const initialSearchState = document.getElementById('initial-search-state');
        const skeletonLoader = document.getElementById('search-loading-skeleton');
        const resultsList = document.getElementById('search-results-list');
        const emptySearchState = document.getElementById('empty-search-state');
        const errorSearchState = document.getElementById('error-search-state');
        const btnRetry = document.getElementById('btn-retry-search');
        const resultsMetaCounter = document.getElementById('results-meta-counter');

        // Filters
        const filterSector = document.getElementById('filter-sector');
        const filterUnitType = document.getElementById('filter-unit-type');
        const filterBudget = document.getElementById('filter-budget');
        const filterArea = document.getElementById('filter-area');

        // Internal State Controllers
        let searchDebounceTimer = null;
        let abortController = null;
        let keyboardFocusIndex = -1;

        // FontAwesome 6 Icon Class Dictionary mapping Backend values
        const iconMap = {
            'building': 'fa-solid fa-building',
            'briefcase': 'fa-solid fa-briefcase',
            'house': 'fa-solid fa-house-chimney',
            'layer-group': 'fa-solid fa-layer-group',
            'image': 'fa-regular fa-image',
            'newspaper': 'fa-regular fa-newspaper',
            'credit-card': 'fa-regular fa-credit-card',
            'link': 'fa-solid fa-link'
        };

        // System Language Fetcher helper
        const getActiveLocale = () => {
            if (window.preferences && window.preferences.lang) {
                return window.preferences.lang;
            }
            return document.documentElement.lang || 'en';
        };

        // Dynamic Localization Updates
        const updateLocalizationTexts = () => {
            const currentLang = getActiveLocale();
            const isAr = currentLang === 'ar';

            // Toggle global dir layouts safely
            document.documentElement.dir = isAr ? 'rtl' : 'ltr';

            // Update all translation nodes in current modal scope
            document.querySelectorAll('[data-en][data-ar]').forEach(el => {
                el.textContent = isAr ? el.getAttribute('data-ar') : el.getAttribute('data-en');
            });

            // Update inputs placeholder tags dynamically
            document.querySelectorAll('[data-placeholder-en][data-placeholder-ar]').forEach(input => {
                input.placeholder = isAr ?
                    input.getAttribute('data-placeholder-ar') :
                    input.getAttribute('data-placeholder-en');
            });
        };

        // Modal Lifecycle Trigger Handlers
        const openSearchModal = () => {
            updateLocalizationTexts();
            searchOverlay.classList.add('active');
            searchOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                searchInput.focus();
            }, 300);
        };

        const closeSearchModal = () => {
            searchOverlay.classList.remove('active');
            searchOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            resetInputStates();
        };

        const resetInputStates = () => {
            searchInput.value = '';
            clearInputBtn.style.display = 'none';
            hideAllStatesExcept(initialSearchState);
            resultsMetaCounter.textContent = '';
            keyboardFocusIndex = -1;
        };

        // Multi-state visibility controller helper
        const hideAllStatesExcept = (activeElement) => {
            const states = [initialSearchState, skeletonLoader, resultsList, emptySearchState,
                errorSearchState
            ];
            states.forEach(state => {
                if (state) state.style.display = 'none';
            });
            if (activeElement) {
                activeElement.style.display = activeElement === resultsList ? 'flex' : 'block';
            }
        };

        // Fetch and Execute Backend Search API 
        const executeLiveSearch = async () => {
            const keyword = searchInput.value.trim();

            // Standard validation check
            if (keyword.length < 2) {
                hideAllStatesExcept(initialSearchState);
                resultsMetaCounter.textContent = '';
                clearInputBtn.style.display = 'none';
                return;
            }

            clearInputBtn.style.display = 'flex';
            hideAllStatesExcept(skeletonLoader);

            // Cancel previous request to avoid race condition/duplicate requests
            if (abortController) {
                abortController.abort();
            }
            abortController = new AbortController();

            // Build query string dynamically using active forms elements
            const queryParams = new URLSearchParams();
            if (keyword) queryParams.append('keyword', keyword);
            if (filterSector && filterSector.value) queryParams.append('sector_id', filterSector.value);
            if (filterUnitType && filterUnitType.value) queryParams.append('unit_type', filterUnitType
                .value);
            if (filterBudget && filterBudget.value) queryParams.append('budget', filterBudget.value);
            if (filterArea && filterArea.value) queryParams.append('area', filterArea.value);

            try {
                const response = await fetch(`/api/search?${queryParams.toString()}`, {
                    signal: abortController.signal
                });

                if (!response.ok) {
                    throw new Error('Network query validation failed.');
                }

                const payload = await response.json();

                if (payload.success && payload.results && payload.results.length > 0) {
                    renderSearchResults(payload.results, payload.total);
                } else {
                    hideAllStatesExcept(emptySearchState);
                    resultsMetaCounter.textContent = '';
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Unified Search Exception:', error);
                    hideAllStatesExcept(errorSearchState);
                    resultsMetaCounter.textContent = '';
                }
            }
        };

        // Render Logic utilizing fast DocumentFragments
        const renderSearchResults = (results, total) => {
            resultsList.innerHTML = '';
            keyboardFocusIndex = -1;
            const locale = getActiveLocale();
            const fragment = document.createDocumentFragment();

            results.forEach((result, idx) => {
                const card = document.createElement('a');
                card.href = result.url || '#';
                card.className = 'search-result-card';
                card.setAttribute('role', 'option');
                card.setAttribute('id', `search-item-${idx}`);
                card.setAttribute('tabindex', '-1');

                // Prevent default hash anchor navigations
                if (!result.url) {
                    card.addEventListener('click', (e) => e.preventDefault());
                }

                // Image Setup or Luxury Gradient Placeholder Setup
                let mediaSection = '';
                if (result.image) {
                    mediaSection = `
                    <div class="result-media-wrapper">
                        <img src="/images/projects/${result.image}" alt="${result.title}" class="result-image" loading="lazy">
                        <div class="type-icon-wrapper">
                            <i class="${iconMap[result.icon] || 'fa-solid fa-diamond'}"></i>
                        </div>
                    </div>
                `;
                } else {
                    mediaSection = `
                    <div class="result-media-wrapper">
                        <div class="result-placeholder-gradient">
                            <i class="${iconMap[result.icon] || 'fa-solid fa-diamond'}"></i>
                        </div>
                    </div>
                `;
                }

                // Create contextual semantic badge class matching mapping style
                const typeClass = result.type ? `badge-${result.type.toLowerCase()}` :
                    'badge-default';
                const badgeLabel = result.badge || result.type || 'Result';

                card.innerHTML = `
                ${mediaSection}
                <div class="result-card-details">
                    <div class="result-header-row">
                        <span class="result-type-badge ${typeClass}">${badgeLabel}</span>
                        <h3 class="result-title">${result.title}</h3>
                    </div>
                    ${result.subtitle ? `<div class="result-subtitle">${result.subtitle}</div>` : ''}
                    <p class="result-description">${result.description || ''}</p>
                </div>
                <div class="result-arrow-indicator">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            `;

                fragment.appendChild(card);
            });

            resultsList.appendChild(fragment);
            hideAllStatesExcept(resultsList);

            // Counter UI localization
            resultsMetaCounter.textContent = locale === 'ar' ?
                `تم العثور على ${total} نتيجة` :
                `Found ${total} results`;
        };

        // Debouncing Input Events (300ms Standard)
        const handleSearchInput = () => {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                executeLiveSearch();
            }, 300);
        };

        // Accessibility Keyboard Controls (ESC, Arrows, Enter)
        const handleKeyboardNavigation = (e) => {
            const cards = resultsList.querySelectorAll('.search-result-card');
            if (cards.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                keyboardFocusIndex = (keyboardFocusIndex + 1) % cards.length;
                focusResultItem(cards, keyboardFocusIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                keyboardFocusIndex = (keyboardFocusIndex - 1 + cards.length) % cards.length;
                focusResultItem(cards, keyboardFocusIndex);
            } else if (e.key === 'Enter') {
                if (keyboardFocusIndex >= 0 && keyboardFocusIndex < cards.length) {
                    e.preventDefault();
                    cards[keyboardFocusIndex].click();
                }
            }
        };

        const focusResultItem = (cards, index) => {
            cards.forEach(card => card.classList.remove('focused-item'));
            const activeCard = cards[index];
            activeCard.classList.add('focused-item');
            activeCard.scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
        };

        // Event Delegation mappings
        if (searchToggleBtn) {
            searchToggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openSearchModal();
            });
        }

        closeSearchBtn.addEventListener('click', closeSearchModal);

        searchOverlay.addEventListener('click', (e) => {
            if (e.target === searchOverlay) {
                closeSearchModal();
            }
        });

        searchInput.addEventListener('input', handleSearchInput);

        clearInputBtn.addEventListener('click', () => {
            resetInputStates();
            searchInput.focus();
        });

        btnRetry.addEventListener('click', executeLiveSearch);

        // Apply Live updates instantly when dropdown configurations are mutated
        [filterSector, filterUnitType, filterBudget, filterArea].forEach(filter => {
            if (filter) {
                filter.addEventListener('change', executeLiveSearch);
            }
        });

        // Global Key Events Mapping (Ctrl+K, Esc, Arrow Navs)
        document.addEventListener('keydown', (e) => {
            // Toggle key logic (⌘+K / Ctrl+K) or forward slash ("/") key
            if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                searchOverlay.classList.contains('active') ? closeSearchModal() : openSearchModal();
            }

            if (e.key === '/' && document.activeElement !== searchInput) {
                e.preventDefault();
                openSearchModal();
            }

            if (searchOverlay.classList.contains('active')) {
                if (e.key === 'Escape') {
                    closeSearchModal();
                } else {
                    handleKeyboardNavigation(e);
                }
            }
        });

        // Listen to theme & language preference alterations seamlessly
        window.addEventListener('preferencesChanged', () => {
            updateLocalizationTexts();
        });
    });
</script>
