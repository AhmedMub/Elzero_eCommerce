<?php
include 'connect.php';
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

//to make navbar only in the dashboard
if (!isset($nav_var)) {
    include $templets . "nav.php";
}
