<?php
ob_start();
if (isset($_POST['submitCart'])) {

    include 'config.php';
    include 'includes/header.php';

    $donormail = $conn->real_escape_string($_POST['donoremail']);
    $donornames = $conn->real_escape_string($_POST['donorNames']);

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

                    <div class="paypal-section">
                        <p class="secure-label"><i class="fa fa-lock"></i> Secure payment via PayPal. All major cards accepted.</p>
                        <div id="paypal-button-container"></div>
                    </div>

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

<script>
(function() {
    var donationAmount = <?php echo $donationmount; ?>;
    var donorEmail = '<?php echo addslashes(htmlspecialchars($donormail)); ?>';
    var donorName = '<?php echo addslashes(htmlspecialchars($donornames)); ?>';

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: donationAmount.toFixed(2),
                        currency_code: 'USD'
                    },
                    description: 'Donation to GECOD Initiative - Supporting vulnerable children in Uganda'
                }],
                payer: {
                    email_address: donorEmail,
                    name: {
                        given_name: donorName
                    }
                }
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                document.getElementById('paypal-button-container').innerHTML =
                    '<div class="donation-success">' +
                    '<i class="fa fa-check-circle"></i>' +
                    '<h3>Thank you, ' + details.payer.name.given_name + '!</h3>' +
                    '<p>Your donation of <strong>$' + donationAmount + ' USD</strong> has been received. ' +
                    'A confirmation has been sent to <strong>' + donorEmail + '</strong>.</p>' +
                    '<p>Transaction ID: ' + details.id + '</p>' +
                    '<a href="index.php" class="btn btn-custom">Return to Home</a>' +
                    '</div>';
            });
        },
        onError: function(err) {
            document.getElementById('paypal-button-container').innerHTML =
                '<div class="donation-error">' +
                '<i class="fa fa-exclamation-circle"></i>' +
                '<p>Payment could not be processed. Please try again or contact us at info@gecodinitiative.org</p>' +
                '<a href="index.php#donate-section" class="btn btn-custom">Try Again</a>' +
                '</div>';
        },
        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'donate'
        }
    }).render('#paypal-button-container');
})();
</script>

<?php
    include 'includes/footer.php';

} else {
    header("Location: index.php");
    exit;
}
?>
