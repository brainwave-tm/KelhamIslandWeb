<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");

var_dump($_POST);

$pageText = safeString($_POST['pageText']);
$pageTitle = safeString($_POST['pageTitle']);
$pageId = safeString($_POST['pageId']);
$objectId = safeString($_POST['objectId']);

$pdo->query("UPDATE pages SET pageText = '$pageText', pageTitle = '$pageTitle' WHERE pageId = $pageId");

header("Location: editPages.php?objectId=$objectId");
?>