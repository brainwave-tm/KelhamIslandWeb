<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

// Delete the images first //
$pageId = safeString($_GET['pageId']);
$objectId = safeString($_GET['objectId']);

$page = $pdo->query("SELECT * FROM pages WHERE pageId = $pageId")->fetchAll();

$imageUrl = $pdo->query("SELECT imageUrl, imageId FROM images WHERE IMAGEiD = (SELECT pageImage FROM pages WHERE pageId = $pageId)")->fetchAll();

$dir = '../content/images/' . $page[0]['objectId'] . '/' . $imageUrl[0]['imageUrl'];
unlink($dir);

$pdo->query("DELETE FROM images WHERE imageId = '" . $imageUrl[0]['imageId'] . "'");
$pdo->query("DELETE FROM pages WHERE pageId = $pageId");

header("Location: editPages.php?objectId=$objectId&message=Deleted%20Page%20Successfully")

?>