<?php
require_once '../api/auth/db_connection.php';

// Get product ID from URL parameter
$id = $_GET['id'];

// Delete product from database
$sql = "DELETE FROM products WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    echo "Product deleted successfully!";
    header('Location: product_management.php'); // Redirect to product management page
} else {
    echo "Error deleting product: " . $conn->error;
}

$conn->close();
?>