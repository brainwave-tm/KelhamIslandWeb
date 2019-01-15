<?php
include("../includes/sessions.inc.php");

// Remove the $_SESSION variables //
unset($_SESSION['user_id']);
unset($_SESSION['username']);
$_SESSION['login'] = 0;

// Remove the cookie //
unset($_COOKIE['PHPSESSID']);
setcookie("PHPSESSID", "", time()-3600);

header('Location: ../index.php');
?>