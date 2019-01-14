<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeString($_GET['objectID']);

$objectData = $pdo->query("SELECT * FROM objects 
                           INNER JOIN images ON objects.objectId = images.imageId
                           WHERE objectID = $objectID")->fetchObject();
echo "<h1>$objectData->objectName</h1>";
$objectPages = $pdo->query("SELECT pageId, pageTitle FROM pages WHERE objectID = $objectID")->fetchAll();
for($i = 0; $i < sizeof($objectPages); $i++)
{
    echo "<h2><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "'>" . ($i+1) . ". " . $objectPages[$i]['pageTitle'] ."</a></h2>";  
}

if(!isset($_GET['pageID']))
{
    echo "<p>$objectData->objectShortDescription</p>";
    $objectImage = $pdo->query("SELECT imageUrl FROM images WHERE imageId = $objectData->objectPreviewImage")->fetchObject();
    echo "<img src='content/images/$objectData->objectPreviewImage/" . $objectImage->imageUrl . "'>";
    
} else
{
    // Display a single page //
    echo "<h3><a href='single-object.php?objectID=$objectID'>Back To Main Menu</a></h3>";
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
        <h1><?php
        echo $objectData->objectName;
        ?></h1>
    </header>
</body>
</html>
