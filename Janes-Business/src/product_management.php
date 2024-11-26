<?php
require_once '../api/auth/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Product Management</h1>
        </header>
        <nav>
            <button onclick="location.href='dashboard.php'">Dashboard</button>
            <button onclick="location.href='order_management.php'">Order Management</button>
            <button onclick="location.href='report_generation.php'">Generate Reports</button>
            <button onclick="location.href='user_management.php'">User Management</button>
        </nav>
        <main>
            <form id="product-form" method="post" action="add_product.php" enctype="multipart/form-data">
                <input type="text" name="product_name" placeholder="Product Name" required>
                <input type="number" name="product_price" placeholder="Price" required>
                <input type="file" name="product_image" accept="image/*">
                <button type="submit">Add Product</button>
            </form>
            <div id="product-list">
                <?php
                // Fetch and display products
                $sql = "SELECT product_id, name, price FROM products LIMIT 10";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <p>Product: " . $row["name"] . " - Price: $" . $row["price"] . "
                        <a href='delete_product.php?id=" . $row["product_id"] . "'>Delete</a>
                        </p>
                        ";
                    }
                } else {
                    echo "No products available.";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>