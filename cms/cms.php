<?php
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <title>Kelham Island Web</title>
</head>
<body>
    <header>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1>CMS</h1>
    </header>

    <div class='objectSelect'>
    <table style="width:100%">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Shelf Position</th>
        </tr>
        <?php
        $objects = $pdo->query("SELECT * FROM objects INNER JOIN images ON objects.objectPreviewImage = images.imageId")->fetchAll();
        foreach($objects as $o)
        {
            echo "<tr>";
                echo "<td>" . $o['objectId'] . "</td>";
                echo "<td>" . $o['objectName'] . "</td>";
                echo "<td>" . $o['objectShortDescription'] ."</td>";
                echo "<td><a href='../content/images/" . $o['objectId'] . "/" . $o['imageUrl'] . "'>" . $o['imageDescription'] ."</a></td>";
                echo "<td>" . $o['objectShelfPosition']. "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    
    </div>
</body>
</html>