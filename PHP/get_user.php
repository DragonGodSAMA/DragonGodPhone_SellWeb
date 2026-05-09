<?php
require_once __DIR__ . '/data_paths.php';
header('Content-Type: application/json; charset=utf-8');

$username = trim($_GET['username'] ?? '');
if ($username === '') {
    echo json_encode(['ok' => false, 'message' => 'username required']);
    exit;
}

$userFile = project_user_data_path();
$raw = file_exists($userFile) ? file_get_contents($userFile) : '';
if ($raw === false) $raw = '';

$blocks = explode("====================================", $raw);
foreach ($blocks as $blk) {
    if (strpos($blk, "Username: $username") !== false) {
        $lines = preg_split('/\r?\n/', trim($blk));
        $map = [];
        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $map[trim($parts[0])] = trim($parts[1]);
            }
        }
        echo json_encode(['ok' => true, 'user' => [
            'username' => $map['Username'] ?? $username,
            'fullName' => $map['Full Name'] ?? '',
            'address' => $map['Address'] ?? '',
            'phone' => $map['Phone'] ?? '',
            'email' => $map['Email'] ?? '',
            'role' => $map['Role'] ?? 'Buyer',
            'registerTime' => $map['Register Time'] ?? ''
        ]]);
        exit;
    }
}

echo json_encode(['ok' => false, 'message' => 'user not found']);
exit;
?>