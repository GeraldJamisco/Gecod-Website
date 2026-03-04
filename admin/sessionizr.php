<?php
session_start();
if (!isset($_SESSION['gecodmail']) && !isset($_SESSION['gecodpassword'])) {
    header('location: index.php');
}else {
    header('dashboard.php');
}