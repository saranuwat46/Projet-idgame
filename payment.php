<?php
session_start();
include("db.php");

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Game Account Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        /* CSS Style */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            background: #f4f7f9;
            color: #333;
        }

        .header {
            width: 100%;
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .header h2 {
            margin: 0;
            font-size: 2em;
        }

        .header nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin: 15px 0 0;
        }

        .header nav ul li {
            margin: 0 15px;
        }

        .header nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .header nav ul li a:hover {
            color: #1abc9c;
        }

        .content {
            width: 80%;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fafafa;
            font-size: 1em;
            color: #555;
        }

        .form-group input[type="submit"] {
            width: 100%;
            background: #1abc9c;
            color: white;
            border: none;
            cursor: pointer;
            padding: 15px;
            font-size: 1.2em;
            transition: background-color 0.3s;
        }

        .form-group input[type="submit"]:hover {
            background: #16a085;
        }

        .form-group input:focus {
            border-color: #1abc9c;
            outline: none;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Game Account Store</h2>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="form.php">Evaluation form</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <div class="content">
        <h2>Payment Details</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="process_payment.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

            <div class="form-group">
                <label for="name">ID:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Email:</label>
                <input type="email" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="card_number">Credit Card Number:</label>
                <input type="number" id="card_number" name="card_number" pattern="\d{16}" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date (MM/YY):</label>
                <input type="number" id="expiry_date" name="expiry_date" pattern="\d{2}/\d{2}" required>
            </div>

            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="number" id="cvv" name="cvv" pattern="\d{3}" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit Payment">
            </div>
        </form>
    </div>
</body>
</html>
