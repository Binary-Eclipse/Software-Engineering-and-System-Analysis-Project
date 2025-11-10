<?php
// handle_donation_ajax.php - Handles the actual database insertion for donations
session_start();

include_once "config.php"; // Assumes $conn is established here

// Initialize session status variables
$_SESSION['donation_status'] = 'error_validation';
$_SESSION['donation_message'] = 'An unknown error occurred during submission.';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['donation_message'] = 'Invalid request method.';
    header("Location: donation.php");
    exit();
}

// --- 1. Collect and Sanitize Donation Data ---
$final_amount = filter_input(INPUT_POST, 'amount_final', FILTER_VALIDATE_FLOAT);
$donation_type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$donor_email = filter_input(INPUT_POST, 'donor_email', FILTER_SANITIZE_EMAIL); // NEW FIELD

// --- 2. Collect and Sanitize Payment Data (SIMULATED from POST) ---
$payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'Card';
$transaction_id = 'SP' . time() . rand(1000, 9999); 
$cardholder_name = filter_input(INPUT_POST, 'cardholder_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'Anonymous Donor';
$card_full_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_NUMBER_INT); 
$card_last_four = substr($card_full_number, -4) ?: NULL;


// --- 3. Basic Validation Checks ---
if ($final_amount === false || $final_amount <= 0) {
    $_SESSION['donation_message'] = 'Invalid or missing donation amount.';
    header("Location: donation.php");
    exit();
}

if (!filter_var($donor_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['donation_message'] = 'Please enter a valid donor email address.';
    header("Location: donation.php");
    exit();
}

// --- 4. Database Insertion Logic ---
if ($conn->connect_error) {
    $_SESSION['donation_status'] = 'error_connection';
    $_SESSION['donation_message'] = 'Database connection failed: ' . $conn->connect_error;
    header("Location: donation.php");
    exit();
}

// Updated SQL statement with the new 'donor_email' field
$sql = "INSERT INTO donation (donor_email, amount, type, reason, payment_method, transaction_id, cardholder_name, card_number_last_four) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters: s=string (donor_email), d=decimal, ssssss=string...
    $stmt->bind_param("sdssssss", 
        $donor_email,         // 1. Donor Email
        $final_amount,        // 2. Amount
        $donation_type,       // 3. Type
        $reason,              // 4. Reason
        $payment_method,      // 5. Payment Method
        $transaction_id,      // 6. Transaction ID
        $cardholder_name,     // 7. Cardholder Name
        $card_last_four       // 8. Card Last Four
    );

    if ($stmt->execute()) {
        // Success
        $_SESSION['donation_status'] = 'success';
        $_SESSION['donation_message'] = 'Thank you! Your donation of ৳' . number_format($final_amount, 2) . ' (Txn ID: ' . $transaction_id . ') was recorded.';
    } else {
        // Database execution error
        $_SESSION['donation_status'] = 'error_db_execute';
        $_SESSION['donation_message'] = 'Database error: Could not execute the statement. Error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    // Statement preparation error
    $_SESSION['donation_status'] = 'error_prepare';
    $_SESSION['donation_message'] = 'Database error: Could not prepare the statement. Error: ' . $conn->error;
}

$conn->close();

// Redirect back to donation.php to display the result (toast)
header("Location: donation.php");
exit();
?>