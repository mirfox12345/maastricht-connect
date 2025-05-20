<?php
session_start();
include 'config.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely retrieve username and password
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if username and password are not empty
    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Successfully logged in
            $_SESSION['username'] = $user['username'];
            $_SESSION['islogin'] = true;
            header("Location: Home.php");  // Redirect to home page
            exit();
        } else {
            echo "Invalid login.";
        }
    } else {
        echo "Please enter both username and password.";
    }
}
?>
