<?php
include './includes/db.php'; // تأكدي من صحة المسار

// جلب جميع المستخدمين الذين لديهم كلمات مرور غير مشفرة
$query = "SELECT id, password FROM users WHERE password NOT LIKE '$2y$%'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $plain_password = $row['password'];

        // تشفير كلمة المرور
        $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

        // تحديث كلمة المرور في قاعدة البيانات
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = $id";
        if (mysqli_query($conn, $update_query)) {
            echo "تم تحديث كلمة المرور للمستخدم ID: $id بنجاح.<br>";
        } else {
            echo "حدث خطأ أثناء تحديث المستخدم ID: $id - " . mysqli_error($conn) . "<br>";
        }
    }
} else {
    echo "لا توجد كلمات مرور تحتاج إلى تشفير.";
}
?>