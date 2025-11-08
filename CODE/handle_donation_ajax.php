<?php
header('Content-Type: application/json');

// Ensure config.php provides the active $conn object
include_once "config.php";

// 1. Check the existing global connection
if (!isset($conn) || $conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    $conn->close();
    exit();
}

// 2. Extract Data from POST
$amount = (float)($_POST["amount_final"] ?? 0); // Amount determined in JS
$type = $_POST["type"] ?? null;
$reason = $_POST["reason"] ?? null;

// Final validation
if (!is_numeric($amount) || $amount <= 0 || $type === null) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid amount or donation type received.']);
    $conn->close();
    exit();
}

// 3. Insert into database using prepared statement
$stmt=$conn->prepare("INSERT INTO donation(amount,type,reason) VALUES (?, ?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => "DB Prepare failed: " . $conn->error]);
    $conn->close();
    exit();
}

// 'd' for DECIMAL/double, 's' for string, 's' for string
$stmt->bind_param("dss", $amount, $type, $reason); 

if($stmt->execute()){
    // Success: Return clean JSON
    echo json_encode(['success' => true, 'message' => 'Donation recorded successfully.']);
} else {
    // Failure: Return SQL error
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => "SQL Execute failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
// NO CLOSING PHP TAG