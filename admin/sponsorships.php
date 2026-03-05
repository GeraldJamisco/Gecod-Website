<?php
include 'config.php';
include 'sessionizr.php';

mysqli_report(MYSQLI_REPORT_OFF); // prevent exceptions on failed queries

// Grand total across all children
$grandTotal = '0.00';
$totalTxns  = 0;
$r = $conn->query("SELECT COALESCE(SUM(amountSponsored),0) AS grand, COUNT(recordid) AS txns FROM paypalsponsors");
if ($r) {
    $totRow     = $r->fetch_assoc();
    $grandTotal = number_format((float)$totRow['grand'], 2);
    $totalTxns  = (int)$totRow['txns'];
}

// Per-child summary via view
$summary = $conn->query("SELECT * FROM child_sponsorship_summary ORDER BY total_received DESC");

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-body">
    <div class="container-fluid mt-3">

        <!-- Page title -->
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sponsorship Audit</li>
                </ol>
            </div>
        </div>

        <!-- Grand-total cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-sm-6">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Raised (USD)</h3>
                        <h2 class="text-white">$<?php echo $grandTotal; ?></h2>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-dollar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Transactions</h3>
                        <h2 class="text-white"><?php echo $totalTxns; ?></h2>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-exchange"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Children Sponsored</h3>
                        <h2 class="text-white"><?php
                            $sr = $conn->query("SELECT COUNT(DISTINCT orphanid) AS c FROM paypalsponsors WHERE amountSponsored > 0");
                            echo $sr ? (int)$sr->fetch_assoc()['c'] : 0;
                        ?></h2>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-child"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Per-child summary table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="d-inline">Sponsorship by Beneficiary</h4>
                        <p class="text-muted">Money received per child through the website. Click a row to see individual transactions.</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="sponsorTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Child Name</th>
                                        <th>Gender</th>
                                        <th>Total Received (USD)</th>
                                        <th>No. of Payments</th>
                                        <th>Last Payment</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $x = 1;
                                while ($summary && $row = $summary->fetch_assoc()):
                                    $orphId    = htmlspecialchars($row['orphanid'],   ENT_QUOTES);
                                    $orphName  = htmlspecialchars($row['orphanNames'],ENT_QUOTES);
                                    $orphGend  = htmlspecialchars($row['orphanGender'],ENT_QUOTES);
                                    $orphImg   = htmlspecialchars($row['orphanImage'], ENT_QUOTES);
                                    $total     = number_format((float)$row['total_received'], 2);
                                    $numTxns   = (int)$row['num_transactions'];
                                    $lastPay   = $row['last_payment_date'] ? date('d M Y', strtotime($row['last_payment_date'])) : '—';
                                    $hasAmount = (float)$row['total_received'] > 0;
                                ?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td>
                                        <img src="../img/beneficiaries/<?php echo $orphImg; ?>"
                                             style="width:50px;height:50px;object-fit:cover;border-radius:50%;" alt="">
                                    </td>
                                    <td><?php echo $orphName; ?></td>
                                    <td><?php echo $orphGend; ?></td>
                                    <td>
                                        <strong class="<?php echo $hasAmount ? 'text-success' : 'text-muted'; ?>">
                                            $<?php echo $total; ?>
                                        </strong>
                                    </td>
                                    <td><?php echo $numTxns; ?></td>
                                    <td><?php echo $lastPay; ?></td>
                                    <td>
                                        <?php if ($hasAmount): ?>
                                        <button class="btn btn-info btn-sm"
                                                data-toggle="modal"
                                                data-target="#txnModal"
                                                data-orphid="<?php echo $orphId; ?>"
                                                data-orphname="<?php echo $orphName; ?>"
                                                onclick="loadTxns(this)">
                                            View Payments
                                        </button>
                                        <?php else: ?>
                                        <span class="text-muted">No payments yet</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right"><strong>Grand Total</strong></th>
                                        <th><strong class="text-success">$<?php echo $grandTotal; ?></strong></th>
                                        <th><?php echo $totalTxns; ?></th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /container-fluid -->
</div><!-- /content-body -->


<!-- Individual Transactions Modal -->
<div class="modal fade" id="txnModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="txnModalTitle">Payment History</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="txnModalBody">
                <p class="text-center text-muted">Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function loadTxns(btn) {
    var orphId   = btn.dataset.orphid;
    var orphName = btn.dataset.orphname;

    document.getElementById('txnModalTitle').textContent = 'Payment History — ' + orphName;
    document.getElementById('txnModalBody').innerHTML    = '<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</p>';

    fetch('get_sponsortxns.php?orphanid=' + encodeURIComponent(orphId))
        .then(function(r){ return r.text(); })
        .then(function(html){ document.getElementById('txnModalBody').innerHTML = html; })
        .catch(function(){ document.getElementById('txnModalBody').innerHTML = '<p class="text-danger">Failed to load transactions.</p>'; });
}
</script>

<?php include 'includes/footer.php'; ?>
