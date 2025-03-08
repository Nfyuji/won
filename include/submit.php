<?php
include "db.php"; // الاتصال بقاعدة البيانات

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// متغيرات لتخزين البيانات من النموذج
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

// التحقق إذا كان البريد الإلكتروني موجود بالفعل في قاعدة البيانات
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // إذا كان البريد الإلكتروني موجودًا مسبقًا، نعرض رسالة للمستخدم
    echo "البريد الإلكتروني هذا مسجل بالفعل!";
} else {
    // إذا لم يكن البريد الإلكتروني موجودًا، نقوم بإدخال البيانات
    $sql = "INSERT INTO users (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "تم إدخال البيانات بنجاح!";
    } else {
        echo "حدث خطأ: " . $conn->error;
    }
}

$conn->close();
?>
