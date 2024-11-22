<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
        <p>Your cart is empty.</p>
        <button onclick="window.location.href='product.php'">Go Back to Products</button>
    <?php endif; ?>
</body>
</html>
