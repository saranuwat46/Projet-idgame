<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Game Account Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('images/14.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
        }

        .login-container h2 {
            margin: 0 0 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .register-link {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .logo {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h2>Game Account Store</h2>
        </div>
        <h2>Login</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif ?>
        <form method="post" action="login_process.php">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
        </form>
        <p class="register-link">
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </div>
    <style type="text/css">
        * {cursor: url(https://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), auto !important;}
    </style>
    <a href="https://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer">
        <img src="https://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" />
    </a>
</body>
</html>