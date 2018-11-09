
<?php
include 'top.php';

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//       
print PHP_EOL . '<!-- SECTION: 1 Initialize variables -->' . PHP_EOL;
// These variables are used in both sections 2 and 3, otherwise we would
// declare them in the section we needed them

$update = false;

print PHP_EOL . '<!-- SECTION: 1a. debugging setup -->' . PHP_EOL;
// We print out the post array so that we can see our form is working.
// Normally i wrap this in a debug statement but for now i want to always
// display it. when you first come to the form it is empty. when you submit the
// form it displays the contents of the post array.
// if ($debug){ 
?>



    <?php
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
    ?>


<?php
// }
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1b form variables -->' . PHP_EOL;
//
// Initialize variables one for each form element
// in the order they appear on the form

$pmkTrailsId = -1;
$fldTrailName = 0;
$fldTotalDistance = "";
$fldHikingTime = "HH:MM:SS";
$fldVerticalRise = "";
$fldRating = 0;
 
if (isset($_GET["id"])) {
    $pmkTrailsId = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");

    $query = 'SELECT fldTrailName, fldTotalDistance, fldHikingTime, fldVerticalRise, fldRating ';
    $query .= 'FROM tblTrails WHERE pmkTrailsId = ?';

    $data = array($pmkTrailsId);

    if ($thisDatabaseReader->querySecurityOk($query, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $records = $thisDatabaseReader->select($query, '');
    }
    
    $trailName = $record[0]["fldTrailName"];
    $distance = $record[0]["pmkTrailsId"];
    $time = $record[0]["fldTotalDistance"];
    $verticalRise = $record[0]["fldVerticalRise"];
    $rating = $record[0]["fldRating"];
}
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form

$trailERROR = false;
$distanceERROR = false;
$timeERROR = false;
$verticalRiseERROR = false;
$ratingERROR = false;

////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1d misc variables -->' . PHP_EOL;
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
        
// have we mailed the information to the user, flag variable?
//$mailed = false;       
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//



print PHP_EOL . '<!-- SECTION: 2 Process for when the form is submitted -->' . PHP_EOL;
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2a Security -->' . PHP_EOL;

    // the url for this form
    $thisURL = DOMAIN . PHP_SELF;

    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page.</p>';
        $msg .= '<p>Security breach detected and reported.</p>';
        die($msg);
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2b Sanitize (clean) data  -->' . PHP_EOL;
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

//
//    $pmkHikersId = (int) htmlentities($_POST["lstHikers"], ENT_QUOTES, "UTF-8");
//     
//    $date = htmlentities($_POST["txtDate"], ENT_QUOTES, "UTF-8");
//
//    $pmkTrailsId = (int) htmlentities($_POST["radTrails"], ENT_QUOTES, "UTF-8");
        
   
        $pmkTrailsId = (int) htmlentities($_POST["hidTrailsId"], ENT_QUOTES, "UTF-8");
        if ($pmkTrailsId > 0) {
            $update = true;
        }
        $fldTrailName = htmlentities($_POST["lstTrails"], ENT_QUOTES, "UTF-8");
        $fldTotalDistance = htmlentities($_POST["txtDistance"], ENT_QUOTES, "UTF-8");
        $fldHikingTime = htmlentities($_POST["txtTime"], ENT_QUOTES, "UTF-8");
        $fldVerticalRise = htmlentities($_POST["txtVerticalRise"], ENT_QUOTES, "UTF-8");
        $fldRating = (int) htmlentities($_POST["radRating"], ENT_QUOTES, "UTF-8");

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2c Validation -->' . PHP_EOL;
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.


   
    if ($fldTrailName == "") {
        $errorMsg[] = 'Please select a trail.';
        $trailERROR = true;
    } elseif (!verifyAlpha($fldTrailName)) {
        $errorMsg[] = 'This trail appears to be incorrect.';
        $trailERROR = true;
    }


    if ($fldTotalDistance == "") {
        $errorMsg[] = 'Please enter a distance';
        $distanceERROR = true;
    } elseif (!verifyNum($fldTotalDistance)) {
        $errorMsg[] = 'This distance appears to be incorrect.';
        $distanceERROR = true;
    }
    
    
     if ($fldHikingTime == "") {
        $errorMsg[] = 'Please enter a time';
        $timeERROR = true;
    } elseif (!verifyTime($fldHikingTime)) {
        $errorMsg[] = 'This time appears to be incorrect.';
        $timeERROR = true;
    }
    
    
     if ($fldVerticalRise == "") {
        $errorMsg[] = 'Please enter a vertical rise';
        $verticalRiseERROR = true;
    } elseif (!verifyNum($fldVerticalRise)) {
        $errorMsg[] = 'This vertical rise appears to be incorrect.';
        $verticalRiseERROR = true;
    }
    
    
    if ($fldRating == "") {
        $errorMsg[] = 'Please select a rating.';
        $ratingERROR = true;
    } elseif (!verifyAlpha($fldRating)) {
        $errorMsg[] = 'This rating appears to be incorrect.';
        $ratingERROR = true;
    }

    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2d Process Form - Passed Validation -->' . PHP_EOL;
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if (DEBUG) {
            print '<p>Form is valid</p>';

        }
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2e Save Data -->' . PHP_EOL;
        //
        // This block saves the data to a CSV file.   
        // array used to hold form values that will be saved to a CSV file
        $dataRecord = array();

        // assign values to the dataRecord array
        $dataRecord[] = $fldTrailName;
        $dataRecord[] = $fldTotalDistance;
        $dataRecord[] = $fldHikingTime;
        $dataRecord[] = $fldVerticalRise;
        $dataRecord[] = $fldRating;

        
        if ($update){
            $query = 'UPDATE tblTrails SET ';
        } else {
            $query = 'INSERT INTO tblTrails SET ';
        }

        $query = "INSERT INTO tblTrails(fldTrailName, fldTotalDistance, fldHikingTime, fldVerticalRise, fldRating) ";
        $query .= "VALUES(?, ?, ?, ?, ?)";
//thisDatabaseWriter->testSecurityQuery($query, 0);
        // print $query;
        //print_r($dataRecord);
        
        if ($update) {
            $query .= 'WHERE pmkTrailsId = ?';
            $data[] = $pmkTrailsId;
        
        
            if ($thisDatabaseWriter->querySecurityOk($query, 1)) {
                $query = $thisDatabaseWriter->sanitizeQuery($query);
                $records = $thisDatabaseWriter->insert($query, $dataRecord);
            }
        }   else{
        if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
            $query = $thisDatabaseWriter->sanitizeQuery($query);
            $records = $thisDatabaseWriter->insert($query, $dataRecord);
            }
        }
   
            if ($records) {
                print '<p>Record Saved</p>';
            } else {
                print '<p>Record NOT Saved</p>';
            }
           
        print PHP_EOL . '<!-- SECTION: 2f Create message -->' . PHP_EOL;
       

        $message = '<h2>Your  information:</h2>';

        foreach ($_POST as $htmlName => $value) {

            $message .= '<p>';
              
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));

            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . ' ';
            }

            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }

    } // end form is valid     
}   // ends if form was submitted.
//#############################################################################


