<?php 


/*------------------------------------------------------------------
     //fetch all categories to display it on the navbar
-------------------------------------------------------------------*/
function fetchCats() { //*v1.0

    global $db;

    $stmt = $db->prepare("SELECT * FROM categories ORDER BY Ordering ASC"); 

    $stmt->execute();

    $catFetch = $stmt->fetchAll();

    return $catFetch;
}

/*------------------------------------------------------------------
     //fetch all Items from the DB depends on category's id
-------------------------------------------------------------------*/
function fetchItems($itemId) { //*v1.0

    global $db;

    $stmt = $db->prepare("SELECT * FROM items WHERE Cat_ID = ?"); 

    $stmt->execute(array($itemId));

    $itemFetch = $stmt->fetchAll();

    return $itemFetch;
}

//this will need to vars the column and the value you looking for
function fetchItems2($column, $val) { //*v2.0

    global $db;

    $stmt = $db->prepare("SELECT * FROM items WHERE $column = ?"); 

    $stmt->execute(array($val));

    $itemFetch = $stmt->fetchAll();

    return $itemFetch;
}

//this is select depend on item approval
function fetchItems3($itemId) { //*v3.0

    global $db;

    $stmt = $db->prepare("SELECT * FROM items WHERE Cat_ID = ? AND Approve = 1"); 

    $stmt->execute(array($itemId));

    $itemFetch = $stmt->fetchAll();

    return $itemFetch;
}

/*------------------------------------------------------------------
     //Note to be displayed if the user is not Active in the DB "RegStatus"
-------------------------------------------------------------------*/

function userStatus($user) {
    
    global $db;

    $stmt = $db->prepare("SELECT Username, RegStatus FROM users WHERE Username = ? AND RegStatus = 0");

    $stmt->execute(array($user));

    $checkStatus = $stmt->rowCount();

    return $checkStatus;
}

//display latest items
function getLatestWeb($select, $table, $order, $limit = 10) { //* v1.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $stmt->execute();

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}

//display latest items in certain category
function getLatestAsideOne($select, $table, $order, $limit = 10) { //* v2.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT $select FROM $table WHERE Cat_ID = 53 ORDER BY $order DESC LIMIT $limit");

    $stmt->execute();

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}
function getLatestAsideTwo($select, $table, $order, $limit = 10) { //* v3.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT $select FROM $table WHERE Cat_ID = 52 ORDER BY $order DESC LIMIT $limit");

    $stmt->execute();

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}
function getLatestAsideThree($select, $table, $order, $limit = 10) { //* v3.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT $select FROM $table WHERE Cat_ID = 48 ORDER BY $order DESC LIMIT $limit");

    $stmt->execute();

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}

// this is to get all without limit
function getLatestWebAll($itemId) { //* v4.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT * FROM comments  WHERE item_Id = ? AND status = 1 ORDER BY comment_Id DESC");

    $stmt->execute(array($itemId));

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}

/*------------------------------------------------------------------
     //this is to check if the loggedIn user activated or not
-------------------------------------------------------------------*/
function checkUser($activeUser) {//*this v1.0 

    global $db;

    $checkStmt = $db->prepare("SELECT Username FROM users WHERE Username = ? AND RegStatus = 1"); 

    $checkStmt->execute(array($activeUser));
    
    $count = $checkStmt->rowCount();

    return $count;
}


/*------------------------------------------------------------------
     //this is to count reviews for each item
-------------------------------------------------------------------*/
function countRev($itemId) { //*this v1.0 

    global $db;// as explained earlier this has to be global

    $stmt = $db->prepare("SELECT COUNT(comment) FROM comments WHERE item_id = ?"); // this is the count() query 

    $stmt->execute(array($itemId));

    $result = $stmt->fetchColumn(); // this is to fetch the column that should be counted

    return $result;
}

/*------------------------------------------------------------------
 1- write a query for each rating number to get total people review for exact rate
 2- put all queries into vars so you can get the sum of them all
 3- write query to get total people have reviewed that item so you can divide by total numbers mentioned in (2)
 -------------------------------------------------------------------*/
