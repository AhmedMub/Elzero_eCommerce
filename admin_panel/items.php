<?php

/*
===============================================================================
    ----------------------------> ITEMS PAGE <-------------------------
===============================================================================
*/
session_start();

$pageTitle = "items";

if (isset($_SESSION['username'])) {

    include "init.php";

    // Get Request
    $do = isset($_GET['do']) ? $_GET['do'] : "Manage";
    
    //Start items.php Pages
    echo "<section class='container'>"; 
        if ($do == "Manage") { 
            
            //get the DATE from the DB to fetch it into table below [*this is Join Query*] to show this item for which user and in wat category as  the foreign key written in the DB
            $stmt = $db->prepare("SELECT 
                                    I.*, C.Name AS categoryName, U.Username AS userUsername 
                                FROM 
                                    `items` I 
                                INNER JOIN 
                                    `categories` C 
                                ON 
                                    C.ID = I.Cat_ID 
                                INNER JOIN 
                                    `users` U 
                                ON 
                                    U.UserID = I.Member_ID
                                ");

            $stmt->execute();

            $itemFetched = $stmt->fetchAll();


            //count all items and display the total number above the table            
            if (!empty($itemFetched)) {?>

                <h2 class="text-center fs-1 mt-4 mb-4">Manage Items</h2>

                <table class="table caption-top text-center table-borderless">
                <?php //count all items and display the total number above the table   ?>
                    <caption>Total Items: <span class="totalItems"><?php echo countItems("Item_ID", "items");?></span></caption>
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Country Made</th>
                            <th>Status</th>
                            <th>Category Name</th>
                            <th>Member Name</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($itemFetched as $item) {
                            echo "<tr>";
                                echo "<th scope='row'>" . $item['Item_ID'] . "</th>";
                                echo "<td>" . $item['Name'] . "</td>";
                                echo "<td>" . $item['Description'] . "</td>";
                                echo "<td>" . $item['Price'] . "</td>";
                                echo "<td>" . $item['Add_Date'] . "</td>";
                                echo "<td>" . $item['Country_Made'] . "</td>";
                                echo "<td>";
                                if ($item['Status'] == 1) {
                                    echo "<span class='badge rounded-pill bg-success'>" . "New" . "</span>";
                                } elseif ($item['Status'] == 2) {
                                    echo "<span class='badge rounded-pill bg-warning'>" . "Used" . "</span>";
                                } elseif ($item['Status'] == 3) {
                                    echo "<span class='badge rounded-pill bg-danger'>" . "Old" . "</span>";
                                }
                                echo "</td>";
                                echo "<td>";
                                    echo "<a class='badge bg-warning unset-a text-capitalize' href='?do=CategoryItem&catId=".$item['Cat_ID']."&catName=".$item['categoryName']."'>" . $item['categoryName'] . "</a>";
                                echo "</td>";
                                echo "<td>"; 
                                    echo "<a class='badge bg-info unset-a text-capitalize' href='?do=UserItems&memberId=".$item['Member_ID']."&userName=".$item['userUsername']."'>" . $item['userUsername'] . "</a>";
                                echo "</td>";
                                echo "<td class='fix-btns'>";
                                    echo "<a href='?do=Edit&itemId=" .$item['Item_ID']. "' class='btn btn-warning mr-2'>" . "Edit" . "</a>";
                                    echo "<form action='?do=Delete&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                        echo "<input type='submit' class='btn btn-danger confirm heightFix mr-2' value='Delete'>";
                                    echo "</form>";
                                    if ($item['Approve'] == 0) {
                                        echo "<form action='?do=Approve&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                            echo "<input type='submit' class='btn btn-info heightFix' value='Approve'>";
                                        echo "</form>";
                                    }
                                echo "</td>";
                            echo "</tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>
                <div><a class="btn btn-info" href="?do=Add">Add Item</a></div>
        <?php
            } else {?>
                
                <div class='noDataMsg mt-5'>
                    <h4 class="NoComments">404</h4>
                    <span>no items found</span>
                    <div class="mt-5"><a href="?do=Add" class="btn btn-info">Add New Item</a></div>
                </div>
            <?php    
            }
        } elseif ($do == "Add") { //Add Item Page
        ?>
            <h2 class="mt-5 mb-4 fs-1 text-center">Add New Item</h2>
            <form action="?do=Insert" class="col-lg-4 col-sm-3" method="POST">                
                <div class="mb-3">
                    <label class="form-label">Item Name</label><span class="asterisk">*</span>
                    <input type="text" name="name" class="form-control" placeholder="Write Item Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Item Description</label><span class="asterisk">*</span>
                    <input type="text" name="description" class="form-control" placeholder="Write Item Description" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Item Price</label><span class="asterisk">*</span>
                    <input type="text" name="price" class="form-control" placeholder="Write Item Price" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Item Country Of Made</label><span class="asterisk">*</span>
                    <input type="text" name="madeIn" class="form-control" placeholder="Write Item Price" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Item Status</label><span class="asterisk">*</span>
                    <select name="status" class="form-select">
                        <option value="0" selected>.....</option>
                        <option value="1">New Item</option>
                        <option value="2">Used Item</option>
                        <option value="3">Old</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label><span class="asterisk">*</span>
                    <select name="username" class="form-select">
                        <option value="0" selected>.....</option>
                        <?php
                        //this is to display users table into a select
                            $stmt = $db->prepare("SELECT * FROM users");
                            
                            $stmt->execute();

                            $usersFetched = $stmt->fetchAll();

                            foreach ($usersFetched as $user) {
                                echo "<option value='" . $user['UserID'] ."'>" . $user['Username'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label><span class="asterisk">*</span>
                    <select name="category" class="form-select">
                        <option value="0" selected>.....</option>
                        <?php
                            $stmt = $db->prepare("SELECT * FROM categories");
                            
                            $stmt->execute();

                            $catsFetched = $stmt->fetchAll();

                            foreach ($catsFetched as $cat) {
                                echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
            </form> 
        <?php
        } elseif ($do == "Insert") {
            
            //check if the user coming from POST Request 
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                
                echo "<h2 class='mt-5 mb-4 fs-1 text-center'>Insert New Item</h2>";

                //define the info coming from the form
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $made = $_POST['madeIn'];
                $status = $_POST['status'];
                $catID  = $_POST['category'];
                $username = $_POST['username'];

                //validate errors from the form

                $validate = array();

                if (empty($name)) {
                    $validate[] = "Please Write an Item Name";
                }
                if (empty($description)) {
                    $validate[] = "Please Write an Item Description";
                }
                if (empty($price)) {
                    $validate[] = "Please Write an Item Price";
                }
                if (empty($made)) {
                    $validate[] = "Please Write an Item Country Made";
                }
                if (empty($status)) {
                    $validate[] = "Please Choose Item Status";
                }

                //if there is no errors in the form
                if (empty($validate)) {
                    
                    //insert into the DB
                    $stmt = $db->prepare("INSERT INTO items (Name, Description, Price, Country_Made, Status, Add_Date, Member_ID, Cat_ID)
                                        VALUES (
                                            :DBname,
                                            :DBdescription,
                                            :DBprice,
                                            :DBcountry,
                                            :DBstatus,
                                            now(),
                                            :DBusername,
                                            :DBcategory
                                        )");

                    $stmt->execute(array(

                        'DBname'        =>  $name,
                        'DBdescription' =>  $description,
                        'DBprice'       =>  $price,
                        'DBcountry'     =>  $made,
                        'DBstatus'      =>  $status,
                        'DBusername'    =>  $username,
                        'DBcategory'    =>  $catID
                    ));

                    echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Item Added" . "</div>";

                    homeRedirectV4("back");
                } else {

                    //activate the Errors in here
                    foreach ($validate as $each) {
                        echo "<div class='alert alert-danger mt-3'>" . $each . "</div>";
                    }
                    homeRedirectV4("back");
                }
            } else {

                $errorMsg = "You Can Not Enter this Page Directly";
                homeRedirect($errorMsg);
            }

        } elseif ($do == "Edit") {

            //check if the item_ID is a number or not and get inval from it
            $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? $_GET['itemId'] : 0;
        
            //[query] show all the data regarding to a selected item 
            $stmt = $db->prepare("SELECT * FROM items WHERE Item_ID = ?");

            $stmt->execute(array($itemId));

            $itemFetched = $stmt->fetch();

            //query for to show related Comments to that itemId
            $stmt = $db->prepare("SELECT cm.*, I.Name AS Item_Name
                                FROM `comments` cm
                                INNER JOIN
                                    `items` I
                                ON
                                    cm.item_Id = I.Item_ID
                                WHERE
                                    I.Item_ID = ?");

            $stmt->execute(array($itemId));

            $commentsFetched = $stmt->fetchAll();

            //put all fetched data in the form            
            $check = checkItem("Item_ID", "items", $itemId);

            if ($check > 0) { ?>
                <h2 class="mt-5 fs-1 text-center">Edit Item</h2>
                <form action="?do=Update" method="POST" class="col-lg-4 col-sm-3">
                    <input type="hidden" name="id" value="<?php echo $itemFetched['Item_ID']?>">

                    <div class="mb-3">
                        <label class="form-label">Item Name</label><span class="asterisk">*</span>
                        <input type="text" class="form-control" name="name" value="<?php echo $itemFetched['Name']?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Description</label><span class="asterisk">*</span>
                        <input type="text" class="form-control" name="description" value="<?php echo $itemFetched['Description']?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Price</label><span class="asterisk">*</span>
                        <input type="text" class="form-control" name="price" value="<?php echo $itemFetched['Price']?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Country Of Made</label><span class="asterisk">*</span>
                        <input type="text" class="form-control" name="made" value="<?php echo $itemFetched['Country_Made']?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Status</label><span class="asterisk">*</span>
                        <select class="form-select" name='status'>
                            <option value="1" <?php if ($itemFetched['Status'] == 1) {echo "selected";}?>>New Item</option>
                            <option value="2" <?php if ($itemFetched['Status'] == 2) {echo "selected";}?>>Used Item</option>
                            <option value="3" <?php if ($itemFetched['Status'] == 3) {echo "selected";}?>>Old</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label><span class="asterisk">*</span>
                        <select class="form-select" name='username'>
                            <?php 
                                $stmt = $db->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $UserFetch = $stmt->fetchAll();
                                
                                foreach ($UserFetch as $user) {

                                    echo "<option value='".$user['UserID']."'"; 
                                        if ($itemFetched['Member_ID'] == $user['UserID']) {echo "selected";} 
                                        echo ">";
                                        echo $user['Username'];
                                    echo "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label><span class="asterisk">*</span>
                        <select class="form-select" name='category'>
                            <?php 
                                $stmt = $db->prepare("SELECT * FROM categories");
                                $stmt->execute();
                                $catFetch = $stmt->fetchAll();
                                
                                foreach ($catFetch as $cat) {

                                    echo "<option value='".$cat['ID']."'"; 
                                        if ($itemFetched['Cat_ID'] == $cat['ID']) {echo "selected";} 
                                        echo ">";
                                        echo $cat['Name'];
                                    echo "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>

                <?php //*=====================>Start Manage Item Comments<===================== 
                if (!empty($commentsFetched)) {//Visible ONLY if there comments regarding to that item
                ?>
                <h2 class="text-center fs-1 mt-5 mb-4">Edit "<?php echo $itemFetched['Name']?>" Comments</h2>
                <table class="table text-center">
                    <thead class="table-warning">
                        <tr>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($commentsFetched as $comment) {
                                echo "<tr>";
                                    echo "<td>" . $comment['comment'] . "</td>";
                                    echo "<td>";
                                        if ($comment['status']  == 0) {
                                            echo "<span class='badge rounded-pill bg-danger'>" ."Deactivated". "</span>";
                                        } else {
                                            echo "<span class='badge rounded-pill bg-success'>" ."Activated". "</span>";
                                        }
                                    echo "</td>";
                                    echo "<td>" . $comment['comment_date'] . "</td>";
                                    echo "<td>" . $comment['Item_Name'] . "</td>";
                                    echo "<td>";
                                        echo "<a class='btn btn-warning' href='comments.php?do=Edit&comId=".$comment['comment_Id']."'>" . "Edit" . "</a>";
                                        echo "<a class='btn btn-danger mr-2 ml-2 confirm' href='comments.php?do=Delete&comId=".$comment['comment_Id']."'>" . "Delete" . "</a>";
                                        if ($comment['status'] == 0) {
                                            echo "<a class='btn btn-info' href='comments.php?do=Approve&comId=".$comment['comment_Id']."'>" . "Approve" . "</a>";
                                        } else {
                                            echo "<a class='btn btn-primary' href='comments.php?do=Disapprove&comId=".$comment['comment_Id']."'>" . "Disapprove" . "</a>";
                                        }
                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            <?php 
            } else {?>

                <div class='noDataMsg'>
                    <h4 class="NoComments">404</h4>
                    <span>no comments found</span>
                </div>
                
            <?php    
            }
            //End Manage Item Comments
            } else {
                $errorMsg = "User Is Not Exists";
                homeRedirect($errorMsg);
            }
        
        } elseif ($do == "Update") {
            
            //check from coming request 
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                
                echo "<h2 class='mt-5 mb-4 fs-1 text-center'>Update Item</h2>";

                //define info coming from Edit page
                $id             = $_POST['id'];
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $price          = $_POST['price'];
                $made           = $_POST['made'];
                $status         = $_POST['status'];
                $catid          = $_POST['category'];
                $member         = $_POST['username'];

                //Validate the errors which if their Empty
                $itemErrors = array();
                
                if (empty($name)) {
                    $itemErrors[] = "Name Must Not be Empty";
                }
                if (empty($description)) {
                    $itemErrors[] = "Description Must Not Be Empty";
                }
                if (empty($price)) {
                    $itemErrors[] = "Price Must Not Be Empty";
                }
                if (empty($made)) {
                    $itemErrors[] = "Country Made Must Not Be Empty";
                }

                if (empty($itemErrors)) {

                    //check that Edited name not exists in the DB because it is unique
                    $checkItemFix = checkItemUpdateFix("*", "items", "Name", "Item_ID", $name, $id);

                    if ($checkItemFix == 0) { 

                        //insert these Data into the DB
                        $stmt = $db->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ? WHERE Item_ID = ?");

                        $stmt->execute(array($name, $description, $price, $made, $status, $catid, $member, $id));
                        
                        echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Item Updated" . "</div>";
                        
                        homeRedirectV4("back");
                    } else {
                        echo "<div class='alert alert-danger mt-5'>" . "Category Name Exists Please Choose New Name" . "</div>";
                        homeRedirectV4("back");
                    }
                }else {

                    foreach ($itemErrors as $error) {
                        echo "<div class='alert alert-danger mt-5'>" . $error . "</div>";
                    }

                    homeRedirectV4("back");
                }
            } else {
                $errorMsg = "You Can NOT Enter This Page Directly";
                homeRedirect($errorMsg);
            }

        } elseif ($do == "Delete") {
            
            //to check user what place coming from, this is to prevent user from write  inside the link to delete any user
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                echo "<h2 class='mt-5 mb-4 fs-1 text-center'>Delete Item</h2>";

                //check if the itemId is a number so you can use it to retrieve data regarding to that itemId
                $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

                //query to get all data from the DB to delete it
                $stmt = $db->prepare("SELECT * FROM items WHERE Item_ID = ?");

                $stmt->execute(array($itemId));

                $stmt->fetch();

                $itemfetched = $stmt->rowCount();

                if ($itemfetched > 0) {

                    //Delete query 
                    $stmt = $db->prepare("DELETE FROM items WHERE Item_ID = :deleted");
                                
                    $stmt->bindParam(':deleted', $itemId);

                    $stmt->execute();

                    echo "<div class='alert alert-success mt-5'>" . "<strong>" . $stmt->rowCount() . " Item Deleted" . "</strong>" . "</div>";

                    homeRedirectV4("back");
                }
            }else {
                $errorMsg = "You Can Not Enter This Page Directly";
                homeRedirect($errorMsg);
            }

        } elseif ($do == "Approve") {
            
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                
                //check from the itemId because you will depend on it in the query below to change the approve state
                $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;
                
                //check to be sure this item exists in the DB
                $check = checkItem("Item_ID", "items", $itemId);
                
                if ($check != 0) {

                    //change the Approve status to make it 1 in the DB
                    $stmt = $db->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                    $stmt->execute(array($itemId));

                    echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Item Approved" . "</div>";
                    homeRedirectV4("back");
                } else {
                    $errorMsg = "This Item Is Not Exists";
                    homeRedirect($errorMsg);
                }
            } else {
                $errorMsg = "You Can Not Browse This Page Directly";
                homeRedirect($errorMsg);
            }
        } elseif ($do == "CategoryItem") {
            
            //set the the get request 
            $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;

            //query to display the each category's Items
            $stmt = $db->prepare("SELECT I.*, U.Username AS userUsername 
                                FROM 
                                    `items` I 
                                INNER JOIN 
                                    `users` U 
                                ON 
                                    U.UserID = I.Member_ID 
                                WHERE 
                                    I.Cat_ID = ?
            ");

            $stmt->execute(array($catId));

            $itemsFetched = $stmt->fetchAll();

            //display all fetched data from DB
            if (!empty($itemsFetched)) { ?>
                <h2 class="text-center fs-1 mt-4 mb-4 text-capitalize">category "<?php echo $_GET['catName'];?>" items</h2>
                <table class="table text-center caption-top">

                    <?php // this is to display number of items that each user has?>
                    <caption>Total Items: <span class="totalItems"><?php echo countItemsV3("Item_ID", "items", "Cat_ID", $catId);?></span></caption>
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Country Made</th>
                            <th>Status</th>
                            <th>Member Name</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($itemsFetched as $item) {
                            echo "<tr>";
                                echo "<th scope='row'>" . $item['Item_ID'] . "</th>";
                                echo "<td>" . $item['Name'] . "</td>";
                                echo "<td>" . $item['Description'] . "</td>";
                                echo "<td>" . $item['Price'] . "</td>";
                                echo "<td>" . $item['Add_Date'] . "</td>";
                                echo "<td>" . $item['Country_Made'] . "</td>";
                                echo "<td>";
                                if ($item['Status'] == 1) {
                                    echo "<span class='badge rounded-pill bg-success'>" . "New" . "</span>";
                                } elseif ($item['Status'] == 2) {
                                    echo "<span class='badge rounded-pill bg-warning'>" . "Used" . "</span>";
                                } elseif ($item['Status'] == 3) {
                                    echo "<span class='badge rounded-pill bg-danger'>" . "Old" . "</span>";
                                }
                                echo "</td>";
                                echo "<td>"; 
                                    echo "<a class='badge bg-info unset-a text-capitalize' href='?do=UserItems&memberId=".$item['Member_ID']."&userName=".$item['userUsername']."'>" . $item['userUsername'] . "</a>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<a href='?do=Edit&itemId=" .$item['Item_ID']. "' class='btn btn-warning mr-2'>" . "Edit" . "</a>";
                                    echo "<form action='?do=Delete&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                        echo "<input type='submit' class='btn btn-danger confirm heightFix mr-2' value='Delete'>";
                                    echo "</form>";
                                    if ($item['Approve'] == 0) {
                                        echo "<form action='?do=Approve&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                            echo "<input type='submit' class='btn btn-info heightFix' value='Approve'>";
                                        echo "</form>";
                                    }
                                echo "</td>";
                            echo "</tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>

            <?php
            } else { ?>

                <div class='noDataMsg mt-5'>
                    <h4 class="NoComments">404</h4>
                    <span>no items found</span>
                    <div class="mt-5"><a href="?do=Add" class="btn btn-info">Add New Item</a></div>
                </div>
            <?php
            }
        } elseif ($do == "UserItems") {

            //set the the get request 
            $memberId = isset($_GET['memberId']) && is_numeric($_GET['memberId']) ? intval($_GET['memberId']) : 0;

            //query to display the each user's Items
            $stmt = $db->prepare("SELECT I.*, C.Name AS categoryName 
                                FROM 
                                    `items` I 
                                INNER JOIN 
                                    `categories` C 
                                ON 
                                    C.ID = I.Cat_ID
                                WHERE 
                                    I.Member_ID = ?
            ");

            $stmt->execute(array($memberId));

            $uesritemsFetched = $stmt->fetchAll();

            if (!empty($uesritemsFetched)) { ?>

                <h2 class="text-center fs-1 mt-4 mb-4 text-capitalize">category "<?php echo $_GET['userName'];?>" items</h2>
                <table class="table text-center caption-top">

                <?php // this is to display number of items that each user has?>
                <caption>Total Items: <span class="totalItems"><?php echo countItemsV3("Item_ID", "items", "Member_ID", $memberId);?></span></caption>
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Country Made</th>
                            <th>Status</th>
                            <th>Category Name</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        foreach ($uesritemsFetched as $item) {
                            echo "<tr>";
                                echo "<th scope='row'>" . $item['Item_ID'] . "</th>";
                                echo "<td>" . $item['Name'] . "</td>";
                                echo "<td>" . $item['Description'] . "</td>";
                                echo "<td>" . $item['Price'] . "</td>";
                                echo "<td>" . $item['Add_Date'] . "</td>";
                                echo "<td>" . $item['Country_Made'] . "</td>";
                                echo "<td>";
                                if ($item['Status'] == 1) {
                                    echo "<span class='badge rounded-pill bg-success'>" . "New" . "</span>";
                                } elseif ($item['Status'] == 2) {
                                    echo "<span class='badge rounded-pill bg-warning'>" . "Used" . "</span>";
                                } elseif ($item['Status'] == 3) {
                                    echo "<span class='badge rounded-pill bg-danger'>" . "Old" . "</span>";
                                }
                                echo "</td>";
                                echo "<td>";
                                    echo "<a class='badge bg-warning unset-a text-capitalize' href='?do=CategoryItem&catId=".$item['Cat_ID']."&catName=".$item['categoryName']."'>" . $item['categoryName'] . "</a>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<a href='?do=Edit&itemId=" .$item['Item_ID']. "' class='btn btn-warning mr-2'>" . "Edit" . "</a>";
                                    echo "<form action='?do=Delete&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                        echo "<input type='submit' class='btn btn-danger confirm heightFix mr-2' value='Delete'>";
                                    echo "</form>";
                                    if ($item['Approve'] == 0) {
                                        echo "<form action='?do=Approve&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                            echo "<input type='submit' class='btn btn-info heightFix' value='Approve'>";
                                        echo "</form>";
                                    }
                                echo "</td>";
                            echo "</tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>
                
            <?php
            } else { ?>

                <div class='noDataMsg mt-5'>
                    <h4 class="NoComments">404</h4>
                    <span>no items found</span>
                    <div class="mt-5"><a href="?do=Add" class="btn btn-info">Add New Item</a></div>
                </div>

            <?php
            }
            

        }else {
            $errorMsg = "No page With This Name" . '"' . $_GET['do'] . '"';

            homeRedirect($errorMsg);
        }

    echo "</section>";
    include $templets . "footer.inc.php";
}else {

    header("location:index.php");
    exit();
}
