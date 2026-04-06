<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// التحقق من الجلسة
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'technician', 'distributor', 'employee'])) {
    header("Location: ../entry/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'التحول الرقمي'; ?></title>
    <link rel="stylesheet" href="styles/style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="/Coop/scripts/script.js" defer></script>
</head>
<body>

<!-- الشريط الثانوي -->
<div class="secondary-bar">
    <div class="right-info">
        <span><i class="fas fa-map-marker-alt"></i> Al-jubail</span>
        <span><i class="fas fa-clock"></i> <span id="current-time">2:30 AM </span></span>
        <span><i class="fas fa-calendar-alt"></i> <span id="current-date">Jan 21, 2025</span></span>
        <span><i class="fas fa-cloud"></i> Cloudy</span>
    </div>
    <div class="left-icons">
        <button id="zoom-in" class="no-loader"><i class="fas fa-search-plus"></i></button>
        <button id="zoom-out" class="no-loader"><i class="fas fa-search-minus"></i></button>
    </div>
</div>

<!-- الهيدر  -->
<header>
    <div class="logo">
        <img src="/Coop/image/supply-chain.png" alt="Platform Logo" style="width: 50px; height: auto; margin-right: 40px">
    </div>
    <nav class="navbar">

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="/Coop/index.php">الرئيسية</a>
            <a href="/Coop/entry/profile.php">حسابي</a>
            <a href="/Coop/pages/inventory.php">عرض المخزون</a>
            <a href="/Coop/entry/tracking-admin.php">متابعة الطلبات</a>
            
            <?php elseif ($_SESSION['role'] == 'technician'): ?>
            <a href="/Coop/index.php">الرئيسية</a>
            <a href="/Coop/entry/profile.php">حسابي</a>
           <!--- <a href="/Coop/pages/technic_requests.php">التحكم بالطلبات</a>--->
            <a href="/Coop/pages/requests.php"> الطلبات المسنده</a>

            <?php elseif ($_SESSION['role'] == 'distributor'): ?>
                <a href="/Coop/index.php">الرئيسية</a>
            <a href="/Coop/entry/profile.php">حسابي</a>
                <a href="/Coop/pages/assign_request.php">توزيع الطلبات</a>
             <!---   <a href="/Coop/pages/requests.php"> ت</a> --->

        <?php elseif ($_SESSION['role'] == 'employee'): ?>
            <a href="/Coop/index.php">الرئيسية</a>
            <a href="/Coop/entry/profile.php">حسابي</a>
            <a href="/Coop/pages/new_request.php">إرسال طلب جديد</a>
            <a href="/Coop/pages/requests.php"> طلباتي</a>

        <?php endif; ?>

    </nav>
    <div class="extra-options">
        <a href="#" class="language"><i class="fas fa-language"></i> AR</a> |
        <a href="/Coop/entry/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>  logout</a>
    </div>
</header>

<!-- هنا ينتهي الهيدر -->

<!-- شاشة التحميل -->
<div class="loader-container" style="display: none;">
    <div class="spinner"></div>
</div>

</body>
</html>