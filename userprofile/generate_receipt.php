<?php
// generate_receipt.php - Script for PDF generation and download

// =========================================================================
// !!! IMPORTANT: MANUAL DOMPDF CONFIGURATION !!!
// Change the path below to point to the correct autoloader file.
// =========================================================================
require_once('dompdf/autoload.inc.php'); // <-- THIS IS THE CRITICAL CHANGE

// Include the necessary namespaces
use Dompdf\Dompdf; 
use Dompdf\Options; 

// Assume 'config.php' is in the same directory and contains $conn
include_once "config.php"; 

// ... (The rest of your code)

$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? 0;

if (!in_array($type, ['order', 'donation']) || (int)$id <= 0) {
    die("Invalid request parameters.");
}

$details = [];

// 1. Fetch Data Based on Type
if ($type === 'order') {
    $sql = "SELECT * FROM orders WHERE order_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $details = $result->fetch_assoc();
    $stmt->close();
    $title = "Order Receipt";
    $filename = "Order_Receipt_" . $id . ".pdf";

} elseif ($type === 'donation') {
    $sql = "SELECT * FROM donation WHERE donation_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $details = $result->fetch_assoc();
    $stmt->close();
    $title = "Donation Receipt";
    $filename = "Donation_Receipt_" . $id . ".pdf";
}

if (!$details) {
    die("Record not found.");
}

// 2. Generate PDF Content (HTML Template)
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <style>
        /* Note: Dompdf requires simpler, inline CSS or internal CSS blocks */
        body { font-family: sans-serif; }
        .receipt { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; }
        h1 { color: #3B82F6; border-bottom: 2px solid #3B82F6; padding-bottom: 10px; }
        .detail-row { margin-bottom: 10px; }
        .detail-row span { font-weight: bold; display: inline-block; width: 150px; }
        .total { font-size: 1.2em; font-weight: bold; border-top: 1px solid #ccc; margin-top: 15px; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="receipt">
        <h1>Save Paws - <?php echo $title; ?></h1>
        <p>Date: <?php echo date('F d, Y H:i:s', strtotime($details[$type . '_date'])); ?></p>
        <hr>

        <?php if ($type === 'order'): ?>
            <div class="detail-row"><span>Order ID:</span> #<?php echo htmlspecialchars($details['order_id']); ?></div>
            <div class="detail-row"><span>Customer Name:</span> <?php echo htmlspecialchars($details['customer_name']); ?></div>
            <div class="detail-row"><span>Customer Email:</span> <?php echo htmlspecialchars($details['customer_email']); ?></div>
            <div class="detail-row"><span>Status:</span> <?php echo htmlspecialchars($details['order_status']); ?></div>
            <div class="detail-row"><span>Shipping:</span> $<?php echo number_format($details['shipping_cost'], 2); ?></div>
            <div class="detail-row"><span>Address:</span> <?php echo nl2br(htmlspecialchars($details['shipping_address'])); ?></div>
            <div class="total"><span>Total Paid:</span> $<?php echo number_format($details['total_amount'], 2); ?></div>
        <?php elseif ($type === 'donation'): ?>
            <div class="detail-row"><span>Donation ID:</span> #<?php echo htmlspecialchars($details['donation_id']); ?></div>
            <div class="detail-row"><span>Type:</span> <?php echo htmlspecialchars(ucwords($details['type'])); ?></div>
            <div class="detail-row"><span>Payment Method:</span> <?php echo htmlspecialchars($details['payment_method']); ?></div>
            <div class="detail-row"><span>Transaction ID:</span> <?php echo htmlspecialchars($details['transaction_id']); ?></div>
            <div class="detail-row"><span>Reason:</span> <?php echo nl2br(htmlspecialchars($details['reason'])); ?></div>
            <div class="total"><span>Amount Donated:</span> $<?php echo number_format($details['amount'], 2); ?></div>
        <?php endif; ?>

        <p style="margin-top: 30px; text-align: center; font-size: 0.8em; color: #666;">
            Thank you for your support to Save Paws!
        </p>
    </div>
</body>
</html>
<?php
$html_content = ob_get_clean();

// =========================================================================
// 3. DOMPDF RENDERING AND STREAMING (The new active code)
// =========================================================================

// Configure options (optional, but good practice for remote images/CSS if needed)
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Load HTML to Dompdf
$dompdf->loadHtml($html_content);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (stream to browser)
$dompdf->stream($filename, ["Attachment" => true]);
exit; // Crucial to stop script execution after streaming

// --- The old fallback code has been removed ---
?>