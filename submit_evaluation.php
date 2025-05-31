<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("db.php");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die('Database connection failed');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // ตรวจสอบว่าค่า rating อยู่ในช่วงที่ถูกต้อง
    if ($rating < 1 || $rating > 5) {
        die('Rating must be between 1 and 5');
    }

    // SQL สำหรับการบันทึกข้อมูลการประเมิน
    $sql = "INSERT INTO evaluations (user_name, email, rating, comments) 
            VALUES ('$user_name', '$email', '$rating', '$comments')";

    if (mysqli_query($conn, $sql)) {
        echo 'Thank you for your feedback!';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>
