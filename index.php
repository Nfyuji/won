<?php
include "include/db.php"; // الاتصال بقاعدة البيانات

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// متغير لتخزين اسم الفائز في حالة وجوده
$winner_name = "";
$winner_email = "";

// اختيار فائز عشوائي من المستخدمين عند الضغط على الزر
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_winner'])) {
    $sql = "SELECT * FROM users ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // إخراج بيانات الفائز
        $row = $result->fetch_assoc();
        $winner_name = $row['first_name'] . " " . $row['last_name'];
        $winner_email = $row['email'];
    } else {
        $winner_name = "لا يوجد مستخدمين";
        $winner_email = "";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>موقع تسجيل المستخدم</title>
    <style>
        /* تنسيق العناصر لتكون في المنتصف */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .close {
            cursor: pointer;
            float: left;
            font-size: 20px;
        }
        #circularLoader {
            display: block;
            margin: 0 auto;
        }
        .winner {
            display: none;
            margin-top: 20px;
            font-size: 24px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="user-image.jpg" alt="صورة المستخدم" class="user-image">
            <h1>اربح مع نور</h1>
            <p>باقي على فتح التسجيل:</p>
            <div class="timer" id="countdown" style="color: blue;"></div>
        </header>
        <main>
            <h2>للدخول في السحب اتبع ما يلي:</h2>
            <ul>
                <li>املأ البيانات بمعلومات صحيحة</li>
                <li>تأكد من صحة بريدك الإلكتروني لاستلام الردود</li>
            </ul>
            <form action="include/submit.php" method="POST">
                <label for="first-name">الاسم الأول:</label>
                <input type="text" id="first-name" name="first_name" required>

                <label for="last-name">الاسم الأخير:</label>
                <input type="text" id="last-name" name="last_name" required>

                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" required>

                <button type="submit">إرسال المعلومات</button>
            </form>

            <!-- زر لاختيار الفائز -->
            <form method="POST">
                <button type="submit" name="select_winner" class="btn">اختيار الفائز</button>
            </form>

            <!-- عرض اسم الفائز فقط عند الضغط على الزر -->
            <?php if ($winner_name != ""): ?>
                <div class="winner">
                    <h3>الفائز هو: <?php echo $winner_name; ?></h3>
                    <p>البريد الإلكتروني: <?php echo $winner_email; ?></p>
                </div>
            <?php endif; ?>
        </main>
        <?php include "include/footer.php"; ?>
        <script>
// تحديد الوقت الذي نريد العد التنازلي إليه (مثال: 13 يوم 11 ساعة 41 دقيقة 51 ثانية)
var targetDate = new Date();
targetDate.setDate(targetDate.getDate() + 13);  // إضافة 13 يوم
targetDate.setHours(targetDate.getHours() + 11); // إضافة 11 ساعة
targetDate.setMinutes(targetDate.getMinutes() + 41); // إضافة 41 دقيقة
targetDate.setSeconds(targetDate.getSeconds() + 51); // إضافة 51 ثانية

// دالة لحساب الوقت المتبقي وتحديث العد التنازلي
function updateCountdown() {
    var now = new Date(); // الحصول على الوقت الحالي
    var timeLeft = targetDate - now; // الفرق بين الوقت المحدد والوقت الحالي

    // إذا انتهى العد التنازلي
    if (timeLeft <= 0) {
        document.getElementById("countdown").innerHTML = "انتهى الوقت!";
        clearInterval(countdownInterval); // إيقاف التحديث بعد الانتهاء
    } else {
        var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24)); // حساب الأيام
        var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // حساب الساعات
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)); // حساب الدقائق
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000); // حساب الثواني

        // عرض الوقت المتبقي
        document.getElementById("countdown").innerHTML = days + " يوم " + hours + " ساعة " + minutes + " دقيقة " + seconds + " ثانية";
    }
}

// تحديث العد التنازلي كل ثانية
var countdownInterval = setInterval(updateCountdown, 1000);

// عرض العد التنازلي فور تحميل الصفحة
updateCountdown();
</script>
</body>
</html>
