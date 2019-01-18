<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");

$objectID = safeString($_GET['objectID']);
$objectData = $pdo->query("SELECT * FROM objects WHERE objectID = $objectID")->fetchObject();           
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="css/desktop.css">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <!-- For Back icons etc. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web</title>
</head>
<body style="display: none;">
    <header>
        <a href="objectSelect.php" class="backLink"><span class="backLink"><i class="fas fa-caret-left"></i><strong>Back</strong></span></a>
        <h1><?php
        echo $objectData->objectName;
        ?></h1>
        <span class="helpButton" ><i id="helpButton"class="far fa-question-circle"></i><p><strong>Help</strong></p></span>
        <a href="index.php"><img class="headerLogo" src="content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>
    <div class="page" id="top">
        <div class="sideBar">
            <ol type="1">
                <?php
                $objectPages = $pdo->query("SELECT pageId, pageTitle, pageImage FROM pages WHERE objectID = $objectID")->fetchAll();
                $pageID = 0;
                if(isset($_GET['pageID']))
                {
                    $pageID = $_GET['pageID'];
                    echo "<li><a href='single-object.php?objectID=$objectID'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
                }
                ?>
                
                <li><u>PAGES</u></li>
                <br>
                <?php
                for($i = 0; $i < sizeof($objectPages); $i++)
                {
                    if ($objectPages[$i]['pageId'] == $pageID)
                    {

                        echo "<li><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "' style='color: grey'>-  " . $objectPages[$i]['pageTitle'] ."</a></li>";  

                        if($objectPages[$i]["pageImage"] != null)
                        {
                            echo "<li><a style='margin-left: 30px;' href='#images'>- Go To Images</a></li>";
                        }
                    }
                    else{
                        echo "<li><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "'>-  " . $objectPages[$i]['pageTitle'] ."</a></li>";  
                    }
                } 
                ?>
            </ol>
        </div>
        <div class="pageContent">
            <?php
                // Sets the default page number to be 1 if no value is set //
                if (isset($_GET['pageID'])) 
                {
                    $pageID = safeInt($_GET['pageID']);
                    $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = $pageID")->fetchObject();
                    echo "<h2 class='title'>$objectPage->pageTitle</h2>";

                    echo "<div class='longDescription'>";
                        echo "<p>" . str_replace("[newline]", "<br>", $objectPage->pageText) . "</p>";
                    echo "</div>";
            
                    if($objectPage->pageImage != NULL)
                    {
                        echo "<h2 style='margin-top: 10px'><a id='images'>Images</a></h2>";
                        echo "<div class='objectImages'>";
                        $objectImage = $pdo->query("SELECT imageUrl, imageDescription FROM images WHERE imageId = '$objectPage->pageImage'")->fetchObject();
                        echo "<img onerror=\"this.src='content/images/errorImage.png';\" src='content/images/$objectID/" . $objectImage->imageUrl . "' title='$objectImage->imageDescription' id='$objectImage->imageDescription'>";
                        echo "</div>";
                    }
                }
                else
                { 
                    $objectPage = $pdo->query("SELECT * FROM objects WHERE objectId = ". $objectID)->fetchObject();
                    echo "<h2 class='title'>$objectPage->objectName</h2>";
                    ?>
                    <div class = 'textSize'>
                        <h3>Text size</strong></h3>
                        <div class = 'sizeButtons'>
                            <button onclick="decrement()">-</button>
                            <button onclick="increment()">+</button>
                        </div>
                    </div>
                    <?php
                    echo "<div class='longDescription'>";
                        echo "<p>" . str_replace("[newline]", "<br>", $objectPage->objectShortDescription) . "</p>";
                    echo "</div>";

                    echo "<h2 style='margin-top: 10px'><a id='images'>Images</a></h2>";
                    echo "<div class='objectImages'>";
                    $objectImage = $pdo->query("SELECT imageUrl, imageId FROM images WHERE imageId = $objectPage->objectPreviewImage")->fetchObject();
                    echo "<img onerror=\"this.src='content/images/errorImage.png';\" src='content/images/$objectPage->objectId/" . $objectImage->imageUrl . "' id='$objectImage->imageId'>";
                    echo "</div>";
                }
                ?>
            
            <p><h3><a href="#top">Back to top</a></h3></p>

        </div>
    </div>
    <div class="popup" style="display: none">
            <h1>Welcome to the Kelham Island <strong>Interactive Open Store Directory</strong>!</h1>
            <p>On this page you can find more information on individual objects including their history, what they were used for and many more amazing facts!</p>
            <ul>
                <li><strong>On the left hand side</strong> You will find some pages with extra information</li>
                <li>At the bottom you will find images for the objects</li>
                <li>You can head back to the object selection at any time by clicking 'Back' in the top left!</li>
            </ul>
            <h1>Enjoy learning about the Open Store objects!</h1>
            <button id="closeBtn">Close</button>
        </div>

    <script>
        function decrement(){
            var $newSizemin = $('.longDescription').css("font-size");
            $newSizemin = $newSizemin.substr(0, $newSizemin.length-2);
            if($newSizemin > 20){
                $newSizemin = $newSizemin - 4;
                $('.longDescription').css("font-size", $newSizemin);
            }
        }
        function increment(){
            var $newSize = $('.longDescription').css("font-size");
            $newSize = $newSize.substr(0, $newSize.length-2);
            if($newSize < 40){
                $newSize = $newSize*1 + 4;
                $('.longDescription').css("font-size", $newSize);
            } 

        }
    </script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $("body").fadeIn(500);
        $("a").click(function(e) {
            $link = $(this).attr("href");
            if(!$link.startsWith("#"))
            {
                e.preventDefault();
                $("body").fadeOut(250,function(){
                    window.location =  $link; 
                });
            } else
            {
                var hash = this.hash;
                $('html, body').animate(
                    { scrollTop: $(hash).offset().top },
                    800,
                    function(){ window.location.hash = hash; }
                );
            }
        });
    });
    $("#closeBtn").on("click", function(){
        $(".popup").fadeOut(500);
    })
    $("#helpButton").on("click", function(){
        $(".popup").fadeIn(500);
    })
    </script>
</body>
</html>
