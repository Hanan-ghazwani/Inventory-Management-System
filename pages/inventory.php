<?php
$page_title = "  عرض المخزون: نظام إدارة المخزون";
// تضمين ملفات الاتصال والهيدر
include '../header.php';
include '../includes/db.php';

// التحقق من صلاحيات المستخدم
if ($_SESSION['role'] != 'admin') {
    header("location: ../entry/login.php");
    exit();
}

// تعريف متغير البحث
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM inventory WHERE item_name LIKE '%$search_query%'";
} else {
    $query = "SELECT * FROM inventory";
}

// استعلام جلب البيانات
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <h1>قائمة المخزون</h1>

  <!-- نموذج البحث -->
<form method="GET" action="inventory.php" style="margin-bottom: 10px; text-align: center;">
    <label for="search" style="font-weight: bold; margin-right: 5px;">بحث:</label>
    <input 
        type="text" 
        id="search" 
        name="search" 
        placeholder="ابحث عن قطعة..." 
        value="<?php echo htmlspecialchars($search_query); ?>" 
        style="
            padding: 8px; 
            width: 250px; 
            border: 1px solid #ddd; 
            border-radius: 4px;"
    >
    <button 
        type="submit" 
        style="
            padding: 8px 20px; 
            background-color: var(--colors-primary-sa-flag-600-primary); 
            color: #fff; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            display: inline-block; 
            width: auto;"
    >
        بحث
    </button>
</form>

    <!-- جدول المخزون -->
    <table class="table-t">
        <thead>
            <tr>
                <th>رقم القطعة</th>
                <th>اسم القطعة</th>
                <th>الكمية</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr style="background-color: <?php echo ($row['quantity'] == 300) ? '#f8d7da' : (($row['quantity'] < 100) ? '#fff3cd' : '#d4edda'); ?>;">
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">لا توجد نتائج مطابقة</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php include '../footer.php'; ?>
</body>
</html>