//step == 1 ==> get
function getTotalRevForEachRateNo($eachRate, $itemId) {

    global $db;

    $stmt = $db->prepare("SELECT COUNT(comment) FROM comments WHERE ratings = ? AND item_Id = ?");

    $stmt->execute(array($eachRate, $itemId));

    $infoFetched = $stmt->fetchColumn();

    return $infoFetched;
}

function calcTotalRev($itemId) {
    $AllRatings = [];
    $AllRatings[]   = getTotalRevForEachRateNo(1, $itemId);
    $AllRatings[]   = getTotalRevForEachRateNo(2, $itemId);
    $AllRatings[]   = getTotalRevForEachRateNo(3, $itemId);
    $AllRatings[]   = getTotalRevForEachRateNo(4, $itemId);
    $AllRatings[]   = getTotalRevForEachRateNo(5, $itemId);

    $calcAll = array_sum($AllRatings);

    return $calcAll;
}

function get_multi_totalRev_with_itsRate($itemId) {
    $multiRate = [];
    $multiRate[]   = getTotalRevForEachRateNo(1, $itemId);
    $multiRate[]   = getTotalRevForEachRateNo(2, $itemId);
    $multiRate[]   = getTotalRevForEachRateNo(3, $itemId);
    $multiRate[]   = getTotalRevForEachRateNo(4, $itemId);
    $multiRate[]   = getTotalRevForEachRateNo(5, $itemId);

    $ratingsResults = [];
    $ratingsResults[]     = $multiRate[0] * 1;
    $ratingsResults[]     = $multiRate[1] * 2;
    $ratingsResults[]     = $multiRate[2] * 3;
    $ratingsResults[]     = $multiRate[3] * 4;
    $ratingsResults[]     = $multiRate[4] * 5;

    $totalMultiRev = array_sum($ratingsResults);

    return $totalMultiRev;
}

function calcItemAverageRevs($theItemId) {
 
    $SumOfItem = get_multi_totalRev_with_itsRate($theItemId);

    $sumRevs = calcTotalRev($theItemId);

    if ($sumRevs > 0) {

        $theItemAverage = $SumOfItem / $sumRevs;
    } else {
        $theItemAverage = null;
    }

    return round($theItemAverage);
}










/*
=============================================================================================
Admin Panel functions
=============================================================================================
*/
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
function homeRedirect($errorMsg, $seconds = 2) { //*this v1.0 

    echo "<div class='error-alert'>";
        echo "<div class='error-overlay'></div>";
            echo "<div class='alerts-style'>";
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger text-uppercase Mymt-5'>". $errorMsg . "</div>";
                    echo "<div class='alert alert-info'>" . "Directed to Dashboard in " . $seconds . " Secondes" . "</div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
    //this is how to write the header(); method
    header("refresh:$seconds;url=index.php");

    //Never FORGET the exit after using header();
    exit();
}

//this version of function you can write a custom $url to be redirected to 
function homeRedirectV2($errorMsg, $url = "index.php", $seconds = 2) { //*this v2.0 

    echo "<div class='container mt-5 alert alert-danger'>". $errorMsg . "</div>";
    echo "<div class='container mt-5 alert alert-info'>" . "Directed to Dashboard in " . $seconds . " Secondes" . "</div>";

    //this is how to write the header(); method
    header("refresh:$seconds;url=$url");

    //Never FORGET the exit after using header();
    exit();
}

