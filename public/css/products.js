let cart = [];

// Add item to cart
function addToCart(id, name, price) {
    // Check if item already in cart
    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        alert(`${name} is already in your cart.`);
        return;
    }

    // Add new item to cart
    cart.push({ id, name, price });
    alert(`${name} added to cart!`);
    updateCartPopup();
}

// Update cart popup
function updateCartPopup() {
    const cartItems = document.getElementById("cart-items");
    cartItems.innerHTML = ""; // Clear existing items

    cart.forEach(item => {
        const li = document.createElement("li");
        li.textContent = `${item.name} - $${item.price.toFixed(2)}`;
        cartItems.appendChild(li);
    });
}

// Show cart popup
function showCart() {
    updateCartPopup();
    document.getElementById("cart-popup").style.display = "flex";
}

// Close cart popup
function closeCart() {
    document.getElementById("cart-popup").style.display = "none";
}

// Checkout (redirect or display message)
function checkout() {
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    alert("Proceeding to checkout...");
    // Implement checkout logic here
}
