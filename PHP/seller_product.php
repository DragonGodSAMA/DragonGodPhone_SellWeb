<?php
require_once __DIR__ . '/data_paths.php';

// 统一清理输入数据
function clean($str) {
    return trim((string)$str);
}

// 1. 接收表单提交的数据
$productName = clean($_POST['productName'] ?? '');
$brand       = clean($_POST['brand'] ?? '');
$basePrice   = (float)($_POST['basePrice'] ?? 0);
$condition   = clean($_POST['condition'] ?? 'Used - Good'); // 下拉默认值
$description = clean($_POST['description'] ?? '');

// 封面图片（先记录文件名，如需真正上传文件，我可以帮你补全）
$coverImage  = $_FILES['coverImage']['name'] ?? '';

// 颜色选项（最多5个）
$colorOptions = [];
for ($i = 1; $i <= 5; $i++) {
    $colorName = clean($_POST["color{$i}Name"] ?? '');
    $colorImg  = $_FILES["color{$i}Image"]['name'] ?? '';
    if ($colorName !== '' || $colorImg !== '') {
        $colorOptions[] = [
            'name'  => $colorName,
            'image' => $colorImg
        ];
    }
}

// 存储选项（最多5个）
$storageOptions = [];
for ($i = 1; $i <= 5; $i++) {
    $storageLabel = clean($_POST["storage{$i}Label"] ?? '');
    $extraPrice   = (float)($_POST["storage{$i}ExtraPrice"] ?? 0);
    if ($storageLabel !== '') {
        $storageOptions[] = [
            'label'       => $storageLabel,
            'extra_price' => $extraPrice
        ];
    }
}

// 服务选项（最多3个）
$serviceOptions = [];
for ($i = 1; $i <= 3; $i++) {
    $serviceName  = clean($_POST["service{$i}Name"] ?? '');
    $servicePrice = (float)($_POST["service{$i}Price"] ?? 0);
    if ($serviceName !== '') {
        $serviceOptions[] = [
            'name'  => $serviceName,
            'price' => $servicePrice
        ];
    }
}

$time = date("Y-m-d H:i:s");

// 2. 拼接成文本格式（和用户注册格式保持一致）
$colorText = "";
foreach ($colorOptions as $idx => $color) {
    $num = $idx + 1;
    $colorText .= "Color {$num} Name: {$color['name']}\n";
    $colorText .= "Color {$num} Image: {$color['image']}\n";
}

$storageText = "";
foreach ($storageOptions as $idx => $sto) {
    $num = $idx + 1;
    $storageText .= "Storage {$num} Label: {$sto['label']}\n";
    $storageText .= "Storage {$num} Extra Price: {$sto['extra_price']}\n";
}

$serviceText = "";
foreach ($serviceOptions as $idx => $ser) {
    $num = $idx + 1;
    $serviceText .= "Service {$num} Name: {$ser['name']}\n";
    $serviceText .= "Service {$num} Price: {$ser['price']}\n";
}

$record = "
====================================
Publish Time: {$time}
Product Name: {$productName}
Brand: {$brand}
Base Price: {$basePrice}
Condition: {$condition}
Description: {$description}
Cover Image: {$coverImage}

--- Color Options ---
{$colorText}
--- Storage Options ---
{$storageText}
--- Services ---
{$serviceText}
====================================
";

// 3. 写入 sellerPhone_data.txt（和你的 data_paths.php 风格统一）
if (!function_exists('project_seller_phone_data_path')) {
    function project_seller_phone_data_path() {
        return project_data_file_path('sellerPhone_data.txt');
    }
}

$filePath = project_seller_phone_data_path();

// FILE_APPEND | LOCK_EX 追加写入 + 文件锁，避免并发损坏
file_put_contents($filePath, $record, FILE_APPEND | LOCK_EX);

// 4. 跳转回页面（可根据你的前端路径调整）
header("Location: ../../HTML/Seller/SellProduct.html?success=1");
exit;
?>