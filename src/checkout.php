<?php
// Get cart data from POST request
$cartData = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

// Handle item removal if requested
if (isset($_POST['remove_item'])) {
    $indexToRemove = $_POST['remove_item'];
    array_splice($cartData, $indexToRemove, 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
    <h1>Checkout</h1>
    <?php if (count($cartData) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartData as $index => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="cart_data" value="<?php echo htmlspecialchars(json_encode($cartData)); ?>">
                                <input type="hidden" name="remove_item" value="<?php echo $index; ?>">
                                <button type="submit" style="color: red;">&#128465;</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="finalize_order.php" method="POST">
            <input type="hidden" name="cart_data" value="<?php echo htmlspecialchars(json_encode($cartData)); ?>">
            <button type="submit">Place Order</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
