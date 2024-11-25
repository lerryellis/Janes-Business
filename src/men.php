<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if no active session
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "janes_shoes";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add to cart functionality
if (isset($_GET['add_to_cart'])) {
    $productId = $_GET['add_to_cart'];  // Get the product ID
    $query = "SELECT * FROM products WHERE id='$productId'";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();  // Fetch product details based on the ID

    // Add the product to the cart session
    $_SESSION['cart'][] = $product;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="men.css">
    <script>
        // Initialize cart array
        let cart = <?php echo json_encode($_SESSION['cart'] ?? []); ?>;

        // Update the cart counter in the navbar
        function updateCartCounter() {
            const cartCount = cart.length;
            document.getElementById('cart-counter').innerText = cartCount;
        }

        // Function to add items to the cart
        function addToCart(item) {
            cart.push(item);
            updateCartPopup();
            updateCartCounter();
            alert('Item added to cart!');
        }

        // Function to update the cart popup
        function updateCartPopup() {
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = '';
            cart.forEach((item, index) => {
                const li = document.createElement('li');
                li.textContent = `${item.name} - $${item.price}`;
                cartItemsContainer.appendChild(li);
            });
            // Update hidden input for checkout
            document.getElementById('cart-data').value = JSON.stringify(cart);
        }

        // Function to show product details popup
        function showProductDetails(product) {
            document.getElementById('product-name').textContent = product.name;
            document.getElementById('product-image').src = product.image_url;
            document.getElementById('product-description').textContent = product.description;
            document.getElementById('product-price').textContent = `$${product.price}`;
            document.getElementById('add-to-cart-btn').onclick = function() {
                addToCart(product);
                document.getElementById('product-details-popup').style.display = 'none';
            };
            document.getElementById('close-popup-btn').onclick = function() {
                document.getElementById('product-details-popup').style.display = 'none';
            };
            document.getElementById('product-details-popup').style.display = 'block';
        }

        // Close popup if clicked outside
        document.addEventListener('click', function(event) {
            if (event.target === document.getElementById('product-details-popup')) {
                document.getElementById('product-details-popup').style.display = 'none';
            }
        });
    </script>
</head>
<body>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

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
            </a>
        </div>
        <div class="navigation-right">
            <a href="checkout.php">
                <img src="images/bag-black.png" alt="Shopping Bag">
                <span id="cart-counter">0 </span>
            </a>
            <span id="username-display" style="color: black;"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" style="color: black; margin-left: 10px;">Logout</a>
        </div>
    </div>

    <!-- Product Section -->
    <section id="men">
        <h2>Men's Shoes</h2>
        <div class="product-container" id="men-container">
            <?php
            $query = "SELECT * FROM products WHERE category='Men' LIMIT 4";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='product-box'>
                        <img src='{$row['image_url']}' alt='{$row['name']}' class='product-image'>
                        <h3>{$row['name']}</h3>
                        <p>Price: \${$row['price']}</p>
                        <button onclick='showProductDetails(" . json_encode($row) . ")'>View Details</button>
                        <button onclick='addToCart(" . json_encode($row) . ")'>Add to Cart</button>
                    </div>";
                }
            } else {
                echo "<p>No products found in this category.</p>";
            }
            ?>
            <button onclick="window.location.href='men.php'">View More</button>
        </div>
    </section>

    <!-- Product Details Popup -->
    <div id="product-details-popup" class="popup" style="display: none;">
        <div class="popup-content">
            <h2 id="product-name"></h2>
            <img id="product-image" alt="" class="product-image">
            <p id="product-description"></p>
            <p id="product-price"></p>
            <div class="button-container">
                <button id="add-to-cart-btn">Add to Cart</button>
                <button id="close-popup-btn">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Call updateCartCounter to initialize cart count on page load
        updateCartCounter();
    </script>

    <?php
    $conn->close();
    ?>
</body>
</html>
