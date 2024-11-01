<?php
session_start();

// Database connection parameters
$servername = "localhost"; // or your database server
$username = "root"; // database username
$password = ""; // database password
$dbname = "janes_shoes"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Prepare and bind SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, now retrieve the password
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Verify password
        if ($input_password === $stored_password) {
            // Successful login
            $_SESSION['user'] = $input_username;
            header("Location: /janes_business/Janes-Business/src/admin_dashboard.php"); // Redirect to the dashboard
            exit();
        } else {
            // Invalid password, set error message in session
            $_SESSION['error_message'] = "Invalid username or password!";
        }
    } else {
        // Invalid username, set error message in session
        $_SESSION['error_message'] = "Invalid username or password!";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to index.php
    header("Location: /janes_business/Janes-Business/src/index.php"); 
    exit();
}
?>
