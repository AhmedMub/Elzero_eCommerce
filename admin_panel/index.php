<?php
session_start();
$nav_var = "";
$pageTitle = "Login";

//*"username" this the name of the Admin session on the admin_panel MAKE SURE TO CHANGE this name in the eCommerce site for other users 
if (isset($_SESSION['username'])) {

    //if this session of "username" exists will direct you to the Dahshboard, [how this session will be found?=> by the query as below in the request method]
    header('location: dashboard.php'); 
}
include "init.php"; //All files included in the Initialize file

    //Here to check if the user coming from post request not like writing direct link, and to be sure that he is coming from the form below
    if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

        //record the info which is "username" and "Password" I received from the "Form" below through "Post" request
            //After that check   
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);
        
        //check if the username exists in the Database with the same password that user entered and I received and put it in the $password
        $stmt = $db->prepare("SELECT 
                                UserID, Username, Password 
                             FROM 
                                users 
                            WHERE 
                                Username = ? 
                            AND 
                                Password = ? 
                            AND 
                                GroupID = 1
                            LIMIT 1");
        $stmt-> execute(array($username, $hashedPass));
        $row = $stmt-> fetch();
        $count = $stmt->rowCount();
        
        // If count > 0 this mean the Database contain record about this username 
        if($count > 0) {
            $_SESSION['username'] = $username; //Register a session name
            $_SESSION['ID'] = $row['UserID']; //register session id  with the person's userID from DB
            header('location: dashboard.php'); // redirect to dashboard.php
            exit(); //to stop scrip from running
        }
    }
?>
<!-- =========================================== -->
<?php //PHP_SELF this to send the form information on submit to the same page which is this page and I will recorded and analyze it afterwords as above?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" class="login" method="POST">
    <h2 class="text-center">Admin Form</h2>
    <div class="mb-3">
        <input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off">
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" name="pass" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Log In</button>
</form>
<!-- =========================================== -->
<?php include $templets . "footer.inc.php"?>