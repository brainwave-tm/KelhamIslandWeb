<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeString($_GET['objectID']);

$objectData = $pdo->query("SELECT * FROM objects WHERE objectID = $objectID")->fetchObject();
echo $objectData->objectName;
?>