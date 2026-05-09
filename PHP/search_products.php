<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/seller_product_repository.php';

function normalize_text($value) {
    $text = trim((string) $value);
    if ($text === '') {
        return '';
    }

    if (function_exists('mb_strtolower')) {
        return mb_strtolower($text, 'UTF-8');
    }

    return strtolower($text);
}

function build_haystack($product) {
    $parts = [
        $product['name'] ?? '',
        $product['brand'] ?? '',
        $product['series'] ?? '',
        $product['description'] ?? '',
        $product['condition'] ?? '',
        implode(' ', $product['keywords'] ?? []),
        implode(' ', $product['storage'] ?? []),
        implode(' ', $product['services'] ?? [])
    ];

    return normalize_text(implode(' ', $parts));
}

function map_seller_product($record) {
    $storage = array_values(array_map(function ($item) {
        return $item['label'] ?? '';
    }, $record['storage'] ?? []));

    $services = array_values(array_map(function ($item) {
        return $item['name'] ?? '';
    }, $record['services'] ?? []));

    $imagePath = seller_asset_web_path($record['cover_image_path'] ?? '', '../../../');
    $productId = $record['id'] ?? '';

    return [
        'id' => $productId,
        'source' => 'seller',
        'name' => $record['name'] ?? 'Untitled Seller Listing',
        'brand' => $record['brand'] ?? 'Seller Listing',
        'series' => $record['series'] ?? '',
        'condition' => $record['condition'] ?? 'Used',
        'price' => $record['base_price'] ?? 0,
        'description' => trim((string) ($record['description'] ?? 'Seller uploaded product listing.')),
        'image' => $imagePath,
        'detailUrl' => '/HTML/Sell_Product/SellerProductDetail.html?id=' . urlencode($productId),
        'buyUrl' => '/HTML/Sell_Product/SellerProductPurchase.html?id=' . urlencode($productId),
        'storage' => $storage,
        'services' => $services,
        'keywords' => $record['keywords'] ?? []
    ];
}

$query = trim((string) ($_GET['q'] ?? ''));

$siteProducts = [
    [
        'id' => 'site-aether-fold-one',
        'source' => 'site',
        'name' => 'Aether Fold One',
        'brand' => 'DragonGod Phone',
        'series' => 'Aether',
        'condition' => 'New',
        'price' => 8999,
        'description' => 'Original DragonGod foldable flagship featured on the homepage and linked product pages.',
        'image' => '../../../Recourses/HomePage/hero-device.svg',
        'detailUrl' => '/HTML/DetailIntroduction/DetailIntroductinoDragonGodXProMax.html?product=aether-fold-one&section=story&scene=search',
        'buyUrl' => '/HTML/SellPage(addcar)/SellPage.html?sku=aether-fold-one-512&campaign=search&source=search-page',
        'storage' => ['256GB', '512GB'],
        'services' => ['Official Warranty', 'Extended Warranty'],
        'keywords' => ['foldable', 'homepage', 'aether', 'dragonos', 'premium']
    ],
    [
        'id' => 'site-x-pro-max',
        'source' => 'site',
        'name' => 'DragonGod X Pro Max',
        'brand' => 'DragonGod Phone',
        'series' => 'X Pro Max',
        'condition' => 'New',
        'price' => 6499,
        'description' => 'Main detail and configurable buy page device with color, storage, and service selection.',
        'image' => '../../../Recourses/DragonGodXProMax/design-color-1.png',
        'detailUrl' => '/HTML/DetailIntroduction/DetailIntroductinoDragonGodXProMax.html?product=x-pro-max&section=design&scene=search',
        'buyUrl' => '/HTML/SellPage(addcar)/SellPage.html?sku=x-pro-max-256&campaign=search&source=search-page',
        'storage' => ['12GB+256GB', '12GB+512GB', '16GB+512GB', '16GB+1TB'],
        'services' => ['Huawei Care+', 'Extended Warranty', 'Screen Protection Plan'],
        'keywords' => ['camera', 'flagship', 'imaging', 'black', 'matcha', 'purple']
    ],
    [
        'id' => 'site-80-pro-max-windrush',
        'source' => 'site',
        'name' => 'DragonGod 80 Pro Max WindRush Edition',
        'brand' => 'DragonGod Phone',
        'series' => '80 Pro Max',
        'condition' => 'New',
        'price' => 6999,
        'description' => 'WindRush Edition product detail page with expandable top-nav search and flagship performance copy.',
        'image' => '../../../Recourses/DragonGod80ProMaxWindRush/DragonGodPhone.png',
        'detailUrl' => '/HTML/DetailIntroduction/DetailIntroductionDragonGod80ProMaxWindRush.html',
        'buyUrl' => '/HTML/DetailIntroduction/DetailIntroductionDragonGod80ProMaxWindRush.html',
        'storage' => ['256GB', '512GB'],
        'services' => ['Official Warranty'],
        'keywords' => ['windrush', 'display', 'battery', 'camera', 'performance']
    ]
];

$sellerDatabasePath = seller_products_database_path();
$sellerDataReady = file_exists($sellerDatabasePath);
$sellerProducts = array_map('map_seller_product', load_seller_products());

$allProducts = array_merge($sellerProducts, $siteProducts);
$sellerListingCount = count($sellerProducts);

if ($query === '') {
    $results = $allProducts;
} else {
    $needle = normalize_text($query);
    $results = array_values(array_filter($allProducts, function ($product) use ($needle) {
        return strpos(build_haystack($product), $needle) !== false;
    }));
}

echo json_encode([
    'query' => $query,
    'sellerDataReady' => $sellerDataReady,
    'sellerListingCount' => $sellerListingCount,
    'total' => count($results),
    'results' => array_values($results),
    'placeholderMessage' => $sellerListingCount > 0 ? null : 'No seller-uploaded phones have been saved yet. Search is currently using the completed site product pages and will automatically include seller listings after the first seller submission.'
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>