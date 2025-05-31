<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status - Game Account Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f4f7f9, #e0e4e8);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 500px;
        }

        .container h2 {
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #333;
            font-weight: 700;
        }

        .container p {
            font-size: 1.1em;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .success {
            color: #1abc9c;
            font-weight: 600;
        }

        .error {
            color: #e74c3c;
            font-weight: 600;
        }

        .container a {
            display: inline-block;
            padding: 12px 24px;
            background: #1abc9c;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.3s;
        }

        .container a:hover {
            background: #16a085;
            transform: scale(1.05);
        }

        .container a:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Status</h2>
        <?php
        if (isset($_SESSION['success'])) {
            echo "<p class='success'>".$_SESSION['success']."</p>";
            unset($_SESSION['success']);
        } elseif (isset($_SESSION['error'])) {
            echo "<p class='error'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <a href="index.php">Go to Home</a>
    </div>
</body>
</html>
