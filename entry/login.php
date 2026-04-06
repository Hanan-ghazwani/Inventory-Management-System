<?php
session_start();
include '../includes/db.php';

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($login) || empty($password)) {
        $error_message = 'يرجى إدخال جميع الحقول المطلوبة.';
    } else {
        $query = "SELECT * FROM users WHERE username = '$login' OR email = '$login'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // سجل الجلسة لتتبعها
                error_log("Login Successful. User Role: " . $_SESSION['role']);

                header("Location: ../index.php");
                exit();
            } else {
                $error_message = 'كلمة المرور غير صحيحة.';
            }
        } else {
            $error_message = 'اسم المستخدم أو البريد الإلكتروني غير موجود.';
        }
    }
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول: نظام إدارة المخزون</title>
    <link rel="stylesheet" href="../styles/login.css"> <!-- ملف CSS الجديد -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <h1 class="login-title">تسجيل الدخول</h1>

        <!-- عرض الإشعارات -->
        <?php if (!empty($success_message)): ?>
            <div class="notification success">
                <i class="fas fa-check-circle"></i>
                <span class="text"><?php echo $success_message; ?></span>
        
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="notification error">
                <i class="fas fa-exclamation-circle"></i>
                <span class="text"><?php echo $error_message; ?></span>
            
            </div>
        <?php endif; ?>

        <!-- نموذج تسجيل الدخول -->
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="login">اسم المستخدم أو البريد الإلكتروني:</label>
                <input type="text" id="login" name="login" placeholder="أدخل اسم المستخدم أو البريد الإلكتروني" required>
                <div class="line"></div>
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                <div class="line"></div>
            </div>

            <button type="submit" class="btn">تسجيل الدخول</button>
        </form>
        <div class="text-link">
            <p>لا يوجد لديك حساب؟ <a href="register.php">إنشاء حساب</a></p>
        </div>
    </div>
</body>
</html>