//this v3.o developed by elzero: this is so you can use any where in the code and redirect to a custom url or back to url you came from
function homeRedirectV3($message, $url = null, $seconds = 2) { //*this v3.0 

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
function homeRedirectV4($back, $seconds = 1) { //*this v4.0 

   $back = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : "index.php";

   echo "<div class='container mt-5 alert alert-info'>" . "You Will be Directed back in " . $seconds . " Secondes" . "</div>";

    //this is how to write the header(); method
    header("refresh:$seconds;url=$back");

    //Never FORGET the exit after using header();
    exit();
}


//this will direct you back to the same page with custom massage
function homeRedirectV5($msg, $seconds = 1) { //*this v5.0 

    $back = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : "index.php";
 
    echo "<div class='error-alert'>";
        echo "<div class='error-overlay'></div>";
            echo "<div class='alerts-style'>";
                echo "<div class='container'>";
                    echo $msg;
                    echo "<div class='alert alert-info'>" . "You Will be Directed back in " . $seconds . " Secondes" . "</div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
 
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
function checkItem($select, $from, $value) {//*this v1.0 

    global $db;//* You have to make the $db global which is the variable that connecting you with DB, has to be global to be able to use it inside and out of the function scope

    //this is PDO way, But I can write it like that too "$select = $value" but instead I will put it in the execute() method;
    $checkStmt = $db->prepare("SELECT $select FROM $from WHERE $select = ?"); 

    //*To Be Aware Of: all variables are in the execute array related to "?" that in the query, as these the data I need to check or to execute[as the values of each "?"  are Equal to the variable that should be in the execute] in this case here the $select = $value; and that is the result of the query I need
    $checkStmt->execute(array($value));
    
    $count = $checkStmt->rowCount();

    return $count;
}

//this to fix Edit page if trying to Edit anything with same name in the DB This is ONLY for "Update" page Not "Add" Page
function checkItemUpdateFix($all, $table, $itemName, $itemId, $nameVal, $IdVal) {//*this v2.0 

    global $db;//* You have to make the $db global which is the variable that connecting you with DB, has to be global to be able to use it inside and out of the function scope

//this is PDO way, But I can write it like that too "$select = $value" but instead I will put it in the execute() method;
    $checkStmt = $db->prepare("SELECT $all FROM $table WHERE $itemName = ? AND $itemId != ?"); 

//*To Be Aware Of: all variables are in the execute array related to "?" that in the query, as these the data I need to check or to execute[as the values of each "?"  are Equal to the variable that should be in the execute] in this case here the $select = $value; and that is the result of the query I need
    $checkStmt->execute(array($nameVal, $IdVal));
    
    $count = $checkStmt->rowCount();

    return $count;
}

/*------------------------------------------------------------------
    this Function will Count and can print the count of any giving column in the DB
    =>count numbers of any items this Accepts two params
    =>First Param: $item-> this is the item will be counted
    =>Seconde Param: $table-> this is the table that has the $item to be counted

    ##NOTE-> this function will echo the count number of the DB members including the admin as well, so if the members page shows 2 users, the function will print 3 as the admin is not showed in the members page
-------------------------------------------------------------------*/
function countItems($item, $table) { //*this v1.0 

    global $db;// as explained earlier this has to be global

    $stmt = $db->prepare("SELECT COUNT($item) FROM $table"); // this is the count() query 

    $stmt->execute();

    $result = $stmt->fetchColumn(); // this is to fetch the column that should be counted

    return $result;
}

function countItemsV2($item, $table, $val) { //*this v2.0 

    global $db;// as explained earlier this has to be global

    $stmt = $db->prepare("SELECT COUNT($item) FROM $table WHERE $item = ?"); // this is the count() query 

    $stmt->execute(array($val));

    $result = $stmt->fetchColumn(); // this is to fetch the column that should be counted

    return $result;
}

/*------------------------------------------------------------------
    this Function will latest items from any column you define through the Params
    //- this function accepts 4 Params:-
    => $select param-> this is the field of the column in the query
    => $table param-> this is the table to choose from in the DB
    => $order param-> this is to sorted in Desc order
    => $limit param-> this is to set how many of the items want it to fetch from the DB  
-------------------------------------------------------------------*/
function getLatest($select, $table, $order, $limit = 10) { //* v1.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $stmt->execute();

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}

//This version won't show the Admins in the dashboard
function getLatestNoAdmin($select, $table, $admins = "GroupID", $order, $limit = 10) { //* v2.0
    
    global $db;
    
    $stmt = $db->prepare("SELECT $select FROM $table WHERE $admins != 1 ORDER BY $order DESC LIMIT $limit");

    $stmt->execute();

    $rowsFetched = $stmt->fetchAll();

    return $rowsFetched;
}