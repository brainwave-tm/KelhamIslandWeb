<?php
include('../includes/sessions.inc.php');
require('../includes/conn.inc.php');
include('../includes/functions.inc.php');
//check login / password combination
if(isset($_POST['login'])){
    //Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT * FROM users WHERE userName = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', safeString($username));
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that username!
        header("Location: ../LoginForm.php");
        die();
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that stored in our users table.
        
        //Compare the passwords.
        $validPassword = password_verify($passwordAttempt, $user['userPassword']);
        
        //If $validPassword is TRUE, the login has been successful.
        if($validPassword){
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['login'] = 1;
            $_SESSION['username'] = $user['userFullName'];
            //Redirect to our protected page, which we called home.php
            header("Location: ../cms/cms.php");
	        die();            
        } else{
            header("Location: ../LoginForm.php");
            die();
        }
    }
}
?>