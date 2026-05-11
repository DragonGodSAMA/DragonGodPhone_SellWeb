<?php
require_once __DIR__ . '/db_config.php';

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
    
    if (strpos($normalizedPath, 'Recourses/SellerUploads/') !== 0) {
        $normalizedPath = 'Recourses/SellerUploads/' . $normalizedPath;
    }
    
    return $prefix . $normalizedPath;
}

function find_seller_product($productId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) return null;
    
    $stmt = $pdo->prepare("SELECT id, color_name as name, image_path FROM product_colors WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product['colors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($product['colors'])) {
        $product['colors'] = [
            [
                'id' => 1,
                'name' => 'Default',
                'image_path' => $product['cover_image']
            ]
        ];
    }
    
    $stmt = $pdo->prepare("SELECT id, storage_label as label, extra_price FROM product_storage WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product['storage'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($product['storage'])) {
        $product['storage'] = [
            [
                'id' => 1,
                'label' => 'Standard',
                'extra_price' => 0.00
            ]
        ];
    }
    
    $stmt = $pdo->prepare("SELECT id, service_name as name, price, description FROM product_services WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product['services'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $product['gallery_paths'] = array_column($product['colors'], 'image_path');
    $product['max_quantity'] = 1;
    
    return $product;
}

function load_seller_products() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC, id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>