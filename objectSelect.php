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
    <meta http-equiv="refresh" content="240;url='index.php'" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web</title>
</head>
<body style="display: none;">
    <header>
        <a href="index.php"><img class="headerLogo" src="content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1>Select an Object</h1>
    </header>

    <div style='background-color: ghostwhite; padding: 2px; margin-top: 10px;'>
    <?php
        $objects = $pdo->query("SELECT * FROM objects
        LEFT JOIN images ON objects.objectPreviewImage = images.imageId
        WHERE objectShelfPosition IS NOT NULL
        ORDER BY objectShelfPosition ASC")->fetchAll();
            echo "<div class='shelf'>";
            foreach($objects as $o)
            {
                echo "<div class='shelfItem' style=''>";
                echo "<div class='shelfImage'>";
                echo "<a href='single-object?objectID=".$o['objectId']."'><img src='content/images/" . $o['objectId'] . "/" . $o['imageUrl'] . "' style='max-height: 200px; max-width: 80%;'/></a>";
                echo "</div>";
                echo "<div style='height: 150px; width: 100%'>";
                echo "<p id='objectName'><a href='single-object?objectID=".$o['objectId']."'><strong>" . $o['objectName'] . "</strong></a></p>";
                echo "</div>";
                echo "<strong><p><a style='float: bottom'href='single-object.php?objectID=" . $o['objectId'] . "'>" . $o['objectShelfPosition'] . "</a></p></strong>";
                echo "</div>";
            }
            echo "</div>";
    ?>
    </div>

    <script type="text/javascript">
    $( document ).ready(function() {
        $("body").fadeIn(1000);
        $("a").click(function(e) {
            e.preventDefault();
            $link = $(this).attr("href");
            $("body").fadeOut(500,function(){
                window.location =  $link; 
            });
        });
    });
    </script>
</body>
</html>