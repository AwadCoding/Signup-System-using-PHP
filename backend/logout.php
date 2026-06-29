<?php
require_once "../config.php";
// امسح كل بيانات  Session 
// عشان كنت بحتجها في ال profile page 
session_unset();
session_destroy();

header("Location: ../frontend/login.html");
exit();
