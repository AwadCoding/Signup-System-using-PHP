<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "../config.php";

// Response Array
$response = [
    "success" => false,
    "errors"  => [],
    "message" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // تنضيف الداتا
    $email    = isset($_POST['email'])    ? trim($_POST['email'])  : '';
    $password = isset($_POST['password']) ? $_POST['password']     : '';

    // ── Validation ─────────────────────────────────────────────────
    if (empty($email)) {
        $response["errors"]["email"] = "البريد الإلكتروني مطلوب.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["errors"]["email"] = "البريد الإلكتروني غير صالح.";
    }

    if (empty($password)) {
        $response["errors"]["password"] = "كلمة المرور مطلوبة.";
    }
    // ───────────────────────────────────────────────────────────────

    if (empty($response["errors"])) {

        // البحث عن المستخدم بالـ email
        $stmt = mysqli_prepare($connection, "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user   = mysqli_fetch_assoc($result);

        // التحقق من الباسورد
        if (!$user) {
            // الإيميل مش موجود في الـ DB
            $response["errors"]["email"] = "البريد الإلكتروني غير مسجل. <a href='signup.html'>إنشاء حساب</a>";

        } elseif (!password_verify($password, $user['password'])) {
            // الإيميل موجود لكن الباسورد غلط
            $response["errors"]["password"] = "كلمة المرور غير صحيحة.";

        } else {
            // ✅ الاتنين صح — سجّل الدخول
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            $response["success"]  = true;
            $response["message"]  = "تم تسجيل الدخول بنجاح! مرحباً، " . htmlspecialchars($user['name']);
            $response["redirect"] = "../backend/profile.php";
        }
    }

} else {
    $response["errors"]["global"] = "طريقة طلب غير صالحة.";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
