<?php
$inputAccount = trim($_POST['loginAccount'] ?? '');
$inputPwd     = trim($_POST['loginPassword'] ?? '');

if (empty($inputAccount) || empty($inputPwd)) {
    header("Location: ../../HTML/Login&Registration/Login.html?error=1");
    exit;
}

$userFile = __DIR__ . "/../data/user_data.txt";
$content  = file_exists($userFile) ? file_get_contents($userFile) : '';

$isValid = false;
$userRole = "Buyer";
$matchName = "";

// 遍历每条用户记录，匹配账号密码同时拿到 Role
$blocks = explode("====================================", $content);
foreach ($blocks as $block) {
    if(
        (strpos($block, "Username: $inputAccount") !== false 
         || strpos($block, "Phone: $inputAccount") !== false 
         || strpos($block, "Email: $inputAccount") !== false)
        && strpos($block, "Password: $inputPwd") !== false
    ){
        $isValid = true;
        // 提取身份
        preg_match('/Role:\s*(\w+)/', $block, $roleMat);
        if(!empty($roleMat[1])){
            $userRole = $roleMat[1];
        }
        // 提取用户名
        preg_match('/Username:\s*([^\n]+)/', $block, $nameMat);
        if(!empty($nameMat[1])){
            $matchName = trim($nameMat[1]);
        }
        break;
    }
}

if ($isValid) {
    // 同时传回 用户名 和 身份
    header("Location: ../../HTML/Login&Registration/Login.html?success=1&username=".urlencode($matchName)."&role=".$userRole);
} else {
    header("Location: ../../HTML/Login&Registration/Login.html?error=1");
}
exit;
?>