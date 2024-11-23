<?php
require_once '../config/database.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the data is not empty
    if (!empty($data)) {
        // Extract the data
        $username = $data['registerUsername'];
        $email = $data['registerEmail'];
        $phoneNumber = $data['registerPhoneNumber'];
        $password = $data['registerPassword'];

        // Check if the username, email, and phone number are already taken
        $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' OR phone_number = '$phoneNumber'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Username, email, or phone number is already taken.']);
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user data into the database
            $query = "INSERT INTO users (username, email, phone_number, password) VALUES ('$username', '$email', '$phoneNumber', '$hashedPassword')";
            $result = $conn->query($query);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Registration successful.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Registration failed.']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>