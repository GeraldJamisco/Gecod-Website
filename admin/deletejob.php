<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_GET['jobid'])) {
    $deletejob = $conn->real_escape_string($_GET['jobid']);
    
    $conn->query("DELETE FROM jobcareer WHERE recordid='$deletejob'");

    header("location: careers.php");
}





?>