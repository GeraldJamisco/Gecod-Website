<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['update_beneficiary'])) {
    $orphanid = $conn->real_escape_string($_POST['orphanid'] ?? '');
    $names    = $conn->real_escape_string($_POST['benefNames'] ?? '');
    $bio      = $conn->real_escape_string($_POST['benefBio']   ?? '');
    $dob      = $conn->real_escape_string($_POST['dob']        ?? '');
    $gender   = $conn->real_escape_string($_POST['gender']     ?? '');

    $imgUpdate = '';
    $allowed   = ['jpg','jpeg','png','gif','webp'];
    $fileField = 'profavatar';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$fileField]['size'] <= 7000000) {
            $fname = $conn->real_escape_string(
                substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6) . ' ' . date('U') . '.' . $ext
            );
            if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/beneficiaries/' . $fname)) {
                $imgUpdate = ", orphanImage='$fname'";
            }
        }
    }

    $conn->query("UPDATE gecodorphans SET orphanNames='$names', orphanInfo='$bio',
                  orphanBirthday='$dob', orphanGender='$gender' $imgUpdate
                  WHERE orphanid='$orphanid'");
    header('Location: benefeciaries.php');
    exit;
}
header('Location: benefeciaries.php');
exit;
?>
