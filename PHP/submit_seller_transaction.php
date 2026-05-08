<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/seller_product_repository.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Only POST requests are allowed.']);
    exit;
}

$listingId = seller_clean_value($_POST['listingId'] ?? '');
$actionType = seller_clean_value($_POST['actionType'] ?? '');
$buyerName = seller_clean_value($_POST['buyerName'] ?? '');
$buyerRole = seller_clean_value($_POST['buyerRole'] ?? '');
$selectedColor = seller_clean_value($_POST['selectedColor'] ?? '');
$selectedStorage = seller_clean_value($_POST['selectedStorage'] ?? '');
$selectedServices = json_decode((string) ($_POST['selectedServices'] ?? '[]'), true);
$quantity = max(1, (int) ($_POST['quantity'] ?? 1));

if ($listingId === '' || !in_array($actionType, ['add_to_cart', 'buy_now'], true)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Missing listing or action information.']);
    exit;
}

$listing = find_seller_product($listingId);
if (!$listing) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'message' => 'The seller product could not be found.']);
    exit;
}

if ($buyerName === '' || $buyerRole !== 'Buyer') {
    http_response_code(403);
    echo json_encode(['ok' => false, 'message' => 'A logged-in Buyer account is required to continue.']);
    exit;
}

$colorMatch = null;
foreach ($listing['colors'] as $color) {
    if ($selectedColor === $color['name'] || $selectedColor === $color['id']) {
        $colorMatch = $color;
        break;
    }
}

$storageMatch = null;
foreach ($listing['storage'] as $storage) {
    if ($selectedStorage === $storage['label'] || $selectedStorage === $storage['id']) {
        $storageMatch = $storage;
        break;
    }
}

if (!$colorMatch || !$storageMatch) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Please choose a valid seller listing configuration before submitting.']);
    exit;
}

$maxQuantity = max(1, (int) ($listing['max_quantity'] ?? 1));
if ($quantity > $maxQuantity) {
    $quantity = $maxQuantity;
}

$normalizedServices = [];
$servicesTotal = 0;
if (is_array($selectedServices)) {
    foreach ($listing['services'] as $service) {
        if (in_array($service['name'], $selectedServices, true) || in_array($service['id'], $selectedServices, true)) {
            $normalizedServices[] = $service['name'];
            $servicesTotal += (float) $service['price'];
        }
    }
}

$unitPrice = (float) $listing['base_price'] + (float) $storageMatch['extra_price'] + $servicesTotal;
$totalPrice = $unitPrice * $quantity;

$transactionsPath = seller_transactions_database_path();
$transactions = [];
if (file_exists($transactionsPath)) {
    $decoded = json_decode((string) file_get_contents($transactionsPath), true);
    if (is_array($decoded)) {
        $transactions = $decoded;
    }
}

$transactionId = uniqid('seller-transaction-', true);
$transactions[] = [
    'id' => $transactionId,
    'listing_id' => $listing['id'],
    'listing_name' => $listing['name'],
    'seller_name' => $listing['seller_name'],
    'action_type' => $actionType,
    'buyer_name' => $buyerName,
    'buyer_role' => $buyerRole,
    'selected_color' => $colorMatch['name'],
    'selected_storage' => $storageMatch['label'],
    'selected_services' => $normalizedServices,
    'quantity' => $quantity,
    'unit_price' => $unitPrice,
    'total_price' => $totalPrice,
    'created_at' => date('c')
];

$writeResult = file_put_contents(
    $transactionsPath,
    json_encode($transactions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    LOCK_EX
);

if ($writeResult === false) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'The second-hand transaction could not be stored.']);
    exit;
}

echo json_encode([
    'ok' => true,
    'transactionId' => $transactionId,
    'message' => $actionType === 'buy_now'
        ? 'Second-hand order submitted successfully.'
        : 'Second-hand product added to the seller cart flow successfully.'
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>