print PHP_EOL . '<!-- SECTION 3 Display Form -->' . PHP_EOL;
//
?>       

        <?php
//####################################
//
        print PHP_EOL . '<!-- SECTION 3a  -->' . PHP_EOL;
// 
// If its the first time coming to the form or there are errors we are going
// to display the form.

        if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
            print '<h2>Thank you for providing your information.</h2>';
            print $message;
        } else {

            print '<h2>Tell us about your hike.</h2>';


            //####################################
            //
        print PHP_EOL . '<!-- SECTION 3b Error Messages -->' . PHP_EOL;
            //
            // display any error messages before we print out the form

            if ($errorMsg) {
                print '<div id="errors">' . PHP_EOL;
                print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
                print '<ol>' . PHP_EOL;

                foreach ($errorMsg as $err) {
                    print '<li>' . $err . '</li>' . PHP_EOL;
                }

                print '</ol>' . PHP_EOL;
                print '</div>' . PHP_EOL;
            }
        }
        
            //####################################
            //
        print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;
       ?>
    
      <form action="<?php print PHP_SELF; ?>"
      method="post"
      id="frmRegister">
        <input type="hidden" id="hidTrailsId" name="hidTrailsId"
               value="<?php print $pmkTrailsId; ?>"
               >

    <fieldset class = "form">
                    <p>
                        <label class="required" for="lstTrails">Trail Name:</label>  
                        
                        <?php if ($trailERROR) {
                                print 'class="mistake"'; } ?>
                               <select name ="lstTrails" id="lstTrails" maxlength="45" >
                               
                                   <option value="<?php print $trailName; ?>" >Camel's Hump </option>
                                   <option value="<?php print $trailName; ?>" >Snake Mountain </option>
                                   <option value="<?php print $trailName; ?>" >Prospect Rock (Manchester) </option>
                                   <option value="<?php print $trailName; ?>" >Skylight Pond </option>
                                   <option value="<?php print $trailName; ?>" >Mount Pisgah </option>
                               </p>      
   
                    <p>
                        <label class="required" for="txtDistance">Total distance:</label>  
                        <input
                        <?php if ($distanceERROR){ 
                                print 'class="mistake"'; }?>
                            id="txtDistance"
                            maxlength="45"
                            name="txtDistance"
                            onfocus="this.select()"
                            
                            tabindex="110"
                            type="text"
                            value="<?php print $distance; ?>"                    
                            >                    
                    </p>


                    <p>
                        <label class="required" for="txtTime">Hiking time:</label>  
                        <input
                        <?php if ($timeERROR){
                            print 'class="mistake"'; }?>
                            id="txtTime"
                            name="txtTime"
                            onfocus="this.select()"
                            placeholder="HH:MM:SS"
                            tabindex="120"
                            type="text"
                            value="<?php print $time; ?>"                    
                            >                    
                    </p>
                    
                     <p>
                        <label class="required" for="txtTime">Hiking time:</label>  
                        <input
                        <?php if ($timeERROR){
                            print 'class="mistake"'; }?>
                            id="txtTime"
                            name="txtTime"
                            onfocus="this.select()"
                            placeholder="HH:MM:SS"
                            tabindex="120"
                            type="text"
                            value="<?php print $time; ?>"                    
                            >                    
                    </p>
                    
                    <p>
                        <label class="required" for="txtVerticalRise">Vertical Rise:</label>  
                        <input
                        <?php if ($verticalRiseERROR){
                            print 'class="mistake"'; }?>
                            id="txtVerticalRise"
                            name="txtTime"
                            onfocus="this.select()"
                            placeholder=""
                            tabindex="120"
                            type="text"
                            value="<?php print $verticalRise; ?>"                    
                            >                    
                    </p>
                    <p>
                    <input type="radio" name="rating" value="0"> Easy<br>
                    <input type="radio" name="ratung" value="1"> Moderate<br>
                    <input type="radio" name="rating" value="2"> Moderately Strenuous<br>
                    <input type="radio" name="rating" value="3"> Strenuous<br>
              
                    </p>
                 

                 </fieldset>
      </form>
<?php include 'footer.php'; ?>

