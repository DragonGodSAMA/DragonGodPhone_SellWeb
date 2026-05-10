<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../HTML/Sell_Product/Sell_Product.html?error=invalid_request');
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/seller_product_repository.php';

$uploadDir = __DIR__ . '/../Recourses/SellerUploads';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function upload_single_image($fileInfo, $uploadDir) {
    if (empty($fileInfo['name']) || $fileInfo['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    $extension = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
    $allowExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowExt)) {
        return null;
    }
    
    $targetName = uniqid('seller_', true) . '.' . $extension;
    $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $targetName;

    if (move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
        return 'Recourses/SellerUploads/' . $targetName; 
    }
    return null;
}

try {
    $pdo->beginTransaction();

    $productId = uniqid('seller-product-', true);
    
    $coverImage = upload_single_image($_FILES['cover_image'], $uploadDir);
    if (!$coverImage) {
        throw new Exception("Failed to upload the cover image. Please check the file format and size.");
    }

    $stmt = $pdo->prepare("INSERT INTO products (
        id, seller_name, seller_role, name, brand, base_price, `condition`, description, cover_image
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $productId,
        !empty($_POST['seller_name']) ? $_POST['seller_name'] : 'Anonymous Seller',
        !empty($_POST['seller_role']) ? $_POST['seller_role'] : 'Seller',
        $_POST['name'],
        $_POST['brand'],
        !empty($_POST['base_price']) ? (float)$_POST['base_price'] : 0.00, 
        !empty($_POST['condition']) ? $_POST['condition'] : 'Used - Good',
        !empty($_POST['description']) ? $_POST['description'] : 'No description provided.',
        $coverImage
    ]);

    if (!empty($_POST['color_name'])) {
        $stmt = $pdo->prepare("INSERT INTO product_colors (product_id, color_name, image_path) VALUES (?, ?, ?)");
        foreach ($_POST['color_name'] as $i => $name) {
            if (empty(trim($name))) {
                continue; 
            }
            
            $img = null;
            if (isset($_FILES['color_image']['tmp_name'][$i]) && $_FILES['color_image']['error'][$i] == UPLOAD_ERR_OK) {
                $img = upload_single_image([
                    'name' => $_FILES['color_image']['name'][$i],
                    'type' => $_FILES['color_image']['type'][$i],
                    'tmp_name' => $_FILES['color_image']['tmp_name'][$i],
                    'error' => $_FILES['color_image']['error'][$i],
                    'size' => $_FILES['color_image']['size'][$i]
                ], $uploadDir);
            }
            
            if (!$img) {
                $img = $coverImage;
            }
            
            $stmt->execute([$productId, $name, $img]);
        }
    }

    if (!empty($_POST['storage'])) {
        $stmt = $pdo->prepare("INSERT INTO product_storage (product_id, storage_label, extra_price) VALUES (?, ?, ?)");
        foreach ($_POST['storage'] as $i => $label) {
            if (empty(trim($label))) {
                continue; 
            }
            
            $extraPrice = isset($_POST['storage_price'][$i]) ? (float)$_POST['storage_price'][$i] : 0.00;
            $stmt->execute([$productId, $label, $extraPrice]);
        }
    }

    if (!empty($_POST['warranty_name'])) {
        $stmt = $pdo->prepare("INSERT INTO product_services (product_id, service_name, price, description) VALUES (?, ?, ?, ?)");
        foreach ($_POST['warranty_name'] as $i => $name) {
            if (empty(trim($name))) {
                continue; 
            }
            
            $price = isset($_POST['warranty_price'][$i]) ? (float)$_POST['warranty_price'][$i] : 0.00;
            $stmt->execute([$productId, $name, $price, $name . " service"]);
        }
    }

    $pdo->commit();
    header('Location: ../HTML/Sell_Product/Sell_Product.html?success=1&id=' . $productId);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("error：" . $e->getMessage());
}
?>