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
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="registration.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Oswald" rel="stylesheet">
    <meta name="robots" content="noindex,follow">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>
<body class="font-opensans"> 
    <!-- Navigation -->
    <div class="navigation">
        <div class="navigation-left">
            <a href="men.php">Men</a>
            <a href="women.php">Women</a>
            <a href="kids.php">Kids</a>
        </div>
        <div class="navigation-center">
           <a href="index.php">
            <img src="images/logo3.png" alt="Logo"  style="margin-left:100px;">
        </div>
        <div class="navigation-right">
            <a href="checkout.php"><img src="images/bag-black.png" alt="Shopping Bag"></a>
            <span id="cart-count"><?php echo $cartCount; ?></span>
            <span id="username-display"><?php echo "Welcome, " . $username; ?></span> 
            <a href="loginpage.php" class="login-btn" id="login-btn"><?php echo $loggedIn ? 'Logout' : 'Login'; ?></a>
        </div>
    </div>

    <!-- Slider Wrapper -->
    <div class="css-slider-wrapper">
        <!-- Slider Controls -->
        <input type="radio" name="slider" class="slide-radio1" checked id="slider_1">
        <input type="radio" name="slider" class="slide-radio2" id="slider_2">
        <input type="radio" name="slider" class="slide-radio3" id="slider_3">
        <input type="radio" name="slider" class="slide-radio4" id="slider_4">

        <!-- Pagination -->
        <div class="slider-pagination">
            <label for="slider_1" class="page1"></label>
            <label for="slider_2" class="page2"></label>
            <label for="slider_3" class="page3"></label>
            <label for="slider_4" class="page4"></label>
        </div>

        <?php
        // Array of products (This can later be fetched from a database)
        $products = [
            ["model-1.png", "Denim Longline T-Shirt Dress", 130],
            ["model-2.png", "Slim Fit Denim Jacket", 110],
            ["model-3.png", "Casual Hoodie", 80],
            ["model-4.png", "Classic Sneakers", 90]
        ];

        // Loop to generate sliders
        foreach ($products as $index => $product) {
            echo "<div class='slider slide-" . ($index + 1) . "'>
            <img src='images/{$product[0]}' alt='Model'>
            <div class='slider-content'>
                <h4 class='new-product-label'>Product</h4>
                <h2>{$product[1]}</h2>                <a href='product.php?product={$product[1]}&price={$product[2]}'>
                    <button type='button' class='buy-now-btn'>\${$product[2]}</button>
                </a>
            </div>
            <div class='number-pagination'><span>" . ($index + 1) . "</span></div>
          </div>";
        }
        ?>
            <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="app.js"></script>
    <script>
    // PHP will inject the session status into the JavaScript variable
var isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;

window.onload = function() {
    var loginButton = document.getElementById("login-btn");
    var usernameDisplay = document.getElementById("username-display");
    
    if (isLoggedIn) {
        // Update the button text to "Logout" and show the username
        loginButton.textContent = "Logout";
        loginButton.href = "../api/auth/logout.php";
        usernameDisplay.textContent = "Welcome, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";
        // Move the text up or down
        usernameDisplay.style.marginTop = "-5px"; // adjust the value as needed
    } else {
        // Keep the button text as "Login"
        loginButton.textContent = "Login";
        loginButton.href = "loginpage.php";
        // Move the text up or down
        loginButton.style.marginTop = "-5px"; // adjust the value as needed
    }
};
    </script>

</body>
</html>