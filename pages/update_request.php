<?php
session_start();
$page_title = " تحديث حالة الطلب";
include '../header.php';
include '../includes/db.php';

// التحقق من الجلسة والسماح فقط للفني بالتحديث
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician') {
    header("Location: ../entry/login.php");
    exit();
}

// استلام معرف الطلب
if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']);
    $query = "SELECT * FROM requests WHERE id = $request_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $request = mysqli_fetch_assoc($result);
    } else {
        die("الطلب غير موجود!");
    }
} else {
    die("رقم الطلب غير محدد!");
}

// تحديث الطلب عند الإرسال
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $update_query = "UPDATE requests SET status = '$status' WHERE id = $request_id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: requests.php");
        exit();
    } else {
        die("حدث خطأ أثناء التحديث: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>تحديث الطلب رقم <?php echo htmlspecialchars($request['id']); ?></h1>
        <form action="update_request.php?id=<?php echo $request['id']; ?>" method="POST">
            <label for="status">حالة الطلب:</label>
            <select id="status" name="status" required>
                <option value="قيد التنفيذ" <?php echo $request['status'] == 'قيد التنفيذ' ? 'selected' : ''; ?>>قيد التنفيذ</option>
                <option value="تم التوصيل" <?php echo $request['status'] == 'تم التوصيل' ? 'selected' : ''; ?>>تم التوصيل</option>
                <option value="ملغي" <?php echo $request['status'] == 'ملغي' ? 'selected' : ''; ?>>ملغي</option>
            </select>
            <button type="submit" name="update">تحديث</button>
        </form>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>