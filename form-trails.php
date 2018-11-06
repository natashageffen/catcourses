
<?php
include 'top.php';

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//       
print PHP_EOL . '<!-- SECTION: 1 Initialize variables -->' . PHP_EOL;
// These variables are used in both sections 2 and 3, otherwise we would
// declare them in the section we needed them

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

$pmkTrailsId = 0;
$fldTotalDistance = "";
$fldHikingTime = "HH:MM:SS";
$fldVerticalRise = "";
$fldRating = 0;
        
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

   
        $pmkTrailsId = (int) htmlentities($_POST["lstHikers"], ENT_QUOTES, "UTF-8");
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


   
    if ($pmkHikersId == "") {
        $errorMsg[] = 'Please select a name.';
        $hikerERROR = true;
    } elseif (!verifyAlpha($pmkHikersId)) {
        $errorMsg[] = 'This name appears to be incorrect.';
        $hikerERROR = true;
    }


     if ($date == "") {
        $errorMsg[] = 'Please enter a date';
        $dateERROR = true;
    } elseif (!verifyDate($date)) {
        $errorMsg[] = 'This date appears to be incorrect.';
        $dateERROR = true;
    }
    
    
    if ($pmkTrailsId == "") {
        $errorMsg[] = 'Please select a trail.';
        $trailERROR = true;
    } elseif (!verifyAlpha($pmkTrailsId)) {
        $errorMsg[] = 'This trail appears to be incorrect.';
        $trailERROR = true;
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
        $dataRecord[] = $pmkHikersId;
        $dataRecord[] = $date;
        $dataRecord[] = $pmkTrailsId;

        


        $query = "INSERT INTO tblHikersTrails(fnkHikersId, fldDateHiked, fnkTrailsId) ";
        $query .= "VALUES(?, ?, ?)";
//thisDatabaseWriter->testSecurityQuery($query, 0);
        // print $query;
        //print_r($dataRecord);
        if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $records = $thisDatabaseWriter->insert($query, $dataRecord);
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
//?>
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
       

            $query = "SELECT pmkHikersId, fldFirstName, fldLastName ";
            $query .= "FROM tblHikers ";
            $query .= "ORDER BY  pmkHikersId";


            // Step Three: run your query being sure to implement security
            if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
                $query = $thisDatabaseReader->sanitizeQuery($query);
                $hikers = $thisDatabaseReader->select($query);
            }
            ?>    

        

            <form action = "<?php print PHP_SELF; ?>"
                  id = "frmRegister"
                  method = "post">
                <fieldset class="listbox <?php if ($hikerERROR) print ' mistake'; ?>">

                    <?php
                    print "<h2>Name:</h2>";

                    print '<label for="lstHikers"';
                    if ($hikerERROR) {
                        print ' class = "mistake"';
                    }
                    print '>Hiker ';
                    print '<select id="lstHikers" ';
                    print '        name="lstHikers"';
                    print '        tabindex="300" >';


                    foreach ($hikers as $hiker) {

                        print '<option ';
                        if ($pmkHikersId == $hiker["pmkHikersId"])
                            print " selected='selected' ";

                        print 'value="' . $hiker["pmkHikersId"] . '">' . $hiker["fldFirstName"] . " " . $hiker["fldLastName"];

                        print '</option>';
                    }

                    print '</select></label>';

                    
                    ?>    
                    
                </fieldset>
                <fieldset class = "date">


                    <p>
                        <label class = "required" for = "txtDate">Date:</label>

                        <input 
    <?php if ($dateERROR) print 'class="mistake"'; ?>
                            id = "txtDate"     
                            maxlength = "45"
                            name = "txtDate"
                            onfocus = "this.select()"
                            placeholder = "YYYY-MM-DD"
                            tabindex = "120"
                            type = "text"
                            value = "<?php print $date; ?>"
                            >

                    </p>     
                </fieldset> 

                <fieldset class="radio <?php if ($trailERROR) print ' mistake'; ?>">
    <?php
    $query = "SELECT pmkTrailsId, fldTrailName ";
    $query .= "FROM tblTrails ";
    $query .= "ORDER BY pmkTrailsId";

    if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $trails = $thisDatabaseReader->select($query);
    }


    print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;
    print '<h2>Trails</h2>' . PHP_EOL;
   
    print '<fieldset class="radiobutton ';
    if ($trailERROR) {
        print ' mistake';
    }
    print '">';
    $i = 0;

    if (is_array($trails)) {
        foreach ($trails as $trail) {

            print "\t" . '<label for="rad' . str_replace(" ", "", $trail["fldTrailName"]) . '"><input type="radio" ';
            print ' id="rad' . str_replace(" ", "", $trail["fldTrailName"]) . '" ';
            print ' name="radTrails" ' ; 

            
            
            print 'value="' . $i++ . '">' . $trail["fldTrailName"];
            print '</label>' . PHP_EOL;
            
       
        }
    }
    print '</fieldset>' . PHP_EOL;
    
    ?>
                  
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

    
