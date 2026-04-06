<?php 
// الصفحة الرئيسية للمشروع
include 'header.php'; 
include 'includes/db.php'; 

// التحقق من الجلسة
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: entry/login.php");
    exit();
}

// تخصيص الصفحة بناءً على الدور
$role = $_SESSION['role'];
$welcome_message = ""; // رسالة ترحيب افتراضية

switch ($role) {
    case 'admin':
        $welcome_message = "";
        break;

    case 'employee':
        $welcome_message = "";
        break;

    case 'technician':
        $welcome_message = "";
        break;

    case 'distributor':
        $welcome_message = "";
        break;

    default:
        // إعادة التوجيه إذا كان الدور غير معروف
        header("Location: entry/login.php");
        exit();
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحول الرقمي</title>
    <link rel="icon" href="icon/icon2.png"/>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- القسم الأول (الترحيب + العنوان) -->
    <section class="hero-section" id="hero-section">
        <div class="overlay">
        <div class="text">    
        <h1><?php echo $welcome_message; ?></h1>   
        <h2>إدارة المخزون</h2>
        <p>مرحبًا بكم في نظام إدارة المخزون الذي يساعد في تسهيل إدارة المخزون والحفاظ على الكميات المخزنة بكفاءة عالية.</p>
        <a href="#" class="btn"> .. </a>
        </div>
</div>
    </section>

    <!-- قسم الخدمات -->
    <section class="services-section" id="ser-section">
        <h2> الخدمات</h2>
        <p>نسعى لتوفير تجربة سهلة لإدارة المخزون من خلال الخدمات التالية:</p>
        
        <div class="services">
            <div class="service">
                <img src="image/plus.png" alt="إضافة المخزون">
                <p>إضافة المخزون</p>
            </div>
            <div class="service">
                <img src="image/track.png" alt="تتبع الطلبات ">
                <p>تتبع الطلبات</p>
            </div>
            <div class="service">
                <img src="image/90.png" alt="توزيع الطلبات">
                <p>توزيع الطلبات</p>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>

</body>
</html>