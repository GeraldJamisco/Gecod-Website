<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['update_member'])) {
    $id       = (int)($_POST['record_id'] ?? 0);
    $names    = $conn->real_escape_string($_POST['bdNames']   ?? '');
    $title    = $conn->real_escape_string($_POST['bdTitle']   ?? '');
    $twitter  = $conn->real_escape_string($_POST['bdtwit']    ?? '');
    $fb       = $conn->real_escape_string($_POST['bdfb']      ?? '');
    $whatsapp = $conn->real_escape_string($_POST['bdwasap']   ?? '');

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

    $conn->query("UPDATE teammembers SET Names='$names', Title='$title', Twitter='$twitter',
                  Facebook='$fb', Whatsapp='$whatsapp' $imgUpdate WHERE recordid=$id");
    header('Location: Members.php');
    exit;
}
header('Location: Members.php');
exit;
?>
