<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Shoe Store - Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Style for overlays, popups, and navigation */
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
    <!-- Navigation -->
    <div class="navigation">
        <div class="navigation-left">
            <a href="#">Home</a>
            <a href="#">About</a>
        </div>
        <div class="navigation-center">LOGO</div>
        <div class="navigation-right">
            <a href="#" class="login-btn" onclick="openLoginPopup()">Login</a>
        </div>
    </div>

    <!-- Slider Section -->
    <div class="css-slider-wrapper">
        <input type="radio" name="slider" class="slide-radio1 slide-radio" id="slide-radio1" checked>
        <input type="radio" name="slider" class="slide-radio2 slide-radio" id="slide-radio2">
        <input type="radio" name="slider" class="slide-radio3 slide-radio" id="slide-radio3">
        <input type="radio" name="slider" class="slide-radio4 slide-radio" id="slide-radio4">

        <div class="slider">
            <div class="slide-1 slider-content">
                <h2>Welcome to Slide 1</h2>
                <h4>Discover our features</h4>
                <button class="buy-now-btn">Shop Now</button>
            </div>
            <div class="slide-2 slider-content">
                <h2>Exclusive Deals</h2>
                <h4>Save big today</h4>
                <button class="buy-now-btn">Shop Now</button>
            </div>
            <div class="slide-3 slider-content">
                <h2>Trending Products</h2>
                <h4>Get the latest trends</h4>
                <button class="buy-now-btn">Shop Now</button>
            </div>
            <div class="slide-4 slider-content">
                <h2>Join Us Now</h2>
                <h4>Sign up for more perks</h4>
                <button class="buy-now-btn">Shop Now</button>
            </div>
        </div>

        <div class="slider-pagination">
            <label for="slide-radio1"></label>
            <label for="slide-radio2"></label>
            <label for="slide-radio3"></label>
            <label for="slide-radio4"></label>
        </div>

        <div class="number-pagination">
            <span id="slide-number">1</span>
        </div>
    </div>

    <!-- JavaScript for Auto-Sliding -->
    <script>
        var TIMEOUT = 6000;
        var interval = setInterval(handleNext, TIMEOUT);

        function handleNext() {
            var $radios = $('input[class*="slide-radio"]');
            var $activeRadio = $('input[class*="slide-radio"]:checked');
            var currentIndex = $activeRadio.index();
            var radiosLength = $radios.length;

            $radios.attr('checked', false);

            if (currentIndex >= radiosLength - 1) {
                $radios.first().attr('checked', true);
            } else {
                $activeRadio.next('input[class*="slide-radio"]').attr('checked', true);
            }
            $('#slide-number').text(currentIndex + 2 > radiosLength ? 1 : currentIndex + 2);
        }
    </script>

    <!-- Popups and Overlays -->
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

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Shoe Store. All Rights Reserved.</p>
    </footer>

    <script src="../public/js/login.js"></script>
    <script src="../public/js/search.js"></script>
    <script>
        function showError(message) {
            const errorPopup = document.getElementById('error-popup');
            const overlay = document.getElementById('overlay');
            errorPopup.textContent = message;
            errorPopup.style.display = 'block';
            overlay.style.display = 'block';
        }

        function closeAllPopups() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('login-popup').style.display = 'none';
            document.getElementById('search-popup').style.display = 'none';
            document.getElementById('error-popup').style.display = 'none';
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            showError(urlParams.get('error'));
        }
    </script>
</body>
</html>
