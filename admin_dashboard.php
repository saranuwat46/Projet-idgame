<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    $_SESSION['error'] = "You must log in first";
    header('location: admin_login.php');
    exit();
}

include("db.php"); // เชื่อมต่อกับฐานข้อมูล

// ดึงข้อมูลยอดขายจากฐานข้อมูล
$query = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS month, SUM(price) AS total_sales FROM orders GROUP BY month ORDER BY month DESC";
$result = $conn->query($query);

if (!$result) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// เตรียมข้อมูลสำหรับกราฟ
$sales_data = array();
while ($row = $result->fetch_assoc()) {
    $sales_data[] = $row;
}

// ดึงข้อมูลการประเมินจากฐานข้อมูล
$feedback_query = "SELECT DATE_FORMAT(submit_time, '%Y-%m') AS month, AVG(rating) AS average_rating, GROUP_CONCAT(comments SEPARATOR '; ') AS comments_summary FROM evaluations GROUP BY month ORDER BY month DESC";
$feedback_result = $conn->query($feedback_query);

if (!$feedback_result) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// เตรียมข้อมูลสำหรับการแสดงเป็นข้อความ
$feedback_data = array();
while ($row = $feedback_result->fetch_assoc()) {
    $feedback_data[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Game Account Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f7f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: relative;
        }

        .header h1 {
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

        .header .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: right;
        }

        .header .user-info p {
            margin: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container {
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        canvas {
            max-width: 100%;
            height: auto;
        }

        .cursor-custom {
            cursor: url(https://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), auto !important;
        }

        .feedback-summary {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="cursor-custom">
    <div class="header">
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="add_product.php">Add Products</a></li>
                <li><a href="admin_products.php">Manage Products</a></li>
                <li><a href="admin_orders.php">Orders</a></li>
                <?php if (isset($_SESSION['admin_username'])) : ?>
                    <li><a href="admin_logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="user-info">
            <p>Hello, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
            <p>Email: <?php echo htmlspecialchars($_SESSION['admin_email']); ?></p>
        </div>
    </div>
    <div class="container">
        <h2>Monthly Sales Chart</h2>
        <canvas id="salesChart"></canvas>
    </div>

    <div class="container">
        <h2>Monthly Feedback Summary</h2>
        <?php foreach ($feedback_data as $data): ?>
            <div class="feedback-summary">
                <h3><?php echo htmlspecialchars($data['month']); ?></h3>
                <p><strong>Average Rating:</strong> <?php echo number_format($data['average_rating'], 1); ?></p>
                <p><strong>Comments:</strong> <?php echo htmlspecialchars($data['comments_summary']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        async function fetchSalesData() {
            const salesData = <?php echo json_encode($sales_data); ?>;
            return salesData;
        }

        async function createCharts() {
            const salesData = await fetchSalesData();

            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesData.map(item => item.month),
                    datasets: [{
                        label: 'Total Sales (Baht)',
                        data: salesData.map(item => item.total_sales),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Sales: ' + tooltipItem.raw + ' Baht';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales (Baht)'
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', createCharts);
    </script>
</body>
</html>
