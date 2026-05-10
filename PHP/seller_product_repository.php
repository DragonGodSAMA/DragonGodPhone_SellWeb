<?php
require_once __DIR__ . '/db_config.php';

function seller_clean_value($value) {
    return trim((string) $value);
}

function seller_asset_web_path($assetPath, $prefix = '../../') {
    $cleanPath = seller_clean_value($assetPath);
    if ($cleanPath === '') return $prefix . 'Recourses/HomePage/hero-device.svg';
    if (preg_match('/^(https?:)?\/\//', $cleanPath) || strpos($cleanPath, 'data:') === 0) return $cleanPath;
    
    $normalizedPath = ltrim(str_replace('\\', '/', $cleanPath), '/');
    if (strpos($normalizedPath, 'Recourses/') !== 0) {
        $normalizedPath = 'Recourses/' . $normalizedPath;
    }
    return $prefix . $normalizedPath;
}

function find_seller_product($productId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM seller_products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
    
    if (!$product) return null;

    $stmt = $pdo->prepare("SELECT color_name as name, image_path FROM product_colors WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product['colors'] = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT label, extra_price FROM product_storage WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product['storage'] = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT name, price FROM product_services WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product['services'] = $stmt->fetchAll();

    return $product;
}