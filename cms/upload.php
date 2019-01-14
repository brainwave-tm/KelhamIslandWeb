<?php
include("../includes/functions.inc.php");
include("../includes/conn.inc.php");

$sql = "SELECT MAX(objectId)AS Max FROM objects";
$stmt->prepare($sql);
$stmt->execute();
$row->fetchObject();
echo $row->Max;

$currentDir = getcwd();
$uploadDirectory = "../CONTENT/IMAGES/";
mkdir($uploadDirectory . "memez");



?>