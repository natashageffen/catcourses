<?php

include 'top.php';

if(isset($_POST['helpful'])) {
 ?>
    <h1 id="form-head">Thanks for your feedback!</h1>
   <?php
    $email_to = "ngeffen@uvm.edu";
    $email_subject = "Email from website";
 
    ?>
    
    <span id="error-message">
    
    <?php
    function died($error) {
        echo "The following error(s) were found with the form you submitted:<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 

    if(!isset($_POST['helpful']) ||
        !isset($_POST['comments'])) {
        died('There appears to be a problem with the form you submitted.');       
    }
 
     
 
    $helpful = $_POST['helpful']; 
    $comments = $_POST['comments']; 
   
 
  if(strlen($comments) < 1) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
  
   ?>
    
    </span>
    
    <?php
    
    $email_message = "Form details below.\n\n";
 
    
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "Did you find this site helpful?: ".clean_string($helpful)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";

$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

}

include 'footer.php';

?>

