
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
$pmkTag = 0;



if (isset($_GET["id"])) {
    $pmkTrailsId = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");

    $query = 'SELECT fldTrailName, fldTotalDistance, fldHikingTime, fldVerticalRise, fldRating ';
    $query .= 'FROM tblTrails WHERE pmkTrailsId = ?';

    $data = array($pmkTrailsId);

    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $trail = $thisDatabaseReader->select($query, $data);
    }

    print "<p>trail array:<pre>"; print_r($trail); print "</pre>";
    
    $fldTrailName = $trail[0]["fldTrailName"];
    $fldTotalDistance = $trail[0]["fldTotalDistance"];
    $fldHikingTime = $trail[0]["fldHikingTime"];
    $fldVerticalRise = $trail[0]["fldVerticalRise"];
    $fldRating = $trail[0]["fldRating"];
    
    
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
$tagERROR = false;


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


    $pmkTrailsId = (int) htmlentities($_POST["hidTrailsId"], ENT_QUOTES, "UTF-8");
    if ($pmkTrailsId > 0) {
        $update = true;
    }
    $fldTrailName = htmlentities($_POST["lstTrails"], ENT_QUOTES, "UTF-8");
    $fldTotalDistance = htmlentities($_POST["txtDistance"], ENT_QUOTES, "UTF-8");
    $fldHikingTime = htmlentities($_POST["txtTime"], ENT_QUOTES, "UTF-8");
    $fldVerticalRise = htmlentities($_POST["txtVerticalRise"], ENT_QUOTES, "UTF-8");
    $fldRating = (int) htmlentities($_POST["radRating"], ENT_QUOTES, "UTF-8");
    $pmkTag = (int) htmlentities($_POST["chkTag"], ENT_QUOTES, "UTF-8");


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
    } elseif (!is_numeric($fldTotalDistance)) {
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
    } elseif (!is_numeric($fldVerticalRise)) {
        $errorMsg[] = 'This vertical rise appears to be incorrect.';
        $verticalRiseERROR = true;
    }



        if($_POST['radRating'] == -1) {
            $errorMsg[] = 'Please select a rating.';
            $ratingERROR = true;
        }
    

 
        if($_POST['chkTag'] == -1) {
            $errorMsg[] = 'Please select a tag.';
            $tagERROR = true;
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

        if ($update) {
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

                if ($thisDatabaseReader->querySecurityOk($query, 1)) {
                    $query = $thisDatabaseWriter->sanitizeQuery($query);
                    $results = $thisDatabaseWriter->update($query, $data);
                }
            } else {
                    if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                        $query = $thisDatabaseReader->sanitizeQuery($query);
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
//
?>
<fieldset class ="formbox">
    <?php
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

    //####################################
    //
        print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;


//    $query = "SELECT pmkTrailsId, fldTrailName ";
//    $query .= "FROM tblTrails ";
//    $query .= "ORDER BY  pmkTrailsId";
//
//
//    // Step Three: run your query being sure to implement security
//    if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
//        $query = $thisDatabaseReader->sanitizeQuery($query);
//        $hikers = $thisDatabaseReader->select($query);
//    }
    ?>    



        <form action = "<?php print PHP_SELF; ?>"
              id = "frmRegister"
              method = "post"
              >
            
            <input type="hidden" id="hidTrailsId" name="hidTrailsId"
                   value ="<?php $pmkTrailsId; ?>"

            <fieldset  class="listbox <?php if ($trailERROR) print ' mistake'; ?>">
                <p>
                <legend>Trail Name</legend>
                <select id="lstTrails" 
                        name="lstTrails" 
                        tabindex="520" >
                    <option <?php if ($fldTrailName == "Camel's Hump") print " selected "; ?>
                        value="Camel's Hump">Camel's Hump</option>

                    <option <?php if ($fldTrailName == "Snake Mountain") print " selected "; ?>
                        value="Snake Mountain">Snake Mountain</option>

                    <option <?php if ($fldTrailName == "Prospect Rock (Manchester)") print " selected "; ?>
                        value="Prospect Rock (Manchester)">Prospect Rock (Manchester)</option>
                    
                    <option <?php if ($fldTrailName == "Skylight Pond") print " selected "; ?>
                        value="Skylight Pond">Skylight Pond</option>
                    
                    <option <?php if ($fldTrailName == "Mount Pisgah") print " selected "; ?>
                        value="Mount Pisgah">Mount Pisgah</option>
                    
                </select>
                </p>
            </fieldset>

            <fieldset class = "distance">


                <p>
                    <label class = "required" for = "txtDistance">Total Distance:</label>

                    <input 
    <?php if ($distanceERROR) print 'class="mistake"'; ?>
                        id = "txtDistance"     
                        maxlength = "45"
                        name = "txtDistance"
                        onfocus = "this.select()"
                        placeholder = ""
                        tabindex = "120"
                        type = "text"
                        value = "<?php print $fldTotalDistance; ?>"
                        >

                </p>     
            </fieldset> 

            <fieldset class = "time">


                <p>
                    <label class = "required" for = "txtTime">Hiking Time:</label>

                    <input 
    <?php if ($timeERROR) print 'class="mistake"'; ?>
                        id = "txtTime"     
                        maxlength = "45"
                        name = "txtTime"
                        onfocus = "this.select()"
                        placeholder = "HH:MM:SS"
                        tabindex = "120"
                        type = "text"
                        value = "<?php print $fldHikingTime; ?>"
                        >

                </p>     
            </fieldset> 

            <fieldset class = "distance">


                <p>
                    <label class = "required" for = "txtVerticalRise">Vertical Rise:</label>

                    <input 
    <?php if ($verticalRiseERROR) print 'class="mistake"'; ?>
                        id = "txtVerticalRise"     
                        maxlength = "45"
                        name = "txtVerticalRise"
                        onfocus = "this.select()"
                        placeholder = ""
                        tabindex = "120"
                        type = "text"
                        value = "<?php print $fldVerticalRise; ?>"
                        >

                </p>     
            </fieldset> 
            
                <fieldset class="radio <?php if ($ratingERROR) print ' mistake'; ?>">
                    <legend>Trail Rating:</legend>
                    <p>    
                        <label class="radio-field"><input type="radio" id="radRatingEasy" name="radRating" value="Easy" tabindex="572" 
    <?php if ($fldRating == "Easy") echo ' checked="checked" '; ?>>
                            Easy</label>
                    </p>
                    <p>
                        <label class="radio-field"><input type="radio" id="radRatingModerate" name="radRating" value="Moderate" tabindex="574" 
    <?php if ($fldRating == "Moderate") echo ' checked="checked" '; ?>>
                            Moderate</label>
                    </p>

                    <p>
                        <label class="radio-field"><input type="radio" id="radRatingModeratelyStrenuous" name="radRating" value="Moderately Strenuous" tabindex="574" 
    <?php if ($fldRating == "Moderately Strenuous") echo ' checked="checked" '; ?>>
                            Moderately Strenuous </label>
                    </p>
                    
                    <p>
                        <label class="radio-field"><input type="radio" id="radRatingStrenuous" name="radRating" value="Strenuous" tabindex="574" 
    <?php if ($fldRating == "Strenuous") echo ' checked="checked" '; ?>>
                            Strenuous </label>
                    </p>
                </fieldset>
            
            <fieldset class="checkbox <?php if ($activityERROR) print ' mistake'; ?>">
    <legend>Check the boxes that apply to this hike:</legend>

    <p>
        <label class="check-field">
            <input <?php if ($pmkTag == "Dogs Allowed") print " checked "; ?>
                id="chkTagDogsAllowed"
                name="chkTag"
                tabindex="420"
                type="checkbox"
                value="Dogs Allowed"> Dogs Allowed</label>
    </p>

    <p>
        <label class="check-field">
            <input <?php if ($pmkTag == "Easy") print " unchecked "; ?>
                id="chkTagEasy"
                name="chkTag"
                tabindex="420"
                type="checkbox"
                value="Easy"> Easy</label>
        
        <label class="check-field">
            <input <?php if ($pmkTag == "Hard") print " unchecked "; ?>
                id="chkTagHard"
                name="chkTag"
                tabindex="420"
                type="checkbox"
                value="Hard"> Hard</label>
    </p>
    
    
    <label class="check-field">
            <input <?php if ($pmkTag == "Hiking") print " unchecked "; ?>
                id="chkTagHiking"
                name="chkTag"
                tabindex="420"
                type="checkbox"
                value="Hiking"> Hiking</label>
    
    <label class="check-field">
            <input <?php if ($pmkTag == "Skiing") print " unchecked "; ?>
                id="chkTagSkiing"
                name="chkTag"
                tabindex="420"
                type="checkbox"
                value="Skiing"> Skiing</label>
    
    <label class="check-field">
            <input <?php if ($pmkTag == "Views") print " unchecked "; ?>
                id="chkTagViews"
                name="chkTag"
                tabindex="420"
                type="checkbox"
                value="Views"> Views</label>
</fieldset>
            
            <fieldset class="buttons">
                <legend></legend>
                <input class = "button" id = "btnSubmit" name = "btnSubmit" tabindex = "900" type = "submit" value = "Register" >
            </fieldset> <!-- ends buttons -->
        </form>     

    <?php
} // ends body submit
?>
</fieldset>     


<?php include 'footer.php'; ?>


