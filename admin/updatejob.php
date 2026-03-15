<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['update_job'])) {
    $id          = (int)(isset($_POST['record_id'])    ? $_POST['record_id']    : 0);
    $title       = $conn->real_escape_string(isset($_POST['jobTitle'])     ? $_POST['jobTitle']     : '');
    $desc        = $conn->real_escape_string(isset($_POST['jobDescript'])  ? $_POST['jobDescript']  : '');
    $position    = $conn->real_escape_string(isset($_POST['jobPosition'])  ? $_POST['jobPosition']  : '');
    $location    = $conn->real_escape_string(isset($_POST['jobLocation'])  ? $_POST['jobLocation']  : '');
    $qualif      = $conn->real_escape_string(isset($_POST['jobQualific'])  ? $_POST['jobQualific']  : '');
    $experience  = $conn->real_escape_string(isset($_POST['jobExperie'])   ? $_POST['jobExperie']   : '');
    $contacts    = $conn->real_escape_string(isset($_POST['jobsend'])      ? $_POST['jobsend']      : '');
    $deadline    = $conn->real_escape_string(isset($_POST['dld'])          ? $_POST['dld']          : '');
    $hiringType  = $conn->real_escape_string(isset($_POST['hiringType'])   ? $_POST['hiringType']   : '');
    $workingHrs  = $conn->real_escape_string(isset($_POST['workingHours']) ? $_POST['workingHours'] : '');

    $imgUpdate = '';
    $allowed   = ['jpg','jpeg','png','gif','webp'];
    $fileField = 'profavatar';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$fileField]['size'] <= 7000000) {
            $fname = $conn->real_escape_string(
                substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6) . ' ' . date('U') . '.' . $ext
            );
            if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/job_banner_images/' . $fname)) {
                $imgUpdate = ", imgBanner='$fname'";
            }
        }
    }

    $conn->query("UPDATE jobcareer SET job_title='$title', JobDescription='$desc', position='$position',
                  location='$location', qualifications='$qualif', experience='$experience',
                  contacts='$contacts', deadlineDate='$deadline', hiringType='$hiringType',
                  workingHours='$workingHrs' $imgUpdate WHERE recordid=$id");
    header('Location: careers.php');
    exit;
}
header('Location: careers.php');
exit;
?>
