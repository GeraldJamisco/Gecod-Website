<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_GET['partnerid'])) {
    $deletepartner = $conn->real_escape_string($_GET['partnerid']);
    
    $conn->query("DELETE FROM gecodpartners WHERE recordid='$deletepartner'");

    header("location: gecodpartners.php");
}





?>