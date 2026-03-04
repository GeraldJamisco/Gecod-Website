<?php
include 'config.php';

if (isset($_POST['add_new_event'])) {
    $eventitle = $conn->real_escape_string($_POST['title']);
    $evencontent = $conn->real_escape_string($_POST['about']);
    $eventdate = $conn->real_escape_string($_POST['datec']);
    $eventimestart = $conn->real_escape_string($_POST['timestart']);
    $eventimend = $conn->real_escape_string($_POST['timeend']);
    $eventlocation = $conn->real_escape_string($_POST['location']);
    // $eventbanner = $conn->real_escape_string($_POST['']);

     // Generate Key
     function random_strings($length_of_string){
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0 , $length_of_string);
    }
    $r_string = random_strings(6);
    $timestamps = date('U');

    if (basename($_FILES["eventBanner"]["name"] !== "")) {
    //Upload Profile Photo Together With Profile
    $target_dir = '../img/events/';
    $target_file = $target_dir . basename($_FILES["eventBanner"]["name"]);
    $uploadOk = 1;
    $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    // Check file size max(7mbs)
    if ($_FILES["eventBanner"]["size"] > 7000000) {
    echo'<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;"> The file is too large. Photo should not exceed 7mbs.</div>';
    $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if (move_uploaded_file($_FILES["eventBanner"]["tmp_name"], "../img/events/".$r_string." ".$timestamps.".".$FileType)) {
    $conn->query("INSERT INTO gecodevents(eventTitle, eventInfo, eventDate, eventTimeStart, eventTimeEnd, eventLocation, eventImageLogo) VALUES ('$eventitle','$evencontent','$eventdate','$eventimestart','$eventimend','$eventlocation','$r_string $timestamps.$FileType')"); 
    header("Location: gecodevents.php");
    
    ?>
    <!-- <script type="text/javascript">
      function Redirect(){
          window.location = "";
      }
      document.write('<p class = "text-center" style = "margin-top: 15px; padding: 5px 10px; border-radius: 3px;"><span style = "color: #263b47; background-color: #f1a804; padding: 5px 20px; border-radius: 25px; font-size: 12px;">event added to the website and system successfuly created. Redirecting ...</span></p>');
      setTimeout('Redirect()', 5000);
    </script> -->
    <?php
    } else {
    echo '<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;">There was an error while uploading your photo.</div>';
    }
    }
    
    }
    
    
    ?>
    
