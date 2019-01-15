<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");

$objectId = safeString($_POST['objectId']);
$objectShortDescription = safeString($_POST['objectShortDescription']);

if(!file_exists("../content/images/" . $_POST['objectId'] . "/" . $_FILES['fileToUpload']["name"]))
{
    $imagePath = uploadFile();
    echo $imagePath;
}
else
{
    $imagePath = replaceFile();
    echo $imagePath;
}

$objectShelfPosition = safeString($_POST['objectShelfPosition']);

$sql2 = "INSERT INTO objects (objectName, objectShortDescription, objectPreviewImage, objectShelfPosition) VALUES ()";
$stmt2= $pdo->prepare($sql2);
// $stmt2->execute([$objectName, $objectShortDescription, $imagePath, $objectShelfPosition]);
header("cms.php");
?>