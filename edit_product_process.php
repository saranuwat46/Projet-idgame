<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    $_SESSION['error'] = "You must log in first";
    header('location: admin_login.php');
    exit();
}

include("db.php"); // เชื่อมต่อกับฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $image_path = 'images/' . $image_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            // Update query with new image path
            $query = "UPDATE products SET name = ?, description = ?, price = ?, status = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssdsdi', $name, $description, $price, $status, $image_path, $product_id);
        } else {
            die('Image upload failed.');
        }
    } else {
        // No new image, just update other fields
        $query = "UPDATE products SET name = ?, description = ?, price = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssdsi', $name, $description, $price, $status, $product_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Product updated successfully";
        header('Location: admin_products.php');
    } else {
        die('Update failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
} else {
    die('Invalid request.');
}
?>
