
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
// }
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1b form variables -->' . PHP_EOL;
//
// Initialize variables one for each form element
// in the order they appear on the form


$Subj = "";
$Number = "";
$Instructor = "";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form

$searchSubjectERROR = false;
$searchNumberERROR = false;
$searchInstructorERROR = false;



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




    $Subj = htmlentities($_POST["lstSubjects"], ENT_QUOTES, "UTF-8");
    $Number = htmlentities($_POST["lstNumbers"], ENT_QUOTES, "UTF-8");
    $Instructor = htmlentities($_POST["lstInstructors"], ENT_QUOTES, "UTF-8");
    

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



    if ($Subj == "" AND !$Number ==""){
        $errorMsg[] = 'Please select a subject.';
        $searchSubjectERROR = true;
        
    }


    if ($Number == "" AND !$Subj =="") {
        $errorMsg[] = 'Please select a course number';
        $searchNumberERROR = true;
    }
    
   
    if ($Instructor == "" AND $Subj == "") {
        $errorMsg[] = 'Please select a course or instructor.';
        $searchInstructorERROR = true;
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
//        $dataRecord = array();
//
//        // assign values to the dataRecord array
//        $dataRecord[] = $searchSubj;
//        $dataRecord[] = $searchNumber;
//        $dataRecord[] = $searchInstructor;




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
   // ends if form was submitted.
//#############################################################################
//
?>
<fieldset class ="formbox">
<?php
//print PHP_EOL . '<!-- SECTION 3 Display Form -->' . PHP_EOL;
////

//        $dataRecord[] = $searchSubj;
//        $dataRecord[] = $searchNumber;
//        $dataRecord[] = $searchInstructor;
//
//
//
//
//        print PHP_EOL . '<!-- SECTION: 2f Create message -->' . PHP_EOL;
//        
//        $searchSubj = ($_POST['lstSubjects']);
//        $searchNum = ($_POST['lstNumbers']);
//        $searchInstructors = ($_POST['lstInstructors']);
//        
//      
//        if(!$Subj == "" AND !$searchSubjectERROR){
//            $query = 'SELECT * FROM tblCourses';
//            $query .= 'WHERE lstSubjects = ? ';
//            }
//        
//        if(!$Number == "" AND !$searchNumberERROR){
//            $query = 'SELECT * FROM tblCourses';
//            $query .= 'WHERE lstNumbers = ? ';
//            }
//        
//            
//        if(!$Instructor == "" AND !$searchInstructorERROR){
//            $query = 'SELECT * FROM tblCourses';
//            $query .= 'WHERE lstInstructors = ? ';
//            }
//        
//            if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
//        $query = $thisDatabaseReader->sanitizeQuery($query);
//        $searchResults = $thisDatabaseReader->select($query);
//    }
//        
//        $message = '<h2>Here are your search results:</h2>';
//        
            
            /*
            
           $count = mysqli_num_rows($query);
           if($count == "0"){
               $message = '<h2>No results found!</h2>';
           }
           else{
               while($row = mysqli_fetch_array($query)){
		
                   $s = $row['column_to_display']; 
				$output .= '<h2>'.$s.'</h2><br>';
               }
           }
             *
             */
//<?php
////####################################
////
//print PHP_EOL . '<!-- SECTION 3a  -->' . PHP_EOL;
//// 
//// If its the first time coming to the form or there are errors we are going
//// to display the form.
//
//if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
//    print '<h2>Thank you for providing your information.</h2>';
//    print $message;
//} else {
//
//    print '<h2 id="form-head">Tell us about a course.</h2>';

    }
    //####################################
    //
        print PHP_EOL . '<!-- SECTION 3b Error Messages -->' . PHP_EOL;
    //
    // display any error messages before we print out the form

    if ($errorMsg) {
        print '<div id="errors">' . PHP_EOL;
        print '<h2>The following errors that need to be fixed:</h2>' . PHP_EOL;
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
    ?> 
        <form action = "<?php print PHP_SELF; ?>"
              id = "frmSearch"
              method = "post"
              
              >
            <h2> Search by Course: </h2>
            <fieldset class="listbox <?php if ($subjectERROR) print ' mistake'; ?>">

    <?php
    $query = "SELECT distinct Subj ";
    $query .= "FROM tblSections ";
    $query .= "ORDER BY  Subj";


    // Step Three: run your query being sure to implement security
    
    


    print '<label for="lstSubjects"';
    
    print '>Subject: ';
    print '<select id="lstSubjects" ';
    print '        name="lstSubjects"';
    print '        tabindex="300" >';


    foreach ($subjects as $subject) {

        print '<option ';
        if ($Subj == $subject["Subj"])
            print " selected='selected' ";

        print 'value="' . $subject["Subj"];

        print '">';


        print $subject["Subj"];
        print '</option>';
    }

    print '</select></label>';
    ?>    

            </fieldset>

            <fieldset class="listbox <?php if ($numberERROR) print ' mistake'; ?>">

    <?php
    $query = "SELECT distinct Number ";
    $query .= "FROM tblSections ";
    $query .= "ORDER BY  Number";


    // Step Three: run your query being sure to implement security
    if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $nums = $thisDatabaseReader->select($query);
    }


    print '<label for="lstNumbers"';
    
    print '>Course #: ';
    print '<select id="lstNumbers" ';
    print '        name="lstNumbers"';
    print '        tabindex="300" >';


    foreach ($nums as $num) {

        print '<option ';
        if ($Number == $num["Number"])
            print " selected='selected' ";

        print 'value="' . $num["Number"];

        print '">';


        print $num["Number"];
        print '</option>';
    }

    print '</select></label>';
    ?>    

            </fieldset>
                
            <h2> Search by Instructor: </h2>
            
            <fieldset class="listbox <?php if ($instructorERROR) print ' mistake'; ?>">

    <?php
    $query = "SELECT distinct Instructor ";
    $query .= "FROM tblSections ";
    $query .= "ORDER BY Instructor";


    // Step Three: run your query being sure to implement security
    if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $instructors = $thisDatabaseReader->select($query);
    }


    print '<label for="lstInstructors"';
    
    print '>Instructor: ';
    print '<select id="lstInstructors" ';
    print '        name="lstInstructors"';
    print '        tabindex="300" >';


    foreach ($instructors as $instructor) {

        print '<option ';
        if ($Instructor == $instructor["Instructor"])
            print " selected='selected' ";

        print 'value="' . $instructor["Instructor"];

        print '">';


        print $instructor["Instructor"];
        print '</option>';
    }

    print '</select></label>';
    ?>    

            </fieldset>



            <fieldset class="buttons">
                <legend></legend>
                <input class = "button" id = "btnSubmit" name = "btnSubmit" tabindex = "900" type = "submit" value = "Search" >
            </fieldset> <!-- ends buttons -->
        </form>     

    <?php
    
    $dataRecord = array();
    $where = 0;
    $and = 0;
    
    
    $query = 'SELECT * FROM tblCourses ';
            
    if ($Subj != ""){
        if($where == 0){
            $query .= 'WHERE ';
            $where = 1;
        } else{
            $query .= ' AND ';
            $and++;
        }
        
        $query .= 'fldSubject like ? ';
        $dataRecord[] = $Subj;
         
    }
    
    $query = 'SELECT * FROM tblCourses ';
            
    if ($Number != ""){
        if($where == 0){
            $query .= 'WHERE ';
            $where = 1;
        } else{
            $query .= ' AND ';
            $and++;
        }
        
        $query .= 'fldNumber like ? ';
        $dataRecord[] = $Number;
         
    }
    
    
    $query = 'SELECT * FROM tblCourses ';
            
    if ($Instructor != ""){
        if($where == 0){
            $query .= 'WHERE ';
            $where = 1;
        } else{
            $query .= ' AND ';
            $and++;
        }
        
        $query .= 'fldInstructor like ? ';
        $dataRecord[] = $Instructor;
         
    }
    
    
    
    
    if ($thisDatabaseReader->querySecurityOk($query, 1, $and)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $dataRecord = $thisDatabaseReader->select($query);
    }
    
    
    if (is_array($dataRecord)) {
        foreach ($dataRecord as $record) {
            print '<p>' . $record['fldSubject'] . ' ' . $record['fldNumber'] . ' ' . $record['fldInstructor']. ' ' . $record['fldDifficultyLevel'] . ' ' . $record['fldTag'] . ' ' . $record['fldSkills'] . ' ' . $record['fldComments'] .'</p>';
        }
    }

?>
</fieldset>     


<?php include 'footer.php'; 





