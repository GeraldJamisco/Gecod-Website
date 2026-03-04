<?php
include 'config.php';

if (isset($_GET['orphanid'])) {
    $deleteorphan = $conn->real_escape_string($_GET['orphanid']);
    
    $conn->query("DELETE FROM gecodorphans WHERE orphanid='$deleteorphan'");

    header("location: benefeciaries.php");
}





?>