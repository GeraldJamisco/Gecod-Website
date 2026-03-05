<?php
include 'config.php';
$pageTitle    = 'Contact Us | GECOD Initiative — Lyantonde, Uganda';
$pageDesc     = 'Get in touch with GECOD Initiative in Lyantonde, Uganda. Call +256 772 586 918 or email info@gecodinitiative.org. We\'d love to hear from you.';
$pageKeywords = 'contact GECOD Initiative, GECOD Uganda contact, Lyantonde NGO contact, info@gecodinitiative.org';
include 'includes/header.php';

$messageSent  = isset($_GET['messageSent']);
$updatesAdded = isset($_GET['updatesAdded']);
?>

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Contact Us</h2>
            </div>
            <div class="col-12">
                <a href="index.php">Home</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Map Start -->
<div class="contact-map-wrap">
    <div class="container">
        <p class="map-label"><i class="fa fa-map-marker-alt"></i> Find Us — Lyantonde, Uganda</p>
    </div>
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d853.2711274228121!2d31.152651031571313!3d-0.39322218165383716!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sug!4v1669716772094!5m2!1sen!2sug"
        width="100%" height="360" frameborder="0" style="border:0; display:block;" allowfullscreen loading="lazy">
    </iframe>
</div>
<!-- Map End -->


<!-- Contact Start -->
<div class="contact">
    <div class="container">
        <div class="section-header text-center">
            <p>Get In Touch</p>
            <h2>We&rsquo;d love to hear from you</h2>
        </div>

        <?php if ($messageSent): ?>
        <div class="contact-alert contact-alert-success">
            <i class="fa fa-check-circle"></i>
            <div>
                <strong>Message sent successfully!</strong>
                <p>Thank you for reaching out. Our team will get back to you within 1&ndash;2 business days.</p>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($updatesAdded): ?>
        <div class="contact-alert contact-alert-success">
            <i class="fa fa-check-circle"></i>
            <div>
                <strong>You&rsquo;re subscribed!</strong>
                <p>Thank you for subscribing to GECOD Initiative updates. Watch your inbox for news and stories from Uganda.</p>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">

            <!-- LEFT: Contact Info -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="contact-info-panel">

                    <h3 class="contact-info-title">Contact Information</h3>
                    <p class="contact-info-intro">Reach us through any of the channels below. We are based in Lyantonde, Uganda and welcome international partners, donors, and volunteers.</p>

                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fa fa-map-marker-alt"></i></div>
                            <div class="contact-info-text">
                                <strong>Our Office</strong>
                                <span>P.O.BOX 123, Cell 2B, Kaliiro Ward<br>Lyantonde Town Council, Uganda</span>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fa fa-phone-alt"></i></div>
                            <div class="contact-info-text">
                                <strong>Phone</strong>
                                <a href="tel:+256772586918">+256 772 586 918</a>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fab fa-whatsapp"></i></div>
                            <div class="contact-info-text">
                                <strong>WhatsApp</strong>
                                <a href="https://wa.me/256772586918?text=Hello%20GECOD%20Initiative%2C%20I%20would%20like%20to%20get%20in%20touch." target="_blank" rel="noopener noreferrer">Chat on WhatsApp</a>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fa fa-envelope"></i></div>
                            <div class="contact-info-text">
                                <strong>Email</strong>
                                <a href="mailto:info@gecodinitiative.org">info@gecodinitiative.org</a>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fa fa-clock"></i></div>
                            <div class="contact-info-text">
                                <strong>Office Hours</strong>
                                <span>Monday &ndash; Friday: 8:00 AM &ndash; 5:00 PM EAT<br>Saturday: 9:00 AM &ndash; 1:00 PM EAT</span>
                            </div>
                        </div>
                    </div>

                    <div class="contact-social">
                        <p>Follow us:</p>
                        <div class="contact-social-links">
                            <a href="https://www.facebook.com/gecodinitiative" target="_blank" rel="noopener noreferrer" class="csoc-btn csoc-fb"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/gecodinitiative" target="_blank" rel="noopener noreferrer" class="csoc-btn csoc-tw"><i class="fab fa-twitter"></i></a>
                            <a href="https://wa.me/256772586918" target="_blank" rel="noopener noreferrer" class="csoc-btn csoc-wa"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT: Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form-panel">
                    <h3 class="contact-form-title">Send Us a Message</h3>
                    <form name="sentMessage" id="contactForm" method="POST" action="sendmail.php">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="contact-label">Your Name <span class="req">*</span></label>
                                    <input type="text" class="form-control contact-input" id="name" placeholder="e.g. John Smith" required name="name"/>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label class="contact-label">Email Address <span class="req">*</span></label>
                                    <input type="email" class="form-control contact-input" id="email" placeholder="e.g. john@email.com" required name="email"/>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="contact-label">Subject <span class="req">*</span></label>
                            <input type="text" class="form-control contact-input" id="subject" placeholder="e.g. Donation enquiry / Partnership" required name="subject"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label class="contact-label">Message <span class="req">*</span></label>
                            <textarea class="form-control contact-input" id="message" placeholder="Tell us how we can help..." rows="6" required name="message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="contact-form-footer">
                            <button class="btn-contact-send" type="submit" name="submit">
                                <i class="fa fa-paper-plane"></i> Send Message
                            </button>
                            <p class="contact-privacy-note"><i class="fa fa-lock"></i> Your information is kept private and never shared.</p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Contact End -->


<?php include 'includes/footer.php'; ?>
