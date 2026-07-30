<div id="searchModal" class="search-modal">
    <div class="search-overlay" onclick="closeSearch()"></div>

    <div class="top-search-bar modal-search">
        <div class="search-wrapper">
            <input type="text" id="mainSearchInput" placeholder="Find your next favorite look…">
            <div class="search-results" id="mainSearchResults"></div>
        </div>
    </div>
</div>
<script>
    document.getElementById('mainSearchInput').addEventListener('input', async (e) => {
        const query = e.target.value;
        if (query.length < 2) return;
        const res = await fetch(`/search/results?q=${query}`);
        const data = await res.json();

        let html = '';
        data.collections.forEach(col => {
            html += `<h3>${col.name}</h3>`;
            col.products.forEach(p => html += `<div>${p.name}</div>`);
        });
        document.getElementById('searchResults').innerHTML = html;
    });
</script>
