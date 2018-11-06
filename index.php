<?php
include 'top.php';
//##############################################################################
//
// This page lists the records based on the query given
// 
//##############################################################################
$records = '';

$query = 'SELECT * FROM tblTrails';

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
print '<h2 class="alternateRows">Hiking Trails</h2>';

if (is_array($records)) {
    foreach ($records as $record) {
        print '<p>' . $record['pmkTrailsId'] . ' ' . $record['fldTrailName'] . ' ' . $record['fldTotalDistance'] . ' ' . $record['fldHikingTime'] . ' ' . $record['fldVerticalRise'] . ' ' . $record['fldRating'] . '</p>';
   
      
}

}

if ($isAdmin == true){
    echo "<a href='form-trails.php'>EDIT TABLE</a>";
}
        
?>

</fieldset>
<?php
include 'footer.php';
?>
