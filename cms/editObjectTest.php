<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");
include('../includes/sessions.inc.php');
require("../logic/auth.php");

$objectID = safeString($_GET['objectID']);
$object = $pdo->query("SELECT * FROM objects
INNER JOIN images ON objects.objectPreviewImage = images.imageId
WHERE objectId = $objectID")->fetchObject();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="../css/desktop.css">
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
        <h1>Editing: <?php echo $object->objectName; ?></h1>
        <span class="helpButton" ><i id="helpButton"class="far fa-question-circle"></i><p><strong>Help</strong></p></span>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>

    <div class="pagePreviewPanel">
        <?php if(isset($_GET["message"])) { echo "<h2 class='message'>" . $_GET["message"] . "</h2><br>"; } ?>
        <form action='submitEditToDatabase.php' method='post' enctype="multipart/form-data" id="editObjectForm">
            <?php
            // Object ID has been supplied, we can load the page directly into an object //
            echo "<input type='text' name='objectId' value='" . $objectID . "' style='display: none;'/>"; // Invisible Element for $_POST //

            echo "<input type='text' name='objectName' value='" . $object->objectName . "'/><br><br>";
            echo "<textarea name='objectShortDescription'>" . str_replace("[newline]", "\n", $object->objectShortDescription) . "</textarea>";

            ?>

            <br><br>
            <strong>Shelf Position: </strong><br>
            <?php 
                $objectShelfRow = substr($object->objectShelfPosition,0,1);
                $objectShelfColumn = substr($object->objectShelfPosition,1,1);

                $shelfPositions = array("A", "B", "C", "F");
                echo "<select name='objectRow'>"; 
                if($objectShelfRow == "") { echo "<option value='NULL' selected>No Row</option>"; }
                for($row = 0; $row < sizeof($shelfPositions); $row++)
                {
                    $selected = "";
                    if($objectShelfRow == $shelfPositions[$row]){ $selected = "selected"; }
                    echo "<option value='" . $shelfPositions[$row] . "'" . $selected . ">" . $shelfPositions[$row] . "</option>";
                }
                if($objectShelfRow) { echo "<option value='NULL'>No Row</option>"; }
                echo "</select>";

                echo "<select name='objectColumn'>";
                $shelfColumnPos = array(1, 2, 3, 4, 5, 6, 7);
                if($objectShelfColumn == "") { echo "<option value='NULL' selected>No Column</option>"; }
                for($column = 0; $column < 7; $column++)
                {
                    $selected = "";
                    if($objectShelfColumn == $column+1) { $selected = "selected"; }
                    echo "<option value='" . $shelfColumnPos[$column] . "'" . $selected . ">" . $shelfColumnPos[$column] . "</option>";
                }
                if($objectShelfColumn) { echo "<option value='NULL'>No Column</option>"; }
                echo "</select>";
            ?>
            <?php

            if($object->objectPreviewImage == null)
            { ?>
                <!-- If object does not have an image, allow user to upload one -->
                <p>Choose New Image: </p>
                <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
                <div class='objectImages'>
                    <img id='eventImagePrev' onerror="this.src='../content/images/errorImage.png';">
                </div>
                <br><br>
            <?php
            } else
            {
                // If object does have images, display them and allow for a new one to be uploaded too //
                $objectImage = $pdo->query("SELECT * FROM images WHERE imageId = " . $object->objectPreviewImage )->fetchObject();
                ?>
                <div class="pageImageAndUpload">
                    <div class="pageImage">
                        <!-- <label>Object Image: Currently <?php echo $objectImage->imageUrl; ?></label><br><br> -->
                        <strong>Image Preview</strong><br><br>
                        <img id="eventImagePrev" onerror="this.src='../content/images/errorImage.png';" class="previewImg" style="width: 200px;" src="<?php echo "../content/images/" . $objectID . "/" . $objectImage->imageUrl; ?>" alt="" />
                    </div>
                    <div class="pageImageUpload">
                        <p><i class="fas fa-plus"></i> Choose New Image: </p>
                        <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
                    </div>
                </div>
                <?php
            }
            echo "<input type='submit' value='Update'>";
            $pagesCheck = intval($pdo->query("SELECT COUNT(pageId) AS pageCount FROM pages WHERE objectId = " . $objectID . ";")->fetchAll()[0]["pageCount"]);
            echo "<div class='pageEditLinksDiv'>";
                if($pagesCheck > 0) { echo "<p><a style=\"color: black\" href=\"editPages.php?objectId=$objectID\"><i class='fas fa-pen'></i><strong> Edit this object's pages</strong></a></p>"; }
                ?>
                <p><a style="color: black" href="addPages.php?objectId=<?php echo $objectID; ?>"><i class="fas fa-plus"></i><strong> Add pages to this object</strong></a></p>
            </div>
        </form>
    </div>
    
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
    });

    $(".helpButton").on("click", function(){
        window.location.href = 'userManual.php';
    })
</script>
</body>
</html>