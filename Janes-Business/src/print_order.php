<?php
require_once '../api/auth/db_connection.php';

// Get order ID from URL parameter
$id = $_GET['id'];

// Fetch order details
$sql = "SELECT * FROM orders WHERE order_id = '$id'";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Order | Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
    <style>
        @media print {
            body {
                font-size: 12pt;
            }
            .order-details {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Print Order</h1>
        </header>
        <nav>
            <button onclick="location.href='order_management.php'">Back to Order Management</button>
        </nav>
        <main>
            <p>Order ID: <?php echo $order['order_id']; ?></p>
            <p>User ID: <?php echo $order['user_id']; ?></p>
            <p>Total Amount: $<?php echo $order['total_amount']; ?></p>
            <p>Order Date: <?php echo $order['order_date']; ?></p>
            <p>Status: <?php echo $order['status']; ?></p>

            <h3>Order Items:</h3>
            <!-- You will need to add code here to fetch and display the order items -->

            <button onclick="window.print()">Print Order</button>
        </main>
    </div>
</body>
</html>