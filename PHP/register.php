<?php
require_once __DIR__ . '/db_connect.php';

$errors = [];

$fullName   = trim($_POST['fullName'] ?? '');
$address    = trim($_POST['address'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$email      = trim($_POST['email'] ?? '');
$regUsername= trim($_POST['regUsername'] ?? '');
$password   = trim($_POST['password'] ?? '');
$role       = $_POST['role'] ?? 'Buyer';

if (empty($fullName)) $errors[] = "Full name is required";
if (empty($phone)) $errors[] = "Phone number is required";
if (empty($email)) $errors[] = "Email is required";
if (empty($regUsername)) $errors[] = "Username is required";
if (empty($password)) $errors[] = "Password is required";

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (!empty($phone) && !preg_match('/^1[3-9]\d{9}$/', $phone)) {
    $errors[] = "Invalid phone number";
}

if (!empty($password) && strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

if (empty($errors)) {
    $check = $pdo->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    $check->execute([$regUsername]);
    if ($check->fetch()) $errors[] = "Username already exists";
}

if (empty($errors)) {
    $check = $pdo->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
    $check->execute([$email]);
    if ($check->fetch()) $errors[] = "Email already exists";
}

if (!empty($errors)) {
    echo "Registration blocked:\n";
    echo implode("\n", $errors);
    exit();
}

$stmt = $pdo->prepare("INSERT INTO users (full_name, address, phone, email, username, password, role) VALUES (?,?,?,?,?,?,?)");
$stmt->execute([$fullName, $address, $phone, $email, $regUsername, password_hash($password, PASSWORD_DEFAULT), $role]);

header("Location: ../../HTML/Login&Registration/Login.html");
exit();
?>