<?php
include 'config.php';
$pageTitle    = 'Community Events | GECOD Initiative Uganda';
$pageDesc     = 'Stay updated with GECOD Initiative\'s upcoming community events, programs, and activities in Uganda. Join us and make a difference.';
$pageKeywords = 'GECOD events Uganda, community events Uganda, NGO events Uganda, charity events Lyantonde, GECOD activities';
include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Community Events</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="event.php">Events</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Events Start -->
<div class="event">
    <div class="container">
        <div class="section-header text-center">
            <p>What&rsquo;s Coming Up</p>
            <h2>Join us at our upcoming community events</h2>
        </div>
        <div class="row">
            <?php
            $twoevents = $conn->query("SELECT * FROM gecodevents ORDER BY eventDate ASC");

            if ($twoevents && mysqli_num_rows($twoevents) > 0) {
                $today = new DateTime();

                while ($eventssoon = mysqli_fetch_array($twoevents)) {
                    $eventtitle    = htmlspecialchars($eventssoon['eventTitle']);
                    $eventcontent  = htmlspecialchars($eventssoon['eventInfo']);
                    $eventdate_raw = $eventssoon['eventDate'];
                    $timestart_raw = $eventssoon['eventTimeStart'];
                    $timeend_raw   = $eventssoon['eventTimeEnd'];
                    $eventlocation = htmlspecialchars($eventssoon['eventLocation']);
                    $eventtimage   = htmlspecialchars($eventssoon['eventImageLogo']);
                    $eventid       = htmlspecialchars($eventssoon['recordid']);

                    // Format date: "March 5, 2026"
                    $eventdate_fmt = '';
                    $isPast = false;
                    if (!empty($eventdate_raw)) {
                        try {
                            $dateObj = new DateTime($eventdate_raw);
                            $eventdate_fmt = $dateObj->format('F j, Y');
                            $isPast = $dateObj < $today;
                        } catch (Exception $e) {
                            $eventdate_fmt = htmlspecialchars($eventdate_raw);
                        }
                    }

                    // Format time: "9:00 AM"
                    $timestart_fmt = '';
                    $timeend_fmt   = '';
                    if (!empty($timestart_raw)) {
                        try { $timestart_fmt = (new DateTime($timestart_raw))->format('g:i A'); } catch (Exception $e) { $timestart_fmt = htmlspecialchars($timestart_raw); }
                    }
                    if (!empty($timeend_raw)) {
                        try { $timeend_fmt = (new DateTime($timeend_raw))->format('g:i A'); } catch (Exception $e) { $timeend_fmt = htmlspecialchars($timeend_raw); }
                    }

                    // Snippet: first 160 chars
                    $snippet = (strlen($eventcontent) > 160) ? substr($eventcontent, 0, 160) . '&hellip;' : $eventcontent;

                    // Status badge
                    $statusBadge = $isPast
                        ? '<span class="event-status-badge past"><i class="fa fa-check-circle"></i> Past Event</span>'
                        : '<span class="event-status-badge upcoming"><i class="fa fa-clock"></i> Upcoming</span>';

                    // Image fallback
                    $imgSrc = !empty($eventtimage)
                        ? 'img/events/' . $eventtimage
                        : 'img/event-placeholder.jpg';

                    // Add to Google Calendar URL
                    $gcalTitle  = urlencode($eventssoon['eventTitle']);
                    $gcalDate   = !empty($eventdate_raw) ? str_replace('-', '', $eventdate_raw) : '';
                    $gcalUrl    = "https://www.google.com/calendar/render?action=TEMPLATE&text={$gcalTitle}&dates={$gcalDate}/{$gcalDate}&location=" . urlencode($eventssoon['eventLocation'] . ', Uganda');

                    echo '
                    <div class="col-lg-6 mb-4">
                        <div class="event-item event-item-enhanced ' . ($isPast ? 'event-past' : '') . '">
                            <div class="event-img-wrap">
                                <img src="' . $imgSrc . '" alt="' . $eventtitle . '">
                                ' . $statusBadge . '
                            </div>
                            <div class="event-content">
                                <div class="event-meta">
                                    ' . (!empty($eventdate_fmt) ? '<p><i class="fa fa-calendar-alt"></i> ' . $eventdate_fmt . '</p>' : '') . '
                                    ' . (!empty($timestart_fmt) ? '<p><i class="far fa-clock"></i> ' . $timestart_fmt . ($timeend_fmt ? ' &ndash; ' . $timeend_fmt : '') . '</p>' : '') . '
                                    ' . (!empty($eventlocation) ? '<p><i class="fa fa-map-marker-alt"></i> ' . $eventlocation . ', Uganda</p>' : '') . '
                                </div>
                                <div class="event-text">
                                    <h3>' . $eventtitle . '</h3>
                                    <p>' . $snippet . '</p>
                                    <div class="event-actions">
                                        ' . (!$isPast ? '<a class="btn btn-custom" href="contact.php">Join This Event</a>' : '<a class="btn btn-custom btn-past" href="contact.php">Get Involved</a>') . '
                                        <button type="button" class="btn btn-custom" data-toggle="modal" data-target="#eventDonateModal" data-eventtitle="' . $eventtitle . '" data-eventid="' . $eventid . '"><i class="fa fa-heart"></i> Donate</button>
                                        ' . (!$isPast && !empty($gcalDate) ? '<a class="event-calendar-link" href="' . $gcalUrl . '" target="_blank" rel="noopener noreferrer"><i class="fa fa-calendar-plus"></i> Add to Calendar</a>' : '') . '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5">
                    <i class="fa fa-calendar-alt" style="font-size:3rem; color:#ccc; display:block; margin-bottom:16px;"></i>
                    <h4 style="color:#aaa;">No events scheduled at this time</h4>
                    <p style="color:#bbb;">Check back soon — we regularly organise community outreach events across Uganda.</p>
                    <a href="index.php#donate-section" class="btn btn-custom mt-2">Support Our Work</a>
                </div>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Events End -->


<!-- Donate CTA Start -->
<div class="about-donate-cta">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Can&rsquo;t Attend? You Can Still Make an Impact</h3>
                <p>Support GECOD Initiative&rsquo;s programs from anywhere in the world &mdash; your donation funds clean water, education, and child sponsorship across Uganda.</p>
            </div>
            <div class="col-md-4 text-center text-md-right">
                <a href="index.php#donate-section" class="btn btn-donate-main"><i class="fa fa-heart"></i> Donate Now</a>
            </div>
        </div>
    </div>
</div>
<!-- Donate CTA End -->

<!-- Event Donate Modal -->
<div class="modal fade" id="eventDonateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content sponsor-modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-heart text-danger"></i> Donate for this Event</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="checkout-cart.php" method="POST">
                <div class="modal-body">
                    <p class="sponsor-modal-intro" id="eventDonateIntro">Support this GECOD community event.</p>
                    <div class="form-group">
                        <label>Your Full Name</label>
                        <input type="text" class="form-control" name="donorNames" placeholder="e.g. John Smith" required>
                    </div>
                    <div class="form-group">
                        <label>Your Email Address</label>
                        <input type="email" class="form-control" name="donoremail" placeholder="e.g. john@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Donation Amount (USD)</label>
                        <select class="custom-select" name="amountselected" required>
                            <option value="">-- Select amount --</option>
                            <option value="25">$25</option>
                            <option value="50">$50</option>
                            <option value="100">$100</option>
                            <option value="200">$200</option>
                            <option value="500">$500</option>
                        </select>
                    </div>
                    <input type="hidden" name="donation_type" value="event">
                    <input type="hidden" name="reference_label" id="eventDonateRef" value="">
                    <p class="small text-muted mt-2"><i class="fa fa-lock"></i> Secure payment via PayPal.</p>
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
<script>
$('#eventDonateModal').on('show.bs.modal', function(e) {
    var btn   = $(e.relatedTarget);
    var title = btn.data('eventtitle');
    $('#eventDonateRef').val(title);
    $('#eventDonateIntro').text('Your donation will directly support: ' + title);
});
</script>

<?php include 'includes/footer.php'; ?>
