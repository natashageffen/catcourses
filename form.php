
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


$pmkCourseId = -1;
$fldSubject = 0;
$fldNumber = 0;
$fldTitle = 0;
$fldClassStanding = 0;
$fldDifficultyLevel = 0;
$fldTag = 0;
$fldMajor = 0;
$fldSkills = "";
$fldComments = "";




if (isset($_GET["id"])) {
    $pmkTrailsId = (int) htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");

    $query = 'SELECT pmkCourseId, fldSubject, fldNumber, fldTitle, fldClassStanding, fldDifficultyLevel, fldTag, fldMajor, fldSkills, fldComments ';
    $query .= 'FROM tblCourses WHERE pmkCourseId = ?';




    $data = array($pmkCourseId);

    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $course = $thisDatabaseReader->select($query, $data);
    }



    print "<p>course array:<pre>";
    print_r($course);
    print "</pre>";


    $fldSubject = $course[0]["fldSubject"];
    $fldNumber = $course[0]["fldNumber"];
    $fldTitle = $course[0]["fldTitle"];
    $fldClassStanding = $course[0]["fldClassStanding"];
    $fldDifficultyLevel = $course[0]["fldDifficultyLevel"];
    $fldTag = $course[0]["fldTag"];
    $fldMajor = $course[0]["fldMajor"];
    $fldSkills = $course[0]["fldSkills"];
    $fldComments = $course[0]["fldComments"];
}

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form

