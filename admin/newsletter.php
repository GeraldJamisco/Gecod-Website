<?php
include 'config.php';
include 'sessionizr.php';
mysqli_report(MYSQLI_REPORT_OFF);

$success = '';
$error   = '';

// Handle send campaign
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_newsletter'])) {
    $subject  = strip_tags(trim($_POST['nl_subject'] ?? ''));
    $bodyHtml = trim($_POST['nl_body'] ?? '');

    if (empty($subject) || empty($bodyHtml)) {
        $error = 'Subject and message body are required.';
    } else {
        $res = $conn->query("SELECT email FROM newsletter_subscribers WHERE status = 'active' ORDER BY subscribed_at ASC");
        $subscribers = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) $subscribers[] = $row['email'];
        }

        if (empty($subscribers)) {
            $error = 'No active subscribers to send to.';
        } else {
            $from    = "GECOD Initiative <info@gecodinitiative.org>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$from}\r\n";
            $headers .= "Reply-To: info@gecodinitiative.org\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            $emailHtml = '<!DOCTYPE html><html><body style="font-family:Arial,sans-serif;color:#333;max-width:600px;margin:0 auto;padding:20px;">'
                . '<div style="background:#1a1a2e;padding:15px 20px;border-radius:6px 6px 0 0;">'
                . '<h2 style="color:#fff;margin:0;">GECOD Initiative Uganda</h2>'
                . '</div>'
                . '<div style="border:1px solid #ddd;border-top:none;padding:25px;border-radius:0 0 6px 6px;">'
                . nl2br(htmlspecialchars($bodyHtml))
                . '<hr style="margin:30px 0;border:none;border-top:1px solid #eee;">'
                . '<p style="font-size:12px;color:#999;">You are receiving this because you subscribed to GECOD Initiative updates.<br>'
                . 'P.O.BOX 123, Lyantonde, Uganda &nbsp;|&nbsp; info@gecodinitiative.org</p>'
                . '</div></body></html>';

            $sent = 0;
            foreach ($subscribers as $email) {
                if (mail($email, $subject, $emailHtml, $headers)) $sent++;
            }

            $safeSubject = $conn->real_escape_string($subject);
            $safeBody    = $conn->real_escape_string($bodyHtml);
            $conn->query("INSERT INTO newsletter_campaigns (subject, body, recipients_count, sent_at) VALUES ('{$safeSubject}', '{$safeBody}', {$sent}, NOW())");

            $success = "Campaign sent successfully to {$sent} subscriber(s).";
        }
    }
}

// Delete subscriber
if (isset($_GET['delete'])) {
    $did = (int)$_GET['delete'];
    $conn->query("DELETE FROM newsletter_subscribers WHERE id = {$did}");
    header("Location: newsletter.php?deleted=1");
    exit;
}

// Toggle active/unsubscribed
if (isset($_GET['toggle'])) {
    $tid = (int)$_GET['toggle'];
    $conn->query("UPDATE newsletter_subscribers SET status = IF(status='active','unsubscribed','active') WHERE id = {$tid}");
    header("Location: newsletter.php");
    exit;
}

// Stats
$totalSubs = 0; $activeSubs = 0; $campaigns = 0;
$r = $conn->query("SELECT COUNT(*) AS c FROM newsletter_subscribers");          if ($r) $totalSubs  = (int)$r->fetch_assoc()['c'];
$r = $conn->query("SELECT COUNT(*) AS c FROM newsletter_subscribers WHERE status='active'"); if ($r) $activeSubs = (int)$r->fetch_assoc()['c'];
$r = $conn->query("SELECT COUNT(*) AS c FROM newsletter_campaigns");            if ($r) $campaigns  = (int)$r->fetch_assoc()['c'];

