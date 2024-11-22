<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="product.css">
    <script>
        let cart = [];

        // Function to add items to the cart
        function addToCart(item) {
            cart.push(item);
            updateCartPopup();
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

        // Function to close the cart popup
        function closeCart() {
            document.getElementById('cart-popup').style.display = 'none';
        }

        // Function to show the cart popup
        function showCart() {
            document.getElementById('cart-popup').style.display = 'block';
        }
    </script>
</head>
<body>
    <h1>Products</h1>
<!-- Men Section -->
<section id="men">
    <h2>Men</h2>
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
    <!-- Men Section -->
    <section id="men">
        <h2>Men</h2>
        <div class="scroll-container">
            <button class="scroll-btn left" onclick="scrollLeft('men-container')">&lt;</button>
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
                            <button onclick='addToCart(" . json_encode($row) . ")'>Add to Cart</button>
                        </div>";
                    }
                } else {
                    echo "<p>No products found in this category.</p>";
                }
                ?>
            </div>
            <button class="scroll-btn right" onclick="scrollRight('men-container')">&gt;</button>
        </div>
    </section>

    <!-- Repeat similar sections for Women and Kids -->
    <section id="women">
        <h2>Women</h2>
        <div class="scroll-container">
            <button class="scroll-btn left" onclick="scrollLeft('women-container')">&lt;</button>
            <div class="product-container" id="women-container">
                <?php
                $query = "SELECT * FROM products WHERE category='Women' LIMIT 4";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <div class='product-box'>
                            <img src='{$row['image_url']}' alt='{$row['name']}' class='product-image'>
                            <h3>{$row['name']}</h3>
                            <p>Price: \${$row['price']}</p>
                            <button onclick='addToCart(" . json_encode($row) . ")'>Add to Cart</button>
                        </div>";
                    }
                } else {
                    echo "<p>No products found in this category.</p>";
                }
                ?>
            </div>
            <button class="scroll-btn right" onclick="scrollRight('women-container')">&gt;</button>
        </div>
    </section>

    <section id="Kids">
        <h2>Kids</h2>
        <div class="scroll-container">
            <button class="scroll-btn left" onclick="scrollLeft('Kids-container')">&lt;</button>
            <div class="product-container" id="Kids-container">
                <?php
                $query = "SELECT * FROM products WHERE category='Kids' LIMIT 4";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <div class='product-box'>
                            <img src='{$row['image_url']}' alt='{$row['name']}' class='product-image'>
                            <h3>{$row['name']}</h3>
                            <p>Price: \${$row['price']}</p>
                            <button onclick='addToCart(" . json_encode($row) . ")'>Add to Cart</button>
                        </div>";
                    }
                } else {
                    echo "<p>No products found in this category.</p>";
                }
                ?>
            </div>
            <button class="scroll-btn right" onclick="scrollRight('women-container')">&gt;</button>
        </div>
    </section>

    <!-- Cart Popup -->
    <div id="cart-popup" class="popup" style="display: none;">
        <div class="popup-content">
            <h2>Shopping Cart</h2>
            <ul id="cart-items"></ul>
            <div>
                <button onclick="closeCart()">Close</button>
                <form id="checkout-form" action="checkout.php" method="POST">
                    <input type="hidden" name="cart_data" id="cart-data">
                    <button type="submit">Checkout</button>
                </form>
            </div>
        </div>
    </div>

    <button onclick="showCart()">View Cart</button>

    <?php $conn->close(); ?>
</body>
</html>
