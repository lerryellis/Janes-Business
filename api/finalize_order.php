<?php
// Start session
session_start();

// Get cart data from POST request
$cartData = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

// Get customer information from POST request
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$shipping = isset($_POST['shipping']) ? $_POST['shipping'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$zip = isset($_POST['zip']) ? $_POST['zip'] : '';

// Validate customer information
if (empty($name) || empty($email) || empty($phone) || empty($shipping)) {
    echo "Error: Please fill in all required fields.";
    exit;
}

// Check if shipping address is required
if ($shipping === 'delivery' && (empty($address) || empty($city) || empty($state) || empty($zip))) {
    echo "Error: Please fill in all required shipping address fields.";
    exit;
}

// Process order
// Connect to database
$conn = mysqli_connect('localhost', 'root', '', 'janes_shoes');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Calculate total amount
$totalAmount = 0;
foreach ($cartData as $item) {
    $totalAmount += $item['price'];
}

// Insert order into database
$orderDate = date('Y-m-d');

// Use 0 as default user_id for guest users
$sql = "INSERT INTO orders (user_id, total_amount, order_date, status) VALUES (0, '$totalAmount', '$orderDate', 'pending')";

if (mysqli_query($conn, $sql)) {
    $order_id = mysqli_insert_id($conn);

    // Insert order items into database
    foreach ($cartData as $item) {
        $sql = "INSERT INTO order_items (order_id, product_name, price) VALUES ('$order_id', '".$item['product_name']."', '".$item['price']."')";
        mysqli_query($conn, $sql);
    }

    // Clear cart session
    unset($_SESSION['cart']);

    // Display success message
    echo "<h1>Thank you for your order!</h1>";
    echo "<p>Your order number is $order_id.</p>";
    echo "<p>We will prepare your order for pickup.</p>";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>