<?php
// Start the session
session_start();

// Database configuration
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "janes_shoes";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the request body
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query to fetch user with the given username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect to index.php
            echo '<script>alert("Login successful!"); window.location.href = "index.php";</script>';
        } else {
            // Invalid password
            echo '<script>alert("Invalid username or password.");</script>';
        }
    } else {
        // User not found
        echo '<script>alert("Invalid username or password.");</script>';
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="background">
        <div class="container">
            <h1>Login</h1>
            <form method="POST" action="" class="form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-button">Login</button>
            </form>
            <p>Don't have an account? <a href="registerpage.php" style="text-decoration: none; color: #4CAF50;">Register here</a></p>
        </div>
    </div>
</body>
</html>