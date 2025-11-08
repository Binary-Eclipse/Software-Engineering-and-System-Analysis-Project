<?php
header('Content-Type: application/json');

// config.php content (for connection)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";

// Create mysqli connection (object oriented)
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB_CONNECTION_FAILED', 'message' => "Database Connection Failed: " . $conn->connect_error]);
    exit();
}
$conn->set_charset("utf8mb4");

// 1. Get JSON data from the AJAX request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'INVALID_REQUEST', 'message' => 'Invalid request method or missing data.']);
    exit();
}

// 2. Extract and sanitize inputs
// Use JSON_ENCODE on the array for the JSON column type in the database
$selected_services_json = json_encode($data['selected_services'] ?? []);
$client_name = $conn->real_escape_string($data['client_name'] ?? '');
$pet_names = $conn->real_escape_string($data['pet_names'] ?? '');
$client_email = $conn->real_escape_string($data['client_email'] ?? '');
$client_phone = $conn->real_escape_string($data['client_phone'] ?? '');
$pet_type = $conn->real_escape_string($data['pet_type'] ?? '');
$pet_breed = $conn->real_escape_string($data['pet_breed'] ?? '');
$service_location = $conn->real_escape_string($data['service_location'] ?? '');
$help_description = $conn->real_escape_string($data['help_description'] ?? '');

// Simple validation for required fields
if (empty($selected_services_json) || empty($client_name) || empty($pet_names) || empty($client_email) || empty($client_phone) || empty($pet_type) || empty($service_location)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'MISSING_FIELDS', 'message' => 'Required fields are missing.']);
    exit();
}

// 3. Prepare and Execute SQL statement
$sql = "INSERT INTO service_requests (selected_services, client_name, pet_names, client_email, client_phone, pet_type, pet_breed, service_location, help_description) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'SQL_PREPARE_FAILED', 'message' => 'SQL prepare failed: ' . $conn->error]);
    $conn->close();
    exit();
}

// Bind parameters
$stmt->bind_param("sssssssss", 
    $selected_services_json, 
    $client_name, 
    $pet_names, 
    $client_email, 
    $client_phone, 
    $pet_type, 
    $pet_breed, 
    $service_location, 
    $help_description
);

if ($stmt->execute()) {
    // Success response: The client-side will proceed to the payment modal upon receiving this.
    echo json_encode(['success' => true, 'message' => 'Service request saved!', 'request_id' => $conn->insert_id]);
} else {
    // Failure response
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'SQL_EXECUTION_FAILED', 'message' => 'Error saving service request: ' . $stmt->error]);
}

// 4. Close statement and connection
$stmt->close();
$conn->close();
?>