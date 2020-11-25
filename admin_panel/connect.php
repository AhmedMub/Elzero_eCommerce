<?php
$dsn ='mysql:host=localhost;dbname=elzero_shop';
$user = 'root';
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMEs utf8'
);

try {
    $db = new PDO($dsn, $user, $pass, $option);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e) {
    echo 'Connection Failed' . $e->getMessage();
}