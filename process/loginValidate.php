<?php
require('../includes/conn.inc.php');
require('../includes/functions.inc.php');
// check login logic here
$username_s = safeString($_POST['username']);
$password_s = safeString($_POST['password']);

$valusername = $pdo ->query("SELECT userName, userPassword FROM users WHERE userName = '" . $username_s . "' AND '". $password_s . "'")->fetchObject();

if(is_null($valusername)){

}else{
    header("Location:../index.php");
}


?>
