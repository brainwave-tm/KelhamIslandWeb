<?php
require('../includes/sessions.inc.php');
require('../includes/conn.inc.php');
// check login logic here
$username_s = safeString($POST_['username']);
$password_s = safeString($POST_['password']);


?>