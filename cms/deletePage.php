<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

// Delete the images first //
$objectId = safeString($_GET['objectId']);
// Then delete the pages //
$pdo->query("DELETE FROM pages WHERE pages.objectId = " . $objectId);

header("Location: cms.php");
?>