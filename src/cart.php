<?php
// Start session
session_start();

if (isset($_SESSION['cart'])) {
    $cartData = $_SESSION['cart'];
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
    $cartData = json_decode($_POST['cart_data'], true); // Decode cart data from POST
} else {
    $cartData = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="men.css">
    <link rel="stylesheet" href="product.css">
</head>
<body>
<h1></h1>
    <!-- Navigation -->
    <div class="navigation">
        <div class="navigation-left">
            <a href="men.php">Men</a>
            <a href="women.php">Women</a>
            <a href="kids.php">Kids</a>
        </div>
        <div class="navigation-center">
            <a href="index.php">
                <img src="images/logo3.png" alt="Logo">
            </a>
        </div>
        <div class="navigation-right">
            <a href="cart.php"><img src="images/bag-black.png" alt="Shopping Bag"></a>
            <?php if (isset($_SESSION['username'])) : ?>
                <span id="username-display" style="font-family: 'poppins', sans-serif; font-size: 20px; color: #000000;">
                    <?php echo $_SESSION['username']; ?>
                </span>
                <a href="logout.php" style="font-size: 16px; color: #000000; text-decoration: none; margin-left: 10px;">Logout</a>
            <?php else : ?>
                <button class="login-btn" id="login-btn" onclick="openPopup()">Login</button>
            <?php endif; ?>
        </div>
    </div>

    <h1>Your Cart</h1>
    <?php if (!empty($cartData)): ?>
        <ul>
            <?php foreach ($cartData as $item): ?>
                <li><?php echo htmlspecialchars($item['name']) . " - $" . htmlspecialchars($item['price']); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total:</strong> $
            <?php echo array_reduce($cartData, function($total, $item) {
                return $total + $item['price'];
            }, 0); ?>
        </p>
        <button onclick="window.location.href='products.php'">Continue Shopping</button>
        <button>Proceed to Payment</button>
    <?php else: ?>
        <div class="empty-cart">
            <p>No items in basket.</p>
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    <?php endif; ?>

    <script>
        // Get cart data from session or POST
        let cartData = <?php echo json_encode($cartData); ?>;
        
        // Function to add items to the cart
        function addToCart(item) {
            // Add item to cart data
            cartData.push(item);
            
            // Send cart data to server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('cart_data=' + JSON.stringify(cartData));
            
            // Update cart display
            location.reload();
        }
    </script>
</body>
</html>
