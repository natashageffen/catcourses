
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

$date = "YYYY-MM-DD";

$pmkHikersId = 0;

$pmkTrailsId = 0;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form

$dateERROR = false;
$hikerERROR = false;
$trailERROR = false;


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


    $date = htmlentities($_POST["txtDate"], ENT_QUOTES, "UTF-8");

    $pmkTrailsId = (int) htmlentities($_POST["radTrails"], ENT_QUOTES, "UTF-8");

    $pmkHikersId = (int) htmlentities($_POST["lstHikers"], ENT_QUOTES, "UTF-8");


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


    if ($date == "") {
        $errorMsg[] = 'Please enter a date';
        $dateERROR = true;
    } elseif (!verifyDate($date)) {
        $errorMsg[] = 'This date appears to be incorrect.';
        $dateERROR = true;
    }


    if ($pmkHikersId == "") {
        $errorMsg[] = 'Please select a name.';
        $hikerERROR = true;
    } elseif (!verifyAlpha($pmkHikersId)) {
        $errorMsg[] = 'This name appears to be incorrect.';
        $hikerERROR = true;
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

        $dataRecord[] = $pmkTrailsId;

        $dataRecord[] = $date;


        $query = "INSERT INTO tblHikersTrails(fnkHikersId, fnkTrailsId, fldDateHiked) ";
        $query .= "VALUES(?, ?, ?)";
//thisDatabaseWriter->testSecurityQuery($query, 0);
        // print $query;
        //print_r($dataRecord);
        if ($thisDatabaseWriter->querySecurityOk($query, 0)) {
            $query = $thisDatabaseReader->sanitizeQuery($query);
            $records = $thisDatabaseWriter->insert($query, $dataRecord);
        }
        ?>
        
            <?php
            if ($records) {
                print '<p>Record Saved</p>';
            } else {
                print '<p>Record NOT Saved</p>';
            }
            ?>
       
        <?php
        /* // setup csv file
          $myFolder = 'data/';
          $myFileName = 'registration';
          $fileExt = '.csv';
          $filename = $myFolder . $myFileName . $fileExt;

          if ($debug)
          print PHP_EOL . '<p>filename is ' . $filename;

          // now we just open the file for append
          $file = fopen($filename, 'a');

          // write the forms informations
          fputcsv($file, $dataRecord);

          // close the file
          fclose($file);
         */

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2f Create message -->' . PHP_EOL;
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2>Your  information.</h2>';

        foreach ($_POST as $htmlName => $value) {

            $message .= '<p>';
            // breaks up the form names into words. for example
            // txtFirstName becomes First Name       
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));

            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . ' ';
            }

            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
//        print PHP_EOL . '<!-- SECTION: 2g Mail to user -->' . PHP_EOL;
//        //
//        // Process for mailing a message which contains the forms data
//        // the message was built in section 2f.
//        $to = $email; // the person who filled out the form     
//        $cc = '';
//        $bcc = '';
//
//        $from = 'WRONG site <customer.service@your-site.com>';
//
//        // subject of mail should make sense to your form
//        $subject = 'Groovy: ';

       // $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
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

//            print '<p>For your records a copy of this data has ';
//            if (!$mailed) {
//                print "not ";
//            }
//
//            print 'been sent:</p>';
//            print '<p>To: ' . $email . '</p>';

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
            //
            /* Display the HTML form. note that the action is to this same page. $phpSelf
              is defined in top.php
              NOTE the line:
              value="<?php print $email; ?>
              this makes the form sticky by displaying either the initial default value (line ??)
              or the value they typed in (line ??)
              NOTE this line:
              <?php if($emailERROR) print 'class="mistake"'; ?>
              this prints out a css class so that we can highlight the background etc. to
              make it stand out that a mistake happened here.
             */

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
                    <!--
                    <legend>Name:</legend>
                    <select id="lstHikers"
                            name="lstHikers"
                            tabindex="520">
                        <option <?php //if ($pmkHikersId == "1") print " selected ";  ?>
                            value="1">Spongebob Squarepants</option>

                        <option <?php //if ($pmkHikersId == "2") print " selected ";  ?>
                            value="2">Patrick Star</option>

                        <option <?php //if ($pmkHikersId == "3") print " selected ";  ?>
                            value="3">Squidward Tentacles</option>

                        <option <?php //if ($pmkHikersId == "4") print " selected ";  ?>
                            value="4">Eugene Krabs</option>

                        <option <?php //if ($pmkHikersId == "5") print " selected ";  ?>
                            value="5">Sandy Cheeks</option>

                    </select>

                    -->
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
            print ' name="radTrails" ' ; // . str_replace(" ", "", $trail["fldTrailName"]) . '" ';

            
            
            print 'value="' . $i++ . '">' . $trail["fldTrailName"];
            print '</label>' . PHP_EOL;
            
        }
    }
    print '</fieldset>' . PHP_EOL;
    
    ?>
                    <!--                    <legend>Trail:</legend>
                                        <p>
                                            <label class="radio-field">
                                                <input type="radio"
                                                       id="1"
                                                       name="radTrail"
                                                       value="1"
                                                       tabindex="572"
    <?php // if ($trail == "Camel's Hump") echo ' checked="checked" ';  ?>>
                                                Camel's Hump
                                            </label>
                                        </p>
                                        <p>
                                            <label class="radio-field">
                                                <input type="radio"
                                                       id="2"
                                                       name="radTrail"
                                                       value="2"
                                                       tabindex="582"
    <?php // if ($trail == "Snake Mountain") echo ' checked="checked" ';  ?>>
                                                Snake Mountain
                                            </label>
                                        </p>
                                        <p>
                                            <label class="radio-field">
                                                <input type="radio"
                                                       id="3"
                                                       name="radTrail"
                                                       value="3"
                                                       tabindex="582"
    <?php // if ($trail == "Prospect Rock") echo ' checked="checked" ';  ?>>
                                                Prospect Rock
                                            </label>
                                        </p>
                                        <p>
                                            <label class="radio-field">
                                                <input type="radio"
                                                       id="4"
                                                       name="radTrail"
                                                       value="4"
                                                       tabindex="582"
    <?php // if ($trail == "Skylight Pond") echo ' checked="checked" ';  ?>>
                                                Skylight Pond
                                            </label>
                                        </p>
                                        <p>
                                            <label class="radio-field">
                                                <input type="radio"
                                                       id="5"
                                                       name="radTrail"
                                                       value="5"
                                                       tabindex="582"
    <?php //if ($trail == "Mount Pisgah") echo ' checked="checked" ';  ?>>
                                                Mount Pisgah
                                            </label>
                                        </p>-->
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

    
