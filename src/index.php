<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Shoe Store - Home</title>
    <style>
        /* Style for overlays and popups */
        #error-popup, #login-popup, #search-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.95);
            color: black;
            padding: 20px;
            border-radius: 10px;
            z-index: 1001;
            text-align: center;
            width: 300px;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .popup-input {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .popup-button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        .icons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .icon-button img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the Shoe Store</h1>
        
        <div class="icons">
            <!-- Login, Search, and Cart Buttons -->
            <button class="icon-button" onclick="openLoginPopup()">
                <img src="../public/images/login-icon.png" alt="Login">
            </button>
            <button class="icon-button" onclick="openSearchPopup()">
                <img src="../public/images/search-icon.png" alt="Search">
            </button>
            <button class="icon-button">
                <img src="../public/images/cart-icon.png" alt="Cart">
            </button>
        </div>

        <!-- User info display -->
        <?php if (isset($_SESSION['user_email'])): ?>
            <div class="user-info">
                <img src="<?php echo $_SESSION['user_profile_image']; ?>" alt="Profile" width="40">
                <span><?php echo $_SESSION['user_email']; ?></span>
            </div>
        <?php endif; ?>
    </header>
    
    <main>
        <h2>Featured Products</h2>
        <div class="gallery">
            <!-- Example gallery or product grid could go here -->
            <iframe src="https://lerryellis.cincopa.com/watch/AAHAJQtbAqgb" width="100%" height="400px"></iframe>
        </div>
    </main>

    <!-- Overlay and Popup Containers -->
    <div id="overlay" onclick="closeAllPopups()"></div>
    
    <div id="error-popup"></div>
    
    <div id="login-popup">
        <form action="../api/auth/login.php" method="post">
            <input class="popup-input" type="text" name="username" placeholder="Username" required>
            <input class="popup-input" type="password" name="password" placeholder="Password" required>
            <button type="submit" class="popup-button">Login</button>
            <button type="button" class="popup-button" onclick="window.location.href='/register.php'">Register</button>
        </form>
    </div>

    <div id="search-popup">
        <form action="/search.php" method="get">
            <input class="popup-input" type="text" name="query" placeholder="Search for products...">
            <button type="submit" class="popup-button">Search</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Shoe Store. All Rights Reserved.</p>
    </footer>

    <script src="../public/js/login.js"></script>
    <script src="../public/js/search.js"></script>
    <script>
        // Error popup function
        function showError(message) {
            const errorPopup = document.getElementById('error-popup');
            const overlay = document.getElementById('overlay');
            errorPopup.textContent = message;
            errorPopup.style.display = 'block';
            overlay.style.display = 'block';
        }

        // Close all popups
        function closeAllPopups() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('login-popup').style.display = 'none';
            document.getElementById('search-popup').style.display = 'none';
            document.getElementById('error-popup').style.display = 'none';
        }
        
        // Check for error message in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            showError(urlParams.get('error'));
        }
    </script>
</body>
</html>
