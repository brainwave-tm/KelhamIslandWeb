<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeInt($_GET['objectID']);

// We are on the 'main page' //
$objectData = $pdo->query("SELECT * FROM objects WHERE objectID = $objectID")->fetchObject();
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


// $pageID = safeInt($_GET['pageID']);

// $objectData = $pdo->query("SELECT * FROM objects WHERE objectID = $objectID")->fetchObject();
// $objectArray = $pdo->query("SELECT * FROM pages WHERE pageId = $pageID")->fetchAll();


// if(sizeof($objectArray) == 0)
// {
//     echo "<h1>No pages found for this object</h1>";
// } else
// {
//      foreach($objectArray as $a)
//      {
//          echo $a['pageText'];
//      }
// }
?>