<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

$objectId = safeString($_POST['objectId']);
$objectName = safeString($_POST['objectName']);
$objectShortDescription = safeString($_POST['objectShortDescription']);
$objectShelfPosition = safeString($_POST['objectShelfPosition']);

$imageData = $pdo->query("SELECT imageUrl, imageId FROM images WHERE imageId = (SELECT objectPreviewImage FROM objects WHERE objectId = '$objectId')")->fetchAll();
$imageUrl = $imageData[0]['imageUrl'];
$imageId = $imageData[0]['imageId'];

$newImageId = null;
if(!$_FILES['fileToUpload']["name"] == "")
{
    removeExistingImage($objectId, $imageUrl);
    $newImageId = replaceFile($objectId);
}
else
{
    $newImageId = $imageId;  
}

$sql2 = "UPDATE objects SET objectName = '" . $objectName . "', objectShortDescription = '" . $objectShortDescription . "', objectPreviewImage = '" . $newImageId . "', objectShelfPosition = '". $objectShelfPosition . "' WHERE objectId = " . $objectId;
$stmt2= $pdo->prepare($sql2);
// $stmt2->execute();
$stmt2->execute([$objectName, $objectShortDescription, $newImageId, $objectShelfPosition]);

?>