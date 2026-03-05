<?php
header('Content-Type: application/json');
include 'config.php';
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request']); exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'No data']); exit;
}

$donorName  = $conn->real_escape_string($data['donor_name']      ?? '');
$donorEmail = $conn->real_escape_string($data['donor_email']     ?? '');
$amount     = round((float)($data['amount']                      ?? 0), 2);
$txnId      = $conn->real_escape_string($data['txn_id']          ?? '');
$status     = $conn->real_escape_string($data['status']          ?? 'COMPLETED');
$refLabel   = $conn->real_escape_string($data['reference_label'] ?? '');
$validTypes = ['general', 'event', 'child_sponsorship'];
$type       = in_array($data['type'] ?? '', $validTypes) ? $data['type'] : 'general';

if ($amount <= 0 || empty($txnId)) {
    echo json_encode(['success' => false, 'error' => 'Invalid amount or transaction']); exit;
}

// Insert into unified donations table
$conn->query("INSERT INTO donations
    (donor_name, donor_email, amount, currency, donation_type, reference_label, paypal_txn_id, paypal_status, donated_at)
    VALUES
    ('{$donorName}', '{$donorEmail}', {$amount}, 'USD', '{$type}', '{$refLabel}', '{$txnId}', '{$status}', NOW())");

// If child sponsorship, also record in paypalsponsors for existing audit
if ($type === 'child_sponsorship' && !empty($data['orphan_id'])) {
    $orphanId = (int)$data['orphan_id'];
    $conn->query("INSERT INTO paypalsponsors
        (orphanid, donor_name, amountSponsored, currency, payment_id, paymentDate)
        VALUES
        ({$orphanId}, '{$donorName}', {$amount}, 'USD', '{$txnId}', NOW())");
}

echo json_encode(['success' => true]);
?>
