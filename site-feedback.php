<!DOCTYPE html>
<html>

<?php
include 'top.php';
?>

<body class="site-feedback">
 

   <form name="feedback-form" method="post" action="feedback-email.php">
<table>
    <tr class="form-item">
 <td >
  <label>Did this site help you learn more about a course?</label>
 </td>
 <td>
  <input type="radio" name="helpful" value="yes" checked="checked"> Yes<br>
<input type="radio" name="helpful" value="no"> No<br>
 </td>
</tr>
 <tr class="form-item">
<td>
  <label>How could we improve this site?</label>
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