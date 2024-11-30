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

// Function to get products by category
function getProductsByCategory($category, $conn) {
    $query = "SELECT * FROM products WHERE category='$category' LIMIT 4";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
}

// Function to display products
function displayProducts($result) {
    if ($result) {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  

  <title>Jane's Shoes - Products</title>
  <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
    }

    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
    }

    nav  
 {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    nav li {
      margin-right:  
 20px;
    }

    .product-section {
      padding: 20px;
    }

    .product-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .product-box {
      border: 1px solid #ccc;
      padding: 20px;
      width: 200px;
      margin-bottom: 20px;
      text-align: center;
      background-color: #fff;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .product-image {
      width: 100%;
    }

    .popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;  

    }

    .popup-content {
      background-color:  
 #fff;
      padding: 20px;
    }
  </style>
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
    <!-- Navigation -->
    <div class="navigation" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; border-bottom: 1px solid #ccc; background-color: #333; color: #fff;">
        <div class="navigation-left" style="display: flex; justify-content: space-between; align-items: center;">
        <a href="men.php" style="margin-right: 20px; color: #fff; text-decoration: none;">Men</a>
            <a href="women.php" style="margin-right: 20px; color: #fff; text-decoration: none;">Women</a>
            <a href="kids.php" style="color: #fff; text-decoration: none;">Kids</a>
        </div>
        <div class="navigation-center" style="display: flex; justify-content: center; align-items: center;">
            <a href="index.php">
                <img src="images/logo3.png" alt="Logo" style="width: 100px; height: 100px;">
            </a>
        </div>
        <div class="navigation-right" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="checkout.php"><img src="images/bag-black.png" alt="Shopping Bag" style="width: 30px; height: 30px;"></a>
            <?php if (isset($_SESSION['username'])) : ?>
                <span id="username-display" style="color: #fff; margin-left: 20px;"><?php echo $_SESSION['username']; ?></span>
            <?php else : ?>
                <button class="login-btn" id="login-btn" onclick="openPopup()" style="background-color: #333; color: #fff; border: none; padding: 10px; cursor: pointer;">Login</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Men Section -->
    <section id="men" style="padding: 20px; background-color: #f2f2f2;">
        <h2 style="text-align: center;">Men</h2>
        <div class="product-container" id="men-container" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <?php
            $menProducts = getProductsByCategory('Men', $conn);
            displayProducts($menProducts);
            ?>
            <button onclick="window.location.href='men.php'" style="background-color: #333; color: #fff; border: none; padding: 10px; cursor: pointer;">View More</button>
        </div>
    </section>

    <!-- Women Section -->
    <section id="women" style="padding: 20px; background-color: #f2f2f2;">
        <h2 style="text-align: center;">Women</h2>
        <div class="product-container" id="women-container" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <?php
            $womenProducts = getProductsByCategory('Women', $conn);
            displayProducts($womenProducts);
            ?>
            <button onclick="window.location.href='women.php'" style="background-color: #333; color: #fff; border: none; padding: 10px; cursor: pointer;">View More</button>
        </div>
    </section>

    <!-- Kids Section -->
    <section id="kids" style="padding: 20px; background-color: #f2f2f2;">
        <h2 style="text-align: center;">Kids</h2>
        <div class="product-container" id="kids-container" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <?php
            $kidsProducts = getProductsByCategory('Kids', $conn);
            displayProducts($kidsProducts);
            ?>
            <button onclick="window.location.href='kids.php'" style="background-color: #333; color: #fff; border: none; padding: 10px; cursor: pointer;">View More</button>
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

    <button onclick="showCart()" style="background-color: #333; color: #fff; border: none; padding: 10px; cursor: pointer;">View Cart</button>

    <?php $conn->close(); ?>
</body>
</html>