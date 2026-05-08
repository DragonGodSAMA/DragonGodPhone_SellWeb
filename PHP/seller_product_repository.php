<?php
function seller_products_database_path() {
    return __DIR__ . '/../data/seller_products.json';
}

function seller_transactions_database_path() {
    return __DIR__ . '/../data/seller_transactions.json';
}

function seller_clean_value($value) {
    return trim((string) $value);
}

function seller_asset_web_path($assetPath, $prefix = '../../') {
    $cleanPath = seller_clean_value($assetPath);

    if ($cleanPath === '') {
        return $prefix . 'Recourses/HomePage/hero-device.svg';
    }

    if (preg_match('/^(https?:)?\/\//', $cleanPath) || strpos($cleanPath, 'data:') === 0) {
        return $cleanPath;
    }

    $normalizedPath = ltrim(str_replace('\\', '/', $cleanPath), '/');

    if (strpos($normalizedPath, 'Recourses/') !== 0) {
        $normalizedPath = 'Recourses/' . $normalizedPath;
    }

    return $prefix . $normalizedPath;
}

function seller_normalize_colors($record) {
    $colors = [];
    $colorRecords = is_array($record['colors'] ?? null) ? $record['colors'] : [];
    $coverImagePath = seller_clean_value($record['cover_image'] ?? '');

    foreach ($colorRecords as $index => $colorRecord) {
        if (!is_array($colorRecord)) {
            continue;
        }

        $colorName = seller_clean_value($colorRecord['name'] ?? '');
        $colorImagePath = seller_clean_value($colorRecord['image'] ?? '');

        if ($colorName === '' && $colorImagePath === '') {
            continue;
        }

        $colors[] = [
            'id' => 'seller-color-' . ($index + 1),
            'name' => $colorName !== '' ? $colorName : 'Option ' . ($index + 1),
            'image_path' => $colorImagePath !== '' ? $colorImagePath : $coverImagePath
        ];
    }

    if (count($colors) === 0) {
        $colors[] = [
            'id' => 'seller-color-default',
            'name' => 'Standard',
            'image_path' => $coverImagePath
        ];
    }

    return $colors;
}

function seller_normalize_storage($record) {
    $storageOptions = [];
    $storageRecords = is_array($record['storage'] ?? null) ? $record['storage'] : [];

    foreach ($storageRecords as $index => $storageRecord) {
        if (!is_array($storageRecord)) {
            continue;
        }

        $storageLabel = seller_clean_value($storageRecord['label'] ?? $storageRecord['name'] ?? '');
        $storagePrice = isset($storageRecord['extra_price']) ? (float) $storageRecord['extra_price'] : (isset($storageRecord['price']) ? (float) $storageRecord['price'] : 0);

        if ($storageLabel === '') {
            continue;
        }

        $storageOptions[] = [
            'id' => 'seller-storage-' . ($index + 1),
            'label' => $storageLabel,
            'extra_price' => $storagePrice
        ];
    }

    if (count($storageOptions) === 0) {
        $storageOptions[] = [
            'id' => 'seller-storage-default',
            'label' => 'Standard listing',
            'extra_price' => 0
        ];
    }

    return $storageOptions;
}

function seller_normalize_services($record) {
    $serviceOptions = [];
    $serviceRecords = is_array($record['services'] ?? null) ? $record['services'] : [];

    foreach ($serviceRecords as $index => $serviceRecord) {
        if (!is_array($serviceRecord)) {
            continue;
        }

        $serviceName = seller_clean_value($serviceRecord['name'] ?? '');
        $servicePrice = isset($serviceRecord['price']) ? (float) $serviceRecord['price'] : 0;
        $serviceDescription = seller_clean_value($serviceRecord['description'] ?? 'Seller-provided add-on service.');

        if ($serviceName === '') {
            continue;
        }

        $serviceOptions[] = [
            'id' => 'seller-service-' . ($index + 1),
            'name' => $serviceName,
            'price' => $servicePrice,
            'description' => $serviceDescription
        ];
    }

    return $serviceOptions;
}

function seller_build_gallery_paths($coverImagePath, $colors) {
    $galleryPaths = [];

    if ($coverImagePath !== '') {
        $galleryPaths[] = $coverImagePath;
    }

    foreach ($colors as $color) {
        $colorImagePath = seller_clean_value($color['image_path'] ?? '');
        if ($colorImagePath !== '' && !in_array($colorImagePath, $galleryPaths, true)) {
            $galleryPaths[] = $colorImagePath;
        }
    }

    if (count($galleryPaths) === 0) {
        $galleryPaths[] = 'Recourses/HomePage/hero-device.svg';
    }

    return $galleryPaths;
}

function seller_normalize_product($record) {
    $coverImagePath = seller_clean_value($record['cover_image'] ?? '');
    $colors = seller_normalize_colors($record);
    $storageOptions = seller_normalize_storage($record);
    $serviceOptions = seller_normalize_services($record);

    return [
        'id' => seller_clean_value($record['id'] ?? uniqid('seller-product-', true)),
        'name' => seller_clean_value($record['name'] ?? 'Untitled Seller Listing'),
        'brand' => seller_clean_value($record['brand'] ?? 'Seller Listing'),
        'condition' => seller_clean_value($record['condition'] ?? 'Used'),
        'description' => seller_clean_value($record['description'] ?? 'Seller uploaded product listing.'),
        'base_price' => isset($record['base_price']) ? (float) $record['base_price'] : 0,
        'seller_name' => seller_clean_value($record['seller_name'] ?? 'Seller'),
        'seller_role' => seller_clean_value($record['seller_role'] ?? 'Seller'),
        'cover_image_path' => $coverImagePath !== '' ? $coverImagePath : 'Recourses/HomePage/hero-device.svg',
        'colors' => $colors,
        'storage' => $storageOptions,
        'services' => $serviceOptions,
        'gallery_paths' => seller_build_gallery_paths($coverImagePath, $colors),
        'keywords' => is_array($record['keywords'] ?? null) ? $record['keywords'] : [],
        'created_at' => seller_clean_value($record['created_at'] ?? ''),
        'max_quantity' => 1
    ];
}

function load_seller_products() {
    $databasePath = seller_products_database_path();
    if (!file_exists($databasePath)) {
        return [];
    }

    $decoded = json_decode((string) file_get_contents($databasePath), true);
    if (!is_array($decoded)) {
        return [];
    }

    $products = [];
    foreach ($decoded as $record) {
        if (is_array($record)) {
            $products[] = seller_normalize_product($record);
        }
    }

    return $products;
}

function find_seller_product($productId) {
    foreach (load_seller_products() as $product) {
        if (($product['id'] ?? '') === $productId) {
            return $product;
        }
    }

    return null;
}
?>