<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Game Account Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('images/2020.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9); /* Light white background with opacity */
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #34495e;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container .input-group {
            margin-bottom: 15px;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            color: #34495e;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container button {
            padding: 10px;
            border: none;
            background: #e74c3c;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s, transform 0.3s;
        }

        .login-container button:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .login-container button:active {
            background-color: #a93226;
            transform: scale(0.95);
        }

        .login-container .error {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .register-link {
            margin-top: 20px;
        }

        .register-link a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
        
        .cursor-custom {
            cursor: url(https://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), auto !important;
        }

        .cursor-link {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 100;
        }
    </style>
</head>
<body class="cursor-custom">
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif ?>
        <form method="post" action="admin_login_process.php">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="login_admin">Login</button>
            </div>
        </form>
       
        </div>
        </style>
    <a href="https://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer">
        <img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" />
    </a>
</body>
</html>