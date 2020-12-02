<?php 

/*
#016 - Split Page With Get Requests
*/

/*
    =>> Without the GET request that has been explained as a below you would have to create all these pages in the categories because:- 
    > if you are coming from a page called action then this action page will execute something and directs you to "manage" page and "add" page will do the same Etc... for all those pages> so if each page of those is a directory that has a 20 pages inside, You will get (20x6=120) you will get 120 pages that has codes. [this is the very old way of programming]   
   -> Categories => [action | manage | Edit | Add | update | insert]

*/
/* 
//GET['do'] Explanation:
-> So this is to check if you are entering this web page through the request method which is "GET" AND It's called "do", then will execute the code but if its not "do" like in this link "http://localhost/elzero_ecommerce/admin_panel/page.php?xx=test" OR even WITHOUT the "xx" Which Is NOT "do" you will be directed to manage page. 
=> AND the manage page will direct the user whatever page name is and so on.
*/ 
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

// This is called Do Query which is set a directed pages علشان تتنقل بين الصفحات
 if($do == 'Manage') {
     // here you will put all your database queries this is in categories
    echo 'Welcome to Manage page' . "<br />";

    //this will direct you to the add page || BY the way You don't need to right (href='page.php?..') because you are in the page.php already
    echo "<a href='?do=Add'>Add New Category</a>";

 } elseif ($do == 'Add') {
     //this page responsible for Add the query
    echo 'Welcome to Add page' . "<br />";

    echo "<a href='?do=Insert'>Click if you want the insert page</a>";
 } elseif ($do == 'Insert') {

    echo 'Welcome to Insert page' . "<br />";

    echo "<a href='?do=Manage'>Go back to manage page?</a>";

 } else { // If "do" doesn't equal any of the above pages, will execute this Error message
     echo 'NO Page Called ' . '"' . $_GET['do'] . '"' . "  Dude";
 }