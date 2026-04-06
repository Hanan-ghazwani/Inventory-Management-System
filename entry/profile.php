<?php
$page_title = "  حسابي";
include '../header.php';
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../entry/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

    $update_query = "UPDATE users SET email = '$email', username = '$username', full_name = '$full_name'";

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update_query .= ", password = '$password'";
    }

    $update_query .= " WHERE id = $user_id";

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['full_name'] = $full_name;
        $success_message = "تم تحديث البيانات بنجاح!";
    } else {
        $error_message = "حدث خطأ أثناء التحديث: " . mysqli_error($conn);
    }
}

// جلب بيانات المستخدم الحالية
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حسابي</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>تعديل بيانات الحساب</h1>
        <?php if (isset($success_message)): ?>
            <div class="notification"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="notification error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="profile.php" method="POST">
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="username">اسم المستخدم:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="full_name">الاسم الثلاثي:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور الجديدة:</label>
                <input type="password" id="password" name="password" placeholder="(اترك الحقل فارغًا إذا لم ترغب في التغيير)">
            </div>

            <button type="submit" class="submit-btn">تحديث البيانات</button>
        </form>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>