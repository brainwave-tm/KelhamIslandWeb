<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" href="css/desktop.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <title>Kelham Island Web</title>
</head>
<body>
    <div style="height: 600px; width: 100%">
    <img class="indexLogo" src="content/images/logo.png" alt="Kelham Island Logo">

    </div>
    <div class="container">
        <h1>Welcome To Kelham Island / <?php echo date("d/m/Y"); ?></h1>
        <a href="objectSelect.php" class="buttonGo">Start</a>
    </div>
</body>
</html>