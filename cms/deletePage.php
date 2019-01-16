<?php
include("../includes/conn.inc.php");
include("../includes/sessions.inc.php");
include("../includes/functions.inc.php");
require("../logic/auth.php");

// Delete the images first //
$pageId = safeString($_GET['pageId']);
?>