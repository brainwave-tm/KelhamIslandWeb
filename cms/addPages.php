<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");
include('../includes/sessions.inc.php');
require("../logic/auth.php");

    $objectID = safeInt($_GET['objectId']);
    $sql = $pdo->query("SELECT objectName FROM objects WHERE objectId = " . $objectID)->fetchObject();
    $objectName = $sql->objectName;

    if (isset($_POST['submit']))
    {
        $pageName = safeString($_POST['newPageTitle']);
        $pageText = safeString($_POST['pageText']);
        $imageId = replaceFile($objectID);

        $sql2 = "INSERT INTO pages (objectId, pageText, pageTitle, pageImage) VALUES (?,?,?,?)";
        $stmt2= $pdo->prepare($sql2);
        $stmt2->execute([$objectID, $pageText, $pageName, $imageId]);
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
        <h1>Add an Page</h1>
        <h2><a href='cms.php' class="backLink"><i class="fas fa-home"></i></a></h2>
    </header>
    <div class="addPagesForm">
        <h1>Adding a page to object: <?php echo $objectName; ?></h1>
        <h2>A page allows you to enter more information about an object for the users to browse through on the front end. Use pages to break up information.</h2>
        <h3>It is suggested that you atleast upload an image or some text, uploading both gives a good feel to the page</h3>
        <form id="addNewPageForm" autocomplete="off" class="" name="addNewPage" method="POST" action="" enctype="multipart/form-data">
            <strong>Page Title* (25 characters max)</strong>
            <input type="text" maxlength="25" name="newPageTitle" id="pageTitle"/>
            <strong>Page Text</strong>
            <textarea name="pageText" name="pageText"></textarea>
            <strong>Page Image</strong>
            <input type="file" id="newImageUpload" name="fileToUpload"/>
            <strong>Image Preview</strong><br>
            <img id="pageImagePrev" style="width: 200px; height: auto;" src="" alt="" />
            <input type="submit" name="submit" value="Submit" class="buttonGo">
        </form>
    </div>
</body>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pageImagePrev').attr('src', e.target.result);
        }            
        reader.readAsDataURL(input.files[0]);
    }
    };
    $("#newImageUpload").change(function(){
        readURL(this);
    });
    $("#addNewPageForm").on('submit', function(e){
        if ($("#pageTitle").val() == "")
        {
            $(".invalidInput").hide();
            $("#pageTitle").after("<p class='invalidInput' style='color: red'>PLEASE ENTER A NAME</p>");
            e.preventDefault();
        }
    });
    $("#pageTitle").focus(function(){
        $(".invalidInput").hide("slow");
    })
</script>
</html>
