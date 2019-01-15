<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");

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
        <a href="index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h2>Editing: <?php echo $object->objectName; ?></h2>
    </header>
    <div class="pageContent">
    <fieldset>
        <form action='submitEditToDatabase.php' method='post' enctype="multipart/form-data">
            <input type="text" name="objectId" style="display: none;" value="<?php echo $object->objectId; ?>">

            <label for="objectName">Object Name: </label>
            <input type="text" value="<?php echo $object->objectName ?>" name="objectName">

            <br>
            <label for="objectShortDescription">Object <strong>Short</strong> Description: </label>
            <input type="text" value="<?php echo $object->objectShortDescription ?>" name="objectShortDescription">

        <br>
        <label for="objectShelfPosition">Object Shelf Position</label>
        <input type="text" value="<?php echo $object->objectShelfPosition ?>" name="objectShelfPosition">

        <br>
        <label for="fileToUpload">Object Image: Currently <?php echo $object->imageUrl; ?></label>   
        <br>
        <p>Choose New Image: </p>
        <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
        <strong>Image Preview</strong><br>
        <img id="eventImagePrev" style="width: 200px;" src="<?php echo "../content/images/" . $object->objectId . "/" . $object->imageUrl; ?>" alt="" />
        
        <br>
        <input type="submit" value="Update">
    </form>
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
</body>
</html>