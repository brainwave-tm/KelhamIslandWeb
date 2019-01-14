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
        <form action="process/loginValidate.php" method="post" >
            <fieldset>
                <p>
                    <label for="username">Username</label>
                    <input type="text" name="new_username" id="username" />   
                </p>
                <p>
                    <label for="pass">Password:</label>
                    <input type="password" name="new_password" id="pass" required>
                </p>  
                <p class="right">
                    <input type="submit" name="login" value="Login" class="sendButton" />
                </p>
                <div class="invalidInput">
                <p>INVALID USERNAME OR PASSWORD</p>
                </div>
            </fieldset>
        </form>
        <div class = "loginToIndex">
        <h1>
        <a href="index.php"> To index </a>
        </h1>
        </div>
    </section>

    <footer>
    </footer>
</div>
</body>
</html>
