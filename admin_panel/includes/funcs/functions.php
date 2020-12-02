<?php 
/*
    This is will working with pages according to an exist Variable
*/
// each page name will be in the title according to user active page 
function getTitle() { // this v1.0
    
    global $pageTitle;

    if (isset($pageTitle)) {

        echo $pageTitle;
    } else {
        echo "Default";
    }
}

/*------------------------------------------------------------------
    Redirect To "Home" Page Function 
    => this function accepts parameters: 
        -> $errorMsg = Will Print the Error Message before the directs works
        -> $seconds = Secondes before Redirecting

    // the header method can be used on location as same as the refresh but the "refresh" you can put a number of secondes before the redirecting work
    => header('refresh:xx; url:xx');
-------------------------------------------------------------------*/
//[versions because I can develope any of these functions or change it afterwords so I have to put versions in the function as record for myself]
function homeRedirect($errorMsg, $seconds = 3) { //*this v1.0 

    echo "<div class='container mt-5 alert alert-danger'>". $errorMsg . "</div>";
    echo "<div class='container mt-5 alert alert-info'>" . "Directed to Dashboard in " . $seconds . " Secondes" . "</div>";

    //this is how to write the header(); method
    header("refresh:$seconds;url=index.php");

    //Never FORGET the exit after using header();
    exit();
}

//this version of function you can write a custom $url to be redirected to 
function homeRedirectV2($errorMsg, $url = "index.php", $seconds = 3) { //*this v2.0 

    echo "<div class='container mt-5 alert alert-danger'>". $errorMsg . "</div>";
    echo "<div class='container mt-5 alert alert-info'>" . "Directed to Dashboard in " . $seconds . " Secondes" . "</div>";

    //this is how to write the header(); method
    header("refresh:$seconds;url=$url");

    //Never FORGET the exit after using header();
    exit();
}

//this v3.o developed by elzero: this is so you can use any where in the code and redirect to a custom url or back to url you came from
function homeRedirectV3($message, $url = null, $seconds = 3) { //*this v3.0 

    if ($url === null) {// null means that I did not set a certain page to be redirect to
        $url = "index.php";
        $linkMsg = "Homepage";
    }  else {
        //this means that If there is a page You just have came from && its not empty like there is a certain page you came from will redirected to it
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

            // $_SERVER['HTTP_REFERER'] this means redirecting back the page you just came from
            $url = $_SERVER['HTTP_REFERER'];
            $linkMsg = "Previous Page";
        } else {
            $url = "index.php";
            $linkMsg = "Homepage";
        }
    }

    echo $message;
    echo "<div class='container mt-5 alert alert-info'>" . "Directed to " . $linkMsg . " in " . $seconds . " Secondes" . "</div>";

    //this is how to write the header(); method
    header("refresh:$seconds;url=$url");

    //Never FORGET the exit after using header();
    exit();
}

//This Simply Redirect back function for Errors that's in foreach loop
function homeRedirectV4($back, $seconds = 3) { //*this v4.0 

   $back = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : "index.php";

   echo "<div class='container mt-5 alert alert-info'>" . "You Will be Directed back in " . $seconds . " Secondes" . "</div>";

    //this is how to write the header(); method
    header("refresh:$seconds;url=$back");

    //Never FORGET the exit after using header();
    exit();
}


/*------------------------------------------------------------------
    check Items function [function accept parameters]
    => this function going to check items in the database before proceed to insert new one 
    =>First Param is:   -> $select = this is to select an item like: [Example: user, item, category] from the form
    =>Seconde Param is: -> $from = this param that selects the table from the DB like: [Example: users, items , categories]
    =>Third Param is>   -> $value = this param basically checking the value of the $select, and it's measured by the rowCount(), if it's grater than 0 this means that the chosen item for insert is already in the DB [Example: Osama, box, etc..]
-------------------------------------------------------------------*/

function checkItem($select, $from, $value) {

    global $db;// this is the DB var, you should make it global before use in here

//this is PDO way, But I can write it like that too "$select = $value" but instead I will put it in the execute() method;
    $checkStmt = $db->prepare("SELECT $select FROM $from WHERE $select = ?"); 

//*To Be Aware Of: all variables are in the execute array related to "?" that in the query, as these the data I need to check or to execute[as the values of each "?"  are Equal to the variable that should be in the execute] in this case here the $select = $value; and that is the result of the query I need
    $checkStmt->execute(array($value));
    
    $count = $checkStmt->rowCount();

    return $count;
}