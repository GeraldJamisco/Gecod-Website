<?php
// Local XAMPP settings
$hostname = "localhost";
$username = "root";
$password = ""; // XAMPP default is empty
$database = "gecodini_gecoddatabase"; // Ensure this database exists in your local phpMyAdmin

// Update this to your local folder path (e.g., http://localhost/your-project-folder/)
if (!defined('base_url')) define('base_url', 'http://localhost/');

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully to local database!";
