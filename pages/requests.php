<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'technician', 'distributor', 'employee'])) {
    header("Location: ../entry/login.php");
    exit();
}

$page_title = "متابعة الطلبات: نظام إدارة المخزون";
include '../header.php';
include '../includes/db.php';

// تحديد دور المستخدم
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// استعلام الطلبات بناءً على الدور
if ($user_role === 'admin') {
    $query = "SELECT r.*, u.full_name AS employee_name, t.full_name AS technician_name 
              FROM requests r
              LEFT JOIN users u ON r.user_id = u.id
              LEFT JOIN users t ON r.technician_id = t.id";
} elseif ($user_role === 'technician') {
    $query = "SELECT r.*, u.full_name AS employee_name 
              FROM requests r
              LEFT JOIN users u ON r.user_id = u.id
              WHERE r.technician_id = '$user_id'";
} elseif ($user_role === 'distributor') {
    $query = "SELECT r.*, u.full_name AS employee_name 
              FROM requests r
              LEFT JOIN users u ON r.user_id = u.id
              WHERE r.status = 'قيد التوزيع'";
} elseif ($user_role === 'employee') {
    $query = "SELECT * FROM requests WHERE user_id = '$user_id'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <h1>متابعة الطلبات</h1>

    <table>
        <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>الوصف</th>
                <th>نوع الطلب</th>
                <th>الأولوية</th>
                <th>القسم</th>
                <th>الحالة</th>
                <th>التاريخ</th>
                <?php if ($user_role === 'admin' || $user_role === 'distributor'): ?>
                    <th>مرسل الطلب</th>
                <?php endif; ?>
                <?php if ($user_role === 'admin' || $user_role === 'technician' || $user_role === 'distributor'): ?>
                    <th>الإجراء</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['request_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['priority']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>

                    <!-- تعيين كلاس الحالة بحيث يتم تطبيق الألوان من CSS -->
                    <td class="
                        <?php
                            switch ($row['status']) {
                                case 'قيد التنفيذ': echo 'status-pending'; break;
                                case 'تم التوصيل': echo 'status-approved'; break;
                                case 'ملغي': echo 'status-rejected'; break;
                                case 'قيد التوزيع': echo 'status-distribution'; break;
                                default: echo ''; 
                            }
                        ?>
                    ">
                        <?php echo htmlspecialchars($row['status']); ?>
                    </td>

                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>

                    <?php if ($user_role === 'admin' || $user_role === 'distributor'): ?>
                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                    <?php endif; ?>

                    <?php if ($user_role === 'admin' || $user_role === 'technician'): ?>
                        <td>
                            <a href="update_request.php?id=<?php echo $row['id']; ?>">تحديث</a>
                        </td>
                    <?php elseif ($user_role === 'distributor'): ?>
                        <td>
<form action="assign_request.php" method="POST">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <select name="technician_id" required>
                                    <option value="">اختر الفني</option>
                                    <?php
                                    $tech_query = "SELECT id, full_name FROM users WHERE role = 'technician'";
                                    $tech_result = mysqli_query($conn, $tech_query);
                                    while ($tech = mysqli_fetch_assoc($tech_result)) {
                                        echo "<option value='" . htmlspecialchars($tech['id']) . "'>" . htmlspecialchars($tech['full_name']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit">توزيع</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php include '../footer.php'; ?>
</body>
</html>