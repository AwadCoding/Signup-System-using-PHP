<?php
require_once "../config.php";


    // لو مش مسجل => يرجع لصفحة تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.html");
    exit();
}

// بيانات المستخدم من الـ Session
$user_id    = $_SESSION['user_id'];
$user_name  = htmlspecialchars($_SESSION['user_name']);
$user_email = htmlspecialchars($_SESSION['user_email']);

// Avatar initials — أول حرف من كل كلمة في الاسم
$initials = '';
foreach (explode(' ', $user_name) as $word) {
    $initials .= strtoupper(mb_substr($word, 0, 1));
}
$initials = mb_substr($initials, 0, 2); 
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile — <?= $user_name ?></title>
    <link rel="stylesheet" href="../frontend/css/profile.css" />
</head>
<body>

    <div class="profile-card">
        <div class="avatar"><?= $initials ?></div>
        <h1 class="profile-name"><?= $user_name ?></h1>
        <p class="profile-email"><?= $user_email ?></p>

        <div class="divider"></div>

        <div class="info-row">
            <span class="info-label">الـ ID</span>
            <span class="info-value">#<?= $user_id ?></span>
        </div>

        <div class="info-row">
            <span class="info-label">الاسم</span>
            <span class="info-value"><?= $user_name ?></span>
        </div>

        <div class="info-row">
            <span class="info-label">البريد</span>
            <span class="info-value"><?= $user_email ?></span>
        </div>

        <div class="info-row">
            <span class="info-label">الحالة</span>
            <span class="info-value"><span class="badge">✓ Active</span></span>
        </div>

        <a href="../frontend/logout.php" class="btn-logout">تسجيل الخروج</a>

    </div>

</body>
</html>
