<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="css/desktop.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <meta http-equiv="refresh" content="240;url='index.php'" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web</title>
</head>
<body style="display: none;">
    <header>
        <a href="index.php" class="backLink"><span class="backLink"><i class="fas fa-caret-left"></i><strong>Back</strong></span></a>
        <h1>Select an Object</h1>
        <span class="helpButton" ><i id="helpButton"class="far fa-question-circle"></i><p><strong>Help</strong></p></span>
        <a href="index.php"><img class="headerLogo" src="content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>

    <?php
    if($_COOKIE['firstEntry'] == "true")
    {
        // Display the popup //
        setcookie("firstEntry", "false", time() + (86400 * 30));
    ?>
        <div class="popup">
            <h1>Welcome to the Kelham Island <strong>Interactive Open Store Directory</strong>!</h1>
            <p>Across the room from you is the <strong>Open Store</strong>. Objects are stored on the racking along the wall; divided into bays. Each bay is labelled with a <strong>letter</strong> and a <strong>number</strong> - for example <strong>A1</strong>. They are labelled as follows:</p>
            <table>
                <?php
                $rows = array("A", "B", "C", "Floor ");
                foreach($rows as $row)
                {
                    echo "<tr>";
                    for($number = 1; $number < 8; $number++)
                    {
                        
                            echo "<td>" . $row . $number . "</td>";
                        
                    }
                    echo "</tr>";
                }
                ?>
            </table>
            <ul>
                <li>The <strong>letter</strong> refers to the column; the highest objects being at <strong>A</strong>, and the lowest objects being on the <strong>Floor</strong></li>
                <li>The <strong>number</strong> refers to the row, numbered 1-7, left to right.</li>
                <li>Click on an object on this page to view information about it; including images, videos and history about the object.</li>
                <li>Bays contain more than one object.</li>
            </ul>
            <h1>Enjoy learning about the Open Store objects!</h1>
            <button id="closeBtn">Close</button>
        </div>
    <?php
    }
    ?>

    <div style='background-color: ghostwhite; padding: 2px; margin-top: 10px;'>
    <?php
        $objects = $pdo->query("SELECT * FROM objects
        LEFT JOIN images ON objects.objectPreviewImage = images.imageId
        WHERE objectShelfPosition IS NOT NULL
        ORDER BY objectShelfPosition ASC")->fetchAll();
            echo "<div class='shelf'>";
            foreach($objects as $o)
            {
                echo "<div class='shelfItem' style=''>";
                echo "<div class='shelfImage'>";
                echo "<a href='single-object?objectID=".$o['objectId']."'><img src='content/images/" . $o['objectId'] . "/" . $o['imageUrl'] . "' style='max-height: 200px; max-width: 80%;'/></a>";
                echo "</div>";
                echo "<div style='height: 150px; width: 100%'>";
                echo "<p id='objectName'><a href='single-object?objectID=".$o['objectId']."'><strong>" . $o['objectName'] . "</strong></a></p>";
                echo "</div>";
                echo "<strong><p><a style='float: bottom'href='single-object.php?objectID=" . $o['objectId'] . "'>" . $o['objectShelfPosition'] . "</a></p></strong>";
                echo "</div>";
            }
            echo "</div>";
    ?>
    </div>
    <script>
        $(".shelfItem").click(function(){
            window.location = $(this).find("a").attr("href");
            return false;
        });
    </script>

    <script type="text/javascript">
    $( document ).ready(function() {
        $("body").fadeIn(1000);
        $("a").click(function(e) {
            e.preventDefault();
            $link = $(this).attr("href");
            $("body").fadeOut(500,function(){
                window.location =  $link; 
            });
        });
    });

    $("#closeBtn").on("click", function() {
        $(".popup").fadeOut(500);
    });
    $("#helpButton").on("click", function(){
        $(".popup").fadeIn();
    });
    </script>
</body>
</html>