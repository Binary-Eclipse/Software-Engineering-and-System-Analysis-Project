<?php
session_start();
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($pass, $user['password'])) {
            // Store session info
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Redirect to home page
            header("Location:guest.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='log_in.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email not found! Please sign up first.'); window.location.href='sign_up.html';</script>";
        exit();
    }
}
?>
