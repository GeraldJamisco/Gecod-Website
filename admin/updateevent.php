<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['update_event'])) {
    $id       = (int)(isset($_POST['record_id'])  ? $_POST['record_id']  : 0);
    $title    = $conn->real_escape_string(isset($_POST['title'])     ? $_POST['title']     : '');
    $about    = $conn->real_escape_string(isset($_POST['about'])     ? $_POST['about']     : '');
    $date     = $conn->real_escape_string(isset($_POST['datec'])     ? $_POST['datec']     : '');
    $tstart   = $conn->real_escape_string(isset($_POST['timestart']) ? $_POST['timestart'] : '');
    $tend     = $conn->real_escape_string(isset($_POST['timeend'])   ? $_POST['timeend']   : '');
    $location = $conn->real_escape_string(isset($_POST['location'])  ? $_POST['location']  : '');

    $imgUpdate = '';
    $allowed   = ['jpg','jpeg','png','gif','webp'];
    $fileField = 'eventBanner';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$fileField]['size'] <= 7000000) {
            $fname = $conn->real_escape_string(
                substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6) . ' ' . date('U') . '.' . $ext
            );
            if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/events/' . $fname)) {
                $imgUpdate = ", eventImageLogo='$fname'";
            }
        }
    }

    $conn->query("UPDATE gecodevents SET eventTitle='$title', eventInfo='$about', eventDate='$date',
                  eventTimeStart='$tstart', eventTimeEnd='$tend', eventLocation='$location'
                  $imgUpdate WHERE recordid=$id");
    header('Location: gecodevents.php');
    exit;
}
header('Location: gecodevents.php');
exit;
?>
