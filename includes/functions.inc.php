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
// $fileName = $_FILES['fileToUpload']['name'];
$fileName = $objectId;
$fileSize = $_FILES['fileToUpload']['size'];
$fileTmpName  = $_FILES['fileToUpload']['tmp_name'];
$fileType = $_FILES['fileToUpload']['type'];
$temp = explode('.',$fileName);
$fileExtension = end($temp);
$uploadPath = $uploadDirectory . basename($fileName) . ".JPG";
print_r($uploadPath);
$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
return $fileName;
}
?>