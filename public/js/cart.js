document.addEventListener("DOMContentLoaded", () => {
    const cartButton = document.getElementById("cart-button");
    const cartModal = document.getElementById("cart-modal");
    const closeCart = document.getElementById("close-cart");
    const cartItemsContainer = document.getElementById("cart-items-container");
    const proceedCheckout = document.getElementById("proceed-checkout");

    // Open cart modal
    cartButton.addEventListener("click", async () => {
        cartModal.style.display = "block";
        await loadCartItems();
    });

    // Close cart modal
    closeCart.addEventListener("click", () => {
        cartModal.style.display = "none";
    });

    // Fetch and display cart items
    async function loadCartItems() {
        const response = await fetch("../api/orders/get_cart.php");
        const data = await response.json();

        if (data.status === "success") {
            cartItemsContainer.innerHTML = data.data
                .map(
                    (item) => `
                <div class="cart-item">
                    <p>${item.name} - $${item.price} x ${item.quantity}</p>
                    <button class="remove-btn" data-id="${item.product_id}">Remove</button>
                </div>
            `
                )
                .join("");
            attachRemoveHandlers();
        } else {
            cartItemsContainer.innerHTML = `<p>${data.message}</p>`;
        }
    }

    // Attach event handlers to remove buttons
    function attachRemoveHandlers() {
        const removeButtons = document.querySelectorAll(".remove-btn");
        removeButtons.forEach((button) => {
            button.addEventListener("click", async () => {
                const productId = button.getAttribute("data-id");
                await removeCartItem(productId);
                await loadCartItems(); // Reload cart after removing
            });
        });
    }

    // Remove item from cart
    async function removeCartItem(productId) {
        const response = await fetch("../api/orders/remove_cart_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ product_id: productId }),
        });
        const data = await response.json();
        alert(data.message); // Show success or error message
    }

    // Proceed to checkout
    proceedCheckout.addEventListener("click", () => {
        window.location.href = "checkout.php";
    });
});
