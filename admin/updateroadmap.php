<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['update_roadmap'])) {
    $id      = (int)(isset($_POST['record_id']) ? $_POST['record_id'] : 0);
    $title   = $conn->real_escape_string(isset($_POST['rdtitle'])   ? $_POST['rdtitle']   : '');
    $content = $conn->real_escape_string(isset($_POST['rdcontent']) ? $_POST['rdcontent'] : '');

    $imgUpdate = '';
    $allowed   = ['jpg','jpeg','png','gif','webp'];
    $fileField = 'profavatar';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$fileField]['size'] <= 7000000) {
            $fname = $conn->real_escape_string(
                substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6) . ' ' . date('U') . '.' . $ext
            );
            if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/' . $fname)) {
                $imgUpdate = ", image='$fname'";
            }
        }
    }

    $conn->query("UPDATE gecodroadmap SET Title='$title', content='$content' $imgUpdate WHERE recordid=$id");
    header('Location: roadMap.php');
    exit;
}
header('Location: roadMap.php');
exit;
?>
