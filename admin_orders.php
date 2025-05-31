<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    $_SESSION['error'] = "You must log in first";
    header('location: admin_login.php');
    exit();
}

include("db.php"); // เชื่อมต่อกับฐานข้อมูล

// ดึงข้อมูลคำสั่งซื้อล่าสุดจากฐานข้อมูล
$query = "SELECT * FROM orders";
$result = $conn->query($query);

if (!$result) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// ถ้าหากมีการส่งค่าของ order_id มา ให้ดึงข้อมูลคำสั่งซื้อที่ต้องการแก้ไข
$order_id = '';
$order = null;
if (isset($_GET['edit'])) {
    $order_id = intval($_GET['edit']); // Ensure the id is an integer

    $query = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('Order not found.');
    }

    $order = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Game Account Store</title>
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

        .edit-form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
        }

        .edit-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .edit-form input, .edit-form textarea, .edit-form button {
            display: block;
            width: 100%;
            margin-bottom: 12px;
        }

        .edit-form input, .edit-form textarea {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .edit-form textarea {
            resize: vertical;
        }

        .edit-form button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #2980b9;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-table th, .order-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .order-table th {
            background-color: #f2f2f2;
        }

        .order-table td {
            background-color: #fff;
        }

        .order-table a {
            text-decoration: none;
            color: #e74c3c;
        }

        .order-table a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_products.php">Manage Products</a></li>
            <li><a href="add_product.php">Add Products</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Manage Orders</h1>

        <!-- ตารางคำสั่งซื้อ -->
        <table class="order-table">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Name</th>
                <th>Address</th>
                <th>Card Number</th>
                <th>Expiry Date</th>
                <th>CVV</th>
                <th>Order Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['card_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['cvv']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td>
                        <a href="admin_orders.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- ฟอร์มแก้ไขคำสั่งซื้อ -->
        <?php if ($order_id && $order): ?>
            <h2>Edit Order</h2>
            <form method="post" action="edit_order_process.php?id=<?php echo $order_id; ?>" class="edit-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($order['username']); ?>" placeholder="Username" required>
                
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($order['product_name']); ?>" placeholder="Product Name" required>
                
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($order['price']); ?>" placeholder="Price" required>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($order['name']); ?>" placeholder="Name" required>
                
                <label for="address">Email:</label>
                <textarea id="address" name="address" rows="4"><?php echo htmlspecialchars($order['address']); ?></textarea>
                
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" value="<?php echo htmlspecialchars($order['card_number']); ?>" placeholder="Card Number" required>
                
                <label for="expiry_date">Expiry Date:</label>
                <input type="text" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($order['expiry_date']); ?>" placeholder="Expiry Date" required>
                
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" value="<?php echo htmlspecialchars($order['cvv']); ?>" placeholder="CVV" required>
                
                <button type="submit" name="update_order">Update Order</button>
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

