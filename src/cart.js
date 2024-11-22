// Initialize an empty cart array
let cart = [];

// Function to add items to the cart
function addToCart(item) {
    // Add the item to the cart
    cart.push(item);

    // Update the cart UI
    updateCartUI();

    // Show the cart popup
    document.getElementById("cart-popup").style.display = "block";
}

// Function to update the cart UI
function updateCartUI() {
    const cartItemsContainer = document.getElementById("cart-items");
    cartItemsContainer.innerHTML = ""; // Clear the existing items

    // Populate the cart items
    cart.forEach((item, index) => {
        const listItem = document.createElement("li");
        listItem.innerHTML = `
            ${item.name} - $${item.price}
            <button onclick="removeFromCart(${index})" style="color: red; border: none; background: transparent; font-size: 16px; cursor: pointer;">
                &#128465;
            </button>
        `;
        cartItemsContainer.appendChild(listItem);
    });

    // Update the hidden input field for checkout
    document.getElementById("cart-data").value = JSON.stringify(cart);
}

// Function to remove an item from the cart
function removeFromCart(index) {
    cart.splice(index, 1); // Remove the item at the specified index
    updateCartUI(); // Refresh the cart UI
}

// Function to close the cart popup
function closeCart() {
    document.getElementById("cart-popup").style.display = "none";
}
