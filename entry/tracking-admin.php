<?php
$page_title = "متابعة سير الطلبات";
include '../header.php';
include '../includes/db.php';

// التحقق من صلاحيات الأدمن
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../entry/login.php");
    exit();
}

// جلب الطلبات
$query = "SELECT r.id AS request_id, u.username AS employee_name, 
                 i.item_name, r.status, r.created_at 
          FROM requests r 
          LEFT JOIN users u ON r.user_id = u.id
          LEFT JOIN inventory i ON r.item_id = i.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>متابعة سير الطلبات</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <h1>مرحبًا، <?php echo htmlspecialchars($_SESSION['username']); ?> (مسؤول)</h1>
    <h2>جميع الطلبات:</h2>

    <table class="table-t">
        <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>اسم الموظف</th>
                <th>اسم القطعة</th>
                <th>الحالة</th>
                <th>تاريخ الطلب</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['request_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td class="
                        <?php 
                            echo ($row['status'] === 'قيد التنفيذ') ? 'status-pending' : 
                                 (($row['status'] === 'تم التوصيل') ? 'status-approved' : 
                                 (($row['status'] === 'ملغي') ? 'status-rejected' : 
                                 (($row['status'] === 'قيد التوزيع') ? 'status-distribution' : '')));
                        ?>">
                        <?php echo htmlspecialchars($row['status']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php include '../footer.php'; ?>
</body>
</html>