<?php
session_start();
include("db.php");

$errors = array();

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($conn, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php'); // เปลี่ยนเส้นทางเป็นหน้าแรกหลังจากล็อกอินสำเร็จ
        } else {
            array_push($errors, "Wrong Username or Password");
            $_SESSION['error'] = "Wrong Username or Password!";
            header("location: login.php");
        }
    } else {
        $_SESSION['error'] = "Username & Password is required";
        header("location: login.php");
    }
}
?>

