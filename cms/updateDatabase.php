<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");


$pageText = safeString($_POST['pageText']);
$pageTitle = safeString($_POST['pageTitle']);
$pageId = safeString($_POST['pageId']);
$objectId = safeString($_POST['objectId']);

$imageData = $pdo->query("SELECT imageUrl, imageId FROM images WHERE imageId = (SELECT pageImage FROM pages WHERE pageId = '$pageId')")->fetchAll();
$imageUrl = $imageData[0]['imageUrl'];
$imageId = $imageData[0]['imageId'];

$newImageId = null;
$errorCode = null;
if(!$_FILES['fileToUpload']["name"] == "")//If there is something to upload
{
    $errorCode = removeExistingImage($objectId, $imageUrl);
    $newImageId = replaceFile($objectId);
}
else
{
    $newImageId = $imageId;  
}

$pdo->query("UPDATE pages SET pageText = '$pageText', pageTitle = '$pageTitle', pageImage= '$newImageId' WHERE pageId = '$pageId'");

header("Location: editPages.php?objectId=$objectId&pageId=$pageId");
?>