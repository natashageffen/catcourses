<?php
print PHP_EOL . '<!--  BEGIN include validation-functions -->' . PHP_EOL;
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// series of functions to help you validate your data. notice that each
// function returns true or false
//function verifyAlphaNum($testString) {
//    // Check for letters, numbers and dash, period, space and single quote only.
//    // added & ; and # as a single quote sanitized with html entities will have 
//    // this in it bob's will be come bob&#039;s
//    return (preg_match ("/^([[:alnum:]]|-|\.| |\'|&|;|#)+$/", $testString));
//}
//from php.net

//function validateDate($date, $format = 'Y-m-d')
//{
//    $d = DateTime::createFromFormat($format, $date);
//    return $d && $d->format($format) == $date;
//}


function verifyDate($date) {
    // Check for date
    return (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date));
}

print PHP_EOL . '<!--  END include validation-functions -->' . PHP_EOL;
?>

