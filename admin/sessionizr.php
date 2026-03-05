<?php
session_start();
if (!isset($_SESSION['gecodmail']) || !isset($_SESSION['gecodpassword'])) {
    header('Location: index.php');
    exit;
}