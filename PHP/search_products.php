<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/seller_product_repository.php';

function normalize_text($value) {
    $text = trim((string)$value);
    if ($text === '') return '';
    return function_exists('mb_strtolower') ? mb_strtolower($text, 'UTF-8') : strtolower($text);
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

$sellerProducts = [];
$rawProducts = load_seller_products();

foreach ($rawProducts as $row) {
    $sellerProducts[] = [
        'id' => $row['id'],
        'source' => 'seller',
        'name' => $row['name'] ?? 'Unnamed Product',
        'brand' => $row['brand'] ?? 'Unknown Brand',
        'series' => '',
        'condition' => $row['condition'] ?? 'Used',
        'price' => $row['base_price'] ?? 0,
        'description' => $row['description'] ?? 'No description',
        'image' => seller_asset_web_path($row['cover_image'], '../../../'),
        'detailUrl' => '../../Sell_Product/SellerProductDetail.php?id=' . $row['id'],
        'buyUrl' => '../../Sell_Product/SellerProductPurchase.php?id=' . $row['id'],
        'storage' => [],
        'services' => [],
        'keywords' => []
    ];
}

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
        'detailUrl' => '../../DetailIntroduction/DetailIntroductinoDragonGodXProMax.html?product=aether-fold-one&section=story&scene=search',
        'buyUrl' => '../../SellPage(addcar)/SellPage.html?sku=aether-fold-one-512&campaign=search&source=search-page',
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
        'detailUrl' => '../../DetailIntroduction/DetailIntroductinoDragonGodXProMax.html?product=x-pro-max&section=design&scene=search',
        'buyUrl' => '../../SellPage(addcar)/SellPage.html?sku=x-pro-max-256&campaign=search&source=search-page',
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
        'detailUrl' => '../../DetailIntroduction/DetailIntroductionDragonGod80ProMaxWindRush.html',
        'buyUrl' => '../../DetailIntroduction/DetailIntroductionDragonGod80ProMaxWindRush.html',
        'storage' => ['256GB', '512GB'],
        'services' => ['Official Warranty'],
        'keywords' => ['windrush', 'display', 'battery', 'camera', 'performance']
    ]
];

$allProducts = array_merge($sellerProducts, $siteProducts);
$sellerCount = count($sellerProducts);

$query = normalize_text($_GET['q'] ?? '');
if ($query === '') {
    $results = $allProducts;
} else {
    $results = array_values(array_filter($allProducts, function ($p) use ($query) {
        return strpos(build_haystack($p), $query) !== false;
    }));
}

echo json_encode([
    'query' => $query,
    'sellerDataReady' => true,
    'sellerListingCount' => $sellerCount,
    'total' => count($results),
    'results' => array_values($results),
    'placeholderMessage' => $sellerCount > 0 ? null : 'No seller-uploaded phones have been saved yet.'
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>