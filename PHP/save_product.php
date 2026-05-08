<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../HTML/Sell_Product/Sell_Product.html?error=invalid_request');
    exit;
}

require_once __DIR__ . '/seller_product_repository.php';

function clean_value($value) {
    return trim((string) $value);
}

function upload_single_image($fileInfo, $uploadDir) {
    if (empty($fileInfo['name']) || (int) ($fileInfo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ((int) ($fileInfo['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return false;
    }

    $extension = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowed, true)) {
        return false;
    }

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
        return false;
    }

    $targetName = uniqid('seller_', true) . '.' . $extension;
    $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $targetName;

    if (!move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
        return false;
    }

    return 'Recourses/SellerUploads/' . $targetName;
}

function collect_rows($labels, $prices, $labelKey, $priceKey) {
    $rows = [];
    $labels = is_array($labels) ? $labels : [];
    $prices = is_array($prices) ? $prices : [];

    foreach ($labels as $index => $label) {
        $cleanLabel = clean_value($label);
        $cleanPrice = isset($prices[$index]) ? (float) $prices[$index] : 0;

        if ($cleanLabel === '') {
            continue;
        }

        $rows[] = [
            $labelKey => $cleanLabel,
            $priceKey => $cleanPrice
        ];
    }

    return $rows;
}

function collect_colors($names, $files, $uploadDir) {
    $rows = [];
    $names = is_array($names) ? $names : [];

    foreach ($names as $index => $name) {
        $cleanName = clean_value($name);
        $imagePath = null;

        if (isset($files['name'][$index]) && $files['name'][$index] !== '') {
            $singleFile = [
                'name' => $files['name'][$index] ?? '',
                'type' => $files['type'][$index] ?? '',
                'tmp_name' => $files['tmp_name'][$index] ?? '',
                'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$index] ?? 0
            ];
            $imagePath = upload_single_image($singleFile, $uploadDir);
            if ($imagePath === false) {
                return false;
            }
        }

        if ($cleanName === '' && !$imagePath) {
            continue;
        }

        $rows[] = [
            'name' => $cleanName !== '' ? $cleanName : 'Color option',
            'image' => $imagePath
        ];
    }

    return $rows;
}

$name = clean_value($_POST['name'] ?? '');
$brand = clean_value($_POST['brand'] ?? '');
$basePrice = isset($_POST['base_price']) ? (float) $_POST['base_price'] : 0;
$condition = clean_value($_POST['condition'] ?? 'Used');
$description = clean_value($_POST['description'] ?? '');
$sellerName = clean_value($_POST['seller_name'] ?? 'Seller');
$sellerRole = clean_value($_POST['seller_role'] ?? 'Seller');

if ($name === '' || $brand === '' || $basePrice <= 0 || $description === '') {
    header('Location: ../../HTML/Sell_Product/Sell_Product.html?error=missing_fields');
    exit;
}

$uploadDir = __DIR__ . '/../Recourses/SellerUploads';
$coverImage = upload_single_image($_FILES['cover_image'] ?? [], $uploadDir);
if ($coverImage === false || $coverImage === null) {
    header('Location: ../../HTML/Sell_Product/Sell_Product.html?error=cover_upload');
    exit;
}

$colors = collect_colors($_POST['color_name'] ?? [], $_FILES['color_image'] ?? [], $uploadDir);
if ($colors === false) {
    header('Location: ../../HTML/Sell_Product/Sell_Product.html?error=color_upload');
    exit;
}

$storage = collect_rows($_POST['storage'] ?? [], $_POST['storage_price'] ?? [], 'label', 'extra_price');
$services = collect_rows($_POST['warranty_name'] ?? [], $_POST['warranty_price'] ?? [], 'name', 'price');

$databasePath = seller_products_database_path();
$existing = [];
if (file_exists($databasePath)) {
    $decoded = json_decode((string) file_get_contents($databasePath), true);
    if (is_array($decoded)) {
        $existing = $decoded;
    }
}

$record = [
    'id' => uniqid('seller-product-', true),
    'name' => $name,
    'brand' => $brand,
    'base_price' => $basePrice,
    'condition' => $condition,
    'description' => $description,
    'seller_name' => $sellerName,
    'seller_role' => $sellerRole,
    'cover_image' => $coverImage,
    'colors' => $colors,
    'storage' => $storage,
    'services' => $services,
    'keywords' => array_values(array_filter([$name, $brand, $condition])),
    'created_at' => date('c')
];

$existing[] = $record;

file_put_contents(
    $databasePath,
    json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

header('Location: ../../HTML/Sell_Product/Sell_Product.html?success=1&id=' . urlencode($record['id']));
exit;
?>