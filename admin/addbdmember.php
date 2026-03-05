<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_POST['add_new_member'])) {
    $bodnames = $conn->real_escape_string($_POST['bdNames']    ?? '');
    $bdtitle  = $conn->real_escape_string($_POST['bdTitle']    ?? '');
    $bdtwit   = $conn->real_escape_string($_POST['bdtwtlink']  ?? '');
    $bdfb     = $conn->real_escape_string($_POST['bdfblink']   ?? '');
    $bdwasap  = $conn->real_escape_string($_POST['bdwsplink']  ?? '');

    $allowed  = ['jpg','jpeg','png','gif','webp'];
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

        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], '../img/' . $filename)) {
            $conn->query("INSERT INTO teammembers(Names, Title, Twitter, Facebook, Whatsapp, image)
                          VALUES('$bodnames','$bdtitle','$bdtwit','$bdfb','$bdwasap','$filename')");
            header('Location: Members.php');
            exit;
        } else {
            echo '<div class="alert alert-danger">Error uploading photo.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Please select a photo.</div>';
    }
}
?>
