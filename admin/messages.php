<?php
include 'config.php';
include 'sessionizr.php';
mysqli_report(MYSQLI_REPORT_OFF);

// Mark as read when opened
if (isset($_GET['id'])) {
    $mid = (int)$_GET['id'];
    $conn->query("UPDATE contact_messages SET status='read' WHERE id={$mid} AND status='new'");
}

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_reply'])) {
    $mid       = (int)$_POST['message_id'];
    $replyBody = trim(isset($_POST['reply_body']) ? $_POST['reply_body'] : '');

    if ($mid > 0 && !empty($replyBody)) {
        // Get original sender details
        $orig = $conn->query("SELECT * FROM contact_messages WHERE id={$mid}");
        if ($orig && $row = $orig->fetch_assoc()) {
            // Save reply to DB
            $stmt = $conn->prepare("INSERT INTO contact_replies (message_id, reply_body) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("is", $mid, $replyBody);
                $stmt->execute();
                $stmt->close();
            }
            // Mark message as replied
            $conn->query("UPDATE contact_messages SET status='replied' WHERE id={$mid}");

            // Send email to original sender
            $toEmail   = $row['sender_email'];
            $toName    = $row['sender_name'];
            $origSubj  = $row['subject'];
            $safeEmail = str_replace(["\r","\n"], '', $toEmail);
            $headers   = "MIME-Version: 1.0\r\n";
            $headers  .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers  .= "From: GECOD Initiative <info@gecodinitiative.org>\r\n";
            $headers  .= "Reply-To: info@gecodinitiative.org\r\n";

            $emailBody = '<!DOCTYPE html><html><body style="font-family:Arial,sans-serif;color:#333;max-width:600px;margin:0 auto;padding:20px;">'
                . '<div style="background:#1a1a2e;padding:15px 20px;border-radius:6px 6px 0 0;">'
                . '<h2 style="color:#fff;margin:0;">GECOD Initiative Uganda</h2></div>'
                . '<div style="border:1px solid #ddd;border-top:none;padding:25px;border-radius:0 0 6px 6px;">'
                . '<p>Dear <strong>' . htmlspecialchars($toName) . '</strong>,</p>'
                . '<p>Thank you for reaching out to GECOD Initiative. Here is our response to your message:</p>'
                . '<blockquote style="border-left:4px solid #e65c00;margin:15px 0;padding:10px 15px;background:#f9f9f9;color:#555;">'
                . '<em>Your original message: &ldquo;' . htmlspecialchars($row['message']) . '&rdquo;</em></blockquote>'
                . '<div style="background:#f0f8f0;border-left:4px solid #28a745;padding:15px;margin:15px 0;">'
                . nl2br(htmlspecialchars($replyBody))
                . '</div>'
                . '<hr style="margin:20px 0;border:none;border-top:1px solid #eee;">'
                . '<p style="font-size:12px;color:#999;">GECOD Initiative Uganda &nbsp;|&nbsp; info@gecodinitiative.org &nbsp;|&nbsp; +256 772 586 918</p>'
                . '</div></body></html>';

            mail($toEmail, 'Re: ' . $origSubj, $emailBody, $headers);
        }
    }
    header("Location: messages.php?id={$mid}&replied=1");
    exit;
}

// Counts
$cntNew = 0;
$r = $conn->query("SELECT COUNT(*) AS c FROM contact_messages WHERE status='new'");
if ($r) $cntNew = (int)$r->fetch_assoc()['c'];

// Inbox list
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY received_at DESC");

