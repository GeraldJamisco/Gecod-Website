<?php
include 'config.php';

if (isset($_GET['deleteid'])) {
    $deleteroadmap = $conn->real_escape_string($_GET['deleteid']);
    
    $conn->query("DELETE FROM `gecodroadmap` WHERE `recordid` = '$deleteroadmap'");
    echo $deleteroadmap;

    header("location: roadMap.php");
}





?>