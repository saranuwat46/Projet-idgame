<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    $_SESSION['error'] = "You must log in first";
    header('location: admin_login.php');
    exit();
}

include("db.php"); // เชื่อมต่อกับฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_GET['id']); // ตรวจสอบว่า id ถูกต้องและเป็นจำนวนเต็ม

    // ตรวจสอบค่าที่ได้รับจากฟอร์ม
    $username = $conn->real_escape_string($_POST['username']);
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $price = $conn->real_escape_string($_POST['price']);
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $card_number = $conn->real_escape_string($_POST['card_number']);
    $expiry_date = $conn->real_escape_string($_POST['expiry_date']);
    $cvv = $conn->real_escape_string($_POST['cvv']);

    // ตรวจสอบว่าข้อมูลทั้งหมดได้รับการส่งมาหรือไม่
    if (empty($username) || empty($product_name) || empty($price) || empty($name) || empty($address) || empty($card_number) || empty($expiry_date) || empty($cvv)) {
        die('All fields are required.');
    }

    // อัพเดตคำสั่งซื้อในฐานข้อมูล
    $query = "UPDATE orders SET 
                username = ?, 
                product_name = ?, 
                price = ?, 
                name = ?, 
                address = ?, 
                card_number = ?, 
                expiry_date = ?, 
                cvv = ? 
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('ssdsssssi', $username, $product_name, $price, $name, $address, $card_number, $expiry_date, $cvv, $order_id);

    if ($stmt->execute()) {
        header('Location: admin_orders.php');
        exit();
    } else {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
} else {
    die('Invalid request method.');
}
