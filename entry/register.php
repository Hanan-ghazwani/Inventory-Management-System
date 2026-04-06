<?php
$page_title = " انشاء حساب جديد ";
include '../includes/db.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : 'employee';

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $error_message = 'اسم المستخدم مسجل مسبقًا.';
    } else {
        $insert_query = "INSERT INTO users (email, full_name, username, password, role) 
                         VALUES ('$email', '$full_name', '$username', '$hashed_password', '$role')";
        if (mysqli_query($conn, $insert_query)) {
            $success_message = 'تم إنشاء الحساب بنجاح! يمكنك تسجيل الدخول الآن.';
        } else {
            $error_message = 'حدث خطأ أثناء إنشاء الحساب، حاول مرة أخرى.';
        }
    }
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب جديد</title>
    <link rel="stylesheet" href="../styles/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>إنشاء حساب جديد</h1>

        <!-- إشعارات النجاح أو الخطأ -->
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

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" required>
                <div class="line"></div>
            </div>
            <div class="form-group">
                <label for="username">اسم المستخدم:</label>
                <input type="text" id="username" name="username" required>
                <div class="line"></div>
            </div>
            <div class="form-group">
                <label for="full_name">الاسم الثلاثي:</label>
                <input type="text" id="full_name" name="full_name" required>
                <div class="line"></div>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required>
                <div class="line"></div>
            </div>

            <div class="form-group">
                <label for="dropdown">الدور:</label>
                <div class="dropdown-container">
                <select id="dropdown" name="role" class="custom-dropdown" required>
                <option value="" disabled selected hidden>  انقر هنا  </option>
                    <option value="employee">موظف</option>
                    <option value="admin">مسؤول</option>
                    <option value="technician">فني</option>
                    <option value="distributor">موزع</option>
                </select>
                <div class="line"></div>
                <div class="dropdown-arrow"></div>
            </div>

            <button type="submit" class="btn">إنشاء حساب</button>
        </form>
        <div class="text-link">
            <p>لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
        </div>
    </div>
</body>
</html>