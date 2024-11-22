<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "janes_shoes";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your query and code here
$query = "SELECT * FROM products WHERE category='Men'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='product-box'>
            <img src='{$row['image_url']}' alt='{$row['name']}' class='product-image'>
            <h3>{$row['name']}</h3>
            <p>Price: \${$row['price']}</p>
            <button onclick='addToCart(" . json_encode($row) . ")'>Add to Cart</button>
        </div>";
    }
} else {
    echo "<p>No products found in this category.</p>";
}

$conn->close();
?>