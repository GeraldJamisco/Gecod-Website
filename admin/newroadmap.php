<?php
include 'config.php';

if (isset($_POST['add_new_roadmap'])) {
    $rdtitle = $conn->real_escape_string($_POST['roadmaptitle']);
    $rdcontent = $conn->real_escape_string($_POST['content']);
    
    // echo $bdwasap;

  // Generate Key
  function random_strings($length_of_string){
    $str_result = '1234567890';
    return substr(str_shuffle($str_result), 0 , $length_of_string);
}
$r_string = random_strings(4);

$timestamps = date('U');


     //    upload student pic
     if (basename($_FILES["profavatar"]["name"] !== "")) {
        //Upload Profile Photo Together With Profile
        $target_dir = '../img/';
        $target_file = $target_dir . basename($_FILES["profavatar"]["name"]);
        $uploadOk = 1;
        $FileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check file size max(7mbs)
        if ($_FILES["profavatar"]["size"] > 7000000) {
        echo'<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;"> The file is too large. Photo should not exceed 7mbs.</div>';
        $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if (move_uploaded_file($_FILES["profavatar"]["tmp_name"], "../img/".$r_string." ".$timestamps.".".$FileType)) {  
            // $conn->query("INSERT INTO gecodroadmap(Title, Content, image)VALUES('$rdtitle','$rdcontent', '$r_string $timestamps.$FileType')");
            if ($conn->query("INSERT INTO gecodroadmap(Title, Content, image)VALUES('$rdtitle','$rdcontent', '$r_string $timestamps.$FileType')") === TRUE) {
    // Insertion successful
} else {
    // Handle SQL error
    echo "Error: " . $conn->error;
}
    
        }





            ?>
            <script type="text/javascript">
            function Redirect() {
                window.location = "roadMap.php";
            }
            document.write(
                '<p class = "text-center" style = "margin-top: 15px; padding: 5px 10px; border-radius: 3px;"><span style = "color: #263b47; background-color: #f1a804; padding: 5px 20px; border-radius: 25px; font-size: 12px;">Road Map sent or Uploaded susccessfuly to GECOD Initiative\'s website. Redirecting ...</span></p>'
            );
            setTimeout('Redirect()', 5000);
            </script>
            <?php
        } else {
        echo '<div style = "background-color: #263b47; color: #f1a804; font-family: arial; font-weight: bold; text-align: center; padding: 20px;">There was an error while uploading your photo and content.</div>';
        }
}
?>