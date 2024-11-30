<?php
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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['registerUsername']);
    $password = trim($_POST['registerPassword']);
    $email = trim($_POST['registerEmail']);
    $phone_number = trim($_POST['registerPhoneNumber']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($email) || empty($phone_number)) {
        echo '<script>alert("All fields are required.");</script>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format.");</script>';
    } elseif (strlen($phone_number) !== 10) {
        echo '<script>alert("Phone number must be 10 characters long.");</script>';
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<script>alert("Email already exists.");</script>';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $sql = "INSERT INTO users (username, password, email, phone_number) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $hashed_password, $email, $phone_number);

            if ($stmt->execute()) {
                echo '<script>alert("Registration successful!"); window.location.href = "loginpage.php";</script>';
            } else {
                echo '<script>alert("Error: ' . $stmt->error . '");</script>';
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="background">
        <div class="container">
        <a href="loginpage.php">
                    <img src="..//src/images/back-arrow.png" alt="Back Arrow" class="back-arrow">
                </a>
            <a href="index.php">
                <img src="..//src/images/logo3.png" alt="Company Logo" class="logo">
            </a>
            <h1></h1>
            <form method="POST" action="" class="form">
                <div class="form-group">
                    <label for="registerUsername">Username:</label>
                    <input type="text" id="registerUsername" name="registerUsername" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password:</label>
                    <input type="password" id="registerPassword" name="registerPassword" required>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email:</label>
                    <input type="email" id="registerEmail" name="registerEmail" required>
                </div>
                <div class="form-group">
                    <label for="registerPhoneNumber">Phone Number:</label>
                    <input type="text" id="registerPhoneNumber" name="registerPhoneNumber" maxlength="10" required>
                </div>
                <button type="submit" class="submit-button">Register</button>
            </form>
        </div>
    </div>
</body>
</html>