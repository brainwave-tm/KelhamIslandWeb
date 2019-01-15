<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");

$objectID = safeString($_GET['objectId']);
$page = $pdo->query("SELECT * FROM pages
INNER JOIN images ON pages.pageImage = images.imageId
WHERE pages.objectId = $objectID")->fetchAll();

$pageId = 0;
if(isset($_GET['pageId'])) { $pageId = safeInt($_GET['pageId']); }
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
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h2>Editing: <?php
        if (isset($_GET['pageId'])) 
        {
                $pageId = safeInt($_GET['pageId']);
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = $pageId")->fetchObject();
                echo $objectPage->pageTitle;
        } else
        {
                $objectId = safeString($_GET['objectId']);
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pages.objectId = $objectId")->fetchAll();
                echo $objectPage[0]["pageTitle"];
        }   
        ?></h2>
    </header>
    <div class="page2">
        <div class="sideBar">
        <ol type="1">
            <?php
            $objectPages = $pdo->query("SELECT pageId, pageTitle, pageImage FROM pages WHERE objectID = $objectID")->fetchAll();
            if(isset($_GET['pageID']))
            {
                echo "<li><a href='editPages.php?objectId=$objectID'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
            }
            ?>
            
            <li>PAGES</li>
            <?php
            for($i = 0; $i < sizeof($objectPages); $i++)
            {
                echo "<li><a href='editPages.php?objectId=$objectID&pageId=" . $objectPages[$i]['pageId'] . "'>" . $objectPages[$i]['pageTitle'] ."</a></li>";  
                
            }
            
            ?>
        </ol>
        </div>
        <div class="pagePreviewPanel">
            <?php
            if (isset($_GET['pageId'])) 
            {
                $pageId = safeInt($_GET['pageId']);
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = $pageId")->fetchObject();

                echo "<h2>$objectPage->pageTitle</h2>";
                echo "<p>$objectPage->pageText</p>";
        
                if(!is_null($objectPage->pageImage))
                {
                    echo "<h2 style='margin-top: 10px'><a name='images'>Images</a></h2>";
                    echo "<div class='objectImages'>";
                        $objectImage = $pdo->query("SELECT imageUrl, imageDescription FROM images WHERE imageId = $objectPage->pageImage")->fetchObject();
                        echo "<img src='../content/images/$objectPage->objectId/" . $objectImage->imageUrl . "' title='$objectImage->imageDescription' id='$objectImage->imageDescription'>";
                    echo "</div>";
                }                        
            } else
            {
                $objectId = safeString($_GET['objectId']);
                $pages = $pdo->query("SELECT * FROM pages
                INNER JOIN images ON pages.pageImage = images.imageId
                WHERE pages.objectId = $objectId")->fetchAll();

                echo "<h2>" . $pages[0]["pageTitle"] . "</h2>";
                echo "<p>". $pages[0]["pageText"] ."</p>";
            }
            ?>
        </div>
    </div>
    
</body>
</html>