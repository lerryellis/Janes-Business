<?php

// Assume session contains user_id
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    sendError("User not logged in", 401);
}

// Fetch cart items
$query = "SELECT C.product_id, P.name, P.price, C.quantity 
          FROM Cart C 
          JOIN Products P ON C.product_id = P.product_id 
          WHERE C.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

sendSuccess("Cart items retrieved successfully", $cartItems);
?>
