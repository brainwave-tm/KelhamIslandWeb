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

//Delete Directory
$dir = '../content/images/' . $objectId . '/';
$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($it,
             RecursiveIteratorIterator::CHILD_FIRST);
foreach($files as $file) {
    if ($file->isDir()){
        rmdir($file->getRealPath());
    } else {
        unlink($file->getRealPath());
    }
}
rmdir($dir);

// Delete reference to images table
$pdo->query("DELETE FROM images WHERE imageId = (SELECT objectPreviewImage FROM objects WHERE objectId = '" . $objectId . "')");

// Finally delete the object //
$pdo->query("DELETE FROM objects WHERE objectId = " . $objectId);

header("Location: cms.php");
?>