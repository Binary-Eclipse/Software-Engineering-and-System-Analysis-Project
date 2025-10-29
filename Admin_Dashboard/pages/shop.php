<?php
// Data is already loaded from the main index.php
?>
<div class="chart-container">
    <div class="section">
        <div class="section-header"><h3>Sells Statistic</h3></div>
        <canvas id="salesChart"></canvas>
    </div>
    <div class="section">
        <div class="section-header"><h3>Profit Statistic</h3></div>
        <canvas id="profitChart"></canvas>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <h3>Products Stock List</h3>
        <button class="btn-add-new" ><i class="fas fa-plus"></i> Add New</button>
    </div>
    <div class="table-container">
        <table class="editable-table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Product ID</th>
                    <th>Title</th>
                    <th>Buyed Date</th>
                    <th>Resources</th>
                    <th>Stock</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Sold</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['serial_no']); ?></td>
                    <td data-field="productId"><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td data-field="title"><?php echo htmlspecialchars($product['title']); ?></td>
                    <td data-field="buyDate" data-type="date"><?php echo htmlspecialchars($product['buyed_date']); ?></td>
                    <td data-field="resources">Supplier</td>
                    <td data-field="stock" data-type="number"><?php echo htmlspecialchars($product['stock_quantity']); ?></td>
                    <td data-field="buyPrice" data-type="number">$<?php echo htmlspecialchars($product['buying_price']); ?></td>
                    <td data-field="sellPrice" data-type="number">$<?php echo htmlspecialchars($product['selling_price']); ?></td>
                    <td><?php echo htmlspecialchars($product['sold_quantity']); ?></td>
                    <td><?php echo htmlspecialchars($product['status']); ?></td>
                    <td class="actions">
                        <button class="btn-edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-delete"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <h3>Products Order Status</h3>
        <button class="btn-add-new"><i class="fas fa-plus"></i> Add New</button>
    </div>
    <div class="table-container">
        <table class="editable-table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Product ID</th>
                    <th>Title</th>
                    <th>Order Date</th>
                    <th>Qty</th>
                    <th>Bill</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['serial_no']); ?></td>
                    <td><?php echo htmlspecialchars($order['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['title']); ?></td>
                    <td data-field="orderDate" data-type="date"><?php echo htmlspecialchars($order['order_date']); ?></td>
                    <td data-field="qty" data-type="number"><?php echo htmlspecialchars($order['quantity']); ?></td>
                    <td data-field="bill">$<?php echo htmlspecialchars($order['bill']); ?></td>
                    <td data-field="customerName"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td data-field="email" data-type="email"><?php echo htmlspecialchars($order['email']); ?></td>
                    <td data-field="contact"><?php echo htmlspecialchars($order['contact']); ?></td>
                    <td data-field="location"><?php echo htmlspecialchars($order['location']); ?></td>
                    <td data-field="deliveryStatus"><?php echo htmlspecialchars($order['delivery_status']); ?></td>
                    <td class="actions">
                        <button class="btn-edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-delete"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Chart data from PHP
const salesData = <?php echo json_encode($salesStats); ?>;
const profitData = <?php echo json_encode($profitStats); ?>;

// Initialize charts with real data
document.addEventListener('DOMContentLoaded', function() {
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx && salesData.length > 0) {
        const labels = salesData.map(item => item.month_year);
        const data = salesData.map(item => item.sales_amount);
        
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales Amount ($)',
                    data: data,
                    fill: false,
                    borderColor: '#4a69bd',
                    tension: 0.1
                }]
            }
        });
    }

    const profitCtx = document.getElementById('profitChart');
    if (profitCtx && profitData.length > 0) {
        const labels = profitData.map(item => item.month_year);
        const profit = profitData.map(item => item.profit);
        
        new Chart(profitCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit ($)',
                    data: profit,
                    backgroundColor: '#1e3799'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>