<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

// Delete the images first //
$objectId = safeString($_GET['objectId']);
$pages = $pdo->query("SELECT pageImage FROM pages WHERE objectId = $objectId")->fetchAll();

for($id = 0; $id < sizeof($pages); $id++)
{
    $pdo->query("DELETE FROM images WHERE imageId = " . $pages[$id]["pageImage"]);
}

// Then delete the pages //
$pdo->query("DELETE FROM pages WHERE pages.objectId = " . $objectId);

// Finally delete the object //
$pdo->query("DELETE FROM objects WHERE objectId = " . $objectId);

header("Location: cms.php");
?>