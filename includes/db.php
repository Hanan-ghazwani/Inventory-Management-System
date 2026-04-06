<?php
//ملف مسؤول عن الاتصال بقاعدة البيانات ويسهل تنفيذ استعلامات قواعد البيانات مثل الاضافة او العرض او الحذف

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'inventory_system';


$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn){
    die("فشل الاتصال بقاعدة البياانات:" . mysqli_connect_error());
} else {
   // echo "تم الاتصال بنجاح";
}

// تفعيل تقارير الأخطاء
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


?>