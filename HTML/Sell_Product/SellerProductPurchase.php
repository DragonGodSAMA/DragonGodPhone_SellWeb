<?php
require_once __DIR__ . '/../../PHP/seller_product_repository.php';

$listingId = seller_clean_value($_GET['id'] ?? '');
$product = $listingId !== '' ? find_seller_product($listingId) : null;

$pageProduct = null;
if ($product) {
    $pageProduct = [
        'id' => $product['id'],
        'name' => $product['name'],
        'brand' => $product['brand'],
        'condition' => $product['condition'],
        'description' => $product['description'],
        'sellerName' => $product['seller_name'],
        'basePrice' => (float) $product['base_price'],
        'maxQuantity' => (int) $product['max_quantity'],
        'detailUrl' => 'SellerProductDetail.php?id=' . urlencode($product['id']),
        'colors' => array_map(function ($color) use ($product) {
            return [
                'id' => $color['id'],
                'name' => $color['name'],
                'image' => seller_asset_web_path($color['image_path'] ?? $product['cover_image_path'], '../../')
            ];
        }, $product['colors']),
        'storage' => array_map(function ($storage) {
            return [
                'id' => $storage['id'],
                'name' => $storage['label'],
                'priceAdjust' => (float) $storage['extra_price']
            ];
        }, $product['storage']),
        'services' => array_map(function ($service) {
            return [
                'id' => $service['id'],
                'name' => $service['name'],
                'price' => (float) $service['price'],
                'description' => $service['description']
            ];
        }, $product['services']),
        'gallery' => array_map(function ($path) {
            return seller_asset_web_path($path, '../../');
        }, $product['gallery_paths'])
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product ? $product['name'] . ' | Seller Purchase' : 'Seller Product Purchase'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .thumbnail-scroll::-webkit-scrollbar {
            height: 4px;
        }

        .thumbnail-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        .thumbnail-scroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 2px;
        }

        .thumbnail-scroll::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        .transition-all-smooth {
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            .sticky-info {
                position: sticky;
                top: 84px;
            }
        }

        .color-option.selected {
            border-color: #FF0000;
            box-shadow: 0 0 0 2px rgba(255, 0, 0, 0.2);
        }

        .storage-option.selected {
            border-color: #FF0000;
            background-color: #fff5f5;
        }

        .service-option.selected {
            border-color: #FF0000;
            background-color: #fff5f5;
        }

        .transaction-message {
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.7;
        }

        .transaction-message.success {
            background: #dcfce7;
            color: #166534;
        }

        .transaction-message.error {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
    <link rel="stylesheet" href="../../CSS/CSSHomePage/stylesofindex.css">
</head>
<body class="bg-white font-sans text-gray-800">
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full gap-4">
                <div class="flex-shrink-0">
                    <a href="../HomePages/pages/store.html" class="text-xl font-bold text-gray-900 hover:text-red-600 transition-colors">
                        Online Store
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-8">
                    <a href="../HomePages/index.html" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Home</a>
                    <a href="../HomePages/pages/search.html" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Search</a>
                    <a href="SellerProductDetail.php<?php echo $product ? '?id=' . urlencode($product['id']) : ''; ?>" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Seller Detail</a>
                    <a href="../HomePages/pages/support.html" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Support</a>
                    <a href="Sell_Product.html" class="text-gray-700 hover:text-red-600 font-medium transition-colors">Seller Upload</a>
                </div>

                <form action="../HomePages/pages/search.html" method="get" class="hidden xl:flex items-center gap-2 border border-gray-200 rounded-full px-3 py-1 bg-white">
                    <input type="search" name="q" placeholder="Search phones" class="w-40 text-sm text-gray-700 outline-none bg-transparent">
                    <button type="submit" class="w-8 h-8 rounded-full bg-red-600 text-white hover:bg-red-700 transition-colors" aria-label="Search">🔍</button>
                </form>

                <div class="hidden md:block">
                    <button class="ghost-button" type="button" data-route="login">Login</button>
                </div>

                <div class="md:hidden">
                    <button id="mobileMenuBtn" class="text-gray-700 hover:text-red-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-3 space-y-2">
                <a href="../HomePages/index.html" class="block text-gray-700 hover:text-red-600 font-medium py-2 transition-colors">Home</a>
                <a href="../HomePages/pages/search.html" class="block text-gray-700 hover:text-red-600 font-medium py-2 transition-colors">Search</a>
                <a href="SellerProductDetail.php<?php echo $product ? '?id=' . urlencode($product['id']) : ''; ?>" class="block text-gray-700 hover:text-red-600 font-medium py-2 transition-colors">Seller Detail</a>
                <a href="../HomePages/pages/support.html" class="block text-gray-700 hover:text-red-600 font-medium py-2 transition-colors">Support</a>
                <a href="Sell_Product.html" class="block text-gray-700 hover:text-red-600 font-medium py-2 transition-colors">Seller Upload</a>
                <button class="ghost-button w-full text-left mt-2" type="button" data-route="login">Login</button>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-16">
        <?php if (!$product): ?>
            <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-2xl p-10 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">Seller Purchase</p>
                <h1 class="text-4xl font-semibold text-gray-900 mt-3">This seller listing is unavailable.</h1>
                <p class="text-gray-600 mt-4 leading-8">The product ID is missing or the listing no longer exists. Return to search or upload a new seller phone to continue the second-hand flow.</p>
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <a href="../HomePages/pages/search.html" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors">Open Search</a>
                    <a href="Sell_Product.html" class="inline-flex items-center justify-center px-5 py-3 rounded-lg border border-gray-300 bg-white text-gray-900 font-semibold hover:bg-gray-50 transition-colors">Open Seller Upload</a>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <div class="space-y-4">
                    <div class="relative bg-gray-50 rounded-lg overflow-hidden aspect-square flex items-center justify-center">
                        <img id="mainImage" src="<?php echo htmlspecialchars(seller_asset_web_path($product['cover_image_path'], '../../')); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full object-contain p-8 transition-all-smooth">
                    </div>

                    <div class="relative">
                        <button id="scrollLeft" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white shadow-md rounded-full w-8 h-8 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <div id="thumbnailContainer" class="thumbnail-scroll flex gap-3 overflow-x-auto scroll-smooth px-10 py-2"></div>

                        <button id="scrollRight" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 hover:bg-white shadow-md rounded-full w-8 h-8 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 rounded-lg p-4">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-gray-700">Second-hand Transaction Flow</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-semibold text-red-600">Seller:</span> <?php echo htmlspecialchars($product['seller_name']); ?>
                                <span class="mx-2">|</span>
                                <span class="font-semibold text-red-600">Condition:</span> <?php echo htmlspecialchars($product['condition']); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky-info space-y-6">
                    <div class="border-b border-gray-200 pb-6">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
                        <p class="text-sm text-gray-500 mb-4"><?php echo htmlspecialchars($product['brand']); ?> seller listing by <?php echo htmlspecialchars($product['seller_name']); ?></p>
                        <div class="flex items-baseline gap-3 mb-2">
                            <span class="text-sm text-gray-500">Listing price:</span>
                            <span id="basePrice" class="text-3xl md:text-4xl font-bold text-red-600">From ¥<?php echo number_format((float) $product['base_price']); ?></span>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-full">Second-hand listing</span>
                            <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full"><?php echo htmlspecialchars($product['condition']); ?></span>
                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">Single-unit transaction</span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Color: <span id="selectedColor" class="text-gray-900 font-normal">Not selected</span></h3>
                        <div id="colorOptions" class="flex flex-wrap gap-3"></div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Storage: <span id="selectedStorage" class="text-gray-900 font-normal">Not selected</span></h3>
                        <div id="storageOptions" class="flex flex-wrap gap-3"></div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Warranty & Services</h3>
                        <div id="serviceOptions" class="space-y-2"></div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-700"><span class="font-semibold">Transaction path:</span> Search -> Seller detail -> Seller purchase</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div class="text-sm text-gray-600"><span class="font-semibold">Account note:</span> Buyer and Seller accounts can purchase; only Seller accounts can publish new listings.</div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 space-y-4">
                        <div id="transactionMessage" class="transaction-message hidden"></div>

                        <div class="flex items-baseline justify-between">
                            <span class="text-sm text-gray-600">Total Price:</span>
                            <span id="totalPrice" class="text-3xl font-bold text-red-600">¥<?php echo number_format((float) $product['base_price']); ?></span>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-700">Quantity:</span>
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <button id="decreaseQty" class="px-3 py-2 hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <input id="quantityInput" type="number" value="1" min="1" max="1" class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" disabled>
                                <button id="increaseQty" class="px-3 py-2 hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-xs text-gray-500">(Second-hand listings are limited to 1 unit)</span>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button id="addToCartBtn" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-red-600" disabled>Add to Cart</button>
                            <button id="buyNowBtn" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-red-600" disabled>Buy Now</button>
                        </div>

                        <p id="validationMessage" class="text-sm text-red-600 text-center hidden">Please select all required configurations</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($pageProduct): ?>
        <script>
            const productData = <?php echo json_encode($pageProduct, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

            let state = {
                selectedColor: productData.colors.length === 1 ? productData.colors[0].id : null,
                selectedStorage: productData.storage.length === 1 ? productData.storage[0].id : null,
                selectedServices: new Set(),
                quantity: 1
            };

            const mainImage = document.getElementById('mainImage');
            const thumbnailContainer = document.getElementById('thumbnailContainer');
            const colorOptions = document.getElementById('colorOptions');
            const storageOptions = document.getElementById('storageOptions');
            const serviceOptions = document.getElementById('serviceOptions');
            const totalPriceEl = document.getElementById('totalPrice');
            const selectedColorEl = document.getElementById('selectedColor');
            const selectedStorageEl = document.getElementById('selectedStorage');
            const quantityInput = document.getElementById('quantityInput');
            const decreaseQty = document.getElementById('decreaseQty');
            const increaseQty = document.getElementById('increaseQty');
            const addToCartBtn = document.getElementById('addToCartBtn');
            const buyNowBtn = document.getElementById('buyNowBtn');
            const validationMessage = document.getElementById('validationMessage');
            const transactionMessage = document.getElementById('transactionMessage');
            const scrollLeft = document.getElementById('scrollLeft');
            const scrollRight = document.getElementById('scrollRight');

            function init() {
                renderColorOptions();
                renderStorageOptions();
                renderServiceOptions();
                renderThumbnails();
                setupEventListeners();
                updateMainImage();
                updateUI();
            }

            function renderColorOptions() {
                colorOptions.innerHTML = productData.colors.map((color) => `
                    <button class="color-option px-4 py-2 border-2 border-gray-300 rounded-lg hover:border-red-400 transition-all-smooth ${state.selectedColor === color.id ? 'selected' : ''}" data-color="${color.id}">
                        ${color.name}
                    </button>
                `).join('');
            }

            function renderStorageOptions() {
                storageOptions.innerHTML = productData.storage.map((storage) => `
                    <button class="storage-option px-4 py-2 border-2 border-gray-300 rounded-lg hover:border-red-400 transition-all-smooth ${state.selectedStorage === storage.id ? 'selected' : ''}" data-storage="${storage.id}">
                        ${storage.name}
                        ${storage.priceAdjust > 0 ? `(+¥${storage.priceAdjust})` : ''}
                    </button>
                `).join('');
            }

            function renderServiceOptions() {
                if (productData.services.length === 0) {
                    serviceOptions.innerHTML = '<p class="text-sm text-gray-500">No optional seller services were added for this second-hand listing.</p>';
                    return;
                }

                serviceOptions.innerHTML = productData.services.map((service) => `
                    <label class="service-option flex items-start gap-3 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-400 transition-all-smooth ${state.selectedServices.has(service.id) ? 'selected' : ''}">
                        <input type="checkbox" class="mt-1 w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" data-service="${service.id}" ${state.selectedServices.has(service.id) ? 'checked' : ''}>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">${service.name}</span>
                                <span class="text-sm font-semibold text-red-600">${service.price > 0 ? `+¥${service.price}` : 'Included'}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">${service.description}</p>
                        </div>
                    </label>
                `).join('');
            }

            function renderThumbnails() {
                thumbnailContainer.innerHTML = productData.colors.map((color) => `
                    <button class="thumbnail-item flex-shrink-0 w-20 h-20 border-2 border-gray-300 rounded-lg overflow-hidden hover:border-red-400 transition-all-smooth ${state.selectedColor === color.id ? 'border-red-600 ring-2 ring-red-200' : ''}" data-color="${color.id}">
                        <img src="${color.image}" alt="${color.name}" class="w-full h-full object-cover">
                    </button>
                `).join('');
            }

            function setupEventListeners() {
                colorOptions.addEventListener('click', (event) => {
                    const button = event.target.closest('.color-option');
                    if (!button) {
                        return;
                    }

                    state.selectedColor = button.dataset.color;
                    updateMainImage();
                    updateUI();
                });

                storageOptions.addEventListener('click', (event) => {
                    const button = event.target.closest('.storage-option');
                    if (!button) {
                        return;
                    }

                    state.selectedStorage = button.dataset.storage;
                    updateUI();
                });

                serviceOptions.addEventListener('change', (event) => {
                    if (event.target.type !== 'checkbox') {
                        return;
                    }

                    const serviceId = event.target.dataset.service;
                    if (event.target.checked) {
                        state.selectedServices.add(serviceId);
                    } else {
                        state.selectedServices.delete(serviceId);
                    }

                    updateUI();
                });

                thumbnailContainer.addEventListener('click', (event) => {
                    const thumbnail = event.target.closest('.thumbnail-item');
                    if (!thumbnail) {
                        return;
                    }

                    state.selectedColor = thumbnail.dataset.color;
                    updateMainImage();
                    updateUI();
                });

                decreaseQty.addEventListener('click', () => {
                    if (state.quantity > 1) {
                        state.quantity -= 1;
                        updateUI();
                    }
                });

                increaseQty.addEventListener('click', () => {
                    if (state.quantity < productData.maxQuantity) {
                        state.quantity += 1;
                        updateUI();
                    }
                });

                quantityInput.addEventListener('change', (event) => {
                    const nextValue = Math.max(1, Math.min(productData.maxQuantity, Number.parseInt(event.target.value, 10) || 1));
                    state.quantity = nextValue;
                    updateUI();
                });

                scrollLeft.addEventListener('click', () => {
                    thumbnailContainer.scrollBy({ left: -200, behavior: 'smooth' });
                });

                scrollRight.addEventListener('click', () => {
                    thumbnailContainer.scrollBy({ left: 200, behavior: 'smooth' });
                });

                thumbnailContainer.addEventListener('scroll', updateScrollArrows);
                addToCartBtn.addEventListener('click', () => submitTransaction('add_to_cart'));
                buyNowBtn.addEventListener('click', () => submitTransaction('buy_now'));

                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                const mobileMenu = document.getElementById('mobileMenu');

                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener('click', () => {
                        mobileMenu.classList.toggle('hidden');
                    });

                    mobileMenu.querySelectorAll('a').forEach((link) => {
                        link.addEventListener('click', () => {
                            mobileMenu.classList.add('hidden');
                        });
                    });
                }
            }

            function updateMainImage() {
                const activeColor = productData.colors.find((color) => color.id === state.selectedColor) || productData.colors[0];
                if (!activeColor) {
                    return;
                }

                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = activeColor.image;
                    mainImage.style.opacity = '1';
                }, 150);
            }

            function updateUI() {
                document.querySelectorAll('.color-option').forEach((button) => {
                    button.classList.toggle('selected', button.dataset.color === state.selectedColor);
                });

                document.querySelectorAll('.storage-option').forEach((button) => {
                    button.classList.toggle('selected', button.dataset.storage === state.selectedStorage);
                });

                document.querySelectorAll('.service-option').forEach((label) => {
                    const checkbox = label.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        label.classList.toggle('selected', checkbox.checked);
                    }
                });

                document.querySelectorAll('.thumbnail-item').forEach((thumbnail) => {
                    thumbnail.classList.toggle('border-red-600', thumbnail.dataset.color === state.selectedColor);
                    thumbnail.classList.toggle('ring-2', thumbnail.dataset.color === state.selectedColor);
                    thumbnail.classList.toggle('ring-red-200', thumbnail.dataset.color === state.selectedColor);
                });

                selectedColorEl.textContent = getSelectedColorName() || 'Not selected';
                selectedStorageEl.textContent = getSelectedStorageName() || 'Not selected';
                totalPriceEl.textContent = `¥${calculateTotalPrice().toLocaleString()}`;
                quantityInput.value = state.quantity;

                const configurationValid = isConfigurationValid();
                decreaseQty.disabled = true;
                increaseQty.disabled = true;
                quantityInput.disabled = true;
                addToCartBtn.disabled = !configurationValid;
                buyNowBtn.disabled = !configurationValid;
                validationMessage.classList.toggle('hidden', configurationValid);
                updateScrollArrows();
            }

            function calculateTotalPrice() {
                let total = Number(productData.basePrice || 0);
                const selectedStorage = productData.storage.find((storage) => storage.id === state.selectedStorage);
                if (selectedStorage) {
                    total += Number(selectedStorage.priceAdjust || 0);
                }

                productData.services.forEach((service) => {
                    if (state.selectedServices.has(service.id)) {
                        total += Number(service.price || 0);
                    }
                });

                return total * state.quantity;
            }

            function isConfigurationValid() {
                return state.selectedColor !== null && state.selectedStorage !== null;
            }

            function getSelectedColorName() {
                const selectedColor = productData.colors.find((color) => color.id === state.selectedColor);
                return selectedColor ? selectedColor.name : '';
            }

            function getSelectedStorageName() {
                const selectedStorage = productData.storage.find((storage) => storage.id === state.selectedStorage);
                return selectedStorage ? selectedStorage.name : '';
            }

            function getSelectedColorImage() {
                const selectedColor = productData.colors.find((color) => color.id === state.selectedColor);
                return selectedColor ? selectedColor.image : mainImage.src;
            }

            function persistSellerCartItem() {
                try {
                    const item = {
                        id: `${productData.id}-${Date.now()}`,
                        listingId: productData.id,
                        name: productData.name,
                        sellerName: productData.sellerName || '',
                        color: getSelectedColorName(),
                        storage: getSelectedStorageName(),
                        selectedServices: [...state.selectedServices].map((serviceId) => {
                            const service = productData.services.find((entry) => entry.id === serviceId);
                            return service ? service.name : serviceId;
                        }),
                        image: getSelectedColorImage(),
                        unit_price: calculateTotalPrice() / state.quantity,
                        quantity: state.quantity,
                        total: calculateTotalPrice()
                    };

                    let cart = [];
                    try {
                        const parsed = JSON.parse(localStorage.getItem('shoppingCart') || '[]');
                        cart = Array.isArray(parsed) ? parsed : [];
                    } catch (error) {
                        cart = [];
                    }

                    const existingIndex = cart.findIndex((entry) => entry.listingId === item.listingId && entry.color === item.color && entry.storage === item.storage && Number(entry.unit_price) === Number(item.unit_price));
                    if (existingIndex >= 0) {
                        cart[existingIndex].quantity = Number(cart[existingIndex].quantity) + Number(item.quantity);
                        cart[existingIndex].total = Number(cart[existingIndex].unit_price) * Number(cart[existingIndex].quantity);
                    } else {
                        cart.push(item);
                    }

                    localStorage.setItem('shoppingCart', JSON.stringify(cart));
                    if (window.DG_updateCartBadges) {
                        window.DG_updateCartBadges();
                    }

                    return true;
                } catch (error) {
                    return false;
                }
            }

            function updateScrollArrows() {
                const { scrollLeft: currentScroll, scrollWidth, clientWidth } = thumbnailContainer;
                scrollLeft.style.opacity = currentScroll > 0 ? '1' : '0';
                scrollRight.style.opacity = currentScroll < scrollWidth - clientWidth - 1 ? '1' : '0';
            }

            function setTransactionMessage(message, tone) {
                transactionMessage.hidden = false;
                transactionMessage.className = `transaction-message ${tone}`;
                transactionMessage.textContent = message;
            }

            async function submitTransaction(actionType) {
                if (!isConfigurationValid()) {
                    updateUI();
                    return;
                }

                const buyerName = localStorage.getItem('loggedInUser');
                const buyerRole = localStorage.getItem('userRole') || 'Guest';
                const normalizedBuyerRole = String(buyerRole).trim().toLowerCase();

                if (!buyerName || !['buyer', 'seller'].includes(normalizedBuyerRole)) {
                    setTransactionMessage('A Buyer or Seller account login is required before continuing the second-hand transaction flow. Redirecting to login...', 'error');
                    window.location.href = `../Login&Registration/Login.html?source=seller-purchase&redirectUrl=${encodeURIComponent(window.location.href)}`;
                    return;
                }

                setTransactionMessage(actionType === 'buy_now' ? 'Submitting second-hand order...' : 'Adding seller listing to the cart flow...', 'success');

                try {
                    const response = await fetch('../../PHP/submit_seller_transaction.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                        },
                        body: new URLSearchParams({
                            listingId: productData.id,
                            actionType,
                            buyerName,
                            buyerRole,
                            selectedColor: getSelectedColorName(),
                            selectedStorage: getSelectedStorageName(),
                            selectedServices: JSON.stringify([...state.selectedServices].map((serviceId) => {
                                const service = productData.services.find((item) => item.id === serviceId);
                                return service ? service.name : serviceId;
                            })),
                            quantity: String(state.quantity),
                            totalPrice: String(calculateTotalPrice())
                        }).toString()
                    });

                    const result = await response.json();
                    if (!response.ok || !result.ok) {
                        throw new Error(result.message || 'The transaction could not be completed.');
                    }

                    if (actionType === 'add_to_cart') {
                        const cartSaved = persistSellerCartItem();
                        const cartMessage = cartSaved
                            ? `${result.message} Transaction ID: ${result.transactionId}. Local cart updated.`
                            : `${result.message} Transaction ID: ${result.transactionId}. Local cart could not be updated in this browser.`;
                        setTransactionMessage(cartMessage, 'success');
                        return;
                    }

                    setTransactionMessage(`${result.message} Transaction ID: ${result.transactionId}`, 'success');
                } catch (error) {
                    setTransactionMessage(error.message || 'The transaction could not be completed. Make sure the project is running through a PHP environment.', 'error');
                }
            }

            document.addEventListener('DOMContentLoaded', init);
        </script>
    <?php endif; ?>

    <script src="../../JS/JSHomePage/common.js"></script>
    <script src="../../JS/JSHomePage/script.js"></script>
</body>
</html>