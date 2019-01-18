<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

$objectId = safeString($_POST['objectId']);
$objectName = safeString($_POST['objectName']);
$objectShortDescription = safeString(str_replace("\n", "[newline]", $_POST['objectShortDescription']));
$objectRow = safeString($_POST['objectRow']);
$objectColumn = safeString($_POST['objectColumn']);
if(!($objectRow == 'NULL' || $objectColumn == 'NULL'))
{
    $objectShelfPosition = $objectRow . $objectColumn;
}
else
{
    $objectShelfPosition = NULL;
}

$imageData = $pdo->query("SELECT imageUrl, imageId FROM images WHERE imageId = (SELECT objectPreviewImage FROM objects WHERE objectId = '$objectId')")->fetchAll();
$imageUrl = $imageData[0]['imageUrl'];
$imageId = $imageData[0]['imageId'];

$newImageId = null;
$errorCode = null;
if(!$_FILES['fileToUpload']["name"] == "")
{
    $errorCode = removeExistingImage($objectId, $imageUrl);
    $newImageId = replaceFile($objectId);
}
else
{
    $newImageId = $imageId;  
}

$sql2 = "UPDATE objects SET objectName = '" . $objectName . "', objectShortDescription = '" . $objectShortDescription . "', objectPreviewImage = '" . $newImageId . "', objectShelfPosition = '". $objectShelfPosition . "' WHERE objectId = " . $objectId;
$stmt2= $pdo->prepare($sql2);
$stmt2->execute();
$stmt2->execute([$objectName, $objectShortDescription, $newImageId, $objectShelfPosition]);

if($errorCode == 0)
{
    header("Location: editObjectTest.php?objectID=$objectId&message=Updated%20Object%20Successfully");
}
else
{
    echo "There has been an error when uploading the image!";
    echo "<a href=\"cms.php\">Return to cms</a>";
}
?>