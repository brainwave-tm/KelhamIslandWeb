<?php
include("includes/conn.inc.php");
include("includes/functions.inc.php");
$userDetails = $pdo->query("SELECT userSecurityQuestion, userSecurityAnswer FROM users")->fetchAll()[0];

$securityQuestionError = false;
$securityQuestionAnswerError = false;

if(isset($_GET['validate']))
{
    // User has clicked update, now we need to validate //
    $validationCanary = true;

    if($_GET['validate'] == 1)
    {
        if($_POST['securityQuestion'] == "" || $_POST['securityAnswer'] == "") $validationCanary = false;

        if(!$validationCanary)
        {
            // User entered some blank text, set some flags //
            if($_POST['securityQuestion'] == "") $securityQuestionError = true;
            if($_POST['securityAnswer'] == "") $securityQuestionAnswerError = true;
        } else
        {
            // Submit to database //
            $pdo->query("UPDATE users SET userSecurityQuestion = '" . safeString($_POST['securityQuestion']) . "', userSecurityAnswer = '" . safeString($_POST['securityAnswer']) . "';");
        }
    } else
    {
        if($_POST['securityAnswer'] == "") $validationCanary = false;

        if(!$validationCanary)
        {
            // User entered some blank text, set some flags //
            if($_POST['securityAnswer'] == "") $securityQuestionAnswerError = true;
        } else
        {
            // Submit to database //
            $passwordCheck = $pdo->query("SELECT userSecurityQuestion, userSecurityAnswer = ");
        }
    }
    
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheet for Desktop -->
    <link rel="stylesheet" media="only screen and (min-width: 901px)" href="css/desktop.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="content/images/favicon.png">
    <title>Kelham Island - Login</title>
</head>
<body>
<div id="container">
    <section>
       <img class="loginLogo" src="content/images/logo.png" alt="Kelham Island Logo">     
        <fieldset>
        <?php
        if($userDetails["userSecurityQuestion"] == NULL && $userDetails["userSecurityAnswer"] == NULL)
        {
            // No security question has been set, allow user to enter one //
        ?>
            <p>No security question has been set - please set one:</p>
            <form action="forgotPassword.php?validate=1" method="POST">
                <strong>Security Question: </strong><br>
                <?php if($securityQuestionError) echo "<h2 class='messageBad'>Please enter a valid question.</h2>"; ?>
                <input maxlength="100" type="text" name="securityQuestion">
                
                <br><br>
                <strong>Security Question Answer: </strong><br>
                <?php if($securityQuestionAnswerError) echo "<h2 class='messageBad'>Please enter a valid answer.</h2>"; ?>
                <input maxlength="100" type="text" name="securityAnswer">

                <br><br>
                <input type="submit" value="Go">
            </form>
        <?php
        } else
        {
        ?>
            <form action="forgotPassword.php?validate=2" method="POST">
                <br><strong>Security Question: </strong><br>
                <p><?php echo $userDetails["userSecurityQuestion"]; ?></p>

                <br>
                <strong>Please enter your answer: </strong><br>
                <?php if($securityQuestionAnswerError) echo "<h2 class='messageBad'>Please enter a valid answer.</h2>"; ?>
                <input maxlength="100" type="text" name="securityAnswer">

                <br><br>
                <input type="submit" value="Go">
            </form>
        <?php
        }
        ?>
        </fieldset>
    
    <div class = "loginToIndex">
    <a href="index.php"> To index </a>
    </div>
    </section>
</div>
</body>
</html>
