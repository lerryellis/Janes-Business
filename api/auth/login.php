<?php
session_start();
include('..//api/auth/db_connection.php');

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$response = ['success' => false, 'message' => 'Invalid credentials'];

if (empty($username) || empty($password)) {
    $response['message'] = 'Please fill in both fields';
    echo json_encode($response);
    exit();
}

// Check if the user exists in the database
$stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && $user['password'] === $password) { // For plaintext password
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin') {
        $response = ['success' => true, 'redirect' => '../../admin_dashboard.php', 'role' => 'admin'];
    } else {
        $response = ['success' => true, 'username' => $user['username']];
    }
} else {
    $response['message'] = 'Incorrect username or password';
}

echo json_encode($response);
$conn->close();
?>
