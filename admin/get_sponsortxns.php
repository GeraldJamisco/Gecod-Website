<?php
include 'config.php';
include 'sessionizr.php';

$orphId = $conn->real_escape_string($_GET['orphanid'] ?? '');

if ($orphId === '') {
    echo '<p class="text-danger">Invalid request.</p>';
    exit;
}

$res = $conn->query(
    "SELECT donor_name, amountSponsored, currency, payment_id, paymentDate
     FROM paypalsponsors
     WHERE orphanid='$orphId'
     ORDER BY paymentDate DESC, recordid DESC"
);

if (!$res || $res->num_rows === 0) {
    echo '<p class="text-muted text-center">No payment records found for this child.</p>';
    exit;
}
?>
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Donor Name</th>
                <th>Amount (USD)</th>
                <th>PayPal Transaction ID</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $x = 1;
        $runningTotal = 0;
        while ($row = $res->fetch_assoc()):
            $donor  = htmlspecialchars($row['donor_name']      ?? 'Anonymous', ENT_QUOTES);
            $amount = number_format((float)$row['amountSponsored'], 2);
            $txnId  = htmlspecialchars($row['payment_id']      ?? '—', ENT_QUOTES);
            $date   = $row['paymentDate'] ? date('d M Y', strtotime($row['paymentDate'])) : '—';
            $runningTotal += (float)$row['amountSponsored'];
        ?>
            <tr>
                <td><?php echo $x++; ?></td>
                <td><?php echo $donor; ?></td>
                <td><strong class="text-success">$<?php echo $amount; ?></strong></td>
                <td><small class="text-muted"><?php echo $txnId ?: '—'; ?></small></td>
                <td><?php echo $date; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr class="table-success">
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>$<?php echo number_format($runningTotal, 2); ?></strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</div>
