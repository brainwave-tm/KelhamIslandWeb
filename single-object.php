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
        <a href="index.php"><img class="headerLogo" src="content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1><?php
        echo $objectData->objectName;
        ?></h1>
        <a href='objectSelect.php' class="backLink"><i class="fas fa-home">Back</i></a>
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
                        echo "<li><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "' style='color: grey'>" . $objectPages[$i]['pageTitle'] ."</a></li>";  
                        
                    }
                    else{
                        echo "<li><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "'>" . $objectPages[$i]['pageTitle'] ."</a></li>";  
                        
                    }
                }
                echo "<br>";
                echo "<li><u><a href='#images'>Images</a></u></li>";
                
                ?>
            </ol>
        </div>
        <div class="pageContent">
            <?php
                // Sets the default pagenumber to be 1 if no value is set \\
                if (isset($_GET['pageID'])) 
                {
                    $pageID = safeInt($_GET['pageID']);
                    $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = $pageID")->fetchObject();
                    echo "<h2 class='title'>$objectPage->pageTitle</h2>";

                    echo "<div class='longDescription'>";
                    echo "<p>" . nl2br($objectPage->pageText). "</p>";
                    echo "</div>";
            
                    if(!is_null($objectPage->pageImage))
                    {
                        echo "<h2 style='margin-top: 10px'><a id='images'>Images</a></h2>";
                        echo "<div class='objectImages'>";
                        $objectImage = $pdo->query("SELECT imageUrl, imageDescription FROM images WHERE imageId = $objectPage->pageImage")->fetchObject();
                        echo "<img src='content/images/$objectID/" . $objectImage->imageUrl . "' title='$objectImage->imageDescription' id='$objectImage->imageDescription'>";
                        echo "</div>";
                    }
                }
                else
                { 
                    $objectPage = $pdo->query("SELECT * FROM objects WHERE objectId = ". $objectID)->fetchObject();
                    echo "<h2 class='title'>$objectPage->objectName</h2>";

                    echo "<div class='longDescription'>";
                    echo "<p>$objectPage->objectShortDescription</p>";
                    echo "</div>";
                    echo "<h2 style='margin-top: 10px'><a id='images'>Images</a></h2>";
                    echo "<div class='objectImages'>";
                    $objectImage = $pdo->query("SELECT imageUrl, imageId FROM images WHERE imageId = $objectPage->objectPreviewImage")->fetchObject();
                    echo "<img src='content/images/$objectPage->objectId/" . $objectImage->imageUrl . "' id='$objectImage->imageId'>";
                    echo "</div>";
                }
                ?>
            <h3><a href="#top">Back to top</a></h3>
        </div>
    </div>

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
    </script>
</body>
</html>
