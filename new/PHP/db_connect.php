<?php
// db_connect.php
$host = 'localhost';
$dbname = 'dragongod_db';
$dbuser = 'root'; 
$dbpass = '123456'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
?>