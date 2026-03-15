<?php
include 'config.php';
include 'sessionizr.php';
mysqli_report(MYSQLI_REPORT_OFF);

// Filters
$filterType = isset($_GET['type']) ? $_GET['type'] : 'all';
$filterFrom = isset($_GET['from']) ? $_GET['from'] : '';
$filterTo   = isset($_GET['to'])   ? $_GET['to']   : '';

$where = [];
if (in_array($filterType, ['general','event','child_sponsorship'])) {
    $where[] = "donation_type = '{$conn->real_escape_string($filterType)}'";
}
if (!empty($filterFrom)) $where[] = "DATE(donated_at) >= '" . $conn->real_escape_string($filterFrom) . "'";
if (!empty($filterTo))   $where[] = "DATE(donated_at) <= '" . $conn->real_escape_string($filterTo) . "'";
$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Grand totals (unfiltered)
$grandTotal = 0; $generalTotal = 0; $eventTotal = 0; $childTotal = 0; $totalCount = 0;
$r = $conn->query("SELECT COALESCE(SUM(amount),0) AS t, COUNT(*) AS c FROM donations");
if ($r) { $rr = $r->fetch_assoc(); $grandTotal = (float)$rr['t']; $totalCount = (int)$rr['c']; }
$r = $conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM donations WHERE donation_type='general'");
if ($r) $generalTotal = (float)$r->fetch_assoc()['t'];
$r = $conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM donations WHERE donation_type='event'");
if ($r) $eventTotal = (float)$r->fetch_assoc()['t'];
$r = $conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM donations WHERE donation_type='child_sponsorship'");
if ($r) $childTotal = (float)$r->fetch_assoc()['t'];

// Filtered list
$donations = $conn->query("SELECT * FROM donations {$whereSQL} ORDER BY donated_at DESC");

