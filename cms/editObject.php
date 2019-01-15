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
    <title>Document</title>
</head>
<body>
    <header>
        <a href="index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h2>Editing: <?php echo $object->objectName; ?></h2>
    </header>
    <div class="pageContent">
    <fieldset>
        <form action='submitEditToDatabase.php' method='post'>
            <label for="objectName">Object Name: </label>
            <input type="text" value="<?php echo $object->objectName ?>" name="objectName">

            <br>
            <label for="objectShortDescription">Object <strong>Short</strong> Description: </label>
            <input type="text" value="<?php echo $object->objectShortDescription ?>" name="objectShortDescription">

            <br>
            <label for="fileToUpload">Object Image: Currently <?php echo $object->imageUrl; ?></label>
            <br>
            <p>Choose New Image: </p>
            <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
            <strong>Image Preview</strong><br>
            <img id="eventImagePrev" style="width: 200px;" src="<?php echo "../content/images/" . $object->objectId . "/" . $object->imageUrl; ?>" alt="" />
        </form>
    </fieldset>
    </div>
</body>
</html>