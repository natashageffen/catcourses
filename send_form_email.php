<?php
if(isset($_POST['txtEmail'])) {
 
    
    $Subj = $_POST["lstSubjects"];
    $Number = $_POST["lstNumbers"];
    $Instructor = $_POST["lstInstructors"];
    $fldDifficultyLevel = $_POST["radDifficultyLevel"];
    $fldTag = $_POST["chkTags"];
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
    $email_message .= "Course #: ".clean_string($Number)."\n";
    $email_message .= "Instructor: ".clean_string($Instructor)."\n";
    $email_message .= "Difficulty Level: ".clean_string($fldDifficultyLevel)."\n";
    $email_message .= "Tag: ".clean_string($fldTag)."\n";
    $email_message .= "Skills Learned: ".clean_string($fldSkills)."\n";
    $email_message .= "Comments: ".clean_string($fldComments)."\n";

$headers = 'From: Cat Courses' .
'Reply-To: ngeffen@uvm.edu'."\r\n" .

@mail($email_to, $email_subject, $email_message, $headers);  
}
?>
