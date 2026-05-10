function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function formatPrice(price) {
    if (!Number.isFinite(Number(price)) || Number(price) <= 0) {
        return 'Price on request';
    }

    return `From ¥${Number(price).toLocaleString('en-US')}`;
}

function normalizeText(value) {
    return String(value || '').trim().toLowerCase();
}

function buildHaystack(product) {
    const parts = [
        product.name || '',
        product.brand || '',
        product.series || '',
        product.description || '',
        product.condition || '',
        ...(product.keywords || []),
        ...(product.storage || []),
        ...(product.services || [])
    ];

    return normalizeText(parts.join(' '));
}

function resolveSearchAssetPath(assetPath) {
    const cleanPath = String(assetPath || 'Recourses/HomePage/hero-device.svg').replace(/^\/+/, '');

    if (/^(data:|blob:|https?:|file:)/i.test(cleanPath)) {
        return cleanPath;
    }

    return `../../../${cleanPath}`;
}

function getOfflineSellerListings() {
    const offlineStore = window.DRAGONGOD_OFFLINE_SELLER_LISTINGS;

    if (offlineStore && typeof offlineStore.getAllListings === 'function') {
        return offlineStore.getAllListings();
    }

    const offlineData = window.DRAGONGOD_OFFLINE_DATA || {};
    return Array.isArray(offlineData.sellerListings) ? offlineData.sellerListings : [];
}

function buildOfflineResults(query) {
    const offlineData = window.DRAGONGOD_OFFLINE_DATA || {};
    const sellerProducts = getOfflineSellerListings().map((record) => ({
        id: record.id,
        source: 'seller',
        name: record.name,
        brand: record.brand,
        series: record.series || '',
        condition: record.condition,
        price: record.basePrice,
        description: record.description,
        image: resolveSearchAssetPath(record.coverImagePath),
        detailUrl: `../../Sell_Product/SellerProductDetail.html?id=${encodeURIComponent(record.id)}`,
        buyUrl: `../../Sell_Product/SellerProductPurchase.html?id=${encodeURIComponent(record.id)}`,
        storage: (record.storage || []).map((item) => item.label),
        services: (record.services || []).map((item) => item.name),
        keywords: record.keywords || []
    }));

    const siteProducts = (offlineData.siteProducts || []).map((record) => ({
        ...record,
        image: resolveSearchAssetPath(record.imagePath)
    }));

    const allProducts = [...sellerProducts, ...siteProducts];
    const needle = normalizeText(query);
    const results = needle
        ? allProducts.filter((product) => buildHaystack(product).includes(needle))
        : allProducts;

    return {
        total: results.length,
        results,
        sellerListingCount: sellerProducts.length,
        placeholderMessage: 'Offline preview mode is active. Search is using the built-in site catalog together with seller listings saved locally in this browser because PHP is not running.',
        usedOfflineData: true
    };
}

function renderData(query, data, status, placeholderNote, resultsMeta, resultsGrid) {
    const resultCount = Number(data.total || 0);
    const usingOfflineData = Boolean(data.usedOfflineData);

    status.hidden = usingOfflineData ? false : true;
    status.textContent = usingOfflineData
        ? 'Offline preview mode: search is using built-in data and seller listings saved locally in this browser because the PHP backend is unavailable in direct-file mode.'
        : '';

    resultsMeta.textContent = query
        ? `${resultCount} result${resultCount === 1 ? '' : 's'} found for "${query}".`
        : `Showing ${resultCount} searchable product${resultCount === 1 ? '' : 's'} across the site.`;

    if (data.placeholderMessage) {
        placeholderNote.hidden = false;
        placeholderNote.textContent = data.placeholderMessage;
    } else {
        placeholderNote.hidden = true;
        placeholderNote.textContent = '';
    }

    if (!Array.isArray(data.results) || data.results.length === 0) {
        resultsGrid.innerHTML = '<div class="search-empty">No matching phones were found. Try another model, storage size, brand, or condition keyword.</div>';
        return;
    }

    resultsGrid.innerHTML = data.results.map(renderProductCard).join('');
}

function renderActions(product) {
    const actions = [];

    if (product.detailUrl) {
        actions.push(`<a class="channel-button ghost" href="${escapeHtml(product.detailUrl)}">Open details</a>`);
    }

    if (product.buyUrl) {
        actions.push(`<a class="channel-button solid" href="${escapeHtml(product.buyUrl)}">Open buy page</a>`);
    }

    if (actions.length === 0) {
        actions.push('<span class="search-placeholder-action">Open this listing from its related page to continue.</span>');
    }

    return actions.join('');
}

function renderProductCard(product) {
    const chips = [
        ...(product.storage || []).slice(0, 3),
        ...(product.services || []).slice(0, 2)
    ].map((item) => `<span class="search-chip">${escapeHtml(item)}</span>`).join('');

    return `
        <article class="search-card">
            <div class="search-card-media">
                <img src="${escapeHtml(product.image || '../../../Recourses/HomePage/hero-device.svg')}" alt="${escapeHtml(product.name)}">
            </div>

            <div class="search-card-top">
                <div>
                    <h3>${escapeHtml(product.name)}</h3>
                    <p>${escapeHtml(product.brand || 'DragonGod Phone')}</p>
                </div>
                <span class="search-badge">${escapeHtml(product.source === 'seller' ? 'Seller listing' : 'Site page')}</span>
            </div>

            <p>${escapeHtml(product.description || 'No description available.')}</p>

            <div class="search-card-meta">${chips || '<span class="search-chip">No extra metadata</span>'}</div>

            <div class="search-price">${escapeHtml(formatPrice(product.price))}</div>

            <div class="search-card-actions">
                ${renderActions(product)}
            </div>
        </article>
    `;
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('searchForm');
    const input = document.getElementById('searchInput');
    const status = document.getElementById('searchStatus');
    const placeholderNote = document.getElementById('placeholderNote');
    const resultsMeta = document.getElementById('resultsMeta');
    const resultsGrid = document.getElementById('resultsGrid');

    if (!form || !input || !status || !placeholderNote || !resultsMeta || !resultsGrid) {
        return;
    }

    async function loadResults(query) {
        status.hidden = false;
        status.textContent = query ? `Searching for "${query}"...` : 'Loading searchable products...';
        placeholderNote.hidden = true;

        try {
            if (window.location.protocol === 'file:') {
                throw new Error('Direct file mode cannot execute PHP.');
            }

            const response = await fetch(`../../../PHP/search_products.php?q=${encodeURIComponent(query)}`);

            if (!response.ok) {
                throw new Error('Search backend unavailable.');
            }

            const data = await response.json();
            renderData(query, data, status, placeholderNote, resultsMeta, resultsGrid);
        } catch (error) {
            if (window.DRAGONGOD_OFFLINE_DATA) {
                const offlineData = buildOfflineResults(query);
                renderData(query, offlineData, status, placeholderNote, resultsMeta, resultsGrid);
                return;
            }

            status.hidden = false;
            status.textContent = 'Search needs a PHP-enabled local server. If you opened the HTML file directly, start the project through a PHP environment and try again.';
            resultsMeta.textContent = 'Search results are unavailable right now.';
            resultsGrid.innerHTML = '';
        }
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const query = input.value.trim();
        const nextUrl = new URL(window.location.href);

        if (query) {
            nextUrl.searchParams.set('q', query);
        } else {
            nextUrl.searchParams.delete('q');
        }

        history.replaceState({}, '', nextUrl);
        loadResults(query);
    });

    const initialQuery = new URLSearchParams(window.location.search).get('q') || '';
    input.value = initialQuery;
    loadResults(initialQuery);
});