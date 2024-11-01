// Toggle between dashboard sections
function showSection(sectionId) {
    document.querySelectorAll('.dashboard-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

// Product Management: Add Product
async function addProduct() {
    const name = document.getElementById('product-name').value;
    const price = document.getElementById('product-price').value;
    const imageFile = document.getElementById('product-image').files[0];

    let formData = new FormData();
    formData.append("name", name);
    formData.append("price", price);
    formData.append("image", imageFile);

    const response = await fetch('../products/add_product.php', {
        method: 'POST',
        body: formData
    });
    const data = await response.json();
    alert(data.message);
}

// Order Management: Fetch Orders
async function fetchOrders() {
    const response = await fetch('../orders/get_orders.php');
    const orders = await response.json();
    const orderList = document.getElementById('order-list');
    orderList.innerHTML = orders.map(order => `
        <div>
            <p>Order ID: ${order.id}</p>
            <p>Status: ${order.status}</p>
        </div>
    `).join('');
}

// Report Generation: View Sales
async function viewSales() {
    const response = await fetch('../reports/sales_report.php');
    const sales = await response.json();
    const reportOutput = document.getElementById('report-output');
    reportOutput.innerHTML = `<p>Total Sales: ${sales.total}</p>`;
}

// Report Generation: Print Receipts
function printReceipt() {
    window.print();
}

// Initialize
showSection('product-management');  // Default to Product Management view
fetchOrders();                      // Load orders on page load
