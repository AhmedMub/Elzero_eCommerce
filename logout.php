<?php

session_start();
session_unset();
session_destroy();

//this is to redirect to same pager that user in
$redirectBack = $_SERVER['HTTP_REFERER'];

header("location:$redirectBack");
exit();

