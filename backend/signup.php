<?php
// إرسال هيدر JSON — يجب أن يكون أول شيء
// ده عشان يبعت الاخطاء لل js 
//وتظهر في تحت  ال input
header("Content-Type: application/json; charset=UTF-8");

require_once "../config.php";

// مصفوفة الاستجابة
// الي بيتخزن فيها الايرورر
$response = [
    "success" => false,
    "errors"  => [],
    "message" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // استقبال البيانات وتنظيفها
    $name             = isset($_POST['name'])             ? trim($_POST['name'])             : '';
    $email            = isset($_POST['email'])            ? trim($_POST['email'])            : '';
    $password         = isset($_POST['password'])         ? $_POST['password']               : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password']       : '';

    // ── Validation ─────────────────────────────────────────────────

    if (empty($name)) {
        $response["errors"]["name"] = "الاسم مطلوب.";
    } elseif (strlen($name) < 3) {
        $response["errors"]["name"] = "الاسم يجب ألا يقل عن 3 أحرف.";
    }

    if (empty($email)) {
        $response["errors"]["email"] = "البريد الإلكتروني مطلوب.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["errors"]["email"] = "البريد الإلكتروني غير صالح.";
    }

    if (empty($password)) {
        $response["errors"]["password"] = "كلمة المرور مطلوبة.";
    } elseif (strlen($password) < 8) {
        $response["errors"]["password"] = "كلمة المرور يجب ألا تقل عن 8 أحرف.";
    }

    if (empty($confirm_password)) {
        $response["errors"]["confirm_password"] = "تأكيد كلمة المرور مطلوب.";
    } elseif ($password !== $confirm_password) {
        $response["errors"]["confirm_password"] = "كلمتا المرور غير متطابقتين.";
    }

    // ── لو مفيش أخطاء → سجل في الـ DB ───────────────────────────
    if (empty($response["errors"])) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // بنشوف لو الميل موجود قبل كدا 
        $check = mysqli_prepare($connection, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            $response["errors"]["email"] = "البريد الإلكتروني مستخدم بالفعل.";
        } else {
            $stmt = mysqli_prepare($connection, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $response["success"] = true;
                $response["message"] = "تم إنشاء الحساب بنجاح! يمكنك تسجيل الدخول الآن.";
            } else {
                $response["errors"]["global"] = "خطأ أثناء حفظ البيانات.";
            }
        }
    }

} else {
    $response["errors"]["global"] = "طريقة طلب غير صالحة.";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();