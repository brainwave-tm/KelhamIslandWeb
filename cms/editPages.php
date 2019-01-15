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
        <h2>Editing <?php
        echo $page[$pageId]["pageTitle"];
        ?></h2>
    </header>
    <div class="page2">
        <div class="sideBar">
        <ol type="1">
            <?php
            $objectPages = $pdo->query("SELECT pageId, pageTitle, pageImage FROM pages WHERE objectID = $objectID")->fetchAll();
            if(isset($_GET['pageID']))
            {
                echo "<li><a href='single-object.php?objectID=$objectID'><i class=\"fas fa-chevron-circle-left\"></i></a></li>";
            }
            ?>
            
            <li>PAGES</li>
            <?php
            for($i = 0; $i < sizeof($objectPages); $i++)
            {
                echo "<li><a href='single-object.php?objectID=$objectID&pageID=" . $objectPages[$i]['pageId'] . "'>" . $objectPages[$i]['pageTitle'] ."</a></li>";  
                
            }
            
            ?>
        </ol>
        </div>
        <div class="pagePreviewPanel">
            <?php
            echo "<h2>" . $page[$pageId]["pageTitle"] . "</h2>";
            echo "<p>" . $page[$pageId]["pageText"] . "</p>";
            echo "<div class='pagePreviewImages'>";
                echo "<img src='../content/images/" . $objectID . "/" . $page[$pageId]["imageUrl"] . "'>";
            echo "</div>";
            ?>
        </div>
    </div>
    
</body>
</html>