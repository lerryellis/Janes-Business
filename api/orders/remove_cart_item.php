<?php

// Assume session contains user_id
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    sendError("User not logged in", 401);
}

// Get product ID from the request
$data = json_decode(file_get_contents("php://input"), true);
$product_id = $data['product_id'] ?? null;

if (!$product_id) {
    sendError("Invalid input: Product ID is required");
}

// Remove product from cart
$query = "DELETE FROM Cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    sendSuccess("Item removed from cart");
} else {
    sendError("Failed to remove item");
}
?>
