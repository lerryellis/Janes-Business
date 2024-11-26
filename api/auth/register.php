<?php
// Database connection settings
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

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the data is not empty
    if (!empty($data['registerUsername']) && !empty($data['registerEmail']) && !empty($data['registerPhoneNumber']) && !empty($data['registerPassword'])) {
        // Extract the data
        $username = $data['registerUsername'];
        $email = $data['registerEmail'];
        $phoneNumber = $data['registerPhoneNumber'];
        $password = $data['registerPassword'];

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username, email, and phone number are already taken using prepared statements
        $query = "SELECT * FROM users WHERE username = ? OR email = ? OR phone_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Close the prepared statement and connection
            $stmt->close();
            echo json_encode(['success' => false, 'message' => 'Username, email, or phone number is already taken.']);
        } else {
             // Insert into database
        $sql = "INSERT INTO users (username, password, email, role, phone_number) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $hashed_password, $email, $role, $phone_number);

            if ($stmt->execute()) {
                // Close the prepared statement and connection
                $stmt->close();
                echo json_encode(['success' => true, 'message' => 'Registration successful.']);
            } else {
                // Close the prepared statement and connection
                $stmt->close();
                echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
