<?php
session_start();
include("db.php");

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
$product_id = isset($_POST['product_id']) ? trim($_POST['product_id']) : '';
$product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$price = isset($_POST['price']) ? trim($_POST['price']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$card_number = isset($_POST['card_number']) ? trim($_POST['card_number']) : '';
$expiry_date = isset($_POST['expiry_date']) ? trim($_POST['expiry_date']) : '';
$cvv = isset($_POST['cvv']) ? trim($_POST['cvv']) : '';
$username = $_SESSION['username'];

// ตรวจสอบค่าที่สำคัญ
if (empty($product_id) || empty($product_name) || empty($price) || empty($name) || empty($address) || empty($card_number) || empty($expiry_date) || empty($cvv)) {
    $_SESSION['error'] = "Missing required fields";
    header('Location: payment.php?product_id=' . urlencode($product_id) . '&product_name=' . urlencode($product_name) . '&price=' . urlencode($price));
    exit();
}

// เตรียมคำสั่ง INSERT สำหรับข้อมูลการสั่งซื้อ
$stmt = $conn->prepare("INSERT INTO orders (username, product_id, product_name, price, address, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("ssssssss", $username, $product_id, $product_name, $price, $address, $card_number, $expiry_date, $cvv);
    if ($stmt->execute()) {
        // เตรียมคำสั่ง UPDATE สำหรับการเปลี่ยนสถานะผลิตภัณฑ์
        $update_stmt = $conn->prepare("UPDATE products SET status = 'Sold out' WHERE id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("s", $product_id);
            if ($update_stmt->execute()) {
                $_SESSION['success'] = "Payment processed successfully and product marked as sold out";
                header('Location: status.php?status=success');
            } else {
                $_SESSION['error'] = "Payment processed, but failed to update product status: " . htmlspecialchars($conn->error);
                header('Location: payment.php?product_id=' . urlencode($product_id) . '&product_name=' . urlencode($product_name) . '&price=' . urlencode($price));
            }
            $update_stmt->close();
        } else {
            $_SESSION['error'] = "Failed to prepare update query: " . htmlspecialchars($conn->error);
            header('Location: payment.php?product_id=' . urlencode($product_id) . '&product_name=' . urlencode($product_name) . '&price=' . urlencode($price));
        }
    } else {
        $_SESSION['error'] = "Failed to process payment: " . htmlspecialchars($stmt->error);
        header('Location: payment.php?product_id=' . urlencode($product_id) . '&product_name=' . urlencode($product_name) . '&price=' . urlencode($price));
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Failed to prepare insert query: " . htmlspecialchars($conn->error);
    header('Location: payment.php?product_id=' . urlencode($product_id) . '&product_name=' . urlencode($product_name) . '&price=' . urlencode($price));
}
$conn->close();
exit();
?>
