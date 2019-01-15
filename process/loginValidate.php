<?php
include("../includes/sessions.inc.php");
require('../includes/conn.inc.php');
require('../includes/functions.inc.php');

$username_s = safeString($_POST['username']);
$password_s = safeString($_POST['password']);
$valusername = $pdo ->query("SELECT * FROM users WHERE userName = '" . $username_s . "'")->fetchObject();
if(is_null($valusername)){
    header("Location:../LoginPage.php?errorMessage=INVALID USERNAME OR PASSWORD");
}
else{
    $dbPasswordHash = $valusername->userPassword;
    if(password_verify($_POST['password'], $dbPasswordHash))
    {
        $_SESSION['user_id'] = $valusername->userId;
        $_SESSION['login'] = 1;
        $_SESSION['username'] = $valusername->userFullName;
        header("Location: ../cms/cms.php");
    }
    else {
        header("Location:../LoginForm.php?errorMessage=INVALID USERNAME OR PASSWORD");       
    }
}
?>