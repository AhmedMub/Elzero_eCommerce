<?php

include 'admin_panel/connect.php';
// this is a fix for Errors like "header already sent" and some header errors as well, But I commented it out because I didn't have these issues
// ob_start();
 
session_start();

//start LogIn session
if (isset($_SESSION['user'])) {
    
    header("location:index.php");
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //this is differentiate between the info you are receiving, Is it a signIn or signUp
    if (isset($_POST['action']) && $_POST['action'] == "login") {

        //get user info from the request method "post"
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $passSha = sha1($pass);

        //check from the user if it is exists in the DB
        $stmt = $db->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ?");

        $stmt->execute(array($user, $passSha));

        // I don't need fetch method because I wont print any of these data I want only to check the Existences ONLY

        $userCount = $stmt->rowCount();

        // Here I will start record the session, so after I checked that user is exists in the DB, then I will make the session of "user" I wrote above equal the exist user that has been found right above via the query
        if ($userCount > 0) {

            //I only need the username for the web site not like the admin_panel that needs userID
            $_SESSION['user'] = $user;

            echo "userExists";
            
        } else {
            echo "there is no such username: " . $_POST['user'];
            exit();
        }

    } 
}

