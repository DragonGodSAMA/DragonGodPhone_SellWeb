<?php
require_once __DIR__ . '/db_connect.php';

$fullName   = $_POST['fullName'] ?? '';
$address    = $_POST['address'] ?? '';
$phone      = $_POST['phone'] ?? '';
$email      = $_POST['email'] ?? '';
$regUsername= $_POST['regUsername'] ?? '';
$password   = $_POST['password'] ?? '';
$role       = $_POST['role'] ?? 'Buyer';

try {
    $sql = "INSERT INTO users (full_name, address, phone, email, username, password, role) 
            VALUES (:fullName, :address, :phone, :email, :username, :password, :role)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':fullName' => $fullName,
        ':address'  => $address,
        ':phone'    => $phone,
        ':email'    => $email,
        ':username' => $regUsername,
        ':password' => $password, // 建议使用 password_hash() 加密
        ':role'     => $role
    ]);

    header("Location: ../../HTML/Login&Registration/Login.html");
} catch (PDOException $e) {
    // 如果用户名或手机重复，会抛出异常
    echo "Registration Error: " . $e->getMessage();
}
exit;
?>