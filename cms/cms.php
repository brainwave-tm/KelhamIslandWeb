<?php
include('../includes/sessions.inc.php');
require("../logic/auth.php");
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="../css/desktop.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="../content/images/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web</title>
</head>
<body>
    <header id="cms">
        <a href="../LoginForm.php" class="backLink"><span class="backLink"><i class="fas fa-caret-left"></i><strong>Back</strong></span></a>
        <h1>CMS</h1>
        <span class="helpButton" ><i id="helpButton"class="far fa-question-circle"></i><p><strong>Help</strong></p></span>
        <a href="logout.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>
    <div class="page">
        <div class="sideBar" id="cmsSidebar">
            <li><h2>Menu</h2></li>
            <ol type="1" class="sideBarMenu">              
                <li><i class="fas fa-user-circle"></i> <a href='cms_user.php'>Account</a></li>
                <li><i class="fas fa-archive"></i> <a href='addObject.php'>Add Object</a></li>
                <li><i class="fas fa-running"></i> <a href='logout.php'>Logout</a></li>
            </ol>
        </div>
        <?php
        if(!isset($_GET['direction'])) { $direction = "DESC"; } else { $direction = $_GET['direction']; }
        if(!isset($_GET['orderBy'])) { $orderBy = "none"; }else {$orderBy = $_GET['orderBy']; }
        if($direction == "DESC") { $direction = "ASC"; $icon = "<i class=\"fas fa-sort-up\"></i>"; } else { $direction = "DESC"; $icon = "<i class=\"fas fa-sort-down\"></i>";}
        ?>
        <div class='objectSelect'>
        <p>To order the objects, click the header of the column to order by ascending or descending values.</p>
        <table style="width:100%">
            <tr>
                <th><i class="fas fa-check-square"></i></th>
                <th><a class="tableHeaderText" href="cms.php?orderBy=objectId&direction=<?php echo $direction; ?>">ID <?php if($orderBy == "objectId") { echo $icon; }?></a></th>
                <th><a class="tableHeaderText" href="cms.php?orderBy=objectName&direction=<?php echo $direction; ?>">Name<?php if($orderBy == "objectName") { echo $icon; }?></a></th>
                <th>Short Description</th>
                <th>Image</th>
                <th><a class="tableHeaderText" href="cms.php?orderBy=objectShelfPosition&direction=<?php echo $direction; ?>">Shelf Position <?php if($orderBy == "objectShelfPosition") { echo $icon; }?></a></th>
            </tr>
            <?php
            $orderOptions = "objectShelfPosition";
            if(isset($_GET['orderBy'])) { $orderOptions = $_GET['orderBy']; }
            $objects = $pdo->query("SELECT * FROM objects INNER JOIN images ON objects.objectPreviewImage = images.imageId ORDER BY " . $orderOptions . " " . $direction)->fetchAll();
            foreach($objects as $o)
            {
                echo "<tr>";
                    echo "<td><input class='radioButton' id=" . $o['objectId'] . " type='radio' value='" . $o['objectId'] . "' name='objects'></td>";
                    echo "<td>" . $o['objectId'] . "</td>";
                    echo "<td>" . $o['objectName'] . "</td>";
                    echo "<td>" . $o['objectShortDescription'] ."</td>";
                    echo "<td><a href='imageView.php?url=" . $o['objectId'] . "/" . $o['imageUrl'] . "'>View Image</a></td>";
                    if($o["objectShelfPosition"] != "NU") { echo "<td>" . $o['objectShelfPosition']. "</td>"; } else { echo "<td style='color: red'>No Shelf Position Set</td>"; }
                echo "</tr>";
            }
            ?>
        </table>
        
        </div>
    </div>

    <script>
    $( document ).ready(function() {
        $(".radioButton").change(function() {
            var clickedRadioButton = $('.radioButton:radio:checked')[0]; // Returns all checked checkboxes with the class 'checkbox' //
            $(".editObjectLink").remove();
            $(".deleteObjectLink").remove();
            $( ".sideBarMenu" ).append( "<li class='editObjectLink'><i class='fas fa-pen'></i> <a href='editObjectTest.php?objectID=" + clickedRadioButton["id"] + "'>Edit Object</a></li> " );
            $( ".sideBarMenu" ).append( "<li class='deleteObjectLink'><i class='fas fa-trash-alt'></i> <a class='deleteObjectLink' href='deleteObject.php?objectId=" + clickedRadioButton["id"] + "' onclick=\"return confirm('Are you sure you want to delete this object?');\">Delete Object</a></li> " );       
        });
    });
    $(".helpButton").on("click", function(){
    window.location.href = 'userManual.php';
    })
    </script>
</body>
</html>