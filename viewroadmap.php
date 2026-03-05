<?php
include 'config.php';
// Default meta — overridden below if a valid post is found
$pageTitle    = 'Road Map | GECOD Initiative Uganda';
$pageDesc     = 'Read GECOD Initiative\'s development road map posts and strategic plans for Uganda.';
$pageKeywords = 'GECOD road map, development Uganda, NGO strategy Uganda';
if (isset($_GET['id'])) {
    $rid   = $conn->real_escape_string($_GET['id']);
    $rmeta = $conn->query("SELECT Title, content FROM gecodroadmap WHERE recordid='$rid'");
    if ($rmeta && $rmeta->num_rows > 0) {
        $rrow      = $rmeta->fetch_assoc();
        $pageTitle = htmlspecialchars($rrow['Title']) . ' | GECOD Road Map';
        $pageDesc  = mb_substr(strip_tags(html_entity_decode($rrow['content'])), 0, 155) . '…';
    }
}
include 'includes/header.php';

if (isset($_GET['id'])) {
    $recordid = $conn->real_escape_string($_GET['id']);
    $result   = $conn->query("SELECT * FROM gecodroadmap WHERE recordid='$recordid'");

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<script>window.location.href='Road Map.php';</script>";
        exit;
    }

    $post    = $result->fetch_assoc();
    $title   = htmlspecialchars($post['Title']);
    $content = htmlspecialchars($post['content']);
    $img     = htmlspecialchars($post['image']);
    $date    = !empty($post['uploadDate']) ? date('F j, Y', strtotime($post['uploadDate'])) : '';

    // Fetch other posts for the sidebar (exclude current)
    $others = $conn->query("SELECT * FROM gecodroadmap WHERE recordid != '$recordid' ORDER BY uploadDate DESC LIMIT 4");
?>

<!-- Page Header Start -->
<div class="jobs_publications">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $title; ?></h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="Road Map.php">Road Map</a>
                <a href="#"><?php echo $title; ?></a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Road Map Detail Start -->
<div class="single">
    <div class="container">
        <div class="row">

            <!-- LEFT: Main Content -->
            <div class="col-lg-8">
                <div class="single-content roadmap-detail-content">

                    <!-- Hero Image -->
                    <div class="roadmap-detail-img">
                        <img src="img/<?php echo $img; ?>" alt="<?php echo $title; ?>">
                    </div>

                    <!-- Meta: date -->
                    <?php if (!empty($date)): ?>
                    <div class="roadmap-detail-meta">
                        <span><i class="fa fa-calendar-alt"></i> <?php echo $date; ?></span>
                        <span><i class="fa fa-map-marker-alt"></i> Lyantonde, Uganda</span>
                        <span><i class="fa fa-tag"></i> GECOD Initiative</span>
                    </div>
                    <?php endif; ?>

                    <!-- Title -->
                    <h2 class="roadmap-detail-title"><?php echo $title; ?></h2>

                    <!-- Full Content -->
                    <div class="roadmap-detail-body">
                        <?php
                        // Render line breaks from the stored content
                        echo nl2br($content);
                        ?>
                    </div>

                    <!-- Share This Post -->
                    <?php
                    $pageUrl   = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                    $shareText = urlencode("Read about GECOD Initiative's project: {$title}");
                    $fbShare   = "https://www.facebook.com/sharer/sharer.php?u={$pageUrl}";
                    $twShare   = "https://twitter.com/intent/tweet?text={$shareText}&url={$pageUrl}";
                    $waShare   = "https://api.whatsapp.com/send?text={$shareText}%20{$pageUrl}";
                    ?>
                    <div class="roadmap-share-section">
                        <p class="share-label"><i class="fa fa-share-alt"></i> Share this initiative:</p>
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

                    <!-- Back button -->
                    <div class="roadmap-back-wrap">
                        <a href="Road Map.php" class="roadmap-back-btn">
                            <i class="fa fa-arrow-left"></i> Back to Road Map
                        </a>
                    </div>

                </div>
            </div>

            <!-- RIGHT: Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">

                    <!-- Donate Widget -->
                    <div class="sidebar-widget roadmap-donate-widget">
                        <h2 class="widget-title">Support This Work</h2>
                        <p>Your donation directly funds projects like this one — helping communities across Uganda access clean water, education, and healthcare.</p>
                        <a href="index.php#donate-section" class="btn-sponsor-main" style="text-decoration:none; text-align:center;">
                            <i class="fa fa-heart"></i> Donate Now
                        </a>
                    </div>

                    <!-- Other Initiatives -->
                    <?php if ($others && mysqli_num_rows($others) > 0): ?>
                    <div class="sidebar-widget">
                        <h2 class="widget-title">Other Initiatives</h2>
                        <div class="roadmap-other-list">
                            <?php while ($other = mysqli_fetch_assoc($others)):
                                $oTitle = htmlspecialchars($other['Title']);
                                $oImg   = htmlspecialchars($other['image']);
                                $oDate  = !empty($other['uploadDate']) ? date('M j, Y', strtotime($other['uploadDate'])) : '';
                                $oId    = htmlspecialchars($other['recordid']);
                                $oSnip  = mb_strlen(htmlspecialchars($other['content'])) > 70
                                            ? mb_substr(htmlspecialchars($other['content']), 0, 70) . '&hellip;'
                                            : htmlspecialchars($other['content']);
                            ?>
                            <a href="viewroadmap.php?id=<?php echo $oId; ?>" class="roadmap-other-item">
                                <div class="roadmap-other-img">
                                    <img src="img/<?php echo $oImg; ?>" alt="<?php echo $oTitle; ?>">
                                </div>
                                <div class="roadmap-other-text">
                                    <h4><?php echo $oTitle; ?></h4>
                                    <?php if (!empty($oDate)): ?>
                                    <span class="roadmap-other-date"><i class="fa fa-calendar-alt"></i> <?php echo $oDate; ?></span>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Sponsor a Child Widget -->
                    <div class="sidebar-widget">
                        <h2 class="widget-title">Sponsor a Child</h2>
                        <p>For just <strong>$38/month</strong> you can sponsor a child's education, meals, and medical care through GECOD Initiative.</p>
                        <a href="Orphans.php" class="btn-choose-me" style="text-decoration:none;">
                            <i class="fa fa-child"></i> Meet the Children
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Road Map Detail End -->

<?php
} else {
    echo "<script>window.location.href='Road Map.php';</script>";
}

include 'includes/footer.php';
?>
