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
    <title>Men's Products</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
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
    <title>Men's Products</title>
    <link rel="stylesheet" href="men.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Oswald" rel="stylesheet">
    <meta name="robots" content="noindex,follow">
<body>
<h1></h1>
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
        </div>
        <div class="navigation-right">
            <a href="cart.php"><img src="images/bag-black.png" alt="Shopping Bag"></a>
            <?php if (isset($_SESSION['username'])) : ?>
                <span id="username-display" style="color: white;"><?php echo $_SESSION['username']; ?></span>
            <?php else : ?>
                <button class="login-btn" id="login-btn" onclick="openPopup()">Login</button>
            <?php endif; ?>
        </div>
    </div>



    
    <div class="product-container">
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
                
                </div>";
                
            }
        } else {
            echo "<p>No products found in this category.</p>";
        }
        ?>
        <button onclick="window.location.href='men.php'">View More</button>
    </div>

   <!-- Product details popup -->
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

        let cart = [];

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
  
  // Add event listener to close popup when clicking outside
  document.addEventListener('click', function(event) {
    if (event.target === document.getElementById('product-details-popup')) {
      document.getElementById('product-details-popup').style.display = 'none';
    }
  });
}
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

    <?php
    $conn->close();
    ?>
</body>
</html>


