<?php
include 'top.php';
//##############################################################################
//
// This page lists the records based on the query given
// 
//##############################################################################
$records = '';

$query = 'SELECT * FROM tblCourses';

// NOTE: The full method call would be:
//           $thisDatabaseReader->querySecurityOk($query, 0, 0, 0, 0, 0)
if ($thisDatabaseReader->querySecurityOk($query, 0)) {
    $query = $thisDatabaseReader->sanitizeQuery($query);
    $records = $thisDatabaseReader->select($query, '');
    
}
?>

<?php
if (DEBUG) {
    print '<p>Contents of the array<pre>';
    print_r($records);
    print '</pre></p>';
}

?>
<fieldset class = "indexbox">
    <?php
print '<h2 class="alternateRows">Records</h2>';

if (is_array($records)) {
    foreach ($records as $record) {
        print '<p>' . $record['pmkCourseId'] . ' ' . $record['Subj'] . ' ' . $record['fldNumber'] . ' ' . $record['fldTitle'] . ' ' . $record['fldClassStanding'] . ' ' . $record['fldDifficultyLevel'] . ' ' . $record['fldTag'] . ' ' . $record['fldMajor'] . ' ' . $record['fldSkills'] . ' ' . $record['fldComments'] . ' ' . $record['fldEmail'] .'</p>';
        if ($isAdmin == true){
        echo '<a href="form.php?id='. $record["pmkCourseId"] . '">EDIT TABLE</a>';
}
        
      
}

}


?>

</fieldset>
<?php
include 'footer.php';
?>


