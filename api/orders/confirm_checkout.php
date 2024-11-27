<?php

session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    sendError("You must be logged in to confirm the order.", 401);
}

// Get phone and PIN from POST data
$phone = $_POST['phone'] ?? null;
$pin = $_POST['pin'] ?? null;

if (!$phone || !$pin) {
    sendError("Phone number and PIN are required.");
}

// Verify phone and PIN
$query = "SELECT user_id FROM Users WHERE user_id = ? AND phone_number = ? AND pin = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $user_id, $phone, $pin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    sendError("Invalid phone number or PIN.");
}

// Fetch cart items
$cart_query = "SELECT product_id, quantity FROM Cart WHERE user_id = ?";
$cart_stmt = $conn->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_items = $cart_stmt->get_result();

// Create a new order
$order_query = "INSERT INTO Orders (customer_id, order_date, total_amount, status) VALUES (?, NOW(), 0, 'confirmed')";
$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_id = $order_stmt->insert_id;

// Add items to Order_Items and update total amount
$total_amount = 0;

while ($item = $cart_items->fetch_assoc()) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    // Get product price
    $price_query = "SELECT price FROM Products WHERE product_id = ?";
    $price_stmt = $conn->prepare($price_query);
    $price_stmt->bind_param("i", $product_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result()->fetch_assoc();
    $price = $price_result['price'];

    $item_total = $price * $quantity;
    $total_amount += $item_total;

    // Add to Order_Items
    $order_item_query = "INSERT INTO Order_Items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $order_item_stmt = $conn->prepare($order_item_query);
    $order_item_stmt->bind_param("iii", $order_id, $product_id, $quantity);
    $order_item_stmt->execute();

    // Reduce stock
    $stock_update_query = "UPDATE Products SET stock = stock - ? WHERE product_id = ?";
    $stock_update_stmt = $conn->prepare($stock_update_query);
    $stock_update_stmt->bind_param("ii", $quantity, $product_id);
    $stock_update_stmt->execute();
}

// Update total amount in the order
$update_order_query = "UPDATE Orders SET total_amount = ? WHERE order_id = ?";
$update_order_stmt = $conn->prepare($update_order_query);
$update_order_stmt->bind_param("di", $total_amount, $order_id);
$update_order_stmt->execute();

// Clear the cart
$clear_cart_query = "DELETE FROM Cart WHERE user_id = ?";
$clear_cart_stmt = $conn->prepare($clear_cart_query);
$clear_cart_stmt->bind_param("i", $user_id);
$clear_cart_stmt->execute();

sendSuccess("Order confirmed successfully.", ['order_id' => $order_id, 'total_amount' => $total_amount]);
?>
