<?php
include "db.php";
$winner_name = "";
$winner_email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM users ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $winner_name = $row['first_name'] . " " . $row['last_name'];
        $winner_email = $row['email'];
    } else {
        $winner_name = "لا يوجد مستخدمين";
        $winner_email = "";
    }
}