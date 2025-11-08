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

// 2. Validate and sanitize inputs
$doctor_name = $conn->real_escape_string($data['doctorName'] ?? '');
$doctor_specialty = $conn->real_escape_string($data['doctorSpecialty'] ?? '');
$appointment_date = $conn->real_escape_string($data['appointmentDate'] ?? '');
$appointment_time = $conn->real_escape_string($data['appointmentTime'] ?? ''); // HH:MM:SS format
$patient_name = $conn->real_escape_string($data['patientName'] ?? '');
$contact_number = $conn->real_escape_string($data['contactNumber'] ?? '');
$owner_email = $conn->real_escape_string($data['email'] ?? '');
$owner_nid = $conn->real_escape_string($data['nidNumber'] ?? '');
$reason_for_visit = $conn->real_escape_string($data['problemDescription'] ?? '');

// Simple validation for required fields
if (empty($doctor_name) || empty($appointment_date) || empty($appointment_time) || empty($patient_name) || empty($contact_number) || empty($reason_for_visit)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'MISSING_FIELDS', 'message' => 'Required appointment and patient details are missing.']);
    exit();
}

// 3. Prepare and Execute SQL statement
$sql = "INSERT INTO doctor_appointments (doctor_name, doctor_specialty, appointment_date, appointment_time, patient_name, contact_number, owner_email, owner_nid, reason_for_visit) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'SQL_PREPARE_FAILED', 'message' => 'SQL prepare failed: ' . $conn->error]);
    $conn->close();
    exit();
}

// Bind parameters (s=string, i=integer, d=double, b=blob)
// All fields are treated as strings for simplicity and VARCHAR/TEXT types
$stmt->bind_param("sssssssss", 
    $doctor_name, 
    $doctor_specialty, 
    $appointment_date, 
    $appointment_time, 
    $patient_name, 
    $contact_number, 
    $owner_email, 
    $owner_nid, 
    $reason_for_visit
);

if ($stmt->execute()) {
    // Success response
    echo json_encode(['success' => true, 'message' => 'Appointment successfully booked!', 'appointment_id' => $conn->insert_id]);
} else {
    // Failure response
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'SQL_EXECUTION_FAILED', 'message' => 'Error booking appointment: ' . $stmt->error]);
}

// 4. Close statement and connection
$stmt->close();
$conn->close();
?>