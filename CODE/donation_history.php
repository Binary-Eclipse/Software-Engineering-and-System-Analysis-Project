<?php
// donation_history.php - This file is included within the main profile.php

// Ensure $conn and $user_email are available from the main file
$user_email_safe = htmlspecialchars($user_email);

// 1. Fetch Donation Data (A real 'donation' table would link to a user somehow, e.g., by user_id or email)
// For this example, assuming a temporary join or a more complex query links it by a user-specific identifier not shown.
// As a placeholder, we select all donations, which is not secure in a real app without a user link!
$sql_donations = "SELECT donation_id, amount, type, donation_date, transaction_id FROM donation LIMIT 10"; // LIMIT for safety
$result_donations = $conn->query($sql_donations);

$donations = $result_donations ? $result_donations->fetch_all(MYSQLI_ASSOC) : [];
?>

<h1><i class="fas fa-hand-holding-heart"></i> Donation History</h1>

<div class="section-card">
    <h3>Your Recent Donations</h3>
    <?php if (empty($donations)): ?>
        <p>You have no donation history yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($donation['donation_id']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($donation['donation_date'])); ?></td>
                        <td>$<?php echo number_format($donation['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars(ucwords($donation['type'])); ?></td>
                        <td>
                            <a href="generate_receipt.php?type=donation&id=<?php echo $donation['donation_id']; ?>" 
                                class="btn" target="_blank" style="padding: 6px 12px; font-size: 0.9rem; background-color: var(--primary-green);">
                                <i class="fas fa-download"></i> Receipt
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>