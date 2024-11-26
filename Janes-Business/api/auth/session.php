<?php
// Start the session
session_start();

// Check if the user is logged in
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : null;

// Initialize the cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to add items to the cart
function add_to_cart($item_id, $quantity = 1) {
    if (!isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] = $quantity; // Add new item
    } else {
        $_SESSION['cart'][$item_id] += $quantity; // Increase quantity
    }
}

// Function to display the cart count
function display_cart_count() {
    echo "<span id='cart-count'>" . array_sum($_SESSION['cart']) . "</span>";
}

// Optional: Session timeout mechanism
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['last_activity'] = time(); // Update last activity time
?>
