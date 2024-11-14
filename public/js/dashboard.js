// Function to switch between dashboard sections
function showSection(sectionId) {
    const sections = document.querySelectorAll('.dashboard-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
}

// Function to fetch and display products dynamically
function fetchProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_products.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const products = JSON.parse(xhr.responseText);
            const productListDiv = document.getElementById('product-list');
            productListDiv.innerHTML = ''; // Clear the list first
            products.forEach(product => {
                const productElement = document.createElement('p');
                productElement.textContent = `Product: ${product.name} - Price: $${product.price}`;
                productListDiv.appendChild(productElement);
            });
        }
    };
    xhr.send();
}

// Function to add a new product to the database
function addProduct() {
    const productName = document.getElementById('product_name').value;
    const productPrice = document.getElementById('product_price').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_product.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(xhr.responseText); // Show success or error message
            fetchProducts(); // Refresh the product list
        }
    };
    xhr.send(`product_name=${productName}&product_price=${productPrice}`);
}

// Initialize page with products and show the default section
document.addEventListener('DOMContentLoaded', function() {
    showSection('product-management');  // Show Product Management by default
    fetchProducts(); // Fetch and display products on page load
});
