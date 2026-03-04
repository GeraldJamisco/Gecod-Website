<?php
include 'config.php';

if (isset($_POST['add_new_partner'])) {
    $partnernames = $conn->real_escape_string($_POST['partnernames']);

     // Generate Key
     function random_strings($length_of_string){
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0 , $length_of_string);
    }
    $r_string = random_strings(6);
    $timestamps = date('U');

    if (basename($_FILES["partnerlogo"]["name"] !== "")) {
    //Upload Profile Photo Together With Profile
    $target_dir = '../img/sponsors/';
    $target_file = $target_dir . basename($_FILES["partnerlogo"]["name"]);
    $uploadOk = 1;
    $FileType = pathinfo($target_file, PATHINFO_EXTENSION);
    
    // Check file size max(7mbs)
    if ($_FILES["partnerlogo"]["size"] > 7000000) {
    echo'<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;"> The file is too large. Photo should not exceed 7mbs.</div>';
    $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if (move_uploaded_file($_FILES["partnerlogo"]["tmp_name"], "../img/sponsors/".$r_string." ".$timestamps.".".$FileType)) {
    $conn->query("INSERT INTO gecodpartners(partnernames, partnerlogo) VALUES('$partnernames', '$r_string $timestamps.$FileType')"); 
    
    
    ?>
    <script type="text/javascript">
      function Redirect(){
          window.location = "gecodpartners.php";
      }
      document.write('<p class = "text-center" style = "margin-top: 15px; padding: 5px 10px; border-radius: 3px;"><span style = "color: #263b47; background-color: #f1a804; padding: 5px 20px; border-radius: 25px; font-size: 12px;">Partner added to the website and system successfuly created. Redirecting ...</span></p>');
      setTimeout('Redirect()', 5000);
    </script>
    <?php
    } else {
    echo '<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;">There was an error while uploading your photo.</div>';
    }
    }
    
    }
    
    
    ?>
    
    