// Open thread if id given
$thread = null; $replies = null;
if (isset($_GET['id'])) {
    $mid    = (int)$_GET['id'];
    $res    = $conn->query("SELECT * FROM contact_messages WHERE id={$mid}");
    if ($res) $thread = $res->fetch_assoc();
    $replies = $conn->query("SELECT * FROM contact_replies WHERE message_id={$mid} ORDER BY replied_at ASC");
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-body">
<div class="container-fluid mt-3">

    <?php if (isset($_GET['replied'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><i class="fa fa-check-circle mr-2"></i>Reply sent successfully.<button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="row">

        <!-- Inbox panel -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-inbox mr-2"></i>Inbox</h5>
                    <?php if ($cntNew > 0): ?>
                    <span class="badge badge-danger"><?= $cntNew ?> new</span>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0" style="overflow-y:auto;max-height:75vh;">
                    <?php
                    $statusColor = ['new' => '#dc3545', 'read' => '#6c757d', 'replied' => '#28a745'];
                    $statusIcon  = ['new' => 'fa-envelope', 'read' => 'fa-envelope-open', 'replied' => 'fa-reply'];
                    $anyMsg = false;
                    while ($messages && $msg = $messages->fetch_assoc()):
                        $anyMsg = true;
                        $isActive = (isset($_GET['id']) && (int)$_GET['id'] === (int)$msg['id']);
                    ?>
                    <a href="messages.php?id=<?= $msg['id'] ?>" class="d-block text-decoration-none" style="border-bottom:1px solid #f0f0f0; background:<?= $isActive ? '#f0f7ff' : ($msg['status']==='new' ? '#fffbf0' : '#fff') ?>; padding:12px 16px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="flex:1;min-width:0;">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa <?= $statusIcon[$msg['status']] ?> mr-2" style="color:<?= $statusColor[$msg['status']] ?>;font-size:12px;"></i>
                                    <strong style="font-size:13px;color:#333;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($msg['sender_name']) ?></strong>
                                    <?php if ($msg['status'] === 'new'): ?><span class="badge badge-danger ml-1" style="font-size:10px;">NEW</span><?php endif; ?>
                                </div>
                                <div style="font-size:12px;color:#555;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($msg['subject']) ?></div>
                                <div style="font-size:11px;color:#aaa;margin-top:2px;"><?= date('d M Y, H:i', strtotime($msg['received_at'])) ?></div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; ?>
                    <?php if (!$anyMsg): ?>
                    <div class="text-center text-muted py-5"><i class="fa fa-inbox fa-2x mb-2 d-block"></i>No messages yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Thread / detail panel -->
        <div class="col-lg-8 mb-4">
            <?php if ($thread): ?>
            <div class="card">
                <div class="card-header" style="background:#1a1a2e;color:#fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0"><?= htmlspecialchars($thread['subject']) ?></h5>
                            <small style="opacity:.7;">From: <?= htmlspecialchars($thread['sender_name']) ?> &lt;<?= htmlspecialchars($thread['sender_email']) ?>&gt; &mdash; <?= date('d M Y H:i', strtotime($thread['received_at'])) ?></small>
                        </div>
                        <span class="badge badge-<?= ['new'=>'danger','read'=>'secondary','replied'=>'success'][$thread['status']] ?>">
                            <?= ucfirst($thread['status']) ?>
                        </span>
                    </div>
                </div>
                <div class="card-body" style="max-height:50vh;overflow-y:auto;" id="threadBody">

                    <!-- Original message -->
                    <div class="d-flex mb-3">
                        <div style="width:36px;height:36px;border-radius:50%;background:#e65c00;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;margin-right:10px;">
                            <?= strtoupper(substr($thread['sender_name'],0,1)) ?>
                        </div>
                        <div style="max-width:80%;">
                            <div style="background:#f1f1f1;border-radius:0 12px 12px 12px;padding:12px 16px;">
                                <strong style="font-size:13px;"><?= htmlspecialchars($thread['sender_name']) ?></strong>
                                <p class="mb-0 mt-1" style="font-size:14px;color:#333;"><?= nl2br(htmlspecialchars($thread['message'])) ?></p>
                            </div>
                            <div style="font-size:11px;color:#aaa;margin-top:4px;"><?= date('d M Y H:i', strtotime($thread['received_at'])) ?></div>
                        </div>
                    </div>

                    <!-- Replies thread -->
                    <?php while ($replies && $rep = $replies->fetch_assoc()): ?>
                    <div class="d-flex mb-3 justify-content-end">
                        <div style="max-width:80%;text-align:right;">
                            <div style="background:#1a1a2e;color:#fff;border-radius:12px 0 12px 12px;padding:12px 16px;display:inline-block;text-align:left;">
                                <strong style="font-size:13px;">GECOD Admin</strong>
                                <p class="mb-0 mt-1" style="font-size:14px;"><?= nl2br(htmlspecialchars($rep['reply_body'])) ?></p>
                            </div>
                            <div style="font-size:11px;color:#aaa;margin-top:4px;"><?= date('d M Y H:i', strtotime($rep['replied_at'])) ?></div>
                        </div>
                        <div style="width:36px;height:36px;border-radius:50%;background:#1a1a2e;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;margin-left:10px;">
                            G
                        </div>
                    </div>
                    <?php endwhile; ?>

                </div>

                <!-- Reply box -->
                <div class="card-footer" style="background:#f8f9fa;">
                    <form method="POST" action="messages.php?id=<?= $thread['id'] ?>">
                        <input type="hidden" name="message_id" value="<?= $thread['id'] ?>">
                        <div class="d-flex align-items-end">
                            <textarea name="reply_body" class="form-control mr-2" rows="3"
                                placeholder="Type your reply to <?= htmlspecialchars($thread['sender_name']) ?>..." required
                                style="resize:none;border-radius:8px;"></textarea>
                            <button type="submit" name="send_reply" class="btn btn-lg" style="background:#e65c00;color:#fff;border-radius:8px;white-space:nowrap;">
                                <i class="fa fa-paper-plane"></i><br><small>Send</small>
                            </button>
                        </div>
                        <small class="text-muted mt-1 d-block"><i class="fa fa-info-circle"></i> Reply will be emailed to <strong><?= htmlspecialchars($thread['sender_email']) ?></strong> and saved here.</small>
                    </form>
                </div>
            </div>

            <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="fa fa-comments fa-3x mb-3 d-block"></i>
                    <p>Select a message from the inbox to view the conversation thread.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>
</div>

<script>
// Auto-scroll thread to bottom
var tb = document.getElementById('threadBody');
if (tb) tb.scrollTop = tb.scrollHeight;
</script>

<?php include 'includes/footer.php'; ?>
