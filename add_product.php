<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    $_SESSION['error'] = "You must log in first";
    header('location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Game Account Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f7f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #2c3e50;
            color: #fff;
            padding: 10px 20px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
        }

        .form-container h1 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            padding: 10px;
            border: none;
            background-color: #e74c3c;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .form-container button:hover {
            background-color: #c0392b;
        }

        .form-container .error, .form-container .success {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: #fff;
        }

        .form-container .error {
            background-color: #e74c3c;
        }

        .form-container .success {
            background-color: #2ecc71;
        }

        a.cursor-link {
            display: block;
            position: absolute;
            top: 0;
            right: 0;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_products.php">Manage Products</a></li>
            <li><a href="admin_orders.php">Orders</a></li>
            <?php if (isset($_SESSION['admin_username'])) : ?>
                <li><a href="admin_logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="form-container">
        <h1>Add New Product</h1>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif ?>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="success">
                <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif ?>
        <form method="post" action="add_product_process.php" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description" rows="4"></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="file" name="image" accept="image/*">
            <select name="status" id="status">
                <option value="Ready for sale" selected>Ready for sale</option>
            </select>
            <button type="submit" name="add_product">Add Product</button>
        </form>
    </div>
    <style type="text/css">
        * {cursor: url(https://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), auto !important;}
    </style>
    <a href="https://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer">
        <img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" />
    </a>
</body>
</html>
