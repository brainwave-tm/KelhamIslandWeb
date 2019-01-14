<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeString($_GET['objectID']);

$objectData = $pdo->query("SELECT * FROM objects 
                           INNER JOIN images ON objects.objectId = images.imageId
                           WHERE objectID = $objectID")->fetchObject();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="css/desktop.css">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <!-- For Back icons etc. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>Kelham Island Web</title>
</head>
<body>
    <header>
        <a href="index.php"><img class="headerLogo" src="content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1><?php
        echo $objectData->objectName;
        ?></h1>
        <h2><a href='objectSelect.php' class="backLink"><i class="fas fa-home"></i></a></h2>
    </header>

    <div class="pagesMenu">
        <ol type="1">
            <?php
            $objectPages = $pdo->query("SELECT pageId, pageTitle FROM pages WHERE objectID = $objectID")->fetchAll();
            if(isset($_GET['pageID']))
            {
                echo "<li><a href='single-object.php?objectID=$objectID'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
            }
            ?>
            
            <li>PAGES</li>
            <li>||</li>
            <?php
            for($i = 0; $i < sizeof($objectPages); $i++)
            {
                echo "<li><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "'>" . $objectPages[$i]['pageTitle'] ."</a></li>";  
                echo "<li>|</li>";
            }
            ?>
        </ol>
    </div>

    <div class="pageContent">
        <?php
        if(!isset($_GET['pageID']))
        {
            echo "<div class='shortDescription'>";
            echo "<p>$objectData->objectShortDescription</p>";
            echo "</div>";
            
            $objectImage = $pdo->query("SELECT imageUrl FROM images WHERE imageId = $objectData->objectPreviewImage")->fetchObject();
            echo "<img src='content/images/$objectData->objectPreviewImage/" . $objectImage->imageUrl . "'>";
            
        } else
        {
            // Display a single page //
            $pageID = safeInt($_GET['pageID']);

            $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = $pageID")->fetchObject();
            echo "<h2>$objectPage->pageTitle</h2>";
            echo "<p>$objectPage->pageText</p>";

            if(!is_null($objectPage->pageImage))
            {
                $objectImage = $pdo->query("SELECT imageUrl FROM images WHERE imageId = $objectPage->pageImage")->fetchObject();
                echo "<img src='content/images/$objectData->objectPreviewImage/" . $objectImage->imageUrl . "'>";
            }
            
        }
        ?>
    </div>
</body>
</html>
