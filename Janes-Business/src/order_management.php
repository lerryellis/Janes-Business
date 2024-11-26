<?php
require_once '../api/auth/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management | Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Order Management</h1>
        </header>
        <nav>
            <button onclick="location.href='dashboard.php'">Dashboard</button>
            <button onclick="location.href='product_management.php'">Product Management</button>
            <button onclick="location.href='report_generation.php'">Generate Reports</button>
            <button onclick="location.href='user_management.php'">User Management</button>
        </nav>
        <main>
            <div id="order-list">
                <?php
                // Fetch and display orders
                $sql = "SELECT order_id, user_id, total_amount, order_date, status FROM orders LIMIT 10";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <p>Order ID: " . $row["order_id"] . " - User ID: " . $row["user_id"] . " - Total Amount: $" . $row["total_amount"] . " - Order Date: " . $row["order_date"] . " - Status: " . $row["status"] . "
                        <a href='view_order.php?id=" . $row["order_id"] . "'>View Order Details</a>
                        <a href='print_order.php?id=" . $row["order_id"] . "'>Print Order</a>
                        </p>
                        ";
                    }
                } else {
                    echo "No orders found.";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>