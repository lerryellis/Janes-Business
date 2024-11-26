<?php
// Start session
session_start();

// Get cart data from POST request
$cartData = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

// Display payment form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="men.css">
    <style>
    body{
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    form {
        width: 50%;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    label {
        display: block;
        margin-bottom: 10px;
    }
    input[type="text"], input[type="email"], input[type="tel"] {
        width: 100%;
        height: 40px;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    input[type="submit"] {
        width: 100%;
        height: 40px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #444;
    }
</style>
</head>
<body>

<h1>Payment</h1>

<form action="../api/finalize_order.php" method="POST">
    <input type="hidden" name="cart_data" value="<?php echo htmlspecialchars(json_encode($cartData)); ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required>
    <label for="shipping">Shipping Method:</label>
    <select id="shipping" name="shipping" required>
        <option value="">Select Shipping Method</option>
        <option value="pickup">Pickup</option>
        <option value="delivery">Delivery</option>
    </select>
    <div id="shipping-address" style="display: none;">
        <label for="address">Shipping Address:</label>
        <input type="text" id="address" name="address" required>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
        <label for="state">State:</label>
        <input type="text" id="state" name="state" required>
        <label for="zip">Zip Code:</label>
        <input type="text" id="zip" name="zip" required>
    </div>
    <input type="submit" value="Confirm Order">
</form>

<script>
    document.getElementById('shipping').addEventListener('change', function() {
        if (this.value === 'delivery') {
            document.getElementById('shipping-address').style.display = 'block';
        } else {
            document.getElementById('shipping-address').style.display = 'none';
        }
    });
</script>

</body>
</html>