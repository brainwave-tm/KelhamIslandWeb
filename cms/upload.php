<?php
include("../includes/functions.inc.php");
include("../includes/conn.inc.php");

$sql = "SELECT MAX(objectId) AS Max FROM objects";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetchObject();
$objectId = $row->Max+1;
echo $objectId;

$currentDir = getcwd();
$uploadDirectory = "../CONTENT/IMAGES/";
mkdir($uploadDirectory . "memez");



?>