<?php
// orders_dashboard.php
if (!@require_once "config.php") die('DB config missing!');

// --- FETCH ORDERS ---
$orders = [];
$res_orders = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
if($res_orders && $res_orders->num_rows > 0){
    $orders = $res_orders->fetch_all(MYSQLI_ASSOC);
}

// --- FETCH ORDER ITEMS ---
$order_items = [];
$res_items = $conn->query("SELECT * FROM order_items ORDER BY item_id DESC"); // Correct column name
if($res_items && $res_items->num_rows > 0){
    $order_items = $res_items->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Orders Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f4f4f4; }
    .btn-edit, .btn-delete { padding: 4px 8px; margin-right: 2px; text-decoration: none; color: white; }
    .btn-edit { background-color: #4CAF50; }
    .btn-delete { background-color: #f44336; }
    .section { margin-bottom: 40px; }
    .section-header h3 { margin-bottom: 10px; }
</style>
</head>
<body>

<!-- ORDERS TABLE -->
<div class="section">
    <div class="section-header"><h3>Orders</h3></div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th><th>Name</th><th>Email</th><th>Address</th>
                <th>Total</th><th>Shipping</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
            <tr>
                <td><?= $order['order_id'] ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td><?= htmlspecialchars($order['customer_email']) ?></td>
                <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                <td><?= number_format($order['total_amount'],2) ?></td>
                <td><?= number_format($order['shipping_cost'],2) ?></td>
                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                <td><?= htmlspecialchars($order['order_status']) ?></td>
                <td><?= htmlspecialchars($order['order_date']) ?></td>
                <td>
                    <a href="edit_order.php?order_id=<?= $order['order_id'] ?>" class="btn-edit">Edit</a>
                    <a href="delete_order.php?order_id=<?= $order['order_id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ORDER ITEMS TABLE -->
<div class="section">
    <div class="section-header"><h3>Order Items</h3></div>
    <table>
        <thead>
            <tr>
                <th>Item ID</th><th>Order ID</th><th>Product ID</th>
                <th>Product Name</th><th>Unit Price</th><th>Quantity</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($order_items as $item): ?>
            <tr>
                <td><?= $item['item_id'] ?></td>
                <td><?= $item['order_id'] ?></td>
                <td><?= $item['product_id'] ?></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= number_format($item['unit_price'],2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>
                    <a href="edit_item.php?item_id=<?= $item['item_id'] ?>" class="btn-edit">Edit</a>
                    <a href="delete_item.php?item_id=<?= $item['item_id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
