<?php
// انسخ الملف ده وسميه config.php
// واملا البيانات بتاعتك

session_start();

$host     = "localhost";
$username = "root";         // اسم مستخدم قاعدة البيانات
$password = "";             // باسورد قاعدة البيانات
$dbname   = "your_db_name"; // اسم قاعدة البيانات

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die(json_encode(["success" => false, "errors" => ["global" => "Connection failed: " . mysqli_connect_error()]]));
}
?>
