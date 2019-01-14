<?php
$dsn = 'mysql:host=localhost;dbname=b7003087_db2';
$user = 'b7003087';
$datapassword = 'Ginge1';
try {
$pdo = new PDO($dsn, $user, $datapassword);
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo ->exec("SET CHARACTER SET utf8");
}
catch (PDOException $e) {
echo 'Connection failed again: ' . $e->getMessage();
}
?>