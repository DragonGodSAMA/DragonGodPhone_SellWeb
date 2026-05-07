<?php
$inputAccount = trim($_POST['loginAccount'] ?? '');
$inputPwd     = trim($_POST['loginPassword'] ?? '');

// 后端验证空值
if (empty($inputAccount) || empty($inputPwd)) {
    header("Location: ../../HTML/Login&Registration/Login.html?error=1");
    exit;
}

$userFile = __DIR__ . "/../user_data.txt";
$content  = file_exists($userFile) ? file_get_contents($userFile) : '';

$isValid = false;
if (
    (strpos($content, "Username: $inputAccount") !== false && strpos($content, "Password: $inputPwd") !== false)
    ||
    (strpos($content, "Phone: $inputAccount") !== false && strpos($content, "Password: $inputPwd") !== false)
    ||
    (strpos($content, "Email: $inputAccount") !== false && strpos($content, "Password: $inputPwd") !== false)
) {
    $isValid = true;
}

if ($isValid) {
    // 登录成功：带回用户名 + 成功状态
    header("Location: ../../HTML/Login&Registration/Login.html?success=1&username=".urlencode($inputAccount));
} else {
    header("Location: ../../HTML/Login&Registration/Login.html?error=1");
}
exit;
?>