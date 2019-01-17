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

        if(!$_FILES['fileToUpload']["name"] == "")
        {
            $imageId = replaceFile($objectID);
        } else
        {
            $imageId = null;
        }
        

        $sql2 = "INSERT INTO pages (objectId, pageText, pageTitle, pageImage) VALUES (?,?,?,?)";
        
        $stmt2= $pdo->prepare($sql2);
        $stmt2->execute([$objectID, $pageText, $pageName, $imageId]);

        header("Location: editObject.php?objectID=$objectID&message=Created%20Page%20Successfully%20");
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
        <h1>Add A New Page</h1>
        <span class="helpButton" ><i id="helpButton"class="far fa-question-circle"></i><p><strong>Help</strong></p></span>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>
    <div class="pagesFlexBox">
        <div class="addPagesForm">
            <h1>Adding a page to object: <?php echo $objectName; ?></h1>
            <h2>A page allows you to enter more information about an object for the users to browse through on the front end. Use pages to break up information.</h2>
            <h3>It is suggested that you atleast upload an image or some text, uploading both gives a good feel to the page</h3>
            <form id="addNewPageForm" autocomplete="off" class="" name="addNewPage" method="POST" action="" enctype="multipart/form-data">
                <strong>Page Title* (25 characters max)</strong>
                <input type="text" maxlength="25" name="newPageTitle" id="pageTitle"/>
                <strong>Page Text</strong>
                <textarea name="pageText" name="pageText" id="pageText"></textarea>
                <strong>Page Image (Optional)</strong>
                <input type="file" id="newImageUpload" name="fileToUpload"/>
                <strong>Image Preview</strong><br>
                <img id="pageImagePrev" style="width: 200px; height: auto;" src="" alt="" />
                <strong>Page Video (Optional)</strong>
                <input type="text" id="pageVideo" name="pageVideo"/>
                <!-- <button id="searchBtn">Search</button> -->

                <input type="submit" name="submit" value="Submit" class="buttonGo">
            </form>
        </div>
        <div class="pagePreview">
            <h1 id="pageTitlePreview" orig="Page Title">Page Title</h1>
            <textarea id="pageTextPreview" orig="Page Text" readonly>Page Text</textarea>
            
            <h2>Images</h2>
            <img id="pageImagePreview">

            <h2>Videos</h2>
            <div id="videoPreview">
                <!-- Add videos here -->
            </div>
        </div>
    </div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pageImagePrev').attr('src', e.target.result);
                $('#pageImagePreview').attr('src', e.target.result);
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
            $(".invalidInput").remove();
            $("#pageTitle").before("<p class='invalidInput' style='color: red'>PLEASE ENTER A TITLE</p>");
            e.preventDefault();
        }      
    });
    $("#pageTitle").focus(function(){
        $(".invalidInput").hide("slow");
    })

    $(".addPagesForm :input").on('input',function(e){
        if(e.currentTarget.value != "")
        {
            $("#" + e.currentTarget.id + "Preview" ).html(e.currentTarget.value);
        } else
        {
            $("#" + e.currentTarget.id + "Preview" ).html($("#" + e.currentTarget.id + "Preview" ).attr("orig"));
        } 
    });

    $("#pageVideo").focusout(function() {
        
        $searchTerm = $("#pageVideo")[0].value;
        $apikey = 'AIzaSyBejjDHXTLdYQ6arb5gCad_Uoe_Udk9Rs4'; 
        $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' + $searchTerm + '&maxResults=4&key=' + $apikey;

        $.ajax({
            type: 'GET',
            url: $googleApiUrl,
            dataType: 'json',
            success: function(response){
                $("#videoPreview").empty();
                response.items.forEach(function(element) {
                    $("#videoPreview").append(
                        "<div class='singleVideo'><iframe src=" +
                        "https://www.youtube.com/embed/" + element.id.videoId + 
                        " allowfullscreen></iframe>" +
                        "<h1><a class='selectVideoLink'>Select</a></h1></div>"
                    );
                });
            }
        });
    });
    $(".helpButton").on("click", function(){
    window.location.href = 'userManual.php';
    })

    function getCookie(cname) {
        // https://www.w3schools.com/js/js_cookies.asp //
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
</script>
</body>
</html>
