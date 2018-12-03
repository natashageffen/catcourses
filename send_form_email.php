<?php
if(isset($_POST['txtEmail'])) {
 
    
    $Subj = $_POST["lstSubjects"];
    $fldnumber = $_POST["lstNumbers"];
    $fldTitle = $_POST["lstTitles"];
    $fldInstructor = $_POST["lstInstructors"];
    $fldClassStanding = $_POST["radClassStanding"];
    $fldDifficultyLevel = $_POST["radDifficultyLevel"];
    $fldTag = $_POST["chkTags"];
    $fldMajor = $_POST["txtMajor"];
    $fldSkills = $_POST["txtSkills"];
    $fldComments = $_POST["txtComments"];
    $fldEmail = $_POST["txtEmail"];
    
    
    
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $email_to = $_POST['txtEmail'];
    $email_subject = "Thanks for visiting Cat Courses!";
    $email_message = "Course review details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Subject: ".clean_string($Subj)."\n";
    $email_message .= "Course #: ".clean_string($fldNumber)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";

$headers = 'From: Cat Courses' .
'Reply-To: ngeffen@uvm.edu'."\r\n" .

@mail($email_to, $email_subject, $email_message, $headers);  
}
?>
