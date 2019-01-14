<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="css/desktop.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <title>Kelham Island Web</title>
</head>
<body>
    <header>
        <a href="index.php"><img class="headerLogo" src="content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1>Select an Object</h1>
    </header>

    <div style='background-color: ghostwhite; padding: 2px; margin-top: 10px;'>
    <?php
        $objects = $pdo->query("SELECT * FROM objects WHERE objectShelfPosition IS NOT NULL")->fetchAll();
            echo "<div class='shelf'>";
            foreach($objects as $o)
            {
                echo "<div class='shelfItem' style=''>";
                echo "<a href='single-object?objectID=".$o['objectId']."'><img src='content/images/" . $o['objectId'] . "/" . $o['objectId'] . "' style='width: 80%'/></a>";
                echo "<div style='height: 150px; width: 100%'>";
                echo "<p id='objectName'><a href='single-object?objectID=".$o['objectId']."'>" . $o['objectName'] . "</a></p>";
                echo "</div>";
                echo "<strong><p><a style='float: bottom'href='single-object.php?objectID=" . $o['objectId'] . "'>" . $o['objectShelfPosition'] . "</a></p></strong>";
                echo "</div>";
            }
            echo "</div>";
    ?>
    </div>
</body>
</html>