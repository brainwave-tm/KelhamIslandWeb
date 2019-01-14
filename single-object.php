<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeString($_GET['objectID']);

$objectData = "SELECT * FROM objects WHERE objectID = ".$objectID;
?>