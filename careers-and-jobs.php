<?php
include 'config.php';
$pageTitle    = 'Careers & Volunteer Opportunities | GECOD Initiative Uganda';
$pageDesc     = 'Explore job openings, internships, and volunteer opportunities at GECOD Initiative in Uganda. Join our team and help empower vulnerable communities.';
$pageKeywords = 'NGO jobs Uganda, volunteer Uganda, GECOD careers, internship Uganda, jobs Lyantonde, nonprofit jobs Uganda';
include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="jobs_publications">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Careers &amp; Jobs</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="careers-and-jobs.php">Careers &amp; Jobs</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Jobs Listing Start -->
<div class="jobs-section">
    <div class="container">
        <div class="section-header text-center">
            <p>Work With Us</p>
            <h2>Current Job Openings at GECOD Initiative</h2>
        </div>
        <p class="jobs-intro text-center">We are looking for passionate individuals who want to make a real difference in communities across Uganda. All positions contribute directly to our mission of empowering vulnerable communities.</p>

        <div class="row mt-4">
            <?php
            $jobfirstview = $conn->query("SELECT * FROM jobcareer ORDER BY uploadDate DESC");

            if ($jobfirstview && mysqli_num_rows($jobfirstview) > 0) {
                while ($rows = mysqli_fetch_array($jobfirstview)) {
                    $jobTitle    = htmlspecialchars($rows['job_title']);
                    $jobDescript = htmlspecialchars($rows['JobDescription']);
                    $jobBanner   = htmlspecialchars($rows['imgBanner']);
                    $jobRecordId = htmlspecialchars($rows['recordid']);
                    $jobLocation = htmlspecialchars($rows['location']);
                    $hiringType  = htmlspecialchars($rows['hiringType']);
                    $deadline    = $rows['deadlineDate'];
                    $uploadDate  = $rows['uploadDate'];

                    // Format deadline
                    $deadlineFmt = '';
                    $isExpired   = false;
                    if (!empty($deadline)) {
                        try {
                            $dlObj     = new DateTime($deadline);
                            $deadlineFmt = $dlObj->format('F j, Y');
                            $isExpired   = $dlObj < new DateTime();
                        } catch (Exception $e) {
                            $deadlineFmt = htmlspecialchars($deadline);
                        }
                    }

                    // Format upload date
                    $postedFmt = '';
                    if (!empty($uploadDate)) {
                        try { $postedFmt = (new DateTime($uploadDate))->format('M j, Y'); } catch (Exception $e) {}
                    }

                    // Snippet
                    $snippet = (mb_strlen($jobDescript) > 120) ? mb_substr($jobDescript, 0, 120) . '&hellip;' : $jobDescript;

                    // Status badge
                    $statusBadge = $isExpired
                        ? '<span class="job-status expired"><i class="fa fa-times-circle"></i> Closed</span>'
                        : '<span class="job-status open"><i class="fa fa-check-circle"></i> Open</span>';

                    // Hiring type badge color
                    $typeClass = 'job-type-default';
                    if (!empty($hiringType)) {
                        $ht = strtolower($hiringType);
                        if (str_contains($ht, 'full')) $typeClass = 'job-type-full';
                        elseif (str_contains($ht, 'part')) $typeClass = 'job-type-part';
                        elseif (str_contains($ht, 'vol')) $typeClass = 'job-type-vol';
                        elseif (str_contains($ht, 'intern')) $typeClass = 'job-type-intern';
                    }

                    echo '
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="job-card ' . ($isExpired ? 'job-expired' : '') . '">
                            <div class="job-img-wrap">
                                <img src="img/job_banner_images/' . $jobBanner . '" alt="' . $jobTitle . '">
                                ' . $statusBadge . '
                            </div>
                            <div class="job-body">
                                <div class="job-badges">
                                    ' . (!empty($hiringType) ? '<span class="job-type-badge ' . $typeClass . '">' . $hiringType . '</span>' : '') . '
                                    ' . (!empty($jobLocation) ? '<span class="job-location-badge"><i class="fa fa-map-marker-alt"></i> ' . $jobLocation . '</span>' : '') . '
                                </div>
                                <h3 class="job-title">
                                    <a href="viewjob.php?jobid=' . $jobRecordId . '">' . $jobTitle . '</a>
                                </h3>
                                <p class="job-snippet">' . $snippet . '</p>
                                <div class="job-meta-row">
                                    ' . (!empty($postedFmt) ? '<span><i class="fa fa-calendar-alt"></i> Posted: ' . $postedFmt . '</span>' : '') . '
                                    ' . (!empty($deadlineFmt) ? '<span class="' . ($isExpired ? 'text-danger' : '') . '"><i class="fa fa-clock"></i> Deadline: ' . $deadlineFmt . '</span>' : '') . '
                                </div>
                            </div>
                            <div class="job-footer">
                                <a href="viewjob.php?jobid=' . $jobRecordId . '" class="job-view-btn ' . ($isExpired ? 'job-view-closed' : '') . '">
                                    ' . ($isExpired ? '<i class="fa fa-eye"></i> View Details' : '<i class="fa fa-paper-plane"></i> View &amp; Apply') . '
                                </a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5">
                    <i class="fa fa-briefcase" style="font-size:3rem; color:#ccc; display:block; margin-bottom:16px;"></i>
                    <h4 style="color:#aaa;">No open positions at the moment</h4>
                    <p style="color:#bbb;">We regularly post new opportunities. Check back soon or get in touch to express your interest.</p>
                    <a href="contact.php" class="btn btn-custom mt-2">Contact Us</a>
                </div>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Jobs Listing End -->


<!-- Volunteer CTA -->
<div class="about-donate-cta">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Don&rsquo;t See a Suitable Role?</h3>
                <p>We welcome volunteers, interns, and partners who share our mission. Reach out and tell us how you&rsquo;d like to contribute to communities in Uganda.</p>
            </div>
            <div class="col-md-4 text-center text-md-right">
                <a href="contact.php" class="btn btn-donate-main"><i class="fa fa-envelope"></i> Get In Touch</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
