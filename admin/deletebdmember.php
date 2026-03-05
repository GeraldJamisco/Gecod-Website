<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_GET['memberid'])) {
    $id = (int)$_GET['memberid'];
    $conn->query("DELETE FROM teammembers WHERE recordid=$id");
    header('Location: Members.php');
    exit;
}
header('Location: Members.php');
exit;
?>
