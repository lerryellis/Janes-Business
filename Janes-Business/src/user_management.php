<?php
require_once '../api/auth/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>User Management</h1>
        </header>
        <nav>
            <button onclick="location.href='dashboard.php'">Dashboard</button>
            <button onclick="location.href='product_management.php'">Product Management</button>
            <button onclick="location.href='order_management.php'">Order Management</button>
            <button onclick="location.href='report_generation.php'">Generate Reports</button>
        </nav>
        <main>
            <form id="user-form" method="post" action="add_user.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button type="submit">Add User</button>
            </form>
            <div id="user-list">
                <?php
                // Fetch and display users
                $sql = "SELECT user_id, username, role FROM users LIMIT 10";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <p>Username: " . $row["username"] . " - Role: " . $row["role"] . "
                        <a href='delete_user.php?id=" . $row["user_id"] . "'>Delete</a>
                        </p>
                        ";
                    }
                } else {
                    echo "No users found.";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>