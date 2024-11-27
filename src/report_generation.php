<?php
require_once '../api/auth/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports | Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Generate Reports</h1>
        </header>
        <nav>
            <button onclick="location.href='dashboard.php'">Dashboard</button>
            <button onclick="location.href='product_management.php'">Product Management</button>
            <button onclick="location.href='order_management.php'">Order Management</button>
            <button onclick="location.href='user_management.php'">User Management</button>
        </nav>
        <main>
            <h2>Total Complete Orders:</h2>
            <?php
            // Fetch total complete orders
            $sql = "SELECT COUNT(order_id) AS total_orders FROM orders WHERE status = 'complete'";
            $result = $conn->query($sql);
            $total_orders = $result->fetch_assoc()['total_orders'];

            echo "<p>Total Complete Orders: $total_orders</p>";
            ?>

            <h2>Order Details:</h2>
            <?php
            // Fetch order details
            $sql = "SELECT * FROM orders WHERE status = 'complete'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "
                    <h3>Order ID: " . $row["order_id"] . "</h3>
                    <p>Order Date: " . $row["order_date"] . "</p>
                    <p>Total Amount: $" . $row["total_amount"] . "</p>
                    <h4>Order Items:</h4>
                    <ul>
                    ";

                    // Fetch order items
                    $sql_items = "SELECT * FROM order_items WHERE order_id = '" . $row["order_id"] . "'";
                    $result_items = $conn->query($sql_items);

                    if ($result_items->num_rows > 0) {
                        while($item = $result_items->fetch_assoc()) {
                            echo "
                            <li>" . $item["product_name"] . " x " . $item["quantity"] . " = $" . $item["total_price"] . "</li>
                            ";
                        }
                    }

                    echo "
                    </ul>
                    ";
                }
            } else {
                echo "No orders found.";
            }
            ?>
        </main>
    </div>
</body>
</html>