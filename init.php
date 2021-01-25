<?php

//*Errors Reporting this means that ANY error will be displayed on your web page [This is for Development only Error will be disabled in production]
ini_set('display_errors', 'On');

error_reporting(E_ALL);

include 'admin_panel/connect.php';

//I will depend on this variable every where in all pages [this is security aspect]
$userSession = "";

if (isset($_SESSION['user'])) {
    $userSession = $_SESSION['user'];
}

//Routes
$css = "layout/css/"; //css dir
$js = "layout/js/"; //js dir
$templets = "includes/templets/"; //templets dir
$langs = "includes/langs/"; //languages dir
$funcs = "includes/funcs/";

/*
========================
Important Files
========================
*/
include $funcs . "functions.php";
include $langs . "english.php";
include $templets . "header.inc.php";



