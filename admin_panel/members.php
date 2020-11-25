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
    } elseif ($do == 'Edit') { //Edit page ?>
        
    <!-- Start Profile Edit Form -->
    <form action="">
        <!-- Start username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" autocomplete="off">
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
            <input type="email" name="email" class="form-control" autocomplete="off">
        </div>
        <!-- end email -->
        <!-- Start full name -->
        <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" name="fullName" class="form-control" autocomplete="off">
        </div>
        <!-- end full name -->
        <!-- Start submit -->
        <div class="mb-3">
            <input type="submit" value="Save" class="btn btn-primary">
        </div>
        <!-- end submit -->
    </form>  

      <?php
    }
    
    include $templets . "footer.inc.php";
} else {

    header('location: index.php');
    exit();
}