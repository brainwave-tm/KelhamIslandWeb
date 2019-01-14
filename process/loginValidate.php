<?php
require('../includes/conn.inc.php');
require('../includes/functions.inc.php');
// check login logic here
$username_s = safeString($_POST['username']);
$password_s = safeString($_POST['password']);
echo $username_s;
echo $password_s;
$valusername = $pdo ->query("SELECT userPassword FROM users WHERE userName = '" . $username_s . "'")->fetchObject();
if(is_null($valusername)){
    header("Location:../LoginPage.php");
}
else{
    if($valusername->userPassword === $password_s)
    {
        header("Location:../youwin.php");
    }
    else {
        header("Location:../index.php");        
    }
    
}


?>
