<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../HTML/Sell_Product/Sell_Product.html?error=invalid_request');
    exit;
}

// 强制开启报错，方便调试
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/seller_product_repository.php';

// 上传路径：根目录下的 Recourses/SellerUploads
$uploadDir = __DIR__ . '/../Recourses/SellerUploads';

// 自动创建上传文件夹
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function upload_single_image($fileInfo, $uploadDir) {
    if (empty($fileInfo['name']) || $fileInfo['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    $extension = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
    // 只允许图片格式
    $allowExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowExt)) {
        return null;
    }
    
    $targetName = uniqid('seller_', true) . '.' . $extension;
    $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $targetName;

    if (move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
        return 'Recourses/SellerUploads/' . $targetName; // 数据库存储完整相对路径
    }
    return null;
}

try {
    $pdo->beginTransaction();

    $productId = uniqid('seller-product-', true);
    
    // 处理封面图（必填）
    $coverImage = upload_single_image($_FILES['cover_image'], $uploadDir);
    if (!$coverImage) {
        throw new Exception("封面图上传失败，请检查文件格式和大小");
    }

    // 1. 插入主表（和数据库表字段完全匹配 + 空值防护）
    $stmt = $pdo->prepare("INSERT INTO products (
        id, seller_name, seller_role, name, brand, base_price, `condition`, description, cover_image
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $productId,
        !empty($_POST['seller_name']) ? $_POST['seller_name'] : 'Anonymous Seller',
        !empty($_POST['seller_role']) ? $_POST['seller_role'] : 'Seller',
        $_POST['name'],
        $_POST['brand'],
        !empty($_POST['base_price']) ? (float)$_POST['base_price'] : 0.00, // 价格强制转数字
        !empty($_POST['condition']) ? $_POST['condition'] : 'Used - Good',
        !empty($_POST['description']) ? $_POST['description'] : 'No description provided.',
        $coverImage
    ]);

    // 2. 插入颜色表
    if (!empty($_POST['color_name'])) {
        $stmt = $pdo->prepare("INSERT INTO product_colors (product_id, color_name, image_path) VALUES (?, ?, ?)");
        foreach ($_POST['color_name'] as $i => $name) {
            if (empty(trim($name))) {
                continue; // 跳过空的颜色名称
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
            
            // 如果没上传颜色图，默认用封面图
            if (!$img) {
                $img = $coverImage;
            }
            
            $stmt->execute([$productId, $name, $img]);
        }
    }

    // 3. 插入存储表
    if (!empty($_POST['storage'])) {
        $stmt = $pdo->prepare("INSERT INTO product_storage (product_id, storage_label, extra_price) VALUES (?, ?, ?)");
        foreach ($_POST['storage'] as $i => $label) {
            if (empty(trim($label))) {
                continue; // 跳过空的存储选项
            }
            
            $extraPrice = isset($_POST['storage_price'][$i]) ? (float)$_POST['storage_price'][$i] : 0.00;
            $stmt->execute([$productId, $label, $extraPrice]);
        }
    }

    // 4. 插入保修服务表（你之前漏掉了这部分）
    if (!empty($_POST['warranty_name'])) {
        $stmt = $pdo->prepare("INSERT INTO product_services (product_id, service_name, price, description) VALUES (?, ?, ?, ?)");
        foreach ($_POST['warranty_name'] as $i => $name) {
            if (empty(trim($name))) {
                continue; // 跳过空的服务选项
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
    die("错误：" . $e->getMessage());
}
?>