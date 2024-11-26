<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Admin Dashboard</h1>
        </header>
        <nav>
            <button onclick="location.href='product_management.php'">Product Management</button>
            <button onclick="location.href='order_management.php'">Order Management</button>
            <button onclick="location.href='report_generation.php'">Generate Reports</button>
            <button onclick="location.href='user_management.php'">User Management</button>
        </nav>
        <main>
            <!-- Content will be loaded from individual pages -->
        </main>
    </div>
</body>
</html>