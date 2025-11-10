<?php
// order_history.php - This file is included within the main profile.php

// 1. Prepare the email for security and consistency
$user_email_safe = $user_email; 

// 2. SQL to fetch data based on customer_email
$sql_orders = "SELECT order_id, total_amount, order_status, order_date, customer_name 
               FROM orders 
               WHERE customer_email = ?";

// 3. Prepare the statement
$stmt = $conn->prepare($sql_orders);

// Check if preparation was successful
if (!$stmt) {
    // Log the error internally, but display a safe message to the user
    error_log("SQL Prepare Error: " . $conn->error);
    $orders = [];
} else {
    // 4. Bind and execute
    $stmt->bind_param("s", $user_email_safe); 
    
    if (!$stmt->execute()) {
        error_log("SQL Execute Error: " . $stmt->error);
        $orders = [];
    } else {
        // 5. Fetch results
        $result_orders = $stmt->get_result();
        $orders = $result_orders->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
?>

<h1><i class="fas fa-box"></i> Order History</h1>

<div class="section-card">
    <h3>Your Recent Orders</h3>
    <?php if (empty($orders)): ?>
        <p>You have no order history yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td>
                            <?php
                                // Logic to determine status badge class based on the order_status field
                                $status = strtolower($order['order_status']);
                                $badge_class = 'status-pending'; 
                                
                                if ($status === 'delivered' || $status === 'completed') {
                                    $badge_class = 'status-delivered'; // Green
                                } elseif ($status === 'paid') {
                                    $badge_class = 'status-paid'; // Blue
                                }
                            ?>
                            <span class="status-badge <?= $badge_class; ?>">
                                <?php echo htmlspecialchars($order['order_status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="generate_receipt.php?type=order&id=<?php echo $order['order_id']; ?>" 
                                class="btn" target="_blank" style="padding: 6px 12px; font-size: 0.9rem;">
                                <i class="fas fa-download"></i> Receipt
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>