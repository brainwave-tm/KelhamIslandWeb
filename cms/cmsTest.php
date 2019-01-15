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
    <meta http-equiv="refresh" content="240;url='index.php'" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <title>Kelham Island Web</title>
</head>
<body>
    <header>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1>CMS</h1>
    </header>
    <div class="page">
        <div class="sideBar">
            <li>Menu</li>
            <ol type="1" class="sideBarMenu">
                <li><i class="fas fa-arrow-circle-left"></i> <a href='../index.php'>Back</a></li>                
                <li><i class="fas fa-user-circle"></i> <a href='cms_user.php'>Account</a></li>
                <li><i class="fas fa-archive"></i> <a href='addObject.php'>Add Object</a></li>
                <li><i class="fas fa-running"></i> <a href='logout.php'>Logout</a></li>
            </ol>
        </div>
        <div class='objectSelect'>
        <table style="width:100%">
            <tr>
                <th>Edit</th>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Shelf Position</th>
            </tr>
            <?php
            $objects = $pdo->query("SELECT * FROM objects INNER JOIN images ON objects.objectPreviewImage = images.imageId ORDER BY objects.objectShelfPosition ASC")->fetchAll();
            for($i = 0; $i < sizeof($objects); $i++)
            {
                $index = 0;
                echo "<tr id='" . $objects[$i]['objectId'] . "-$index'" . $objects[$i]['objectId'] ."'>";
                    echo "<td id='" . $objects[$i]['objectId'] . "-$index'><a class='editBtn' href='#'><i class='fas fa-pen'></i></a></td>";
                    $index++;
                    echo "<td id='" . $objects[$i]['objectId'] . "-$index'>" . $objects[$i]['objectId'] . "</td>";
                    $index++;
                    echo "<td id='" . $objects[$i]['objectId'] . "-$index'>" . $objects[$i]['objectName'] . "</td>";
                    $index++;
                    echo "<td id='" . $objects[$i]['objectId'] . "-$index'>" . $objects[$i]['objectShortDescription'] ."</td>";
                    $index++;
                    echo "<td id='" . $objects[$i]['objectId'] . "-$index'><a href='../content/images/" . $objects[$i]['objectId'] . "/" . $objects[$i]['imageUrl'] . "'>" . $objects[$i]['imageDescription'] ."</a></td>";
                    $index++;
                    echo "<td id='" . $objects[$i]['objectId'] . "-$index'>" . $objects[$i]['objectShelfPosition']. "</td>";
                echo "</tr>";
                $index = 0;
            }

            foreach($objects as $o)
            {
                
            }
            ?>
        </table>
        
        </div>
    </div>

    <script>
    $( document ).ready(function() {
        $(".editBtn").click(function() {
            var tableRows = $(this).parent().parent().children();
            tableRows[0]['innerHTML'] = "<a class='submitBtn' href='#' onclick='submit();'><i class='fas fa-check'></i></a>";
            tableRows = tableRows.slice(2, tableRows.length); // Remove the edit button from the array //
            tableRows.each(function( index ) {
                var row = $(this)[0];
                row['innerHTML'] = "<textarea>" + row["innerHTML"] + "</textarea>";
            });
        });

        $('textarea').change(function(){
            alert("The text has been changed.");
        });
    });

    function submit() {
        var tableRows = $(".submitBtn").parent().parent().children();
        tableRows = tableRows.slice(1, tableRows.length);
        tableRows.each(function( index ) {
            var id = $(this)[0]["id"];
            console.dir(id);
        });
    }
    </script>
</body>
</html>