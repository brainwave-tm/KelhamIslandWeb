<?php
require('../includes/sessions.inc.php');
require('../includes/conn.inc.php');
// check login logic here
$username_s = safeString($POST_['username']);
$password_s = safeString($POST_['password']);

if($username_s and $password_s){
NotValid()
}

function NotValid(){
$("invalidInput").show();
}

?>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>