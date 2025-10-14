<?php
$host = "localhost"; // your server
$user = "root";      // default username in XAMPP
$pass = "";           // default password (empty)
$db   = "savepaws";  // your database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
