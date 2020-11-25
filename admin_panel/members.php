<?php
/*
    Manage Members page
=>  You can Add || Edit || delete members from this page
*/
session_start();
$pageTitle = "Members";

if (isset($_SESSION['username'])) {

    include "init.php";
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        //manage
    } elseif ($do == 'Edit') { //Edit page 
        
        //check if the userID is a Number and if its a number get the integer value from it
        $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;  
        
        //Select and get all data from DB according to that UserID
        $stmt = $db->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

        //execute the query
        $stmt-> execute(array($userId));

        //fetch these data from DB
        $row = $stmt-> fetch();

        //this is rowcount to check on the id
        $count = $stmt->rowCount();

        // if the id matched one of DB ids show these data inside below inputs
        if ($count > 0) {  ?>
            <!-- Start Profile Edit Form -->
            <form action="" class=" col-lg-4 col-sm-10">
                <h2>Edit Member</h2>
                <!-- Start username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $row['Username']?>" autocomplete="off">
                </div>
                <!-- end username -->
                <!-- Start password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                </div>
                <!-- end password -->
                <!-- Start email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $row['Email']?>" autocomplete="off">
                </div>
                <!-- end email -->
                <!-- Start full name -->
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" name="fullName" class="form-control" value="<?php echo $row['FullName']?>" autocomplete="off">
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
        } else {
            echo "There is NO such ID";
        }
    }
    
    include $templets . "footer.inc.php";
} else {

    header('location: index.php');
    exit();
}