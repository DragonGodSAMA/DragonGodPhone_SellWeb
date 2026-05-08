<?php
$fullName   = $_POST['fullName'] ?? '';
$address    = $_POST['address'] ?? '';
$phone      = $_POST['phone'] ?? '';
$email      = $_POST['email'] ?? '';
$regUsername= $_POST['regUsername'] ?? '';
$password   = $_POST['password'] ?? '';
$role       = $_POST['role'] ?? 'Buyer'; // 接收身份
$time       = date("Y-m-d H:i:s");

$text = "
====================================
Register Time: $time
Full Name: $fullName
Address: $address
Phone: $phone
Email: $email
Username: $regUsername
Password: $password
Role: $role
====================================
";

file_put_contents(__DIR__ . "/../data/user_data.txt", $text, FILE_APPEND);

header("Location: ../../HTML/Login&Registration/Login.html");
exit;
?>