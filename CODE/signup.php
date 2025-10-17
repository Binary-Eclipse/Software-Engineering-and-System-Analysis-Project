<?php
// sign_up.php
session_start();
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: sign_up.html");
    exit();
}

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass  = trim($_POST['password'] ?? '');

if ($name === '' || $email === '' || $pass === '') {
    echo "<script>alert('Please fill all fields.'); window.location.href='sign_up.html';</script>";
    exit();
}

// Check if email exists (prepared)
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "<script>alert('Email already registered!'); window.location.href='sign_up.html';</script>";
    $check->close();
    $conn->close();
    exit();
}
$check->close();

// Hash password
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Insert new user (prepared)
$insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
if (!$insert) {
    error_log("Prepare failed: " . $conn->error);
    echo "<script>alert('Server error. Try again later.'); window.location.href='sign_up.html';</script>";
    exit();
}
$insert->bind_param("sss", $name, $email, $hashed_pass);

if ($insert->execute()) {
    echo "<script>alert('Signup Successful! You can now log in.'); window.location.href='log_in.html';</script>";
} else {
    error_log("Insert failed: " . $insert->error);
    echo "<script>alert('Error registering user. Please try again.'); window.location.href='sign_up.html';</script>";
}

$insert->close();
$conn->close();
?>
