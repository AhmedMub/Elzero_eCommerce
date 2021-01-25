<?php
include 'admin_panel/connect.php';
include "includes/funcs/functions.php";

 if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['action']) && $_POST['action'] == "register") {
        //get new user info into variables
        $newUser = $_POST['username'];
        $mail = $_POST['email'];
        $password = $_POST['password'];
        $passwordSha = sha1($password);
       
        //Start Validate Errors
        $validErrors = array();
       
            //Start Username Validate
            if (!empty($newUser)) {

                $fnewUser = filter_var($newUser, FILTER_SANITIZE_STRING);
                
            } else {
                $validErrors[] = "<div class='error-wrapper'>username is a required field can NOT be empty</div>";
                echo join("", $validErrors);
                exit(); //this is print the only one error not all errors so this will stop the script till this point
            }
            if (empty($mail)) {
                $validErrors[] = "<div class='error-wrapper'>email is a required field can NOT be empty</div>";
                echo join("", $validErrors);
                exit();
            } elseif (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
                $validErrors[] = "<div class='error-wrapper'>please enter a valid email</div>";
                echo join("", $validErrors);
                exit();
            } else {
                $fmail = filter_var($mail, FILTER_SANITIZE_EMAIL);
            }
            if (empty($password)) {
                $validErrors[] = "<div class='error-wrapper'>password is a required field can NOT be empty</div>";
                echo join("", $validErrors);
                exit();
            } elseif (filter_var($password, FILTER_VALIDATE_INT) == false) {
                $validErrors[] = "<div class='error-wrapper'>password must be integer</div>";
                echo join("", $validErrors);
                exit();
            } else {
                $fpassword = filter_var($password, FILTER_SANITIZE_NUMBER_INT); 
            }


            //check if the user exists in the DB before insert to DB
            $userCheck = checkItem("Username", "users", $fnewUser);

            if ($userCheck > 0) {
                $validErrors[] = "<div class='error-wrapper'>username already exists please change it</div>";
                echo join("", $validErrors);
                exit();
            } else {
                $stmt = $db->prepare("INSERT INTO users(Username, Email, Password, Date)

                                        VALUES(:znewUser, :zmail, :zpass, now())");
                
                $stmt->execute(array(
                    'znewUser' => $fnewUser,
                    'zmail' => $fmail,
                    'zpass' => $passwordSha
                ));

                $inserted = $stmt->rowCount();

                echo "<div class='error-wrapper error-wrapper-success'>" . "successful registration NOW go to login" . "</div>";
            }
        } 
        
 }

