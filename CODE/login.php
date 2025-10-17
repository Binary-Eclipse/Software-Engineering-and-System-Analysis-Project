<?php
// log_in.php
session_start();
include_once "config.php";

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: log_in.html");
    exit();
}

$email = trim($_POST['email'] ?? '');
$pass  = trim($_POST['password'] ?? '');

// Basic validation
if ($email === '' || $pass === '') {
    echo "<script>alert('Please enter email and password.'); window.location.href='log_in.html';</script>";
    exit();
}

// Prepared statement - fetch user by email
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
if (!$stmt) {
    // DB error
    error_log("Prepare failed: " . $conn->error);
    echo "<script>alert('Server error. Try again later.'); window.location.href='log_in.html';</script>";
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $name, $hash);
    $stmt->fetch();

    // Verify password
    if (password_verify($pass, $hash)) {
        // Successful login
        session_regenerate_id(true); // prevent session fixation
        $_SESSION['user_id']   = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['email']     = $email;
        // Optional: set a role if you have one
        // $_SESSION['role'] = 'user';

        header("Location: guest.php"); // change to your protected page
        exit();
    } 
    else {
        // Wrong password
        // Generic message to avoid user enumeration
        echo "<script>alert('Invalid email or password.'); window.location.href='log_in.html';</script>";
        exit();
    }
} 
else {
    // Email not found
    // Generic message to avoid user enumeration
    echo "<script>alert('Invalid email or password.'); window.location.href='log_in.html';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>
