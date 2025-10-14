<?php
session_start();
include_once "php/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "<script>alert('Login successful!'); window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='log_in.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found! Please sign up first.'); window.location.href='sign_up.html';</script>";
    }
}
?>
