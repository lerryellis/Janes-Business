<?php
// db_connection.php
$servername = "localhost";
$username = "root"; // Update if needed
$password = "";     // Update if needed
$dbname = "janes_shoes"; // Ensure this is correct

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database connected successfully!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Jane's Shoe Business</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Admin Dashboard</h1>
            <nav>
                <button onclick="showSection('product-management')">Product Management</button>
                <button onclick="showSection('order-management')">Order Management</button>
                <button onclick="showSection('report-generation')">Generate Reports</button>
            </nav>
        </header>

        <main>
            <!-- Product Management Section -->
            <section id="product-management" class="dashboard-section">
                <h2>Product Management</h2>
                <form id="product-form" method="post" action="add_product.php" enctype="multipart/form-data">
                    <input type="text" name="product_name" placeholder="Product Name" required>
                    <input type="number" name="product_price" placeholder="Price" required>
                    <input type="file" name="product_image" accept="image/*">
                    <button type="submit">Add Product</button>
                </form>
                <div id="product-list">
                    <?php
                    // Fetch and display products
                    $sql = "SELECT name, price FROM products LIMIT 10";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<p>Product: " . $row["name"] . " - Price: $" . $row["price"] . "</p>";
                        }
                    } else {
                        echo "No products available.";
                    }
                    ?>
                </div>
            </section>

            <!-- Order Management Section -->
            <section id="order-management" class="dashboard-section">
                <h2>Order Management</h2>
                <div id="order-list">
                    <?php
                    // Fetch and display orders
                    $sql = "SELECT order_id, total_amount, status FROM orders LIMIT 10";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<p>Order ID: " . $row["order_id"] . " - Amount: $" . $row["total_amount"] . " - Status: " . $row["status"] . "</p>";
                        }
                    } else {
                        echo "No orders found.";
                    }
                    ?>
                </div>
            </section>

            <!-- Report Generation Section -->
            <section id="report-generation" class="dashboard-section">
                <h2>Generate Reports</h2>
                <button onclick="viewSales()">View Sales</button>
                <button onclick="printReceipt()">Print Receipts</button>
                <div id="report-output">
                    <?php
                    // Sample data for reports
                    echo "<p>Sales report feature coming soon!</p>";
                    ?>
                </div>
            </section>
        </main>
    </div>

    <script src="../public/js/dashboard.js"></script>
</body>
</html>

<?php $conn->close(); ?>
