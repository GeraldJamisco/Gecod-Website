<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['add_new_event'])) {
    $eventitle   = $conn->real_escape_string(isset($_POST['title'])     ? $_POST['title']     : '');
    $evencontent = $conn->real_escape_string(isset($_POST['about'])     ? $_POST['about']     : '');
    $eventdate   = $conn->real_escape_string(isset($_POST['datec'])     ? $_POST['datec']     : '');
    $eventstart  = $conn->real_escape_string(isset($_POST['timestart']) ? $_POST['timestart'] : '');
    $eventend    = $conn->real_escape_string(isset($_POST['timeend'])   ? $_POST['timeend']   : '');
    $eventloc    = $conn->real_escape_string(isset($_POST['location'])  ? $_POST['location']  : '');

    $allowed   = ['jpg','jpeg','png','gif','webp'];
    $fileField = 'eventBanner';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die('<div class="alert alert-danger">Invalid file type. Allowed: jpg, jpeg, png, gif, webp.</div>');
        }
        if ($_FILES[$fileField]['size'] > 7000000) {
            die('<div class="alert alert-danger">File too large. Max 7 MB.</div>');
        }

        $r_string  = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6);
        $timestamp = date('U');
        $filename  = $conn->real_escape_string($r_string . ' ' . $timestamp . '.' . $ext);

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/events/' . $filename)) {
            $conn->query("INSERT INTO gecodevents(eventTitle, eventInfo, eventDate, eventTimeStart, eventTimeEnd, eventLocation, eventImageLogo)
                          VALUES('$eventitle','$evencontent','$eventdate','$eventstart','$eventend','$eventloc','$filename')");
            header('Location: gecodevents.php');
            exit;
        } else {
            echo '<div class="alert alert-danger">Error uploading banner.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Please select an event banner.</div>';
    }
}
?>
