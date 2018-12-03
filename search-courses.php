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
        <input type="text" name="query" />
        <input type="submit" value="Search" />
    </form>
</body>
   <?php include 'footer.php'; ?>
</html>