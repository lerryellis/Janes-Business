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
    <link rel="stylesheet" href="men.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 1em;
            text-align: left;
        }
        
        th {
            background-color: #f0f0f0;
        }
        
        button[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 1em 2em;
            font-size: 1em;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #444;
        }
    </style>
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
        </div>
        <div class="navigation-right">
            <a href="cart.php"><img src="images/bag-black.png" alt="Shopping Bag"></a>
            <?php if (isset($_SESSION['username'])) : ?>
                <span id="username-display" style="color: white;"><?php echo $_SESSION['username']; ?></span>
            <?php else : ?>
                <button class="login-btn" id="login-btn" onclick="openPopup()">Login</button>
            <?php endif; ?>
        </div>
    </div>

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
    <script>
        // Function to remove item from cart
        function removeItem(index) {
            // Send AJAX request to remove item from cart
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'checkout.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('remove_item=' + index + '&cart_data=' + JSON.stringify(cartData));
            
            // Update cart display
            location.reload();
        }
    </script>
</body>
</html>