$subsList      = $conn->query("SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC");
$pastCampaigns = $conn->query("SELECT * FROM newsletter_campaigns ORDER BY sent_at DESC LIMIT 10");
?>
<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-body">
<div class="container-fluid mt-3">

    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show"><i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($success) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show"><i class="fa fa-exclamation-circle mr-2"></i><?= htmlspecialchars($error) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-warning alert-dismissible fade show">Subscriber removed.<button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <!-- Stat cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-users fa-2x mr-3 opacity-75"></i>
                    <div><div style="font-size:2rem;font-weight:700;"><?= $totalSubs ?></div><div>Total Subscribers</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white" style="background:linear-gradient(135deg,#155724,#28a745);">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-check-circle fa-2x mr-3 opacity-75"></i>
                    <div><div style="font-size:2rem;font-weight:700;"><?= $activeSubs ?></div><div>Active Subscribers</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white" style="background:linear-gradient(135deg,#7b2d00,#e65c00);">
                <div class="card-body d-flex align-items-center">
                    <i class="fa fa-paper-plane fa-2x mr-3 opacity-75"></i>
                    <div><div style="font-size:2rem;font-weight:700;"><?= $campaigns ?></div><div>Campaigns Sent</div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Subscribers list -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-list mr-2"></i>Newsletter Subscribers</h5>
                    <span class="badge badge-success"><?= $activeSubs ?> active</span>
                </div>
                <div class="card-body p-0">
                    <div style="max-height:420px;overflow-y:auto;">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
                                    <th>Subscribed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; while ($subsList && $row = $subsList->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'active'): ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Unsubscribed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['subscribed_at'])) ?></td>
                                    <td>
                                        <a href="newsletter.php?toggle=<?= $row['id'] ?>" class="btn btn-xs btn-outline-warning" title="Toggle active/unsubscribed"><i class="fa fa-sync-alt"></i></a>
                                        <a href="newsletter.php?delete=<?= $row['id'] ?>" class="btn btn-xs btn-outline-danger" onclick="return confirm('Remove this subscriber permanently?')" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($totalSubs === 0): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">No subscribers yet. They will appear here when visitors sign up from the website footer.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php if ($campaigns > 0): ?>
            <div class="card mt-3">
                <div class="card-header"><h5 class="mb-0"><i class="fa fa-history mr-2"></i>Recent Campaigns</h5></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="thead-dark">
                            <tr><th>Subject</th><th>Recipients</th><th>Sent At</th></tr>
                        </thead>
                        <tbody>
                            <?php while ($pastCampaigns && $c = $pastCampaigns->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($c['subject']) ?></td>
                                <td><span class="badge badge-info"><?= $c['recipients_count'] ?></span></td>
                                <td><?= date('d M Y H:i', strtotime($c['sent_at'])) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Compose panel -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
                    <h5 class="mb-0 text-white"><i class="fa fa-paper-plane mr-2"></i>Compose &amp; Send Campaign</h5>
                    <small class="text-white-50">Will be sent to all <?= $activeSubs ?> active subscriber(s)</small>
                </div>
                <div class="card-body">
                    <form method="POST" action="newsletter.php">
                        <div class="form-group">
                            <label><strong>Subject Line</strong></label>
                            <input type="text" name="nl_subject" class="form-control" placeholder="e.g. GECOD Initiative — Monthly Update" required>
                        </div>
                        <div class="form-group">
                            <label><strong>Message</strong></label>
                            <small class="text-muted d-block mb-1">Plain text. Line breaks are preserved automatically.</small>
                            <textarea name="nl_body" class="form-control" rows="13"
                                placeholder="Dear Supporter,&#10;&#10;Write your update here...&#10;&#10;Regards,&#10;GECOD Initiative Team" required></textarea>
                        </div>
                        <div class="alert alert-info py-2 small mb-3">
                            <i class="fa fa-info-circle mr-1"></i>
                            A GECOD-branded header and footer will be added automatically to every email.
                        </div>
                        <button type="submit" name="send_newsletter" class="btn btn-block btn-lg"
                            style="background:#e65c00;color:#fff;font-weight:600;"
                            <?= $activeSubs === 0 ? 'disabled title="No active subscribers"' : '' ?>>
                            <i class="fa fa-paper-plane mr-2"></i>Send to <?= $activeSubs ?> Subscriber(s)
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<?php include 'includes/footer.php'; ?>
