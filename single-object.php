<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeString($_GET['objectID']);

$objectData = $pdo->query("SELECT * FROM objects 
                           INNER JOIN images ON objects.objectId = images.imageId
                           WHERE objectID = $objectID")->fetchObject();
echo "<h1>$objectData->objectName</h1>";
echo "<img src='$objectData->imageUrl' title='$objectData->imageDescription' alt='$objectData->imageDescription' style='width: 25%;'>";
echo "<p>$objectData->objectLongDescription</p>";
?>