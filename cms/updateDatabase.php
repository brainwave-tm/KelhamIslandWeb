<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

$pageText = safeString(str_replace("\n", "[newline]", $_POST['pageText'])); // Newlines are removed :( //
$pageTitle = safeString($_POST['pageTitle']);
$pageId = safeString($_POST['pageId']);
$objectId = safeString($_POST['objectId']);

$imageData = $pdo->query("SELECT imageUrl, imageId FROM images WHERE imageId = (SELECT pageImage FROM pages WHERE pageId = '$pageId')")->fetchAll();
var_dump($imageData);

if($_FILES["fileToUpload"]["name"] != "") // If user IS uploading an image
{
    if(sizeof($imageData) != 0) // Page has an image //
    {
        $errorCode = removeExistingImage($objectId, $imageData[0]['imageUrl']);
    }
    $newImageId = uploadFile($objectId);        
    $sql = "UPDATE pages SET pageImage = '" . $newImageId . "' WHERE pageId = " . $pageId;
    $stmt= $pdo->prepare($sql);
    $stmt->execute();

    $sqlText = ", pageImage= '$newImageId'";
} else
{
    $sqlText = "";
}

$pdo->query("UPDATE pages SET pageText = '$pageText', pageTitle = '$pageTitle' $sqlText WHERE pageId = '$pageId'");

header("Location: editPages.php?objectId=$objectId&pageId=$pageId&message=Page updated successfully");
?>