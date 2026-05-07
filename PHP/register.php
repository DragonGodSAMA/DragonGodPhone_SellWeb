<?php
$fullName   = $_POST['fullName'] ?? '';
$address    = $_POST['address'] ?? '';
$phone      = $_POST['phone'] ?? '';
$email      = $_POST['email'] ?? '';
$regUsername= $_POST['regUsername'] ?? '';
$password   = $_POST['password'] ?? '';
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
====================================
";

file_put_contents(__DIR__ . "/../user_data.txt", $text, FILE_APPEND);

// 直接跳转到登录页，不显示任何内容
header("Location: ../../HTML/Login&Registration/Login.html");
exit;
?>