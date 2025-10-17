<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";

// Create mysqli connection (object oriented)
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");
?>
