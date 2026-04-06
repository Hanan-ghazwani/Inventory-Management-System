<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'technician', 'distributor', 'employee'])) {
    header("Location: ../entry/login.php");
    exit();
}

$page_title = "  توزيع الطلبات";
include '../header.php';
include '../includes/db.php';

$success_message = '';
$error_message = '';

// معالجة طلب التوزيع
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = intval($_POST['request_id']);
    $technician_id = intval($_POST['technician_id']);

    if ($request_id > 0 && $technician_id > 0) {
        // تحديث الطلب وإسناده إلى الفني
        $assign_query = "UPDATE requests SET technician_id = ?, status = 'قيد التنفيذ' WHERE id = ?";
        $stmt = $conn->prepare($assign_query);
        $stmt->bind_param("ii", $technician_id, $request_id);

        if ($stmt->execute()) {
            $success_message = 'تم توزيع الطلب بنجاح!';
        } else {
            $error_message = 'حدث خطأ أثناء توزيع الطلب.';
        }
        $stmt->close();
    } else {
        $error_message = 'يرجى اختيار طلب وفني صالحين.';
    }
}

// استعلام لجلب الطلبات التي حالتها "قيد التوزيع"
$query = "SELECT requests.id, requests.description, requests.department, requests.request_type, 
          requests.priority, users.full_name 
          FROM requests 
          JOIN users ON requests.user_id = users.id
          WHERE requests.status = 'قيد التوزيع'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css"> <!-- تأكد من مسار CSS -->
</head>
<body>
<div class="container">
    <h1>توزيع الطلبات</h1>

    <!-- عرض رسائل النجاح أو الخطأ -->
    <?php if (!empty($success_message)): ?>
        <div class="notification success"><?php echo $success_message; ?></div>
    <?php elseif (!empty($error_message)): ?>
        <div class="notification error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <table class="assign-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الوصف</th>
                    <th>القسم</th>
                    <th>نوع الطلب</th>
                    <th>الأولوية</th>
                    <th>مرسل الطلب</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td><?php echo htmlspecialchars($row['request_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['priority']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td>
                            <form action="assign_request.php" method="POST">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">

                                <select name="technician_id" required>
                                    <option value="">اختر الفني</option>
                                    <?php
                                    // استعلام لجلب الفنيين
                                    $tech_query = "SELECT id, full_name FROM users WHERE role = 'technician'";
                                    $tech_result = $conn->query($tech_query);

                                    if ($tech_result->num_rows > 0) {
                                        while ($tech = $tech_result->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($tech['id']) . "'>" . htmlspecialchars($tech['full_name']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>لا يوجد فنيين</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit">توزيع</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>لا توجد طلبات بحاجة إلى التوزيع.</p>
    <?php endif; ?>
</div>

<?php include '../footer.php'; ?>
</body>
</html>