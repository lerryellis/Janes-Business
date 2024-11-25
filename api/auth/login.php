<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "janes_shoes";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from request body
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $conn->real_escape_string($data["username"]);
    $password = $conn->real_escape_string($data["password"]);

    // Query to check if user exists
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        // Get user data
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION['username'] = $row["username"];
        $_SESSION['role'] = $row["role"];

        // Set response data
        $responseData = [
            "success" => true,
            "username" => $row["username"],
            "role" => $row["role"],
            "redirect" => "admin_dashboard.php" // Change to desired redirect URL
        ];

        // Send response
        header("Content-Type: application/json");
        echo json_encode($responseData);
    } else {
        // Set response data
        $responseData = [
            "success" => false,
            "message" => "Invalid username or password"
        ];

        // Send response
        header("Content-Type: application/json");
        echo json_encode($responseData);
    }
}

// Close database connection
$conn->close();
?>
