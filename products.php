<?php
session_start();
include("db.php");

$query = "SELECT * FROM products";
$results = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Game Account Store</title>
    <link rel="stylesheet" href="style.css">
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
    

        .content h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product {
            border: 1px solid #b0c4de;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: calc(33.333% - 20px); /* 3 items per row with gap */
            max-width: 300px;
            position: relative;
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            max-height: 200px;
            object-fit: cover;
            transition: filter 0.3s;
        }

        .product.sold-out img {
            filter: grayscale(100%);
        }

        .product h3 {
            margin: 10px 0;
            color: #333;
        }

        .product p {
            margin: 5px 0;
        }

        .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #007bff;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .btn:active {
        background-color: #004085;
        transform: scale(0.95);
    }

    .btn[disabled] {
        background-color: #999;
        cursor: not-allowed;
        box-shadow: none;
    }
</style>
</head>
<body>
    <div class="header">
        <h2>Game Account Store</h2>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="payment.php">Payment</a></li>
                <li><a href="form.php">Evaluation form</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <div class="content">
        <h2>ID Rov
        </h2>
        <div class="products-container">
            <?php while ($row = mysqli_fetch_assoc($results)): ?>
                <div class="product <?php echo htmlspecialchars($row['status']) == 'Sold out' ? 'sold-out' : ''; ?>">
                    <font color="green">&#187;</font><b><?php echo htmlspecialchars($row['name']); ?></b><br>
                    <font color="green"></font> <?php echo htmlspecialchars($row['description']); ?><br>
                    <font color="green">&#128176;</font> ราคา: <span class="underline"><?php echo htmlspecialchars($row['price']); ?> บาท</span><br>
                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <div>Status: <?php echo htmlspecialchars($row['status']); ?></div>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <form method="get" action="payment.php">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
                            <button type="submit" class="btn" 
                                    <?php echo htmlspecialchars($row['status']) == 'Sold out' ? 'disabled' : ''; ?>>
                                <?php echo htmlspecialchars($row['status']) == 'Ready for sale' ? 'สั่งซื้อ' : 'Sold Out'; ?>
                            </button>
                        </form>
                    <?php else: ?>
                        <p><a href="login.php" class="btn">Login to Buy</a></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <style type="text/css">
        * {cursor: url(https://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), auto !important;}
    </style>
    <a href="https://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer">
        <img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" />
    </a>
</body>
</html>
