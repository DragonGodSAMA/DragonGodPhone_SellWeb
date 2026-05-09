<?php
require_once __DIR__ . '/data_paths.php';

// This endpoint updates a user's block inside user_data.txt
// It expects POST fields: regUsername, fullName, address, phone, email, password, role

$regUsername = trim($_POST['regUsername'] ?? '');
if ($regUsername === '') {
    header('Location: ../HTML/Login&Registration/UserProfile.html?error=missing_username');
    exit;
}

$userFile = project_user_data_path();
$raw = file_exists($userFile) ? file_get_contents($userFile) : '';
if ($raw === false) $raw = '';

$blocks = explode("====================================", $raw);
$found = false;
for ($i = 0; $i < count($blocks); $i++) {
    if (strpos($blocks[$i], "Username: $regUsername") !== false) {
        // parse original block lines to preserve unspecified fields
        $orig = $blocks[$i];
        $lines = preg_split('/\r?\n/', trim($orig));
        $map = [];
        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $map[trim($parts[0])] = trim($parts[1]);
            }
        }

        // gather updates
        $fullName = trim($_POST['fullName'] ?? ($map['Full Name'] ?? ''));
        $address = trim($_POST['address'] ?? ($map['Address'] ?? ''));
        $phone = trim($_POST['phone'] ?? ($map['Phone'] ?? ''));
        $email = trim($_POST['email'] ?? ($map['Email'] ?? ''));
        $password = trim($_POST['password'] ?? ($map['Password'] ?? ''));
        $role = trim($_POST['role'] ?? ($map['Role'] ?? 'Buyer'));

        // If password empty, keep old
        if ($password === '') $password = ($map['Password'] ?? '');

        $time = date('Y-m-d H:i:s');

        $newBlock = "\nRegister Time: $time\nFull Name: $fullName\nAddress: $address\nPhone: $phone\nEmail: $email\nUsername: $regUsername\nPassword: $password\nRole: $role\n";

        $blocks[$i] = $newBlock;
        $found = true;
        break;
    }
}

if (!$found) {
    // append new record in same format
    $time = date('Y-m-d H:i:s');
    $fullName = trim($_POST['fullName'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? 'Buyer');

    $newBlock = "\n====================================\nRegister Time: $time\nFull Name: $fullName\nAddress: $address\nPhone: $phone\nEmail: $email\nUsername: $regUsername\nPassword: $password\nRole: $role\n====================================\n";
    $raw .= $newBlock;
} else {
    // re-join blocks with delimiter
    $raw = implode('====================================', $blocks);
}

// safe write with backup
@copy($userFile, $userFile . '.bak');
if (file_put_contents($userFile, $raw, LOCK_EX) === false) {
    header('Location: ../HTML/Login&Registration/UserProfile.html?error=save_failed');
    exit;
}

// after save, redirect back to profile with success
header('Location: ../HTML/Login&Registration/UserProfile.html?success=1');
exit;
?>