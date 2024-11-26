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
                <button onclick="showSection('user-management')">User Management</button>
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

            <!-- User Management Section -->
            <section id="user-management" class="dashboard-section">
                <h2>User Management</h2>
                <form id="user-form" method="post" action="add_user.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <select name="role" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <button type="submit">Add User</button>
                </form>
                <div id="user-list">
                    <h3>Existing Users</h3>
                    <?php
                    // Fetch and display users
                    $sql = "SELECT username, role FROM users LIMIT 10";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<p>Username: " . $row["username"] . " - Role: " . $row["role"] . "</p>";
                        }
                    } else {
                        echo "No users found.";
                    }
                    ?>
                </div>
            </section>
        </main>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.dashboard-section');
            sections.forEach(section => section.style.display = 'none');

            document.getElementById(sectionId).style.display = 'block';
        }

        // Show the first section by default
        document.addEventListener('DOMContentLoaded', () => showSection('product-management'));
    </script>
</body>
</html>

<?php $conn->close(); ?>
