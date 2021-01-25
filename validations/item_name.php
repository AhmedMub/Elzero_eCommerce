<?php

include "../admin_panel/connect.php";
include "../includes/funcs/functions.php";
//check from the request I send from the ajax that is post request
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //receive the data from the request
    $itemName = $_POST['itemName'];

    //this error to make sure that ajax request must not be empty
   if (empty($itemName)) {
        
    echo "this must not be empty";
    
   } else {
        //check if the name exists in the DB
        $checkItemName = checkItem("Name", "items", $itemName);
            
        if ($checkItemName > 0) {
            echo "item name already exists";
        } else {
            echo "<span class='validate_correct'>this looks awesome</span>";
        }
   }
}
