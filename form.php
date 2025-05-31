<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("db.php");

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die('Database connection failed');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
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

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fafafa;
            font-size: 1em;
            color: #555;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group input[type="submit"] {
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

        .form-group input:focus, .form-group textarea:focus {
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
        <h2>Website Evaluation Form</h2>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="payment.php">Payment</a></li>
                <?php if (isset($_SESSION['username'])) : ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <div class="content">
        <form action="submit_evaluation.php" method="post">
            <div class="form-group">
                <label for="user_name">Name:</label>
                <input type="text" id="user_name" name="user_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="rating">How would you rate our website (1-5)?</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
            </div>

            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments" rows="4" cols="50"></textarea>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

    <script>
        document.querySelector('form').onsubmit = function(event) {
            event.preventDefault(); // ป้องกันการ submit form ทันที
            alert("Thank you for your feedback!");
            window.location.href = 'index.php'; // เปลี่ยนหน้าไปยัง index.php
        };
    </script>

</body>
</html>
