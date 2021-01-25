<?php

include "../admin_panel/connect.php";
include "../includes/funcs/functions.php";
//create a new Item 
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //receive the info sent from the form into variables ans sanitize it
    $item_name = filter_var($_POST['item-name'], FILTER_SANITIZE_STRING);
    $item_description = filter_var($_POST['item-description'], FILTER_SANITIZE_STRING);
    $item_price = filter_var($_POST['item-price']);
    $item_madeIn = filter_var($_POST['item-madeIn'], FILTER_SANITIZE_STRING);
    $item_status = filter_var($_POST['item-status'], FILTER_SANITIZE_NUMBER_INT);
    $item_cat = filter_var($_POST['item-category'], FILTER_SANITIZE_NUMBER_INT);
    $item_id = $_POST['id'];

    
    $validate_newItem = array();

    if (empty($item_name)) {
        $validate_newItem[] = "item name must not be empty";

    } elseif (strlen($item_name) < 2) {

        $validate_newItem[] = "this is not a valid item name";
    }
    if (empty($item_description)) {
        $validate_newItem[] = "item description must not be empty";
    } elseif (strlen($item_description) < 3) {
        $validate_newItem[] = "this is not a valid description";
    }
    if (empty($item_price)) {
        $validate_newItem[] = "item price must not be empty";

    }
    if (empty($item_madeIn)) {
        $validate_newItem[] = "item country of made must not be empty";

    } elseif (strlen($item_madeIn) < 2) {
        $validate_newItem[] = "this is not a valid country";
    }
    if ($item_status <= 0) {
        $validate_newItem[] = "this is not a valid status";
    }
    if ($item_cat <= 0) {
        $validate_newItem[] = "this is not a valid category";
    }


    //show errors of the validation 
    if (!empty($validate_newItem)) {

        foreach ($validate_newItem as $error) {

            echo "<div class='error-wrapper'>". $error . "</div>";
            exit();
        }
    } else {
        
        $checkItemDB = checkItem("Name", "items", $item_name);

        if ($checkItemDB != 0) {

            echo "<div class='error-wrapper'>" . "Item name exists please change it" . "</div>";
            exit();

        } else {

            $stmt = $db->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Cat_ID, Member_ID, Add_Date) 
                                VALUES(
                                    :zName,
                                    :zdescription,
                                    :zprice,
                                    :zOfMade,
                                    :zstatus,
                                    :zcat,
                                    :zmember,
                                    now())");
            $stmt->execute(array(
            'zName'         => $item_name,
            'zdescription'  => $item_description,
            'zprice'        => $item_price,
            'zOfMade'       => $item_madeIn,
            'zstatus'       => $item_status,
            'zcat'          => $item_cat,
            'zmember'       => $item_id
            ));

            //if stmt true which is all good
            if ($stmt) {
                echo "<div class='error-wrapper-success'>" . " Item added will be live after approval" . "</div>";
                exit();
            }
        }
    }
}