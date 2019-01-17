<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");
include('../includes/sessions.inc.php');
require("../logic/auth.php");
$objectID = safeString($_GET['objectId']);
$page = $pdo->query("SELECT * FROM pages
INNER JOIN images ON pages.pageImage = images.imageId
WHERE pages.objectId = $objectID")->fetchAll();

$pageId = 0;
if(isset($_GET['pageId'])) { $pageId = safeInt($_GET['pageId']); }
if($_GET['deleteImage'] ?? NULL == 1)
{
    $page = $pdo->query("SELECT * FROM pages WHERE pageId = $pageId")->fetchAll();
    $imageUrl = $pdo->query("SELECT imageUrl, imageId FROM images WHERE IMAGEiD = (SELECT pageImage FROM pages WHERE pageId = $pageId)")->fetchAll();

    $dir = '../content/images/' . $page[0]['objectId'] . '/' . $imageUrl[0]['imageUrl'];
    unlink($dir);
    $pdo->query("DELETE FROM images WHERE imageId = '" . $imageUrl[0]['imageId'] . "'");
    $pdo->query("UPDATE pages SET pageImage = NULL WHERE pageId = '".$pageId."'");
}
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
        <a href="editObject.php?objectID=<?php echo $objectID; ?>" class="backLink"><span class="backLink"><i class="fas fa-caret-left"><strong>Back</strong></i></span></a>
        <h2>Editing: <?php
        if (isset($_GET['pageId'])) 
        {
                $pageId = safeInt($_GET['pageId']);
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = '" . $pageId . "'")->fetchObject();
                echo $objectPage->pageTitle;
        } else
        {
                $objectId = safeString($_GET['objectId']);
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pages.objectId = $objectId")->fetchAll();
                echo $objectPage[0]["pageTitle"];
        }   
        ?></h2>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>
    

    <div class="page2">
        <div class="sideBar">
        <ol type="1">
            <?php
            $objectPages = $pdo->query("SELECT pageId, pageTitle, pageImage FROM pages WHERE objectID = $objectID")->fetchAll();
            if(isset($_GET['pageID']))
            {
                echo '<li><a href="editPages.php?objectId=' . $objectID . '"><i class=\"fas fa-chevron-circle-left\"></i></a></li>';
            }
            ?>
            <li>PAGES</li>
            <?php
            for($i = 0; $i < sizeof($objectPages); $i++)
            {
                // echo "<li><a href='editPages.php?objectId=$objectID&pageId=" . $objectPages[$i]['pageId'] . "'> - " . $objectPages[$i]['pageTitle'] ."</a></li>";  
                
                echo '<li><a href="deletePage?objectId=' . $objectID . '&pageId=' . $objectPages[$i]["pageId"] . '" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash-alt"></i></a> <a href="editPages.php?objectId=' . $objectID . '&pageId=' . $objectPages[$i]['pageId'] . '">' . $objectPages[$i]['pageTitle'] .'</a></li>';                
            }
            ?>
            <br>
            <li><a href="addPages.php?objectId=<?php echo $objectID; ?>"><i class="fas fa-plus"></i> Add page to this object</a></li>
        </ol>
        </div>
        <div class="pagePreviewPanel">
            <?php
                $objectId = safeString($_GET['objectId']);          
            ?>
                <form action="updateDatabase.php" method="post" enctype="multipart/form-data">
                <?php
                if(isset($_GET['pageId']))
                {
                    echo "<input type='text' name='pageId' value='" . $pageId . "' style='display: none;'/>";
                    echo "<input type='text' name='objectId' value='" . $objectId . "' style='display: none;'/>";                
                    echo "<input type='text' name='pageTitle' value='" . $objectPage->pageTitle . "'/><br><br>";
                    echo "<textarea name='pageText'>" . $objectPage->pageText . "</textarea>";

                    if(!is_null($objectPage->pageImage))
                    { 
                        echo "<h2 style='margin-top: 10px'><a name='images'>Images</a></h2>";
                    ?>
                        <label for="newImageUpload">Choose New Image: </label>
                        <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
                    <?php
                        $pageImage = $pdo->query("SELECT pageImage FROM pages WHERE pageId = $pageId")->fetchAll();
                        if(!($pageImage[0]['pageImage'] == NULL))
                        {
                            echo '<a href=\'editpages.php?objectId='.$objectId.'&pageId='.$pageId.'&deleteImage=1\' class=\'textLink\' onclick="return confirm(\'Are you sure you want to delete the image?\')"><i class=\'fas fa-trash-alt\'></i>Delete image from page</a>';
                        }
                        echo "<div class='objectImages'>";
                            $objectImage = $pdo->query("SELECT * FROM images WHERE imageId = " . $objectPage->pageImage )->fetchObject();
                            echo "<img id='eventImagePrev' src='../content/images/" . $objectPage->objectId . "/" . $objectImage->imageUrl . "'>";
                        echo "</div>";
                    }
                        echo "<input type='submit' value='Update'>";
                        echo "</form>";    
                } else
                {
                    echo "<input type='text' name='pageId' value='" . $pageId . "' style='display: none;'/>";
                    echo "<input type='text' name='objectId' value='" . $objectId . "' style='display: none;'/>";                
                    echo "<input type='text' name='pageTitle' value='" . $objectPage[0]["pageTitle"] . "'/><br><br>";
                    echo "<textarea name='pageText'>" . $objectPage[0]["pageText"] . "</textarea>";


                    if(!is_null($objectPage[0]["pageImage"]))
                    { ?>
                        <label for="newImageUpload">Choose New Image: </label>
                        <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
                    <?php } else {
                        echo "<h2 style='margin-top: 10px'><a name='images'>Images</a></h2>";
                        echo "<div class='objectImages'>";
                            $objectImage = $pdo->query("SELECT * FROM images WHERE imageId = " . $objectPage[0]["pageImage"] )->fetchObject();
                            echo "<img id='eventImagePrev' src='../content/images/" . $objectPage[0]["objectId"] . "/" . $objectImage->imageUrl . "'>";
                        echo "</div>";
                    }
                        echo "<input type='submit' value='Update'>";
                        echo "</form>";
                }             
                ?>
        </div>
    </div>
<script>
    function readURL(input) {
    if (input.files && input.files[0]) 
    {
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