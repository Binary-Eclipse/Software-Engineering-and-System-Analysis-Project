<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savepaws";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize input
$date_incident = $_POST['date_incident'] ?? '';
$type_incident = $_POST['type_incident'] ?? '';
$incident_address = $_POST['incident_address'] ?? '';
$city = $_POST['abuse_city'] ?? '';
$state = $_POST['abuse_state'] ?? '';
$zip_code = $_POST['abuse_zip'] ?? '';
$detailed_description = $_POST['detailed_description'] ?? '';
$reporter_name = $_POST['abuse_name'] ?? null;
$reporter_email = $_POST['abuse_email'] ?? null;

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO abuse_reports (date_incident, type_incident, incident_address, city, state, zip_code, detailed_description, reporter_name, reporter_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssssssss",
    $date_incident,
    $type_incident,
    $incident_address,
    $city,
    $state,
    $zip_code,
    $detailed_description,
    $reporter_name,
    $reporter_email
);

// Execute
if ($stmt->execute()) {
    echo "<script>alert('Report submitted successfully!'); window.location.href='rescue.html';</script>";
} else {
    echo "<script>alert('Error: Could not submit report.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
