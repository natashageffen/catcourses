<!DOCTYPE html>
<html>
    <?php
    include 'top.php';
    ?>
<head>
    <title>Search</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <form action="search-results.php" method="GET">
        <fieldset>
        <label>Search by Course:</label>
        <input type="text" name="subject-query" placeholder="Subject"/>
        <input type="text" name="number-query" placeholder="Course #"/>
        <input type="submit" value="Search" />
        </fieldset>
        <fieldset>
        <label>Search by Instructor:</label>
        <input type="text" name="instructor-query" />
        <input type="submit" value="Search" 
               placeholder="Instructor Name"/>
        
        </fieldset>
    </form>
</body>
   <?php include 'footer.php'; ?>
</html>