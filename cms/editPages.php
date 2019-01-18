<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");
include('../includes/sessions.inc.php');
require("../logic/auth.php");
$objectID = safeString($_GET['objectId']);
$page = $pdo->query("SELECT * FROM pages
INNER JOIN images ON pages.pageImage = images.imageId
WHERE pages.objectId = $objectID")->fetchAll(); // Is this entire statement needed? //

$pageId = 0;
if(isset($_GET['pageId'])) { $pageId = safeInt($_GET['pageId']); }
if(isset($_GET['deleteImage']))
{
    if($_GET['deleteImage'] ?? NULL == 1)
    {
        $page = $pdo->query("SELECT * FROM pages WHERE pageId = $pageId")->fetchAll();
        $imageUrl = $pdo->query("SELECT imageUrl, imageId FROM images WHERE IMAGEiD = (SELECT pageImage FROM pages WHERE pageId = $pageId)")->fetchAll();
        $dir = '../content/images/' . $page[0]['objectId'] . '/' . $imageUrl[0]['imageUrl'];
        unlink($dir);
        $pdo->query("DELETE FROM images WHERE imageId = '" . $imageUrl[0]['imageId'] . "'");
        $pdo->query("UPDATE pages SET pageImage = NULL WHERE pageId = '".$pageId."'");
        if(!isset($_GET['pageId'])) { header("Location: editPages.php?objectId=" . $objectID); } else { header("Location: editPages.php?objectId=" . $objectID . "&pageId=" . $pageId . "&message=Deleted%20Page%20Successfully"); }
    }
}

// Check if the user has deleted the last page. If so, there's nothing left to display, so they should be redirected to the editObject.php page //
$pagesCheck = intval($pdo->query("SELECT COUNT(pageId) AS pageCount FROM pages WHERE objectId = " . $objectID . ";")->fetchAll()[0]["pageCount"]);
if($pagesCheck == 0) { header("Location: editObject.php?objectID=" . $objectID . "&message=Deleted%20Page%20Successfully"); }
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
        <a href="editObjectTest.php?objectID=<?php echo $objectID; ?>" class="backLink"><span class="backLink"><i class="fas fa-caret-left"><strong>Back</strong></i></span></a>
        <h2>Editing: <?php
        if (isset($_GET['pageId'])) 
        {
                $pageId = safeInt($_GET['pageId']);
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pageId = '" . $pageId . "'")->fetchObject();
                echo $objectPage->pageTitle;
        } else
        {
                $objectPage = $pdo->query("SELECT * FROM pages WHERE pages.objectId = $objectID")->fetchAll();
                echo $objectPage[0]["pageTitle"];
        }   
        ?></h2>
        <a href="logout.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
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
            <li><a href="addPages.php?objectId=<?php echo $objectID; ?>"><i class="fas fa-plus"></i> Add another page</a></li>
        </ol>
        </div>

        <div class="pagePreviewPanel">
            <?php
            if(isset($_GET["message"]))
            {
                echo "<h2 class='message'>" . $_GET["message"] . "</h2><br>";
            }    
            ?>
                <form action="updateDatabase.php" method="post" enctype="multipart/form-data">
                <?php
                if(isset($_GET['pageId']))
                {
                    // Page ID has been supplied, we can load the page directly into an object //
                    echo "<input type='text' name='pageId' value='" . $pageId . "' style='display: none;'/>"; // Invisible Element for $_POST //
                    echo "<input type='text' name='objectId' value='" . $objectID . "' style='display: none;'/>"; // Invisible Element for $_POST //

                    echo "<input type='text' name='pageTitle' value='" . $objectPage->pageTitle . "'/><br><br>";
                    echo "<textarea name='pageText'>" . str_replace("[newline]", "\n", $objectPage->pageText) . "</textarea>";

                    if($objectPage->pageImage == null)
                    { ?>
                        <!-- If objectPage does not have an image, allow user to upload one -->
                        <p>Choose New Image: </p>
                        <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
                        <div class='objectImages'>
                            <?php if($objectPage->pageImage != NULL) { echo "<img id='eventImagePrev' onerror=\"this.src='../content/images/errorImage.png';\">"; }; ?>
                        </div>
                        <br><br>
                    <?php
                    } else
                    {
                        // If objectPage does have images, display them and allow for a new one to be uploaded too //
                        $objectImage = $pdo->query("SELECT * FROM images WHERE imageId = " . $objectPage->pageImage )->fetchObject();
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
                                <?php echo '<a href=\'editpages.php?objectId='.$objectID.'&pageId='.$pageId.'&deleteImage=1\' class=\'textLink\' onclick="return confirm(\'Are you sure you want to delete the image?\')"><i class=\'fas fa-trash-alt\'></i> Delete image from page</a>'; ?>
                            </div>
                        </div>
                        <?php
                    }
                    echo "<input type='submit' value='Update'>";
                    echo "</form>";
                } else
                {
                    $pageId = $objectPage[0]["pageId"];
                    echo "<input type='text' name='pageId' value='" . $pageId . "' style='display: none;'/>";
                    echo "<input type='text' name='objectId' value='" . $objectID . "' style='display: none;'/>";                
                    echo "<input type='text' name='pageTitle' value='" . $objectPage[0]["pageTitle"] . "'/><br><br>";
                    echo "<textarea name='pageText'>" . str_replace("[newline]", "\n", $objectPage[0]["pageText"]) . "</textarea>";

                    if($objectPage[0]["pageImage"] == NULL)
                { ?>
                        <div class="newImageUpload">
                            <label for="newImageUpload"><strong>Choose New Image: </strong></label><br><br>
                            <input type="file" id="newImageUpload" name="fileToUpload"/><br><br>
                            <?php if($objectPage[0]["pageImage"] != NULL) {
                                    echo "<img id=\"eventImagePrev\" onerror=\"this.src='../content/images/errorImage.png';\" class=\"previewImg\" style=\"width: 200px;\" src=../content/images/" . $objectID . "/" . $objectImage[0]["imageUrl"] . " alt=\"/>";
                                }
                            ?>
                            <br><br>
                        </div>
                    <?php } else {
                        echo "<h2 style='margin-top: 10px'><a name='images'>Images</a></h2>";
                        echo "<div class='objectImages'>";
                            $objectImage = $pdo->query("SELECT * FROM images WHERE imageId = " . $objectPage[0]["pageImage"] )->fetchObject();
                            if($objectImage != NULL) { echo "<img id='eventImagePrev' src='../content/images/" . $objectPage[0]["objectId"] . "/" . $objectImage->imageUrl . "'>"; }
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

    function displayErrorIma(image) {
        image.onerror = "";
        image.src = "../content/images/errorImage.png";
        return true;
    }
</script>
</body>
</html>