<?php 

/*
#016 - Split Page With Get Request
*/
/*
    Categories => [action | manage | update | add | insert] all of these should be pages but in the course will do it here in advanced way

*/

//check if the request method is get via do will execute the code but if its not via do will be directed to mange page 
$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

// This is called Do Query which is set a directed pages علشان تتنقل بين الصفحات
 if($do == 'Mange') {
     // here you will put all your database queries this is in categories
    echo 'this is mange page ';

    //this will direct you to the add page || by the way You don't need to right (href='page.php?..') because you are in the page.php already
    echo "<a href='?do=Add'>Add New Category</a>";

 } elseif ($do == 'Add') {
     //this page responsible for Add the query
    echo 'this is Add page';
 } elseif ($do == 'Insert') {
    echo 'this is to insert';
 } else {
     echo 'no page with this name';
 }