<?php
// التأكد من تسجيل الدخول كفني
session_start();
if ($_SESSION['role'] !== 'technician') {
    header('Location: ../index.php');
    exit();
}
$page_title = "   الفني:الطلبات";
include '../header.php';
include '../includes/db.php';

// جلب الطلبات التي تم إسنادها لهذا الفني
$technician_id = $_SESSION['user_id']; // معرف الفني المسجل دخوله
$query = "SELECT * FROM requests WHERE technician_id = '$technician_id' AND status = 'قيد التنفيذ'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- المحتوى -->
    <div class="container">
        <h1>الطلبات المسندة إليك</h1>
        <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="technic-table">
        <thead>
            <tr>
                <th>#</th>
                <th>الوصف</th>
                <th>القسم</th>
                <th>نوع الطلب</th>
                <th>الأولوية</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo isset($row['id']) ? $row['id'] : ''; ?></td>
                    <td><?php echo isset($row['description']) ? $row['description'] : ''; ?></td>
                    <td><?php echo isset($row['department']) ? $row['department'] : ''; ?></td>
                    <td><?php echo isset($row['request_type']) ? $row['request_type'] : ''; ?></td>
                    <td><?php echo isset($row['priority']) ? $row['priority'] : ''; ?></td>
                    <td><?php echo isset($row['status']) ? $row['status'] : ''; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>لا توجد طلبات مسندة إليك حاليًا.</p>
<?php endif; ?>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>