<?php
session_start();
include("db.php"); // รวมไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username)) {
        $_SESSION['error'] = "Username is required";
        header('location: admin_login.php');
        exit();
    }
    if (empty($password)) {
        $_SESSION['error'] = "Password is required";
        header('location: admin_login.php');
        exit();
    }

    // Query to select the admin
    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1) {
        $admin = mysqli_fetch_assoc($results);
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['success'] = "You are now logged in";
        header('location: admin_dashboard.php');
    } else {
        $_SESSION['error'] = "Invalid Username or Password. Please try again.";
        header("location: admin_login.php");
    }

    // ปิดการเชื่อมต่อหลังจากทำงานเสร็จ
    mysqli_close($conn);
} else {
    $_SESSION['error'] = "Invalid request.";
    header("location: admin_login.php");
}
?>
