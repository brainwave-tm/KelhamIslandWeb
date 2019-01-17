<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

setcookie("firstEntry", "true", time() + (86400 * 30));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" href="css/desktop.css">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web</title>
</head>
<body style="display: none;">
    <div class="video-background">
        <div class="video-foreground">
            <iframe src="https://www.youtube.com/embed/m37TXq01N5o?autoplay=1&loop=1&playlist=m37TXq01N5o" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <div style="height: 350px; width: 100%">
        <img class="indexLogo" src="content/images/logo.png" alt="Kelham Island Logo">
    </div>
    <div class = "indexText">
    <h1>Interactive open store directory</h1>
    </div>
    <div class="indexContainer">
        <h1><a href="objectSelect.php">Click To Begin</a></h1>
    </div>
    <div class = "loginLink">
        <a href="LoginForm.php"> Admin login</a>
    </div>

    <script type="text/javascript">
    $( document ).ready(function() {
        $("body").fadeIn(2000);
        $("a").click(function(e) {
            e.preventDefault();
            $link = $(this).attr("href");
            $("body").fadeOut(500,function(){
                window.location =  $link; 
            });
        });
    });
    </script>
</body>
</html>