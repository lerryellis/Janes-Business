<?php
// Start PHP session if needed
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider</title>
    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Oswald" rel="stylesheet">
    <meta name="robots" content="noindex,follow">
</head>
<body>
    <!-- Navigation -->
<div class="navigation">
    <div class="navigation-left">
        <a href="#">Men</a>
        <a href="#">Women</a>
        <a href="#">Kids</a>
    </div>
    <div class="navigation-center">
        <img src="images/logo.png" alt="Logo">
    </div>
   

<div class="navigation-right">
    <a href="#"><img src="images/shopping-bag.png" alt="Shopping Bag"></a>
    <span id="username-display"></span> <!-- Display the logged-in user's name here -->
    <button class="login-btn" id="login-btn" onclick="openPopup()">Login</button>
</div>
</div>

<!-- Popup Container -->
<div id="popup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">x</span>
        
        <!-- Login Form -->
        <div id="login-form">
            <h2>Login</h2>
            <form id="loginForm">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="button" onclick="authenticateUser()">Login</button>
            </form>
            <p>Don't have an account? <a href="#" onclick="switchToRegister()">Register here</a></p>
        </div>
    </div>
</div>

<!-- Username Display (hidden by default) -->
<div class="user-info" id="user-info" style="display: none;">
    Welcome, <span id="username-display"></span>!
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
                        <h2>{$product[1]}</h2>
                        <button type='button' class='buy-now-btn'>\${$product[2]}</button>
                    </div>
                    <div class='number-pagination'><span>" . ($index + 1) . "</span></div>
                  </div>";
        }
        ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="app.js"></script>
    <script src="popup.js" defer></script>

</body>
</html>