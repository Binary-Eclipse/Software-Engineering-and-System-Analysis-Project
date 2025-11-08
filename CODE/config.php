<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";

// Create mysqli connection (object oriented)
// $conn will contain the mysqli object OR false/null if connection failed.
$conn = new mysqli($host, $user, $pass, $db);

// The calling file (handle_adoption.php) will check $conn->connect_error,
// which is now possible because we didn't exit the script prematurely.

// Optional: set charset
if ($conn && !$conn->connect_error) {
    $conn->set_charset("utf8mb4");
}

// NOTE: DO NOT place a closing ?> 