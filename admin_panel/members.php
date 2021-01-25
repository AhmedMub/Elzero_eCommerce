<?php
/* --------------------------------------
=========================================
Page Name - members.php

This page to manage all users => [Add && Edit && Delete && Activate] comments
=========================================
---------------------------------------*/

session_start();// never forget to start the session

// pageTitle that working according to a function in functions.php so each page name appears in the title
$pageTitle = "Members"; 

if (isset($_SESSION['username'])) { // start the user session so you can brows this page 

    include "init.php";
    
    //TODO put icons for all buttons in the project

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // this is explained in page.php

    //*this is the root of the if 
    if ($do == 'Manage') { //this is the "manage" page that has all users from the Database 

        $query = "";

        // this means if the request is "do=Manage&page=Pending" will activate this $query which going to show the pending users only that has the RegStatus equal to 0
        // this is called a "Pending" page
        if (isset($_GET['page']) && $_GET['page'] == "Pending") {
            $query = "AND RegStatus = 0";
        }

        //show All Users Except the Admin
        $stmt = $db->prepare("SELECT * FROM users WHERE GroupID != 1 $query"); //$query is activated depend on the above condition
        
        $stmt-> execute();

        //Store all fetched Data inside a Variable / fetchAll means that will get all the data
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {//this will show up if there is no members in the DB to be displayed?>
    
        <div class="container">
            <h2 class="text-center mt-5 mb-5 fs-1">Manage Members</h2>
            <table class="table table-success table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th class="col">#ID</th>
                        <th class="col">Username</th>
                        <th class="col">Email</th>
                        <th class="col">Full Name</th>
                        <th class="col">Registered Date</th>
                        <th class="col">Controls</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // loop through all data to display them as below
                    foreach ($rows as $row) {
                        echo "<tr class='text-center'>";
                            echo "<th scope='row'>" . $row['UserID'] . "</th>";
                            echo "<td>" . $row['Username'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['FullName'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>"; // this is the current date for each user created
                            //this is how to make the button go to "Edit" page
                            echo "<td>
                                    <a href='?do=Edit&userId=" . $row['UserID'] ."' class='btn btn-warning'>Edit</a>
                                    <a href='?do=Delete&userId=" . $row['UserID'] ."' class='btn btn-danger confirm'>Delete</a>";
                                    //this btn shows only inf the user not Active 
                                    if ($row['RegStatus'] == 0) {
                                        echo "<a href='?do=Activate&userId=" . $row['UserID'] ."' class='btn btn-info ml-1'>Activate</a>";
                                    }
                            echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <a href='?do=Add' class="btn btn-primary">Add New Member</a>
        </div>
    <?php
    } else { ?>

        <div class='noDataMsg mt-5'>
            <h4 class="NoComments">404</h4>
            <span>no Members found</span>
            <div class="mt-5"><a href="?do=Add" class="btn btn-info">Add New Member</a></div>
        </div>

    <?php    
    }
// this is the Add page, to understand it's content you've must been created Edit page first, so that has all Explanation
    } elseif($do == 'Add') { ?>

        <form action="?do=Insert" class=" col-lg-4 col-sm-10" method="POST"><?php // After completing this form user will directed to "Insert" page along with these info?>           
                <h2>Add New Member</h2>

                <!-- Start username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label><span class="asterisk">*</span>
                    <input type="text" class="form-control" name="username" autocomplete="off" required="required" placeholder="Username For Login">     
                </div>
                <!-- end username -->

                <!-- Start password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label><span class="asterisk">*</span>
                    <input type="password" name="password" class="form-control" autocomplete="new-password" required="required" placeholder="Password">
                </div>
                <!-- end password -->

                <!-- Start email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label><span class="asterisk">*</span>
                    <input type="email" name="email" class="form-control" autocomplete="off" required="required" placeholder="Email Address">
                </div>
                <!-- end email -->

                <!-- Start full name -->
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label><span class="asterisk">*</span>
                    <input type="text" name="fullName" class="form-control" autocomplete="off" required="required" placeholder="Full Name">  
                </div>
                <!-- end full name -->
                
                <!-- Start submit -->
                <div class="mb-3">
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>
                <!-- end submit -->
            </form>  

       <?php 
    } elseif($do == "Insert") { // this is the "Insert" page that will receive the form Info from the "Add" page.

        echo "<h2 style='text-align: center; margin: 40px 0; font-size: 40px;'>Insert New Member</h2>";
        echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == "POST") { // these Codes Explained in "update" page
            

            $user = $_POST['username'];
            $pass = $_POST['password'];
            $email = $_POST['email'];
            $fullname = $_POST['fullName'];
        }
        $shaPass = sha1($_POST['password']);
        //checking for Errors
        $formErrors = array();

        if (strlen($user) > 10 || strlen($user) < 3) {
            $formErrors[] = "Username Must Be at Least 4 Characters and Maximum 10 Characters";
        }
        if (empty($user)) {
            $formErrors[] = "Username can not be Empty";
        }
        if (empty($pass)) {
            $formErrors[] = "Password Can not be Empty";
        }
        if (empty($email)) {
            $formErrors[] = "Email Can not be Empty";
        }
        if (empty($fullname)) {
            $formErrors[] = "Full Name Can not be Empty";
        }

        foreach($formErrors as $error) {
            echo "<div class='alert alert-danger'>" . $error . "</div>";
            
            homeRedirectV4("back"); // user will be directed back to form in the "Add" page
        }

        if (empty($formErrors)) { // if the $formErrors is empty will run the below code

            $check = checkItem("Username", "users", $user); //checking if the username already exists in the DB
            
            if ($check == 1) {
                
                $errorMsg = "Username Already Taken Change It Please";

                homeRedirectV2($errorMsg, "?do=Add");

            } else {

                //This is how to Insert into Database:
                //- you have write what's in the VALUES in same as INSERT INTO order.
                //- then execute the query in form of an array like the below   
                //-> Date Added in lesson 36, and the now() means that every user will get the current date
                //the value of the RegStatus will be 1 ONLY if the admin created the user
                 $stmt = $db->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date)
                                    VALUES (
                                        :DBuser, 
                                        :DBpass, 
                                        :DBmail, 
                                        :DBfullname,
                                        1,
                                        now()
                                        )");//these are values of the query INSERT INTO
                $stmt-> execute(array(
                    'DBuser' => $user,
                    'DBpass' => $shaPass, // don't forget to put sha1 variable NOT pass variable
                    'DBmail' => $email,
                    'DBfullname' => $fullname
                ));
                // Success Message
                $message = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Inserted" . "</div>";

                homeRedirectV3($message, "back");
            }
        }

        echo "</div>";
    } elseif ($do == 'Edit') { //Edit page 
        
        //check if the userID is a Number and if its a number get the integer value from it
        $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;  
        
        //Select and get all data from DB according to that UserID number you found on this query above
        $stmt = $db->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1"); // if you can remember from mysql course this query will show all the cells from the users table that related to userID number

        //execute the query
        $stmt-> execute(array($userId));

        //fetch these data from DB / so you can print it anywhere in this script 
        $row = $stmt-> fetch();

        //this is rowcount to check on the id
        $count = $stmt->rowCount();

        // if the id matched one of DB ids show these data inside below inputs
        if ($count > 0) {  ?>
            <!-- Start Profile Edit Form -->
            <?php // this action means will directed to update page to update user data on DB?>
            <form action="?do=Update" class=" col-lg-4 col-sm-10" method="POST"> 
            <input type="hidden" name="userId" value="<?php echo $userId?>"> <?php // this #imp this userId it depends on the userId var that created above in the page and with the userId I will depend on it to send the updates to the DB ?>
            
                <h2>Edit Member</h2>
                <!-- Start username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label><span class="asterisk">*</span>
                    <input type="text" class="form-control" name="username" value="<?php echo $row['Username']?>" autocomplete="off" required="required">
                    
                </div>
                <!-- end username -->
                <!-- Start password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>"><?php // this input will work in case of the user did not change the password so the password input is EMPTY ?>
                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave password empty as the old one is valid">
                </div>
                <!-- end password -->
                <!-- Start email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label><span class="asterisk">*</span>
                    <input type="email" name="email" class="form-control" value="<?php echo $row['Email']?>" autocomplete="off" required="required">
                </div>
                <!-- end email -->
                <!-- Start full name -->
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label><span class="asterisk">*</span>
                    <input type="text" name="fullName" class="form-control" value="<?php echo $row['FullName']?>" autocomplete="off" required="required">  
                </div>
                <!-- end full name -->
                <!-- Start submit -->
                <div class="mb-3">
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>
                <!-- end submit -->
            </form>  

        <?php
        // if there is no Matched UserID show below message
        } else { //*if the "do=Edit&userId=0" number not in the the DB
            $errorMsg = "There is NO such ID";
            
            homeRedirect($errorMsg);
        }
    } elseif ($do == 'Update') { //this is the update page && this page will be responsible for receiving the form updates and push it to the DB ##This is Important 
        // check if the edit that equal username already exists in the DB 
        echo "<h2 style='text-align: center; margin: 40px 0; font-size: 40px;'>Update Member</h2>";
        echo "<div class='container'>"; //to make inside a bootstrap container
            if ($_SERVER['REQUEST_METHOD'] == "POST") { // these are the data that I received from the edit page created above

                //Get variable from the form created above --##Imp the values inside the $_POST I got it from the name of every input above 
                $id   = $_POST['userId']; 
                $user = $_POST['username'];
                $mail = $_POST['email'];
                $name = $_POST['fullName'];
                
                // this is For: if the password input is empty will use the old pass but if changed will be updated in DB
                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : SHA1($_POST['newpassword']) ;

                $formErrors = array();

                if (strlen($user) < 3) { // Username length error
                                      // this is a bootstrap looks of the alerts 
                    $formErrors[] = "<div class='alert alert-danger'>User Name Must Be at lease <strong>4 characters</strong> and maximum <strong>10 characters</strong></div>"; 
                }
                if (empty($user)) { //username must not be empty
                    $formErrors[] = "<div class='alert alert-danger'>Sorry You Have To Write an <strong>Username</strong></div>";
                }
                if (empty($mail)) {//email must not be empty
                    $formErrors[] = "<div class='alert alert-danger'>Sorry You Have To Write an <strong>Email Address</strong></div>";
                }
                if (empty($name)) { //full name must not be empty
                    $formErrors[] = "<div class='alert alert-danger'>Sorry You Have To Write Your <strong>Full Name</strong></div>";
                }


                foreach($formErrors as $error) { // this is to print the array of errors once it happens
                    echo $error;

                    homeRedirectV4("back"); // will be directed back to the form in edit page
                }

                //to check if the validations all correct which going to make array errors is empty then update the DB
                if (empty($formErrors)) { 

                    // check when user edit the username, it is not exists in the DB already
                    $check = checkItemUpdateFix("*", "users","Username", "UserID", $user, $id);

                    if ($check == 0) {

                         //update the DB with the above variables by executing this query blow
                         $stmt = $db->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
                         $stmt->execute(array($user, $mail, $name, $pass, $id));
 
                         // Update succeeded notification:
                         $message = "<p class='container fs-2 alert alert-success'>" . $stmt->rowCount() . " Record Updated</p>";
 
                         homeRedirectV3($message, "back");
                    } else {
                        echo "<div class='alert alert-danger'>Username Already Exists Please Change it</div>";
                        homeRedirectV4("back");
                    }
                }
            } else { //*this error for "do=Update" if someone just typed it will display this error because the user must come from "POST" request
                echo "Can not enter this page directly";
            }

        echo "</div>";
    } elseif($do == "Delete") { // this is to delete a user from the database

        echo "<h2 class='mt-5 mb-4 fs-1 text-center'>Delete Item</h2>";
        echo "<div class='container'>";

                //check for the id -> this code explained in "edit" page
                $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0 ;

                // write the query for userId that I got from the above
                $stmt = $db->prepare('SELECT * FROM users WHERE UserID = ?');
                
                //then execute the query I wrote above
                $stmt->execute(array($userId));

                //then Fetching these data from DB
                $row = $stmt->fetch();

                //the rowCount to see how many rows changed
                $count = $stmt->rowCount();

                //check if the rowCount is grater than 0 will delete it from the DB
                if ($count > 0) {
                    
                    //This is how to write the Delete query from the DB
                    $stmt = $db->prepare("DELETE FROM users WHERE UserID = :DBuser");

                    //this to tell the query that: the UserID that have been chosen on the query above is equal the :DBuser that you already created above in the check errors conditions
                    $stmt->bindParam(":DBuser", $userId);

                    //then execute this Delete
                    $stmt->execute();

                    echo "<p class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted" . "</p>";

                    homeRedirectV4("back");
            echo "</div>";

        } else { //*if the "do=Delete&userId=0" userId number not in the the DB
            $errorMsg = "This Is Not a User!";

            homeRedirect($errorMsg);
        }

    } elseif ($do == "Activate") { // this is Activate page //TODO you should create Deactivate user as well
        // this for activate the user by change the RegStatus to be 1 insteadof 0

        // check if there is a request is a useId and its a number 
        $userId = isset($_GET["userId"]) && is_numeric($_GET["userId"]) ? intval($_GET['userId']) : 0;

        $check = checkItem("UserID", "users", $userId);

        echo "<div class='container'>";
            if ($check > 0) { //explained above
                
                echo "<h2 class='mt-5 fs-1 text-center'>Activate Member</h2>";

                //this how to change the RegStatus from the Db
                $stmt = $db->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

                $stmt->execute(array($userId));

                $row = $stmt->rowCount();

                echo "<div class='alert alert-success mt-5'>" . $row . " User Activated" . "</div>";
                homeRedirectV4("back");
            } else {
                $errorMsg = "User ID Not Exist";

                homeRedirect($errorMsg);
                
            }
        echo "</div>";

    } else { //*if the "do=test" in case someone write anything after do, so this for the page that not exists
        $errorMsg = 'NO Page Called ' . '"' . $_GET['do'] . '"' . "  Dude ";

        homeRedirect($errorMsg);
    } 
    include $templets . "footer.inc.php";
} else { // this if the $_SESSION['Username] not Exist

    header('location: index.php');
    exit();
}