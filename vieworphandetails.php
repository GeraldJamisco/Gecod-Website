<?php
include 'config.php';
include 'includes/header.php';

if (isset($_GET['orphanid'])) {
    $orphanid = $conn->real_escape_string($_GET['orphanid']);
    $orphandetails = $conn->query("SELECT * FROM gecodorphans WHERE orphanid='$orphanid'");

    if (!$orphandetails || mysqli_num_rows($orphandetails) === 0) {
        echo "<script>window.location.href='Orphans.php';</script>";
        exit;
    }

    $mydetails   = $orphandetails->fetch_assoc();
    $childName   = htmlspecialchars($mydetails['orphanNames']);
    $childInfo   = htmlspecialchars($mydetails['orphanInfo']);
    $childImg    = htmlspecialchars($mydetails['orphanImage']);
    $childBday   = $mydetails['orphanBirthday'];
    $childGender = htmlspecialchars($mydetails['orphanGender']);

    // Calculate age
    $age = '';
    if (!empty($childBday)) {
        try {
            $dob = new DateTime($childBday);
            $now = new DateTime();
            $age = $dob->diff($now)->y;
        } catch (Exception $e) { $age = ''; }
    }

    // Extract first sentence as a personal quote
    $sentences = preg_split('/(?<=[.!?])\s+/', $childInfo, 2);
    $quote = !empty($sentences[0]) ? $sentences[0] : $childInfo;

    // Social share URLs
    $pageUrl    = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    $shareText  = urlencode("Help sponsor {$childName}'s education at GECOD Initiative Uganda! Just \$38/month changes a life.");
    $fbShare    = "https://www.facebook.com/sharer/sharer.php?u={$pageUrl}";
    $twShare    = "https://twitter.com/intent/tweet?text={$shareText}&url={$pageUrl}";
    $waShare    = "https://api.whatsapp.com/send?text={$shareText}%20{$pageUrl}";
?>

<div class="page-header-orphans">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Sponsor a Child</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="Orphans.php">Beneficiaries</a>
                <a href="#"><?php echo $childName; ?></a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Child Profile Start -->
<div class="single">
    <div class="container">
        <div class="row">

            <!-- LEFT: Photo + Quote + Share -->
            <div class="col-lg-6">
                <div class="single-content child-profile-left">
                    <div class="child-photo-wrap">
                        <img src="img/beneficiaries/<?php echo $childImg; ?>" alt="<?php echo $childName; ?>">
                    </div>

                    <?php if (!empty($quote)): ?>
                    <div class="child-quote-block">
                        <i class="fa fa-quote-left"></i>
                        <p><?php echo $quote; ?></p>
                        <span class="quote-author">&mdash; <?php echo $childName; ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="share-section">
                        <p class="share-label"><i class="fa fa-share-alt"></i> Help <?php echo $childName; ?> find a sponsor &mdash; share their story:</p>
                        <div class="share-btns">
                            <a href="<?php echo $fbShare; ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-fb">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="<?php echo $twShare; ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-tw">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="<?php echo $waShare; ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-wa">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Details + Sponsorship -->
            <div class="col-lg-6">
                <div class="sidebar">

                    <!-- Child Details -->
                    <div class="sidebar-widget">
                        <h2 class="widget-title">About <?php echo $childName; ?></h2>
                        <div class="child-details-list">
                            <div class="child-detail-row">
                                <i class="fa fa-user"></i>
                                <span><strong>Name:</strong> <?php echo $childName; ?></span>
                            </div>
                            <?php if (!empty($age)): ?>
                            <div class="child-detail-row">
                                <i class="fa fa-birthday-cake"></i>
                                <span><strong>Age:</strong> <?php echo $age; ?> years old</span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($childGender)): ?>
                            <div class="child-detail-row">
                                <i class="fa fa-child"></i>
                                <span><strong>Gender:</strong> <?php echo $childGender; ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="child-detail-row">
                                <i class="fa fa-map-marker-alt"></i>
                                <span><strong>Location:</strong> Lyantonde, Uganda</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sponsorship Status -->
                    <div class="sidebar-widget sponsor-status-widget">
                        <h2 class="widget-title">Sponsorship Status</h2>
                        <div class="sponsor-status-content">
                            <div class="sponsor-status-label">
                                <span class="status-badge-awaiting"><i class="fa fa-clock"></i> Awaiting First Sponsor</span>
                                <span class="status-count">0 of 1 needed</span>
                            </div>
                            <div class="sponsor-progress-bar">
                                <div class="sponsor-progress-fill" style="width: 0%;"></div>
                            </div>
                            <p class="sponsor-urgency">
                                <i class="fa fa-exclamation-circle"></i>
                                <?php echo $childName; ?> is still waiting. Be the first to change their life.
                            </p>
                        </div>
                    </div>

                    <!-- What $38/month covers -->
                    <div class="sidebar-widget covers-widget">
                        <h2 class="widget-title">What Your <span class="cost-highlight">$38 / month</span> Covers</h2>
                        <ul class="covers-list">
                            <li><i class="fa fa-graduation-cap"></i> School fees &amp; stationery</li>
                            <li><i class="fa fa-utensils"></i> Three nutritious meals daily</li>
                            <li><i class="fa fa-heartbeat"></i> Medical care &amp; health checkups</li>
                            <li><i class="fa fa-tshirt"></i> Clothing &amp; personal hygiene items</li>
                            <li><i class="fa fa-book"></i> Learning materials &amp; tutoring support</li>
                            <li><i class="fa fa-shield-alt"></i> Safe shelter &amp; protection</li>
                        </ul>
                        <p class="covers-note">
                            <i class="fa fa-check-circle"></i> 100% of your sponsorship goes directly to the child.
                        </p>
                    </div>

                    <!-- Sponsor CTA Button -->
                    <button class="btn-sponsor-main" data-toggle="modal" data-target="#sponsorModal">
                        <i class="fa fa-heart"></i> Sponsor <?php echo $childName; ?> &mdash; $38 / month
                    </button>

                </div>
            </div>
        </div>

        <!-- Other Waiting Kids Carousel -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="single-related">
                    <h2>Other Children Also Waiting</h2>
                    <div class="owl-carousel related-slider">
                        <?php
                        $orphandetailswaiting = $conn->query("SELECT * FROM gecodorphans");
                        while ($rows = mysqli_fetch_array($orphandetailswaiting)) {
                            $wNames  = htmlspecialchars($rows['orphanNames']);
                            $wImg    = htmlspecialchars($rows['orphanImage']);
                            $wGender = htmlspecialchars($rows['orphanGender']);
                            $wId     = htmlspecialchars($rows['orphanid']);
                            echo '<div class="post-item">
                                <a href="vieworphandetails.php?orphanid=' . $wId . '">
                                    <div class="post-img">
                                        <img src="img/beneficiaries/' . $wImg . '" alt="' . $wNames . '">
                                    </div>
                                    <div class="post-text">
                                        <a href="vieworphandetails.php?orphanid=' . $wId . '">' . $wNames . '</a>
                                        <div class="post-meta">
                                            <p>' . $wGender . '</p>
                                            <p>Lyantonde, Uganda</p>
                                        </div>
                                    </div>
                                </a>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Child Profile End -->

<!-- Sponsor Modal -->
<div class="modal fade" id="sponsorModal" tabindex="-1" role="dialog" aria-labelledby="sponsorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content sponsor-modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sponsorModalLabel">
                    <i class="fa fa-heart text-danger"></i> Sponsor <?php echo $childName; ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="checkout-cart.php" method="POST">
                <div class="modal-body">
                    <p class="sponsor-modal-intro">
                        You&rsquo;re about to change <strong><?php echo $childName; ?>&rsquo;s</strong> life with just
                        <strong>$38 / month</strong>. Fill in your details below to proceed to secure payment.
                    </p>
                    <div class="form-group">
                        <label>Your Full Name</label>
                        <input type="text" class="form-control" name="donorNames" placeholder="e.g. John Smith" required>
                    </div>
                    <div class="form-group">
                        <label>Your Email Address</label>
                        <input type="email" class="form-control" name="donoremail" placeholder="e.g. john@email.com" required>
                    </div>
                    <input type="hidden" name="amountselected" value="38">
                    <input type="hidden" name="childSponsored" value="<?php echo $childName; ?>">
                    <p class="small text-muted mt-2">
                        <i class="fa fa-lock"></i> Secure payment processed via PayPal. All major cards accepted.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submitCart" class="btn-sponsor-submit">
                        <i class="fa fa-credit-card"></i> Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    echo "<script type='text/javascript'> window.location.href='Orphans.php';</script>";
}

include 'includes/footer.php';
?>
