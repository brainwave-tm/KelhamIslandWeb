<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");

$pageText = safeString($_POST['pageText']);
$pageTitle = safeString($_POST['pageTitle']);
$pageId = safeString($_POST['pageId']);

$pdo->query("UPDATE pages SET pageText = '$pageText', pageTitle = '$pageTitle' WHERE pageId = $pageId");

header("Location: cms.php");
?>