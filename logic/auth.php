<?php
if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
    // print_r($_SESSION);
};
?>