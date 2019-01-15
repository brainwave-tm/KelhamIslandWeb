<?php
    // require("../logic/auth.php");
    include("../includes/conn.inc.php");
    include("../includes/functions.inc.php");

    if(isset($_POST['submit']))
    {
        if ($_POST['objectID'] == 0)
        {
            $objectName = safeString($_POST['objectName']);
            $objectShortDescription = safeString($_POST['objectShortDescription']);
            $imagePath = uploadFile();
            $objectShelfPosition = safeString($_POST['objectShelfPosition']);
            

            $sql2 = "INSERT INTO objects (objectName, objectShortDescription, objectPreviewImage, objectShelfPosition) VALUES (?,?,?,?)";
            $stmt2= $pdo->prepare($sql2);
            $stmt2->execute([$objectName, $objectShortDescription, $imagePath, $objectShelfPosition]);
            header("Location: cms.php");
        }
    }
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
        <form id="addObjectForm" method="POST" autocomplete="off" action="" enctype="multipart/form-data">
            <input type="hidden" name="objectID" value="0"/>
            <strong>Object Name: (max 25 characters)</strong><input maxlength="25" type="text" id="objectName" name="objectName"></input>
            <br>
            <strong>Short Description: </strong><input maxlength="150" type="text" name="objectShortDescription"></input>
            <br>
            <strong>Shelf Position: </strong><input type="text" name="objectShelfPosition"/>
            <br>
            <strong>Object Main Image</strong><input type="file" id="newImageUpload" name="fileToUpload"/>
            <strong>Image Preview</strong><br>
            <img id="eventImagePrev" style="width: 200px;" src="" alt="" />
            <input type="submit" name="submit" value="Submit" class="buttonGo">
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
    };
    $("#newImageUpload").change(function(){
        readURL(this);
    });
    $('#addObjectForm').on('submit', function(e) {
        // var objectName = $("#objectName").value;
        // console.log($("#objectName").value);
        // if (objectName == null || objectName == '') { alert("please enter a name"); }
        // e.preventDefault();
    });
</script>
</html>