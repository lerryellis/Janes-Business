<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Shoe Store</title>
    <style>
        /* Style for the error popup */
        #error-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            z-index: 1000;
            text-align: center;
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <header>
        <h1>Shoe Store</h1>
        <div class="login">
            <form action="../api/auth/login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
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
        <h2></h2>
        <div class="gallery">
            <!-- Cincopa gallery integration will be added here -->
            <iframe src="https://lerryellis.cincopa.com/watch/AAHAJQtbAqgb" width="100%" height="400px"></iframe>
        </div>
    </main>

    <!-- Error popup and overlay -->
    <div id="overlay" onclick="closePopup()"></div>
    <div id="error-popup"></div>

    <footer>
        <p>&copy; 2024 Shoe Store. All Rights Reserved.</p>
    </footer>

    <script>
        // Function to show error message
        function showError(message) {
            const errorPopup = document.getElementById('error-popup');
            const overlay = document.getElementById('overlay');
            errorPopup.textContent = message;
            errorPopup.style.display = 'block';
            overlay.style.display = 'block';
        }

        // Function to close the error popup
        function closePopup() {
            const errorPopup = document.getElementById('error-popup');
            const overlay = document.getElementById('overlay');
            errorPopup.style.display = 'none';
            overlay.style.display = 'none';
        }

        // Check for error message from the URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            showError(urlParams.get('error'));
        }
    </script>
</body>
</html>
