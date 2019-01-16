<?php
include("../includes/conn.inc.php");
include("../includes/functions.inc.php");
include("../process/ChangePassword.php");
include('../includes/sessions.inc.php');
require("../logic/auth.php");

if(isset($_POST['username']))
{
    $check =false;
    $username = $_POST['username'];
    $getUserName = $pdo->query("SELECT userName FROM users")->fetchObject();
    if (empty($username))
    {
        $errorUsername = 'Usernamer field is empty.';
    }
    else if($username == $getUserName->userName)
    {
        $errorUsername = 'Use different username than the current one.';
    }   
    else if(strlen($username) > 25)
    {
        $errorUsername = 'Too large!Only up to 25 characters.';
    }
    else
    {         
        $successUsername = 'Successfully changed Username!';
        $query = $pdo->prepare("UPDATE users SET userName = '" . safeString($username) . "' WHERE userId = 1");
        $query->execute();
    }
}
if (isset($_POST['repassword']))
{
    $repassword = $_POST['repassword'];
    if (empty($repassword))
    {
        $errorRePassword = 'Password confirmation field is empty.';
    }
}
if (isset($_POST['password']))
{    
    $password = $_POST['password'];
    if(empty($password))
    {
        $errorPassword = 'Password field is empty.';
    }
    else if(isset($_POST['repassword']))
    {
        $repassword = $_POST['repassword'];
        if (empty($repassword))
        {
            $errorRePassword = 'Password confirmation field is empty.';
        }
        else if(strlen($password) > 100)
        {
            $errorPassword = 'Password too big!Use a new one less than 100 characters.';
        }
        else if ($password == $repassword)
        {
            $newpassword = changePassword($password);
            $query = $pdo->prepare("UPDATE users SET userPassword = '". safeString($newpassword) . "' WHERE userId = 1");
            $query->execute();
            $successPassword='Successfully changed Password!';
        }
        else
        {
            $errorPassword= 'Password doesnt match with confirmation password.';
        }
    }
}
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
    <!-- For Back icons etc. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Kelham Island Web - User Control</title>    
</head>
<body>
   <header>
        <a href="cms.php" class="backLink"><span class="backLink"><i class="fas fa-caret-left"></i><strong>Back</strong></span></a>
        <h1>Edit Your Account</h1>
        <a href="../index.php"><img class="headerLogo" src="../content/images/logo.png" alt="Kelham Island Logo"></a>
    </header>
<form action="cms_user.php" method="post">
    <div class="username_box">
    <h1>Change UserName</h1>
        <?php
            if(isset($errorUsername))
            { ?>
            <small style="color:#aa0000;"><?php echo $errorUsername; ?></small>
                <br /><br />
        <?php } ?>
        <?php
            if(isset($successUsername))
            { ?>
            <small style="color:#008000;"><?php echo $successUsername; ?></small>
                <br /><br />
        <?php } ?>
        <?php
            $getUserName = $pdo->query("SELECT userName FROM users")->fetchObject();            
            echo "Current UserName : " ?> <small style="color:#008000;"><?php echo $getUserName->userName; ?></small>             
        
        <p>                  
            <label for="username">Enter your new Username:</label>
            <input type="text" name="username" placeholder="Username"/> 
        </p>
        <p>
            <input type="submit" value="Change Username" class="changeButton" />
        </p>
    </div>
</form>
<form action="cms_user.php" method="post" >
    <div class="password_box">
    <h1>Change Password</h1>           
        <?php if(isset($errorPassword)) { ?>
            <small style="color:#aa0000;"><?php echo $errorPassword; ?></small>
            <br />
        <?php } ?>

        <?php if(isset($errorRePassword)) { ?>
            <small style="color:#aa0000;"><?php echo $errorRePassword; ?></small>
            <br />
        <?php } ?>

        <?php if(isset($successPassword)) { ?>
            <small style="color:#008000;"><?php echo $successPassword; ?></small>
            <br />
        <?php } ?>

        <p>              
            <label for="password">Enter your new Password:</label>
            <input type="text" name="password" placeholder="Password" />
        </p>
        <p>
            <label for="password">Confirm your new Password:</label>
            <input type="text" name="repassword" placeholder="Re-enter Password" />
        </p> 
        <p >
            <input type="submit" value="Change Password" class="changeButton" />
        </p>
    </div>
</form>
</body>
</html>