$subjectERROR = false;
$numberERROR = false;
$titleERROR = false;
$classStandingERROR = false;
$difficultyLevelERROR = false;
$tagERROR = false;
$majorERROR = false;




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


    $pmkCourseId = (int) htmlentities($_POST["hidCourseId"], ENT_QUOTES, "UTF-8");

    if ($pmkCourseId > 0) {
        $update = true;
    }

    $fldSubject = htmlentities($_POST["lstSubjects"], ENT_QUOTES, "UTF-8");
    $fldnumber = htmlentities($_POST["lstNumbers"], ENT_QUOTES, "UTF-8");
    $fldClassStanding = htmlentities($_POST["radClassStandings"], ENT_QUOTES, "UTF-8");
    $fldDifficultyLevel = htmlentities($_POST["radDifficultyLevels"], ENT_QUOTES, "UTF-8");
    $fldTag = htmlentities($_POST["chkTags"], ENT_QUOTES, "UTF-8");
    $fldMajor = htmlentities($_POST["lstMajors"], ENT_QUOTES, "UTF-8");
    $fldSkills = htmlentities($_POST["txtSkills"], ENT_QUOTES, "UTF-8");
    $fldComments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
   
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

 

    if ($fldSubject == "") {
        $errorMsg[] = 'Please select a subject.';
        $subjectERROR = true;
    } elseif (!verifyAlpha($fldSubject)) {
        $errorMsg[] = 'This subject appears to be incorrect.';
        $subjectERROR = true;
    }


    if ($fldNumber == "") {
        $errorMsg[] = 'Please select a number';
        $numberERROR = true;
    } elseif (!is_numeric($fldNumber)) {
        $errorMsg[] = 'This number appears to be incorrect.';
        $numberERROR = true;
    }

    if ($fldTitle == "") {
        $errorMsg[] = 'Please select a title.';
        $titleERROR = true;
    } 
    
    if ($_POST ['radClassStandings'] == -1) {
        $errorMsg[] = 'Please select a class standing.';
        $classStandingERROR = true;
    } 
    
    if ($_POST ['radDifficultyLevels'] == -1) {
        $errorMsg[] = 'Please select a difficulty level.';
        $difficultyLevelERROR = true;
    } elseif (!verifyAlpha($fldDifficultyLevel)) {
        $errorMsg[] = 'This difficulty level appears to be incorrect.';
        $difficultyLevelERROR = true;
    }
    
    if ($_POST ['chkTags'] == "") {
        $errorMsg[] = 'Please select a tag.';
        $tagERROR = true;
    } 

    if ($fldMajor == "") {
        $errorMsg[] = 'Please select a major.';
        $majorERROR = true;
    } elseif (!verifyAlpha($fldMajor)) {
        $errorMsg[] = 'This major appears to be incorrect.';
        $majorERROR = true;
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
        $dataRecord[] = $fldSubject;
        $dataRecord[] = $fldNumber;
        $dataRecord[] = $fldTitle;
        $dataRecord[] = $fldClassStanding;
        $dataRecord[] = $fldDifficultyLevel;
        $dataRecord[] = $fldTag;
        $dataRecord[] = $fldMajor;
        $dataRecord[] = $fldSkills;
        $dataRecord[] = $fldComments;
              

        print_r($dataRecord);


        if ($update) {
            $query = 'UPDATE tblCourses SET ';
            $query .= 'fldSubject = ?, ';
            $query .= 'fldNumber = ?, ';
            $query .= 'fldTitle = ?, ';
            $query .= 'fldClassStanding = ?, ';
            $query .= 'fldDifficultyLevel = ? ';
            $query .= 'fldTag = ? ';
            $query .= 'fldMajor = ? ';
            $query .= 'fldSkills = ? ';
            $query .= 'fldComments = ? ';
        } else {

            $query = "INSERT INTO tblCourses(fldSubject, fldNumber, fldTitle, fldClassStanding, fldDifficultyLevel, fldTag, fldMajor, fldSkills, fldComments) ";
            $query .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        }



//      
//thisDatabaseWriter->testSecurityQuery($query, 0);
        // print $query;
        //print_r($dataRecord); 




        if ($update) {
            $query .= 'WHERE pmkCourseId = ?';
            $dataRecord[] = $pmkCourseId;

            if ($thisDatabaseReader->querySecurityOk($query, 1)) {
                $query = $thisDatabaseWriter->sanitizeQuery($query);
                $records = $thisDatabaseWriter->update($query, $dataRecord);
            }
        } else {
            if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
                $query = $thisDatabaseReader->sanitizeQuery($query);
                $records = $thisDatabaseWriter->insert($query, $dataRecord);
            }
        }
        if ($records) {
            if ($update) {
                print '<p>Record updated</p>';
            } else {


                print '<p>Record Saved</p>';
            }
        } else {
            print '<p>Record NOT Saved</p>';
            print_r($dataRecord);
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


        if ($isAdmin == true) {
            ?> 
            <form action = "<?php print PHP_SELF; ?>"
                  id = "frmRegister"
                  method = "post"
                  >

                <input type="hidden" id="hidCourseId" name="hidCourseId"
                       value ="<?php print $pmkCourseId; ?>">
                       
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

                <fieldset class="radio <?php if ($classStandingERROR) print ' mistake'; ?>">
                    <legend>Class Standing (when you took the course):</legend>
                    <p>    
                        <label class="radio-field"><input type="radio" id="radClassStandingFreshman" name="radClassStanding" value="Freshman" tabindex="572" 
                                                          <?php if ($fldClassStanding == "Freshman") echo ' checked="checked" '; ?>>
                            Freshman</label>
                    </p>
                    <p>
                        <label class="radio-field"><input type="radio" id="radClassStandingSophomore" name="radClassStanding" value="Sophomore" tabindex="574" 
                                                          <?php if ($fldRating == "Sophomore") echo ' checked="checked" '; ?>>
                            Sophomore</label>
                    </p>

                    <p>
                        <label class="radio-field"><input type="radio" id="radClassStandingJunior" name="radClassStanding" value="Junior" tabindex="574" 
                                                          <?php if ($fldRating == "Junior") echo ' checked="checked" '; ?>>
                            Junior </label>
                    </p>

                    <p>
                        <label class="radio-field"><input type="radio" id="radClassStandingSenior" name="radClassStanding" value="Senior" tabindex="574" 
                                                          <?php if ($fldRating == "Senior") echo ' checked="checked" '; ?>>
                            Senior </label>
                    </p>
                </fieldset>

                
                 <fieldset class="radio <?php if ($fldDifficultyLevel) print ' mistake'; ?>">
                    <legend>Difficulty level of course:</legend>
                    <p>    
                        <label class="radio-field"><input type="radio" id="radDifficultyLevelEasy" name="radDifficultyLevel" value="Easy" tabindex="572" 
                                                          <?php if ($fldClassStanding == "Easy") echo ' checked="checked" '; ?>>
                            Easy</label>
                    </p>
                    <p>
                        <label class="radio-field"><input type="radio" id="radDifficultyLevelModerate" name="radDifficultyLevel" value="Moderate" tabindex="574" 
                                                          <?php if ($fldRating == "Moderate") echo ' checked="checked" '; ?>>
                            Moderate</label>
                    </p>

                    <p>
                        <label class="radio-field"><input type="radio" id="radDifficultyLevelHard" name="radDifficultyLevel" value="Hard" tabindex="574" 
                                                          <?php if ($fldRating == "Hard") echo ' checked="checked" '; ?>>
                            Hard </label>
                    </p>

                    <p>
                        <label class="radio-field"><input type="radio" id="radDifficultyLevelVeryHard" name="radDifficultyLevel" value="VeryHard" tabindex="574" 
                                                          <?php if ($fldRating == "VeryHard") echo ' checked="checked" '; ?>>
                            Very Hard </label>
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
        }
        else {
            print '<p>You are not authorized to see this page.</p>';
        }
    }
    ?>
</fieldset>     


<?php include 'footer.php'; ?>


