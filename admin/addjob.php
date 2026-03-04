<?php
include 'config.php';

if (isset($_POST['add_new_Job'])) {
    $jobTitle = $conn->real_escape_string($_POST['jobTitle']);
    $jobDescript = $conn->real_escape_string($_POST['jobDescript']);
    $jobPosition = $conn->real_escape_string($_POST['jobPosition']);
    $joblocation = $conn->real_escape_string($_POST['jobLocation']);
    $jobQualific = $conn->real_escape_string($_POST['jobQualific']);
    $jobExperie = $conn->real_escape_string($_POST['jobExperie']);
    $dld = $conn->real_escape_string($_POST['dld']);
    $jobsend = $conn->real_escape_string($_POST['jobsend']);
    $hiringType = $conn->real_escape_string($_POST['hiringType']);


  // Generate Key
  function random_strings($length_of_string){
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0 , $length_of_string);
   

}
$r_string = random_strings(6);
$timestamps = date('U');

if (basename($_FILES["profavatar"]["name"] !== "")) {
//Upload Profile Photo Together With Profile
$target_dir = '../img/job_banner_images/';
$target_file = $target_dir . basename($_FILES["profavatar"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check file size max(7mbs)
if ($_FILES["profavatar"]["size"] > 7000000) {
echo'<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;"> The file is too large. Photo should not exceed 7mbs.</div>';
$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if (move_uploaded_file($_FILES["profavatar"]["tmp_name"], "../img/job_banner_images/".$r_string." ".$timestamps.".".$FileType)) {

//  $conn->query(""); 
 $insertQuery = "INSERT INTO jobcareer(job_title, JobDescription, position, location, qualifications, experience, contacts, imgBanner, deadlineDate, hiringType) VALUES ('$jobTitle','$jobDescript','$jobPosition','$joblocation','$jobQualific','$jobExperie','$jobsend','$r_string $timestamps.$FileType','$dld','$hiringType')";
 if ($conn->query($insertQuery) === TRUE) {
     // Insertion successful
     // Redirect the user
     header("Location: careers.php");
     exit();
 } else {
     // Handle SQL error
     echo "Error: " . $conn->error;
 }
}
}

}


?>

