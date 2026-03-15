<?php
include 'config.php';
$pageTitle    = 'Our Road Map | GECOD Initiative Development Plans';
$pageDesc     = 'Explore GECOD Initiative\'s development road map — our strategic plans, projects, and vision for empowering communities across Uganda.';
$pageKeywords = 'GECOD road map, development plans Uganda, GECOD projects, community development Uganda, NGO strategy Uganda';
include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Our Road Map</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="Road Map.php">Road Map</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Programs / Services Start -->
<div class="service">
    <div class="container">
        <div class="section-header text-center">
            <p>How We Help</p>
            <h2>Our core programs serving communities across Uganda</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-diet"></i>
                    </div>
                    <div class="service-text">
                        <h3>Healthy Food</h3>
                        <p>Using donations from generous supporters, we deliver food to families in the slums of Lyantonde and flood-prone areas who have no reliable access to meals.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-water"></i>
                    </div>
                    <div class="service-text">
                        <h3>Pure Water</h3>
                        <p>We provide clean, safe water to communities without access and train local people in sustainable water management practices for long-term health.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-healthcare"></i>
                    </div>
                    <div class="service-text">
                        <h3>Health Care</h3>
                        <p>With support from local partners, we provide primary health care to community members suffering from malaria, fevers, and other treatable conditions.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-education"></i>
                    </div>
                    <div class="service-text">
                        <h3>Primary Education</h3>
                        <p>We run literacy seminars and learning programs for adults and children who have never had access to formal schooling, giving them tools to build a better future.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-home"></i>
                    </div>
                    <div class="service-text">
                        <h3>Residence Facilities</h3>
                        <p>Through the generosity of donors, we have secured temporary shelter for families who have lost their homes to poverty, floods, or displacement.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-social-care"></i>
                    </div>
                    <div class="service-text">
                        <h3>Social Care</h3>
                        <p>Working alongside other NGOs, we provide psychosocial support and community counselling to individuals and families experiencing depression and hardship.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Programs / Services End -->


<!-- Road Map Posts Start -->
<div class="blog" style="background: #f9f9f9; padding: 60px 0;">
    <div class="container">
        <div class="section-header text-center">
            <p>Projects &amp; Initiatives</p>
            <h2>Our Strategic Direction &amp; Future Goals</h2>
        </div>
        <div class="row">
            <?php
            $roadmap = $conn->query("SELECT * FROM gecodroadmap ORDER BY uploadDate DESC");

            if ($roadmap && mysqli_num_rows($roadmap) > 0) {
                while ($rows = mysqli_fetch_array($roadmap)) {
                    $recordid = htmlspecialchars($rows['recordid']);
                    $title    = htmlspecialchars($rows['Title']);
                    $content  = htmlspecialchars($rows['content']);
                    $img      = htmlspecialchars($rows['image']);
                    $date     = !empty($rows['uploadDate']) ? date('F j, Y', strtotime($rows['uploadDate'])) : '';

                    // Truncate long content
                    $snippet = (strlen($content) > 130) ? substr($content, 0, 130) . '&hellip;' : $content;

                    echo '
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="roadmap-card">
                            <div class="roadmap-img">
                                <img src="img/' . $img . '" alt="' . $title . '">
                                ' . (!empty($date) ? '<span class="roadmap-date"><i class="fa fa-calendar-alt"></i> ' . $date . '</span>' : '') . '
                            </div>
                            <div class="roadmap-body">
                                <h3 class="roadmap-title">' . $title . '</h3>
                                <p class="roadmap-snippet">' . $snippet . '</p>
                            </div>
                            <div class="roadmap-card-footer">
                                <a href="viewroadmap.php?id=' . $recordid . '" class="roadmap-readmore">
                                    Read More <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center">
                    <p class="text-muted">Road map projects and initiatives will appear here as they are added.</p>
                </div>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Road Map Posts End -->


<!-- Donate CTA Start -->
<div class="about-donate-cta">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Help Us Deliver on This Road Map</h3>
                <p>Every dollar you donate funds the programs above &mdash; clean water, education, healthcare, and child sponsorship across Uganda.</p>
            </div>
            <div class="col-md-4 text-center text-md-right">
                <a href="index.php#donate-section" class="btn btn-donate-main"><i class="fa fa-heart"></i> Donate Now</a>
            </div>
        </div>
    </div>
</div>
<!-- Donate CTA End -->


<?php include 'includes/footer.php'; ?>
