<?php
// ربط قاعدة البيانات
include './includes/db.php'; // عدل المسار حسب مكان ملف db.php

// كلمة المرور الجديدة (استبدلها بكلمة المرور المطلوبة)
$new_password = '90067899';
$username = 'user1';
$new_password = 'abc123';


$username = 'user2';
$new_password = 'adf565';

// تشفير كلمة المرور
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

// تحديث كلمة المرور في قاعدة البيانات
$query = "UPDATE users SET password = '$hashed_password' WHERE username = 'admin'";

if (mysqli_query($conn, $query)) {
    echo "تم تحديث كلمة المرور بنجاح!";
} else {
    echo "حدث خطأ: " . mysqli_error($conn);
}
?>