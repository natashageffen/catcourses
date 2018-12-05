<!DOCTYPE html>
<html>
    <?php
    include 'top.php';
    ?>
<head>
    <title>Search</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
    <form action="search-results.php" method="GET">
        <label>Search by Course:</label>
        <input type="text" name="subject-query" placeholder="Subject"/>
        <input type="text" name="number-query" placeholder="Course #"/>
        <input type="submit" value="Search" />
    </form>
    
    <form action="search-results.php" method="GET">
        <label>Search by Instructor:</label>
        <input type="text" name="instructor-query" />
        <input type="submit" value="Search" />
    </form>
</body>
   <?php include 'footer.php'; ?>
</html>