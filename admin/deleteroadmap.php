<?php
include 'config.php';
include 'sessionizr.php';

if (isset($_GET['deleteid'])) {
    $deleteroadmap = $conn->real_escape_string($_GET['deleteid']);
    $conn->query("DELETE FROM gecodroadmap WHERE recordid='$deleteroadmap'");
    header('Location: roadMap.php');
    exit;
}





?>