<?php
if (isset($_POST['submit'])) {
    
    $names = $_POST['name'];
    // echo $names;
    $emailfrom = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];


    $mailto = "info@gecodinitiative.org";
    $headers = "FROM: Gecod initiative's Website  ".$emailfrom;  //
    $txt = "You have received an email from ". $names.", ".$emailfrom.".\n\n".$message;
   mail($mailto, $subject, $txt, $headers);
  header ("Location: contact.php?messageSent");
}else if (isset($_POST['updates'])) {
    
    $mailto = "info@gecodinitiative.org";
    $requester = $_POST['mailupdates'];
    $headers = "FROM: ". $requester;
    $subject = "Coming from the Newsletter and Updates of your website";
    $txt = 'I am requesting for updates About Gecod Initiative, Please Contact me on ' .$requester. ' immediately, this is coming from your website in the footer mail input for Updates';
    mail($mailto, $subject, $txt, $headers);
    header ("Location: contact.php?Updates Coming To Your Inbox Now");
}
?>