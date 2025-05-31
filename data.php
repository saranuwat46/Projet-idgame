<?php
include("db.php");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die('Database connection failed');
}

// ดึงข้อมูลยอดขายจากตาราง orders
$query = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(price) AS total_sales FROM orders GROUP BY month ORDER BY month DESC";
$result = $conn->query($query);

if (!$result) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// เตรียมข้อมูลสำหรับกราฟ
$sales_data = array();
while ($row = $result->fetch_assoc()) {
    $sales_data[] = $row;
}

echo json_encode($sales_data);

$conn->close();
?>
