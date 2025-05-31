<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    $_SESSION['error'] = "You must log in first";
    header('location: admin_login.php');
    exit();
}

include("db.php"); // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบค่าของ status ที่ส่งมาจากฟอร์มค้นหา
$status_filter = '';
if (isset($_GET['status']) && $_GET['status'] !== '') {
    $status_filter = $_GET['status'];
}

// ดึงข้อมูลสินค้าจากฐานข้อมูลพร้อมกับฟิลเตอร์ตามสถานะ
$query = "SELECT * FROM products";
if (!empty($status_filter)) {
    $query .= " WHERE status = '" . $conn->real_escape_string($status_filter) . "'";
}
$result = $conn->query($query);

if (!$result) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// ถ้าหากมีการส่งค่าของ product_id มา ให้ดึงข้อมูลสินค้าที่ต้องการแก้ไข
$product_id = '';
$product = null;
if (isset($_GET['edit'])) {
    $product_id = intval($_GET['edit']); // Ensure the id is an integer

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('Product not found.');
    }

    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Game Account Store</title>
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
            padding: 15px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-form, .edit-form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
        }

        .search-form label, .edit-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .search-form select, .edit-form input, .edit-form textarea, .edit-form button {
            display: block;
            width: 100%;
            margin-bottom: 12px;
        }

        .search-form select, .edit-form select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .search-form button, .edit-form button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .search-form button:hover, .edit-form button:hover {
            background-color: #2980b9;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .product-table td {
            background-color: #fff;
        }

        .product-table a {
            text-decoration: none;
            color: #e74c3c;
        }

        .product-table a:hover {
            text-decoration: underline;
        }

        .edit-form input, .edit-form textarea {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .edit-form textarea {
            resize: vertical;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="add_product.php">Add Products</a></li>
            <li><a href="admin_orders.php">Orders</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Manage Products</h1>

        <!-- แสดงฟอร์มค้นหาเฉพาะเมื่อไม่อยู่ในโหมดแก้ไข -->
        <?php if (!$product_id): ?>
            <!-- ฟอร์มค้นหา -->
            <form method="GET" action="admin_products.php" class="search-form">
                <label for="status">Filter by status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="Ready for sale" <?php if ($status_filter == 'Ready for sale') echo 'selected'; ?>>Ready for sale</option>
                    <option value="Sold out" <?php if ($status_filter == 'Sold out') echo 'selected'; ?>>Sold out</option>
                </select>
                <button type="submit">Search</button>
            </form>
        <?php endif; ?>

        <!-- ตารางสินค้ -->
        <table class="product-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="admin_products.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- ฟอร์มแก้ไขสินค้า -->
        <?php if ($product_id && $product): ?>
            <h2>Edit Product</h2>
            <form method="post" action="edit_product_process.php?id=<?php echo $product_id; ?>" enctype="multipart/form-data" class="edit-form">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" placeholder="Product Name" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" placeholder="Price" required>
                
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Ready for sale" <?php if ($product['status'] == 'Ready for sale') echo 'selected'; ?>>Ready for sale</option>
                    <option value="Sold out" <?php if ($product['status'] == 'Sold out') echo 'selected'; ?>>Sold out</option>
                </select>
                
                <button type="submit" name="update_product">Update Product</button>
            </form>
        <?php endif; ?>
        </div>
    <style type="text/css">
        * {cursor: url(https://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), auto !important;}
    </style>
    <a href="https://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer">
        <img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" />
    </a>
</body>
</html>