<?php
include 'config.php';
$pageTitle    = 'Our Beneficiaries | Sponsor a Child in Uganda | GECOD Initiative';
$pageDesc     = 'Meet GECOD Initiative\'s beneficiaries — orphans and vulnerable children in Uganda who need your support. Sponsor a child today and help transform their future.';
$pageKeywords = 'sponsor a child Uganda, orphan support Uganda, GECOD beneficiaries, child sponsorship Uganda, vulnerable children Uganda, orphanage Uganda';
include 'includes/header.php';
?>

<div class="page-header-orphans">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Beneficiaries</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="Orphans.php">Orphans &amp; Beneficiaries</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Beneficiaries Listing Start -->
<div class="beneficiaries-section">
    <div class="container">
        <div class="section-header text-center">
            <p>Support a Child</p>
            <h2>Vulnerable Children Waiting for a Sponsor</h2>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <p class="sponsor-intro-text">For just <strong>$50 / month</strong> you can transform a child&rsquo;s future &mdash; covering school fees, daily meals, medical care, and clothing. Browse the children below and choose who you&rsquo;d like to support.</p>
            </div>
        </div>
        <div class="row">
            <?php
            $bodmembers = $conn->query("SELECT * FROM gecodorphans");
            while ($rows = mysqli_fetch_array($bodmembers)) {
                $orphanid = htmlspecialchars($rows['orphanid']);
                $names    = htmlspecialchars($rows['orphanNames']);
                $info     = htmlspecialchars($rows['orphanInfo']);
                $img      = htmlspecialchars($rows['orphanImage']);
                $birthday = $rows['orphanBirthday'];
                $gender   = htmlspecialchars($rows['orphanGender']);

                // Calculate age from birthday
                $age = '';
                if (!empty($birthday)) {
                    try {
                        $dob = new DateTime($birthday);
                        $now = new DateTime();
                        $age = $dob->diff($now)->y;
                    } catch (Exception $e) { $age = ''; }
                }

                // Short bio snippet (first 85 chars)
                $snippet = (strlen($info) > 85) ? substr($info, 0, 85) . '&hellip;' : $info;

                // Gender badge styling
                $genderClass = (strtolower($gender) === 'female') ? 'badge-girl' : 'badge-boy';
                $genderLabel = !empty($gender) ? $gender : 'Child';

                echo '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="beneficiary-card">
                        <div class="beneficiary-img-wrap">
                            <img src="img/beneficiaries/' . $img . '" alt="' . $names . '">
                            <span class="awaiting-badge"><i class="fa fa-star"></i> Awaiting Sponsor</span>
                            <span class="gender-badge ' . $genderClass . '">' . $genderLabel . '</span>
                        </div>
                        <div class="beneficiary-body">
                            <h3 class="beneficiary-name">' . $names . '</h3>
                            <div class="beneficiary-meta">
                                ' . (!empty($age) ? '<span><i class="fa fa-birthday-cake"></i> Age ' . $age . '</span>' : '') . '
                                <span><i class="fa fa-map-marker-alt"></i> Lyantonde, Uganda</span>
                            </div>
                            ' . (!empty($snippet) ? '<p class="beneficiary-snippet">&ldquo;' . $snippet . '&rdquo;</p>' : '') . '
                            <div class="beneficiary-cost">
                                <i class="fa fa-heart"></i> <strong>$50 / month</strong> sponsors this child
                            </div>
                        </div>
                        <div class="beneficiary-footer">
                            <a href="vieworphandetails.php?orphanid=' . $orphanid . '" class="btn-choose-me">
                                <i class="fa fa-hand-holding-heart"></i> Choose Me
                            </a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Beneficiaries Listing End -->

<?php include 'includes/footer.php'; ?>
