<?php
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='sign_up.html';</script>";
        exit();
    }

    // Hash the password
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_pass')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Signup Successful! You can now log in.'); window.location.href='log_in.html';</script>";
        exit();
    } else {
        echo "<script>alert('Error registering user. Please try again.'); window.location.href='sign_up.html';</script>";
        exit();
    }
}
?>