// Monthly chart data (last 6 months)
$chartLabels = []; $chartData = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-{$i} months"));
    $label = date('M Y', strtotime("-{$i} months"));
    $chartLabels[] = $label;
    $rr = $conn->query("SELECT COALESCE(SUM(amount),0) AS t FROM donations WHERE DATE_FORMAT(donated_at,'%Y-%m')='{$month}'");
    $chartData[] = $rr ? (float)$rr->fetch_assoc()['t'] : 0;
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-body">
<div class="container-fluid mt-3">

    <!-- Stat cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><p class="mb-1">Total Raised</p><h3 class="mb-0">$<?= number_format($grandTotal, 2) ?></h3></div>
                        <i class="fa fa-dollar-sign fa-2x opacity-50"></i>
                    </div>
                    <small><?= $totalCount ?> transactions</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background:linear-gradient(135deg,#155724,#28a745);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><p class="mb-1">General Donations</p><h3 class="mb-0">$<?= number_format($generalTotal, 2) ?></h3></div>
                        <i class="fa fa-hand-holding-heart fa-2x opacity-50"></i>
                    </div>
                    <small>Homepage &amp; Navbar</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background:linear-gradient(135deg,#7b2d00,#e65c00);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><p class="mb-1">Event Donations</p><h3 class="mb-0">$<?= number_format($eventTotal, 2) ?></h3></div>
                        <i class="fa fa-calendar-alt fa-2x opacity-50"></i>
                    </div>
                    <small>Per-event contributions</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background:linear-gradient(135deg,#003366,#0066cc);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><p class="mb-1">Child Sponsorships</p><h3 class="mb-0">$<?= number_format($childTotal, 2) ?></h3></div>
                        <i class="fa fa-child fa-2x opacity-50"></i>
                    </div>
                    <small>Monthly child support</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly chart -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h5 class="mb-0"><i class="fa fa-chart-bar mr-2"></i>Monthly Donations (Last 6 Months)</h5></div>
                <div class="card-body"><canvas id="monthlyChart" height="100"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><h5 class="mb-0"><i class="fa fa-chart-pie mr-2"></i>By Type</h5></div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="typeChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter bar -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" action="donations.php" class="form-inline">
                <label class="mr-2"><strong>Filter:</strong></label>
                <select name="type" class="custom-select custom-select-sm mr-2">
                    <option value="all"              <?= $filterType === 'all'               ? 'selected' : '' ?>>All Types</option>
                    <option value="general"          <?= $filterType === 'general'           ? 'selected' : '' ?>>General</option>
                    <option value="event"            <?= $filterType === 'event'             ? 'selected' : '' ?>>Event</option>
                    <option value="child_sponsorship"<?= $filterType === 'child_sponsorship' ? 'selected' : '' ?>>Child Sponsorship</option>
                </select>
                <input type="date" name="from" class="form-control form-control-sm mr-2" value="<?= htmlspecialchars($filterFrom) ?>" placeholder="From">
                <input type="date" name="to"   class="form-control form-control-sm mr-2" value="<?= htmlspecialchars($filterTo) ?>" placeholder="To">
                <button type="submit" class="btn btn-sm btn-dark mr-2"><i class="fa fa-filter"></i> Filter</button>
                <a href="donations.php" class="btn btn-sm btn-outline-secondary">Clear</a>
            </form>
        </div>
    </div>

    <!-- Donations table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fa fa-list mr-2"></i>Donation Records</h5>
            <a href="donations.php?export=1&type=<?= urlencode($filterType) ?>&from=<?= urlencode($filterFrom) ?>&to=<?= urlencode($filterTo) ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-file-csv mr-1"></i>Export CSV</a>
        </div>
        <div class="card-body p-0">
            <div style="overflow-x:auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Donor</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Reference</th>
                            <th>PayPal TXN</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $typeBadge = ['general' => 'badge-success', 'event' => 'badge-warning', 'child_sponsorship' => 'badge-primary'];
                        $typeLabel = ['general' => 'General', 'event' => 'Event', 'child_sponsorship' => 'Sponsorship'];
                        $i = 1;
                        $filteredTotal = 0;
                        while ($donations && $row = $donations->fetch_assoc()):
                            $filteredTotal += (float)$row['amount'];
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= date('d M Y H:i', strtotime($row['donated_at'])) ?></td>
                            <td><?= htmlspecialchars($row['donor_name']) ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($row['donor_email']) ?>"><?= htmlspecialchars($row['donor_email']) ?></a></td>
                            <td><strong>$<?= number_format((float)$row['amount'], 2) ?></strong></td>
                            <td><span class="badge <?= isset($typeBadge[$row['donation_type']]) ? $typeBadge[$row['donation_type']] : 'badge-secondary' ?>"><?= isset($typeLabel[$row['donation_type']]) ? $typeLabel[$row['donation_type']] : $row['donation_type'] ?></span></td>
                            <td><?= htmlspecialchars($row['reference_label'] ?: '—') ?></td>
                            <td><small class="text-monospace"><?= htmlspecialchars($row['paypal_txn_id'] ?: '—') ?></small></td>
                            <td><span class="badge badge-<?= $row['paypal_status'] === 'COMPLETED' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($row['paypal_status']) ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if ($i === 1): ?>
                        <tr><td colspan="9" class="text-center text-muted py-4">No donations found for the selected filters.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if ($i > 1): ?>
                    <tfoot class="thead-dark">
                        <tr>
                            <td colspan="4" class="text-right"><strong>Filtered Total:</strong></td>
                            <td><strong>$<?= number_format($filteredTotal, 2) ?></strong></td>
                            <td colspan="4"></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Monthly bar chart
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [{
            label: 'USD Donated',
            data: <?= json_encode($chartData) ?>,
            backgroundColor: 'rgba(230,92,0,0.7)',
            borderColor: '#e65c00',
            borderWidth: 1,
            borderRadius: 4
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

// Type doughnut
new Chart(document.getElementById('typeChart'), {
    type: 'doughnut',
    data: {
        labels: ['General', 'Event', 'Child Sponsorship'],
        datasets: [{
            data: [<?= $generalTotal ?>, <?= $eventTotal ?>, <?= $childTotal ?>],
            backgroundColor: ['#28a745','#e65c00','#0066cc']
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>

<?php
// CSV export
if (isset($_GET['export'])) {
    // Re-query for export
    $exp = $conn->query("SELECT * FROM donations {$whereSQL} ORDER BY donated_at DESC");
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="gecod_donations_' . date('Ymd') . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID','Date','Donor Name','Donor Email','Amount (USD)','Type','Reference','PayPal TXN','Status']);
    while ($exp && $row = $exp->fetch_assoc()) {
        fputcsv($out, [
            $row['id'], $row['donated_at'], $row['donor_name'], $row['donor_email'],
            $row['amount'], $row['donation_type'], $row['reference_label'],
            $row['paypal_txn_id'], $row['paypal_status']
        ]);
    }
    fclose($out);
    exit;
}
include 'includes/footer.php';
?>
