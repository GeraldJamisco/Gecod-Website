<?php
include 'config.php';
// Default meta — overridden below if a valid job is found
$pageTitle    = 'Careers & Jobs | GECOD Initiative Uganda';
$pageDesc     = 'Explore job openings and volunteer opportunities at GECOD Initiative Uganda.';
$pageKeywords = 'NGO jobs Uganda, GECOD careers, volunteer Uganda';
if (isset($_GET['jobid'])) {
    $jid  = $conn->real_escape_string($_GET['jobid']);
    $jmeta = $conn->query("SELECT job_title, JobDescription FROM jobcareer WHERE recordid='$jid'");
    if ($jmeta && $jmeta->num_rows > 0) {
        $jrow      = $jmeta->fetch_assoc();
        $pageTitle = htmlspecialchars($jrow['job_title']) . ' | GECOD Initiative Careers';
        $pageDesc  = substr(strip_tags(html_entity_decode($jrow['JobDescription'])), 0, 155) . '…';
    }
}
include 'includes/header.php';

if (isset($_GET['jobid'])) {
    $this_jobid = $conn->real_escape_string($_GET['jobid']);
    $result     = $conn->query("SELECT * FROM jobcareer WHERE recordid = '$this_jobid'");

    if (!$result || mysqli_num_rows($result) === 0) {
        echo '<div class="container" style="padding: 60px 15px; text-align:center;">
            <i class="fa fa-exclamation-circle" style="font-size:3rem; color:#f77f00; display:block; margin-bottom:16px;"></i>
            <h3>Job Not Found</h3>
            <p class="text-muted">The position you are looking for could not be found or may have been removed.</p>
            <a href="careers-and-jobs.php" class="btn btn-custom mt-3">Back to Careers</a>
        </div>';
    } else {
        $job = $result->fetch_assoc();

        $jobTitle    = htmlspecialchars($job['job_title']);
        $jobDesc     = htmlspecialchars($job['JobDescription']);
        $position    = htmlspecialchars($job['position']);
        $location    = htmlspecialchars($job['location']);
        $qualifs     = htmlspecialchars($job['qualifications']);
        $experience  = htmlspecialchars($job['experience']);
        $contacts    = htmlspecialchars($job['contacts']);
        $imgBanner   = htmlspecialchars($job['imgBanner']);
        $hiringType  = htmlspecialchars($job['hiringType']);
        $workHours   = htmlspecialchars(isset($job['workingHours']) ? $job['workingHours'] : '');

        // Format dates
        $deadlineFmt = '';
        $isExpired   = false;
        if (!empty($job['deadlineDate'])) {
            try {
                $dlObj       = new DateTime($job['deadlineDate']);
                $deadlineFmt = $dlObj->format('F j, Y');
                $isExpired   = $dlObj < new DateTime();
            } catch (Exception $e) {
                $deadlineFmt = htmlspecialchars($job['deadlineDate']);
            }
        }

        $postedFmt = '';
        if (!empty($job['uploadDate'])) {
            try { $postedFmt = (new DateTime($job['uploadDate']))->format('F j, Y'); } catch (Exception $e) {}
        }

        // Share URLs
        $pageUrl   = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $shareText = urlencode("Job Opening at GECOD Initiative Uganda: {$job['job_title']}. Apply now!");
        $fbShare   = "https://www.facebook.com/sharer/sharer.php?u={$pageUrl}";
        $twShare   = "https://twitter.com/intent/tweet?text={$shareText}&url={$pageUrl}";
        $waShare   = "https://api.whatsapp.com/send?text={$shareText}%20{$pageUrl}";
?>

<!-- Page Header Start -->
<div class="jobs_publications">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Careers &amp; Opportunities</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="careers-and-jobs.php">Careers &amp; Jobs</a>
                <a href="#"><?php echo $jobTitle; ?></a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Job Detail Start -->
<div class="single">
    <div class="container">
        <div class="row">

            <!-- LEFT: Main Content -->
            <div class="col-lg-8">
                <div class="single-content job-detail-content">

                    <!-- Banner Image -->
                    <div class="job-detail-img">
                        <img src="img/job_banner_images/<?php echo $imgBanner; ?>" alt="<?php echo $jobTitle; ?>">
                        <?php if ($isExpired): ?>
                        <span class="job-detail-expired-banner"><i class="fa fa-times-circle"></i> This position is now closed</span>
                        <?php endif; ?>
                    </div>

                    <!-- Title & badges -->
                    <div class="job-detail-header">
                        <h2 class="job-detail-title"><?php echo $jobTitle; ?></h2>
                        <div class="job-detail-badges">
                            <?php if (!empty($hiringType)): ?>
                            <span class="job-type-badge job-type-default"><?php echo $hiringType; ?></span>
                            <?php endif; ?>
                            <?php if (!empty($location)): ?>
                            <span class="job-location-badge"><i class="fa fa-map-marker-alt"></i> <?php echo $location; ?>, Uganda</span>
                            <?php endif; ?>
                            <?php if (!empty($deadlineFmt)): ?>
                            <span class="job-deadline-badge <?php echo $isExpired ? 'expired' : ''; ?>">
                                <i class="fa fa-clock"></i> Deadline: <?php echo $deadlineFmt; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- About the Organisation -->
                    <div class="job-detail-section">
                        <h3><i class="fa fa-building"></i> About GECOD Initiative</h3>
                        <p>Go Empower Communities for Development Initiative (GECOD INITIATIVE) is a youth, women and young people led Non-profit Community Based Organisation founded in 2018, aiming at empowering vulnerable communities to amplify their voices, build their capacity, empower them socio-economically, and support them to achieve quality education and good health.</p>
                    </div>

                    <!-- Position -->
                    <?php if (!empty($position)): ?>
                    <div class="job-detail-section">
                        <h3><i class="fa fa-user-tie"></i> Position</h3>
                        <p><?php echo nl2br($position); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Job Description -->
                    <div class="job-detail-section">
                        <h3><i class="fa fa-clipboard-list"></i> Job Description</h3>
                        <p><?php echo nl2br($jobDesc); ?></p>
                    </div>

                    <!-- Qualifications -->
                    <?php if (!empty($qualifs)): ?>
                    <div class="job-detail-section">
                        <h3><i class="fa fa-graduation-cap"></i> Qualifications</h3>
                        <p><?php echo nl2br($qualifs); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Experience -->
                    <?php if (!empty($experience)): ?>
                    <div class="job-detail-section">
                        <h3><i class="fa fa-briefcase"></i> Experience Required</h3>
                        <p><?php echo nl2br($experience); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- How to Apply -->
                    <?php if (!empty($contacts)): ?>
                    <div class="job-detail-section job-apply-section">
                        <h3><i class="fa fa-paper-plane"></i> How to Apply</h3>
                        <p><?php echo nl2br($contacts); ?></p>
                        <?php if (!$isExpired): ?>
                        <a href="mailto:info@gecodinitiative.org?subject=Application: <?php echo urlencode($job['job_title']); ?>" class="btn-apply-now">
                            <i class="fa fa-envelope"></i> Apply via Email
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="roadmap-share-section">
                        <p class="share-label"><i class="fa fa-share-alt"></i> Share this opportunity:</p>
                        <div class="share-btns">
                            <a href="<?php echo $fbShare; ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-fb"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="<?php echo $twShare; ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-tw"><i class="fab fa-twitter"></i> Twitter</a>
                            <a href="<?php echo $waShare; ?>" target="_blank" rel="noopener noreferrer" class="share-btn share-wa"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                        </div>
                    </div>

                    <!-- Back -->
                    <div class="roadmap-back-wrap">
                        <a href="careers-and-jobs.php" class="roadmap-back-btn">
                            <i class="fa fa-arrow-left"></i> Back to Careers
                        </a>
                    </div>

                </div>
            </div>

            <!-- RIGHT: Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">

                    <!-- Apply CTA widget -->
                    <?php if (!$isExpired): ?>
                    <div class="sidebar-widget job-apply-widget">
                        <h2 class="widget-title">Ready to Apply?</h2>
                        <p>Send your CV and cover letter to our team. We review all applications and will be in touch.</p>
                        <a href="mailto:info@gecodinitiative.org?subject=Application: <?php echo urlencode($job['job_title']); ?>" class="btn-apply-now" style="display:block; text-align:center;">
                            <i class="fa fa-paper-plane"></i> Apply Now
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="sidebar-widget job-closed-widget">
                        <h2 class="widget-title">Position Closed</h2>
                        <p>This vacancy is no longer accepting applications. Check our listings for other open roles.</p>
                        <a href="careers-and-jobs.php" class="roadmap-back-btn" style="display:block; text-align:center;">
                            <i class="fa fa-briefcase"></i> View Open Roles
                        </a>
                    </div>
                    <?php endif; ?>

                    <!-- Job Overview -->
                    <div class="sidebar-widget">
                        <h2 class="widget-title">Job Overview</h2>
                        <div class="job-overview-list">
                            <div class="job-overview-row">
                                <i class="fa fa-building"></i>
                                <span><strong>Organisation:</strong> GECOD Initiative Uganda</span>
                            </div>
                            <?php if (!empty($hiringType)): ?>
                            <div class="job-overview-row">
                                <i class="fa fa-tag"></i>
                                <span><strong>Type:</strong> <?php echo $hiringType; ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($location)): ?>
                            <div class="job-overview-row">
                                <i class="fa fa-map-marker-alt"></i>
                                <span><strong>Location:</strong> <?php echo $location; ?>, Uganda</span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($workHours)): ?>
                            <div class="job-overview-row">
                                <i class="fa fa-clock"></i>
                                <span><strong>Hours:</strong> <?php echo $workHours; ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($postedFmt)): ?>
                            <div class="job-overview-row">
                                <i class="fa fa-calendar-alt"></i>
                                <span><strong>Posted:</strong> <?php echo $postedFmt; ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($deadlineFmt)): ?>
                            <div class="job-overview-row <?php echo $isExpired ? 'text-danger' : ''; ?>">
                                <i class="fa fa-hourglass-end"></i>
                                <span><strong>Deadline:</strong> <?php echo $deadlineFmt; ?>
                                <?php echo $isExpired ? ' <em>(Expired)</em>' : ''; ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Support Widget -->
                    <div class="sidebar-widget roadmap-donate-widget">
                        <h2 class="widget-title">Support Our Mission</h2>
                        <p>Can&rsquo;t join our team right now? A donation supports our programs directly — clean water, education, and child sponsorship across Uganda.</p>
                        <a href="index.php#donate-section" class="btn-sponsor-main" style="text-decoration:none; text-align:center;">
                            <i class="fa fa-heart"></i> Donate Now
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Job Detail End -->

<?php
    }
} else {
    echo "<script>window.location.href='careers-and-jobs.php';</script>";
}

include 'includes/footer.php';
?>
