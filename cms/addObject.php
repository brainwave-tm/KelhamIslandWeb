<?php
    // require("../logic/auth.php");
    include("../includes/conn.inc.php");
    include("../includes/functions.inc.php");
    include('../includes/sessions.inc.php');
    require("../logic/auth.php");

    if(isset($_POST['submit']))
    {
        if ($_POST['objectID'] == 0)
        {
            $objectName = safeString($_POST['objectName']);
            $objectShortDescription = safeString($_POST['objectShortDescription']); 
            $objectRow = safeString($_POST['objectRow']);
            $objectColumn = safeString($_POST['objectColumn']);
            $objectShelfPosition = null;
            $objectImagePreview = $_FILES['fileToUpload'];

            // <?php if(isset($errorImage)) { <small style="color:#aa0000;"><?php echo $errorImage; </small><br /><br /><?php } 
            if($objectRow == "NULL" || $objectColumn == "NULL")
            {
                $objectShelfPosition == null;
            }
            else
            {
                $objectShelfPosition = $objectRow . $objectColumn;
            }            

            $errorCheck = false;

            if($objectName == "")
            {
                $errorName = 'ERROR! Please include "Name" for the object.';
                $errorCheck = true;
            }
            if($objectShortDescription == "")
            {
                $errorShortDescription = 'ERROR! Please include "Short Description" for the object.';
                $errorCheck = true;
            }            
            if($objectImagePreview["name"] == "")
            {
                $errorImagePreview = 'ERROR! Please include "Image" for the object.';
                $errorCheck = true;
            }


            if($errorCheck == false)
            {            
                $sql2 = "INSERT INTO objects (objectName, objectShortDescription, objectShelfPosition) VALUES (?,?,?)";
                $stmt2= $pdo->prepare($sql2);
                $stmt2->execute([$objectName, $objectShortDescription, $objectShelfPosition]);

                $newObjectId = $pdo->query("SELECT MAX(objectId) as MAX FROM objects")->fetchObject();
                $imageID = uploadFile($newObjectId->MAX);
                $sql2 = "UPDATE objects SET objectPreviewImage = '" . $imageID . "' WHERE objectId = " . $newObjectId->MAX;
                $stmt2= $pdo->prepare($sql2);

                $stmt2->execute();
                // header("Location: cms.php");
            }            
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
        <a href="cms.php" class="backLink"><span class="backLink"><i class="fas fa-caret-left"></i><strong>Back</strong></span></a>
        <h1>Add An Object</h1>
        <span class="helpButton" ><i id="helpButton"class="far fa-question-circle"></i><p><strong>Help</strong></p></span>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>
    <div class="addObjectForm">
        <form id="addObjectForm" method="POST" autocomplete="off" action="" enctype="multipart/form-data">
            <input type="hidden" name="objectID" value="0"/>
            <strong>Object Name: (max 50 characters)</strong>
            <?php if(isset($errorName)) { ?><small style="color:#aa0000;"><?php echo $errorName; ?></small><?php } ?>        
            <input maxlength="50" type="text" id="objectName" name="objectName"></input>
            <br>
            <strong>Short Description: </strong>
            <?php if(isset($errorShortDescription)) { ?><small style="color:#aa0000;"><?php echo $errorShortDescription; ?></small><?php } ?>
            <input maxlength="150" type="text" name="objectShortDescription"></input>
            <br>
            <strong>Shelf Position: </strong>
            <select name="objectRow">
                <option value="NULL">No row</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="F">Floor</option>
            </select>
            <select name="objectColumn">
                <option value="NULL">No column</option>            
                <option value="1">1</option>
                <option value="2">2</option>-
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
            </select>
            <p style="font-size: 20px; margin: 0;"><span style="color: red">Please Note: </span>If no shelf position is selected the object will not show on the main screen to visitors</p>
            <br>
            <strong>Object Main Image</strong>
            <?php if(isset($errorImagePreview)) { ?><small style="color:#aa0000;"><?php echo $errorImagePreview; ?></small><?php } ?>            
            <input type="file" style="font-size: 1rem;" id="newImageUpload" name="fileToUpload"/>
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
    $(".helpButton").on("click", function(){
    window.location.href = 'userManual.php';
    })
</script>
</html>