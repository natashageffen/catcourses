<!DOCTYPE html>
<html>

<?php
include 'top.php';
?>

<body class="site-feedback">
 

   <form name="feedback-form" method="post" action="feedback_email.php">
<table>
    <tr class="form-item">
 <td >
  <label>First Name *</label>
 </td>
 <td>
  <input  type="text" name="first_name" maxlength="50" size="30">
 </td>
</tr>
<tr class="form-item">
 <td>
  <label>Last Name *</label>
 </td>
 <td>
  <input  type="text" name="last_name" maxlength="50" size="30">
 </td>
</tr>
<tr class="form-item">
 <td >
  <label>Email Address *</label>
 </td>
 <td>
  <input  type="text" name="email" maxlength="80" size="30">
 </td>
</tr>
<tr class="form-item">
 <td>
  <label>Telephone Number</label>
 </td>
 <td>
  <input  type="text" name="telephone" maxlength="30" size="30">
 </td>
</tr>
<tr class="form-item">
 <td>
  <label>Comments *</label>
 </td>
 <td>
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 </td>
</tr>
<tr class="form-item">
    <td colspan="2" >
        <input class="submit-button" type="submit" value="SUBMIT">
 </td>
</tr>
</table>
</form>

    
</body>	

<?php
include 'footer.php'; ?>    

</html>