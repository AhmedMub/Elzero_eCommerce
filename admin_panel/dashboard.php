<?php
session_start();
$pageTitle = "Dashboard";
if (isset($_SESSION['username'])) {
    include "init.php";
    echo "Welcome to dashboard";
    include $templets . "footer.inc.php";
} else {
    header('location: index.php');
    exit();
}