<?php
// Start the session to access session variables
session_start();

// Display the logged-in user's name
if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
    $loggedIn = true;
} else {
    $username = "Guest";  // Default if not logged in
    $loggedIn = false;
}

// Initialize the cart if it's not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Cart count logic
$cartCount = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blank Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .navigation {
            margin-top: 20px; /* Move the navbar down */
            border-bottom: 1px solid #ccc; /* Add a bottom border */
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
            <a href="index.php">
            <img src="images/logo3.png" alt="Logo" style="margin-left: 90px;">
        </div>
        <div class="navigation-right">
            <a href="checkout.php"><img src="images/bag-black.png" alt="Shopping Bag"></a>
            <span id="cart-count"><?php echo $cartCount; ?></span>
            <span id="username-display"><?php echo "Welcome, " . $username; ?></span> 
            <a href="<?php echo $loggedIn ? '../api/auth/logout.php' : 'loginpage.php'; ?>" class="login-btn" id="login-btn"><?php echo $loggedIn ? 'Logout' : 'Login'; ?></a>
        </div>
    </div>

    <!-- Add your content here -->

    <script>
        // PHP will inject the session status into the JavaScript variable
        var isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;

        window.onload = function() {
            var loginButton = document.getElementById("login-btn");
            var usernameDisplay = document.getElementById("username-display");
            
            if (isLoggedIn) {
                // Update the button text to "Logout" and show the username
                loginButton.textContent = "Logout";
                usernameDisplay.textContent = "Welcome, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";
                // Move the text up or down
                usernameDisplay.style.marginTop = "-5px"; // adjust the value as needed
            } else {
                // Keep the button text as "Login"
                loginButton.textContent = "Login";
                // Move the text up or down
                loginButton.style.marginTop = "-5px"; // adjust the value as needed
            }
        };
    </script>

</body>
</html>