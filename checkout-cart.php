<?php
ob_start();
if (isset($_POST['submitCart'])) {

    include 'config.php';
    include 'includes/header.php';

    $donormail    = $conn->real_escape_string($_POST['donoremail']);
    $donornames   = $conn->real_escape_string($_POST['donorNames']);
    $validTypes   = ['general', 'event', 'child_sponsorship'];
    $donationType = in_array(isset($_POST['donation_type']) ? $_POST['donation_type'] : '', $validTypes) ? $_POST['donation_type'] : 'general';
    $refLabel     = htmlspecialchars(trim(isset($_POST['reference_label']) ? $_POST['reference_label'] : (isset($_POST['childSponsored']) ? $_POST['childSponsored'] : '')));
    $orphanId     = (int)(isset($_POST['orphan_id']) ? $_POST['orphan_id'] : 0);

    // Determine amount: use custom if "custom" was selected
    if (isset($_POST['customAmount']) && !empty($_POST['customAmount'])) {
        $donationmount = (int)$_POST['customAmount'];
    } else {
        $donationmount = (int)$_POST['amountselected'];
    }

    if ($donationmount < 1) {
        header("Location: index.php");
        exit;
    }
?>

<div class="page-header-orphans">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Complete Your Donation</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a> &rsaquo; <a href="#donate-section">Donate</a> &rsaquo; Checkout
            </div>
        </div>
    </div>
</div>

<!-- Checkout Start -->
<div class="single">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="single-content">
                    <h2>You are one step away from making a difference!</h2>
                    <p>Thank you, <strong><?php echo htmlspecialchars($donornames); ?></strong>.
                    Your donation of <strong>$<?php echo $donationmount; ?> USD</strong> will directly
                    support vulnerable children and families in Uganda.</p>

                    <div class="donate-form">
                        <p><i class="fa fa-user"></i> <strong>Name:</strong> <?php echo htmlspecialchars($donornames); ?></p>
                        <p><i class="fa fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($donormail); ?></p>
                        <p><i class="fa fa-dollar-sign"></i> <strong>Amount:</strong> $<?php echo $donationmount; ?> USD</p>
                    </div>

                    <p class="secure-label"><i class="fa fa-lock"></i> Secure payment via Flutterwave. Cards, bank transfer &amp; mobile money accepted.</p>
                    <button id="flw-pay-btn" class="btn btn-flw btn-block">
                        <i class="fa fa-credit-card"></i> Donate $<?php echo $donationmount; ?> USD Now
                    </button>
                    <div id="flw-result"></div>

                    <p class="mt-3 text-muted small">
                        A confirmation email will be sent to <?php echo htmlspecialchars($donormail); ?> after your donation is processed.
                        Thank you for supporting GECOD Initiative.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h2 class="widget-title">Donation Summary</h2>
                        <div class="text-widget">
                            <table class="table">
                                <tr><th>Donor</th><td><?php echo htmlspecialchars($donornames); ?></td></tr>
                                <tr><th>Email</th><td><?php echo htmlspecialchars($donormail); ?></td></tr>
                                <tr><th>Amount</th><td><strong>$<?php echo $donationmount; ?> USD</strong></td></tr>
                                <tr><th>Organization</th><td>GECOD Initiative, Uganda</td></tr>
                            </table>
                            <div class="impact-note">
                                <i class="fa fa-heart text-danger"></i>
                                Your generosity directly funds orphan support, health outreach, and girls&rsquo; education programs.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other waiting kids -->
            <div class="col-lg-12">
                <div class="single-related">
                    <h2>Children Waiting for Support</h2>
                    <div class="owl-carousel related-slider">
                        <?php
                        $bodmembers = $conn->query("SELECT * FROM gecodorphans");
                        while ($rows = mysqli_fetch_array($bodmembers)) {
                            $ophanid = $rows['orphanid'];
                            $names = $rows['orphanNames'];
                            $info = $rows['orphanInfo'];
                            $img = $rows['orphanImage'];

                            echo '<div class="post-item">
                                <div class="post-img">
                                    <img src="img/beneficiaries/'.htmlspecialchars($img).'" />
                                </div>
                                <div class="post-text">
                                    <a href="vieworphandetails.php?orphanid='.intval($ophanid).'">'.htmlspecialchars($names).'</a>
                                    <div class="post-meta">
                                        <p>Location: <span>Uganda</span></p>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
document.getElementById('flw-pay-btn').addEventListener('click', function() {
    FlutterwaveCheckout({
        public_key: "b918c318-99e6-4b06-a5df-20c21c6854a5",
        tx_ref: "GECOD-" + Date.now(),
        amount: <?php echo $donationmount; ?>,
        currency: "USD",
        payment_options: "card, banktransfer, ussd, mobilemoney",
        customer: {
            email: "<?php echo addslashes(htmlspecialchars($donormail)); ?>",
            name:  "<?php echo addslashes(htmlspecialchars($donornames)); ?>"
        },
        meta: {
            donation_type: "<?php echo addslashes($donationType); ?>",
            reference:     "<?php echo addslashes($refLabel); ?>",
            orphan_id:     <?php echo $orphanId; ?>
        },
        customizations: {
            title:       "GECOD Initiative Donation",
            description: "Supporting vulnerable children and families in Uganda",
            logo:        "https://gecodinitiative.org/img/logo.png"
        },
        callback: function(data) {
            if (data.status === "successful" || data.status === "completed") {
                fetch('save-donation.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        donor_name:      "<?php echo addslashes(htmlspecialchars($donornames)); ?>",
                        donor_email:     "<?php echo addslashes(htmlspecialchars($donormail)); ?>",
                        amount:          <?php echo $donationmount; ?>,
                        txn_id:          data.transaction_id,
                        status:          data.status,
                        type:            "<?php echo addslashes($donationType); ?>",
                        reference_label: "<?php echo addslashes($refLabel); ?>",
                        orphan_id:       <?php echo $orphanId; ?>
                    })
                });
                document.getElementById('flw-result').innerHTML =
                    '<div class="donation-success">' +
                    '<i class="fa fa-check-circle"></i>' +
                    '<h3>Thank you, <?php echo addslashes(htmlspecialchars($donornames)); ?>!</h3>' +
                    '<p>Your donation of <strong>$<?php echo $donationmount; ?> USD</strong> has been received.</p>' +
                    '<p>Transaction ID: ' + data.transaction_id + '</p>' +
                    '<a href="index.php" class="btn btn-custom">Return to Home</a>' +
                    '</div>';
                document.getElementById('flw-pay-btn').style.display = 'none';
            }
        },
        onclose: function() {}
    });
});
</script>

<?php
    include 'includes/footer.php';

} else {
    header("Location: index.php");
    exit;
}
?>
