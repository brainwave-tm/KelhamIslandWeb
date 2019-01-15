<?php
function changePassword($password){
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    return $hashed_password;
}
?>
