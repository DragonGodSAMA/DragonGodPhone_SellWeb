(function () {
    const STORAGE_KEY = 'dragongodOfflineSellerListings';
    const MAX_INLINE_IMAGE_BYTES = 350000;

    function safeParse(value, fallback) {
        if (!value) {
            return fallback;
        }

        try {
            const parsed = JSON.parse(value);
            return Array.isArray(parsed) ? parsed : fallback;
        } catch (error) {
            return fallback;
        }
    }

    function getSeedListings() {
        const offlineData = window.DRAGONGOD_OFFLINE_DATA || {};
        return Array.isArray(offlineData.sellerListings) ? offlineData.sellerListings : [];
    }

    function getUserListings() {
        try {
            return safeParse(window.localStorage.getItem(STORAGE_KEY), []);
        } catch (error) {
            return [];
        }
    }

    function getAllListings() {
        return [...getUserListings(), ...getSeedListings()];
    }

    function findListingById(id) {
        return getAllListings().find((item) => item.id === id) || null;
    }

    function saveListing(listing) {
        const nextListings = getUserListings().filter((item) => item.id !== listing.id);
        nextListings.unshift(listing);
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify(nextListings.slice(0, 24)));
        return listing;
    }

    function slugify(value) {
        return String(value || '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '') || 'listing';
    }

    function createId(name) {
        return `offline-seller-${slugify(name)}-${Date.now()}`;
    }

    function isUsableFile(file) {
        return typeof File !== 'undefined' && file instanceof File && file.size > 0;
    }

    function readFileAsDataUrl(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(String(reader.result || ''));
            reader.onerror = () => reject(new Error('Failed to read image.'));
            reader.readAsDataURL(file);
        });
    }

    async function buildImageReference(file, fallbackPath) {
        if (!isUsableFile(file) || file.size > MAX_INLINE_IMAGE_BYTES) {
            return fallbackPath;
        }

        try {
            return await readFileAsDataUrl(file);
        } catch (error) {
            return fallbackPath;
        }
    }

    function buildKeywords(parts) {
        return Array.from(new Set(
            parts
                .map((item) => String(item || '').trim().toLowerCase())
                .filter(Boolean)
                .flatMap((item) => item.split(/\s+/))
        ));
    }

    window.DRAGONGOD_OFFLINE_SELLER_LISTINGS = {
        STORAGE_KEY,
        getSeedListings,
        getUserListings,
        getAllListings,
        findListingById,
        saveListing,
        createId,
        buildImageReference,
        buildKeywords
    };
})();