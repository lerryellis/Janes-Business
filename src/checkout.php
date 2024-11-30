<?php
// Start session
session_start();

// Initialize cart data
$cartData = [];

// Get cart data from POST request
if (isset($_POST['cart_data'])) {
    $cartData = json_decode($_POST['cart_data'], true);
}

// Get cart data from session
if (isset($_SESSION['cart'])) {
    $cartData = array_merge($cartData, $_SESSION['cart']);
}

// Handle item removal if requested
if (isset($_POST['remove_item'])) {
    $indexToRemove = $_POST['remove_item'];
    if (isset($cartData[$indexToRemove])) {
        array_splice($cartData, $indexToRemove, 1);
    }
    // Update session cart data
    $_SESSION['cart'] = $cartData;
}

// Update session cart data
$_SESSION['cart'] = $cartData;

// Display the logged-in user's name
if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
    $loggedIn = true;
} else {
    $username = "Guest";  // Default if not logged in
    $loggedIn = false;
}

// Cart count logic
$cartCount = count($cartData);

// Validate cart data
if (!empty($cartData)) {
    foreach ($cartData as $index => $item) {
        if (!isset($item['name']) || !isset($item['price'])) {
            unset($cartData[$index]);
        }
    }
    $_SESSION['cart'] = $cartData;
}

// Calculate total cost
$totalCost = 0;
if (!empty($cartData)) {
    foreach ($cartData as $item) {
        $totalCost += $item['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .navigation {
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
            background-color: #fff;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navigation-left a, .navigation-right a {
            margin-right: 20px;
            text-decoration: none;
            color: #333;
        }
        .navigation-center img {
            width: 150px;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 3px;
        }
        button:hover {
            background-color: darkred;
        }
        #cart-count {
            font-weight: bold;
            font-size: 18px;
        }
        .checkout-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .checkout-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="navigation">
        <div class="navigation-left">
            <a href="men.php">Men</a>
            <a href="women.php">Women</a>
            <a href="kids.php">Kids</a>
        </div>
        <div class="navigation-center">
            <a href="index.php"><img src="images/logo3.png" alt="Logo"></a>
        </div>
        <div class="navigation-right">
            <a href="checkout.php"><img src="images/bag-black.png" alt="Shopping Bag"></a>
            <span id="cart-count"><?php echo $cartCount; ?></span>
            <span id="username-display"><?php echo "Welcome, " . $username; ?></span> 
            <a href="<?php echo $loggedIn ? '../api/auth/logout.php' : 'loginpage.php'; ?>" class="login-btn" id="login-btn"><?php echo $loggedIn ? 'Logout' : 'Login'; ?></a>
        </div>
    </div>

    <h1>Checkout</h1>

    <?php if (!empty($cartData)): ?>
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
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1">Total:</td>
                    <td colspan="2">$<?php echo $totalCost; ?></td>
                </tr>
            </tfoot>
        </table>
        <form action="../api/payments.php" method="POST">
            <input type="hidden" name="cart_data" value="<?php echo htmlspecialchars(json_encode($cartData)); ?>">
            <button type="submit" class="checkout-button">Place Order</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <script>
        var isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;

        window.onload = function() {
            var loginButton = document.getElementById("login-btn");
            var usernameDisplay = document.getElementById("username-display");

            if (isLoggedIn) {
                loginButton.textContent = "Logout";
                usernameDisplay.textContent = "Welcome, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";
                usernameDisplay.style.marginTop = "-5px";
            } else {
                loginButton.textContent = "Login";
                loginButton.style.marginTop = "-5px";
            }
        };
    </script>
</body>
</html>
