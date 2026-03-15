<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['add_new_Job'])) {
    $jobTitle    = $conn->real_escape_string(isset($_POST['jobTitle'])     ? $_POST['jobTitle']     : '');
    $jobDescript = $conn->real_escape_string(isset($_POST['jobDescript']) ? $_POST['jobDescript'] : '');
    $jobPosition = $conn->real_escape_string(isset($_POST['jobPosition']) ? $_POST['jobPosition'] : '');
    $joblocation = $conn->real_escape_string(isset($_POST['jobLocation']) ? $_POST['jobLocation'] : '');
    $jobQualific = $conn->real_escape_string(isset($_POST['jobQualific']) ? $_POST['jobQualific'] : '');
    $jobExperie  = $conn->real_escape_string(isset($_POST['jobExperie'])  ? $_POST['jobExperie']  : '');
    $dld         = $conn->real_escape_string(isset($_POST['dld'])         ? $_POST['dld']         : '');
    $jobsend     = $conn->real_escape_string(isset($_POST['jobsend'])     ? $_POST['jobsend']     : '');
    $hiringType  = $conn->real_escape_string(isset($_POST['hiringType'])  ? $_POST['hiringType']  : '');
    $workingHrs  = $conn->real_escape_string(isset($_POST['workingHours']) ? $_POST['workingHours'] : '');

    $allowed   = ['jpg','jpeg','png','gif','webp'];
    $fileField = 'profavatar';

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

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/job_banner_images/' . $filename)) {
            $q = "INSERT INTO jobcareer(job_title, JobDescription, position, location, qualifications, experience,
                  contacts, imgBanner, deadlineDate, hiringType, workingHours)
                  VALUES('$jobTitle','$jobDescript','$jobPosition','$joblocation','$jobQualific','$jobExperie',
                         '$jobsend','$filename','$dld','$hiringType','$workingHrs')";
            if ($conn->query($q)) {
                header('Location: careers.php');
                exit;
            } else {
                echo '<div class="alert alert-danger">Database error: ' . htmlspecialchars($conn->error) . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Error uploading image.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Please select a banner image.</div>';
    }
}
?>
