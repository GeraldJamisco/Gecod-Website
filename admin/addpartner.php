<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['add_new_partner'])) {
    $partnernames = $conn->real_escape_string($_POST['partnernames'] ?? '');

    $allowed   = ['jpg','jpeg','png','gif','webp','svg'];
    $fileField = 'partnerlogo';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die('<div class="alert alert-danger">Invalid file type. Allowed: jpg, jpeg, png, gif, webp, svg.</div>');
        }
        if ($_FILES[$fileField]['size'] > 7000000) {
            die('<div class="alert alert-danger">File too large. Max 7 MB.</div>');
        }

        $r_string  = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6);
        $timestamp = date('U');
        $filename  = $conn->real_escape_string($r_string . ' ' . $timestamp . '.' . $ext);

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/sponsors/' . $filename)) {
            $conn->query("INSERT INTO gecodpartners(partnernames, partnerlogo) VALUES('$partnernames','$filename')");
            header('Location: gecodpartners.php');
            exit;
        } else {
            echo '<div class="alert alert-danger">Error uploading logo.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Please select a partner logo.</div>';
    }
}
?>
