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
    $password = $data["password"]; // No escaping needed here, since it's used with password_verify later.

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
        if (password_verify($password, $row["password"])) {
            // Set session variables
            $_SESSION['username'] = $row["username"];
            $_SESSION['role'] = $row["role"];

            // Set response data
            $responseData = [
                "success" => true,
                "username" => $row["username"],
                "role" => $row["role"],
                "redirect" => $row["role"] === "admin" ? "admin_dashboard.php" : "user_dashboard.php" // Role-based redirect
            ];
        } else {
            // Invalid password
            $responseData = [
                "success" => false,
                "message" => "Invalid username or password"
            ];
        }
    } else {
        // User not found
        $responseData = [
            "success" => false,
            "message" => "Invalid username or password"
        ];
    }

    // Send response
    header("Content-Type: application/json");
    echo json_encode($responseData);

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
