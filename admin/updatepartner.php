<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['update_partner'])) {
    $id    = (int)($_POST['record_id']     ?? 0);
    $names = $conn->real_escape_string($_POST['partnernames'] ?? '');

    $imgUpdate = '';
    $allowed   = ['jpg','jpeg','png','gif','webp','svg'];
    $fileField = 'partnerlogo';

    if (!empty($_FILES[$fileField]['name']) && basename($_FILES[$fileField]['name']) !== '') {
        $ext = strtolower(pathinfo($_FILES[$fileField]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$fileField]['size'] <= 7000000) {
            $fname = $conn->real_escape_string(
                substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6) . ' ' . date('U') . '.' . $ext
            );
            if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/sponsors/' . $fname)) {
                $imgUpdate = ", partnerlogo='$fname'";
            }
        }
    }

    $conn->query("UPDATE gecodpartners SET partnernames='$names' $imgUpdate WHERE recordid=$id");
    header('Location: gecodpartners.php');
    exit;
}
header('Location: gecodpartners.php');
exit;
?>
