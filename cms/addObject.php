<?php
    require("../logic/auth.php");
    include("../includes/conn.inc.php");
    include("../includes/functions.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="../css/desktop.css">
    <!-- Favicon -->
    <link rel="icon" href="../content/images/favicon.png">
    <!-- For Back icons etc. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web</title>
</head>
<body>
    <header>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1>Add an Object</h1>
        <h2><a href='cms.php' class="backLink"><i class="fas fa-home"></i></a></h2>
    </header>
    <div class="addObjectForm">
        <form id="addObjectForm" method="POST" autocomplete="off" action="upload.php" enctype="multipart/form-data">
            <strong>Object Name: (max 25 letters)</strong><input maxlength="25" type="text" name="objectName"></input>
            <br>
            <strong>Short Description: </strong><input maxlength="150" type="text" name="objectShortDescription"></input>
            <br>
            <strong>Object Main Image</strong><input type="file" id="newImageUpload" name="fileToUpload"/>
            <strong>Image Preview</strong><br>
            <img id="eventImagePrev" style="width: 200px;" src="" alt="" />
            <input type="submit" value="Submit" class="buttonGo">
        </form>
    </div>
</body>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#eventImagePrev').attr('src', e.target.result);
            }            
            reader.readAsDataURL(input.files[0]);
    }
    }
    $("#newImageUpload").change(function(){
        readURL(this);
    })
</script>
</html>