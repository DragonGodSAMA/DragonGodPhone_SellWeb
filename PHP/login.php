<?php
require_once __DIR__ . '/db_connect.php';

$inputAccount = trim($_POST['loginAccount'] ?? '');
$inputPwd     = trim($_POST['loginPassword'] ?? '');

if (empty($inputAccount) || empty($inputPwd)) {
    header("Location: ../../HTML/Login&Registration/Login.html?error=1");
    exit;
}

try {
    $sql = "SELECT username, role, password FROM users 
            WHERE username = :account OR phone = :account OR email = :account 
            LIMIT 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':account' => $inputAccount]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $inputPwd) {
        $matchName = $user['username'];
        $userRole  = $user['role'];
        
        header("Location: ../../HTML/Login&Registration/Login.html?success=1&username=".urlencode($matchName)."&role=".$userRole);
    } else {
        header("Location: ../../HTML/Login&Registration/Login.html?error=1");
    }
} catch (PDOException $e) {
    die("Login Error: " . $e->getMessage());
}
exit;
?>