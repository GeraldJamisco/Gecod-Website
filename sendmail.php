<?php
if (isset($_POST['submit'])) {
    // Sanitize all inputs — strip tags, trim whitespace
    $names   = strip_tags(trim($_POST['name']   ?? ''));
    $email   = filter_var(trim($_POST['email']  ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject'] ?? ''));
    $message = strip_tags(trim($_POST['message'] ?? ''));

    // Basic validation
    if (empty($names) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php");
        exit;
    }

    $mailto  = "info@gecodinitiative.org";
    // Safe headers — no newlines allowed in sender name/email (prevents header injection)
    $safeName  = str_replace(["\r", "\n"], '', $names);
    $safeEmail = str_replace(["\r", "\n"], '', $email);
    $headers   = "From: {$safeName} <{$safeEmail}>\r\n";
    $headers  .= "Reply-To: {$safeEmail}\r\n";
    $headers  .= "X-Mailer: PHP/" . phpversion();

    $body  = "You have received a new message from the GECOD Initiative website.\r\n\r\n";
    $body .= "Name:    {$names}\r\n";
    $body .= "Email:   {$email}\r\n";
    $body .= "Subject: {$subject}\r\n\r\n";
    $body .= "Message:\r\n{$message}";

    mail($mailto, $subject, $body, $headers);
    header("Location: contact.php?messageSent");
    exit;

} elseif (isset($_POST['updates'])) {
    $requester = filter_var(trim($_POST['mailupdates'] ?? ''), FILTER_SANITIZE_EMAIL);

    if (!filter_var($requester, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php");
        exit;
    }

    $mailto  = "info@gecodinitiative.org";
    $safeRequester = str_replace(["\r", "\n"], '', $requester);
    $headers = "From: Newsletter Subscriber <{$safeRequester}>\r\n";
    $headers .= "Reply-To: {$safeRequester}\r\n";
    $subject = "Newsletter Subscription Request";
    $body    = "A visitor has requested to receive updates from GECOD Initiative.\r\n\r\nEmail: {$requester}";

    mail($mailto, $subject, $body, $headers);
    header("Location: contact.php?updatesAdded");
    exit;

} else {
    header("Location: contact.php");
    exit;
}
?>
