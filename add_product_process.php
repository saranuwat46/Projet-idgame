<?php
session_start();
include("db.php");

if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Handle image upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    if (empty($name) || empty($price)) {
        $_SESSION['error'] = "Name and Price are required.";
        header('location: add_product.php');
        exit();
    }

    $query = "INSERT INTO products (name, description, price, image, status) VALUES ('$name', '$description', '$price', '$image', '$status')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Product added successfully.";
    } else {
        $_SESSION['error'] = "Error adding product: " . mysqli_error($conn);
    }

    header('location: add_product.php');
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header('location: add_product.php');
    exit();
}
?>
