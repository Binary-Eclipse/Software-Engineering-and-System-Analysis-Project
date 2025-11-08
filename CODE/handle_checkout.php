<?php
// handle_checkout.php - Strict Version for JSON Integrity

// Set header first. Ensure NO output precedes this.
header('Content-Type: application/json');

// Immediately suppress all PHP errors and warnings to prevent them from breaking JSON
ini_set('display_errors', 0);
error_reporting(0);

// --- Configuration Embedded Directly ---
$host = "localhost";
$user = "root";
$pass = "";
$db   = "savepaws";

// Create mysqli connection (object oriented)
$conn = new mysqli($host, $user, $pass, $db);

// Defensive connection check
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Get JSON data
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing data.']);
    $conn->close();
    exit();
}

// 1. Extract and Validate Order Data
$customer_name = $data['customer_name'] ?? '';
$shipping_address = $data['shipping_address'] ?? '';
$customer_email = $data['customer_email'] ?? '';
$payment_method = $data['payment_method'] ?? 'Unknown';
$total_amount = $data['total_amount'] ?? 0.00;
$shipping_cost = $data['shipping_cost'] ?? 50.00;
$items = $data['items'] ?? [];

if (empty($customer_name) || empty($shipping_address) || empty($items)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing customer or cart item details.']);
    $conn->close();
    exit();
}

$order_id = null;
$success = false;
$final_message = '';

// --- TRANSACTION START ---
$conn->begin_transaction();

try {
    // 2. Insert into orders table
    $sql_order = "INSERT INTO orders (customer_name, customer_email, shipping_address, total_amount, shipping_cost, payment_method) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    
    if (!$stmt_order) {
        throw new Exception("Order preparation failed: " . $conn->error);
    }
    
    $total_str = (string) number_format($total_amount, 2, '.', '');
    $shipping_str = (string) number_format($shipping_cost, 2, '.', '');
    
    $stmt_order->bind_param("sssdds", 
        $customer_name, 
        $customer_email, 
        $shipping_address, 
        $total_str, 
        $shipping_str, 
        $payment_method
    );

    if (!$stmt_order->execute()) {
        throw new Exception("Order execution failed: " . $stmt_order->error);
    }
    
    $order_id = $conn->insert_id;
    $stmt_order->close();

    // 3. Insert into order_items table
    $sql_item = "INSERT INTO order_items (order_id, product_id, product_name, unit_price, quantity) VALUES (?, ?, ?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);

    if (!$stmt_item) {
        throw new Exception("Order item preparation failed: " . $conn->error);
    }
    
    foreach ($items as $item) {
        $product_id = $item['product_id'];
        $product_name = $item['product_name'];
        $unit_price = $item['unit_price'];
        $quantity = $item['quantity'];

        $price_str = (string) number_format($unit_price, 2, '.', '');
        
        $stmt_item->bind_param("iisdi", $order_id, $product_id, $product_name, $price_str, $quantity);
        
        if (!$stmt_item->execute()) {
            throw new Exception("Item execution failed for product {$product_name}: " . $stmt_item->error);
        }
    }
    
    $stmt_item->close();

    // 4. Commit Transaction
    $conn->commit();
    $success = true;
    
} catch (Exception $e) {
    // 5. Rollback on failure
    $conn->rollback();
    $final_message = "Order transaction failed. Reason: " . $e->getMessage();
}

// 6. Final Response
if ($success) {
    echo json_encode(['success' => true, 'order_id' => $order_id, 'message' => 'Order placed successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $final_message ?? 'An unknown server error occurred.']);
}

$conn->close();
// Ensure NO CLOSING PHP TAG (?>)