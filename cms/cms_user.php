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
    <title>Kelham Island - User Control</title>
</head>
<body>
    <header>
        <a href="index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
        <h1>Edit your account</h1>
    </header>
<form action="process/userNameValidation.php" method="post" >
    <div class="username_box">
        <h1>Change UserName</h1>
        <?php
            $getUserName = $pdo->query("SELECT userName FROM users")->fetchObject();
            echo "Current UserName : " . $getUserName->userName;
        ?>
        <p>                  
            <label for="username">Enter your new Username:</label>
            <input type="text" name="new_username" id="username" /> 
        </p>
        <p>
            <input type="submit" value="Change Username" class="changeButton" />
        </p>
    </div>
</form>
<form action="process/userPasswordValidation.php" method="post" >
    <div class="password_box">
    <h1>Change Password</h1>    
        <p>              
            <label for="password">Enter your new Password:</label>
            <input type="text" name="new_password" id="password" />
        </p>
        <p>
            <label for="password">Confirm your new Password:</label>
            <input type="text" name="new_password" id="password" />
        </p> 
        <p >
            <input type="submit" value="Change Password" class="changeButton" />
        </p>
    </div>
</form>

</body>
</html>