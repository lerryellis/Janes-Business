<?php
// delete_user.php

// Include the database connection file
require_once 'db_connection.php';

// Get user ID from URL parameter
$id = $_GET['id'];

// Delete user from database
$sql = "DELETE FROM users WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully!";
    header('Location: user_management.php'); // Redirect to user management page
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>