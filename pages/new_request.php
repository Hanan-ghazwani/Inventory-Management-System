<?php
$page_title = "إضافة طلب جديد";
include '../header.php';
include '../includes/db.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $request_type = mysqli_real_escape_string($conn, $_POST['request_type']);
    $item_id = intval($_POST['item_id']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    // التحقق من الحد اليومي للطلبات
    $date_today = date('Y-m-d');
    $check_query = "SELECT COUNT(*) AS request_count FROM requests WHERE user_id = '$user_id' AND DATE(created_at) = '$date_today'";
    $check_result = mysqli_query($conn, $check_query);
    $row = mysqli_fetch_assoc($check_result);

    if ($row['request_count'] >= 3) {
        $error_message = "لقد وصلت إلى الحد الأقصى للطلبات اليومية (3 طلبات).";
    } else {
        // إدخال الطلب
        $query = "INSERT INTO requests (user_id, request_type, item_id, description, priority, department, status, created_at) 
                  VALUES ('$user_id', '$request_type', '$item_id', '$description', '$priority', '$department', 'قيد التوزيع', NOW())";

        if (mysqli_query($conn, $query)) {
            $success_message = "تم إرسال الطلب بنجاح!";
        } else {
            $error_message = "حدث خطأ أثناء الإرسال: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة طلب جديد</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>إضافة طلب جديد</h1>
        <?php if ($success_message): ?>
            <div class="notification"><?php echo $success_message; ?></div>
        <?php elseif ($error_message): ?>
            <div class="notification error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="new_request.php" method="POST">
            <div class="form-group">
                <label for="request_type">نوع الطلب: <span style="color: red;">*</span></label>
                <select id="request_type" name="request_type" required>
                    <option value="">اختر نوع الطلب</option>
                    <option value="أجهزة">أجهزة</option>
                    <option value="شبكات">شبكات</option>
                    <option value="أنظمة">أنظمة</option>
                </select>
            </div>

            <div class="form-group">
                <label for="item_id">اختر القطعة: <span style="color: red;">*</span></label>
                <select id="item_id" name="item_id" required>
                    <option value="">اختر القطعة</option>
                    <?php
                    $query = "SELECT id, item_name FROM inventory WHERE quantity > 0";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['item_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">وصف الطلب: <span style="color: red;">*</span></label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="priority">الأولوية: <span style="color: red;">*</span></label>
                <select id="priority" name="priority" required>
                    <option value="">اختر الأولوية</option>
                    <option value="عالية">عالية</option>
                    <option value="متوسطة">متوسطة</option>
                    <option value="منخفضة">منخفضة</option>
                </select>
            </div>

            <div class="form-group">
            <label for="department">القسم: <span style="color: red;">*</span></label>
                <input type="text" id="department" name="department" required>
            </div>

            <button type="submit" class="submit-btn">إرسال الطلب</button>
        </form>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>