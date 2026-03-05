<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_GET['eventid'])) {
    $deleteevent = $conn->real_escape_string($_GET['eventid']);
    
    $conn->query("DELETE FROM gecodevents WHERE recordid='$deleteevent'");

    header("location: gecodevents.php");
}





?>