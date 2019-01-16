<?php
function safeInt($int){
	return filter_var($int, FILTER_VALIDATE_INT);
}
function safeString($str){
	return filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
}
function safeFloat($float) {
	return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}
function uploadFile(){
include("../includes/conn.inc.php");

$sql = "SELECT MAX(objectId) AS Max FROM objects";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetchObject();
$objectId = $row->Max+1;
echo $objectId;

//Make Directory
$currentDir = getcwd();
$uploadDirectory = "../content/images/";
mkdir($uploadDirectory . $objectId);
$uploadDirectory = $uploadDirectory . $objectId . "/";
//Move file to created directory
$fileName = $_FILES['fileToUpload']['name'];
// $fileName = $objectId;
$fileSize = $_FILES['fileToUpload']['size'];
$fileTmpName  = $_FILES['fileToUpload']['tmp_name'];
$fileType = $_FILES['fileToUpload']['type'];
$temp = explode('.',$fileName);
$fileExtension = end($temp);
$uploadPath = $uploadDirectory . basename($fileName);
$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

$sql = "INSERT INTO images (imageUrl) VALUES (?)";
$stmt2= $pdo->prepare($sql);
$stmt2->execute([$fileName]);

$sql = $pdo->query("SELECT MAX(imageId) as newImageId FROM images")->fetchObject();


return $sql->newImageId;
}

function replaceFile($objectId)
{
	include("../includes/conn.inc.php");
	//Make Directory
	$currentDir = getcwd();
	$uploadDirectory = "../content/images/";
	$uploadDirectory .= $objectId . "/";

	//Move file to created directory
	$fileName = $_FILES['fileToUpload']['name'];
	//$fileName = $objectId;
	$fileSize = $_FILES['fileToUpload']['size'];
	$fileTmpName = $_FILES['fileToUpload']['tmp_name'];
	$fileType = $_FILES['fileToUpload']['type'];
	$temp = explode('.',$fileName);
	$fileExtension = end($temp);
	$uploadPath = $uploadDirectory . basename($fileName);
	$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
	
	$sql = "INSERT INTO images (imageUrl) VALUES (?)";
	$stmt2= $pdo->prepare($sql);
	$stmt2->execute([$fileName]);

	$sql = $pdo->query("SELECT MAX(imageId) as newImageId FROM images")->fetchObject();


	return $sql->newImageId;
}

function removeExistingImage($objectId, $imageUrl)
{
	$errorCode = 0;
	$filePath = "../content/images/" . $objectId . "/" . $imageUrl;
	if (!unlink($filePath))
	{
		$errorCode = 1;
	}
	return $errorCode;
}
?>