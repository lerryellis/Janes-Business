<?php
require_once '../api/auth/db_connection.php';

// Get form data
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_FILES['product_image'];

// Upload product image
$image_upload_path = "uploads/" . basename($product_image['name']);
move_uploaded_file($product_image['tmp_name'], $image_upload_path);

// Insert product into database
$sql = "INSERT INTO products (name, price, image) VALUES ('$product_name', '$product_price', '$image_upload_path')";
if ($conn->query($sql) === TRUE) {
    echo "Product added successfully!";
    header('Location: product_management.php'); // Redirect to product management page
} else {
    echo "Error adding product: " . $conn->error;
}

$conn->close();
?>