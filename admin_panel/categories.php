<?php
/* --------------------------------------
=========================================
Page Name - categories.php

This page to manage all categories => [Add && Edit && Delete] categories
=========================================
---------------------------------------*/
session_start();

$pageTitle = "Categories";

if (isset($_SESSION['username'])) {

    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : "Manage";//explained in the "members" page
    
    if ($do == "Manage") { // this the mange page 

        //this is the default order for the categories
        $sort = "ASC";

        $sort_arr  = array("ASC", "DESC"); // I put in an array so I can use in the if condition as below

    //if there is $_GET sort && equals one of the array above will run the code, which is going the make $sort equal whatever in the $_GET sort, as the table sorting depends on what in the $sort variable, as its written in the query below 
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {
            $sort = $_GET['sort'];
        }

        //fetch data from the Db to display it in the manage page, Will be ordered by "Ordering" 
        $stmt = $db->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        
        $stmt->execute();

        $showCat = $stmt->fetchAll();

        if (!empty($showCat)) { //this will show up if there is no categories in the DB to be displayed?>

        <div class="container">
        <h2 class="mt-4 text-center text-capitalize fs-1">manage categories</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover mt-5 text-center caption-top">
                <caption><?php //this is for control the sorting: when click ASC or DESC will add these classes?>
                    Order: 
                    <a class='<?php if ($sort == "ASC") { echo "badge bg-info padgeFix";}?>' href='?sort=ASC'>ASC</a>
                    <span> | </span> 
                    <a class='<?php if ($sort == "DESC") { echo "badge bg-info padgeFix";}?>' href='?sort=DESC'>DESC</a>
                </caption>
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Ordering</th>
                            <th scope="col">Visibility</th>
                            <th scope="col">Comments</th>
                            <th scope="col">Ads</th>
                            <th scope="col">Controls</th>
                        </tr>
                        <tbody>
                                <?php // to understand the foreach() in here you have to review the members.php as all have been explained 
                                    foreach($showCat as $row) {
                                        echo "<tr>";
                                        //Start Category ID 
                                        echo "<th scope='row'>". $row["ID"] . "</th>";
                                        //End ID
                                        //Start Category Name 
                                        echo "<td>". $row["Name"] . "</td>";
                                        //End Category Name
                                        //Start Category Description
                                        echo "<td>";
                                            if($row["Description"] == "") {
                                                echo "<span class='badge bg-warning'>" . "No Description" . "</span>";
                                            } else { echo $row["Description"]; }
                                        echo "</td>";
                                        //End Category Description
                                        //Start Category Order
                                        echo "<td>";
                                            if ($row["Ordering"] <= 0) {
                                                echo "<span class='badge rounded-pill bg-warning'>" . "Empty" . "</span>";
                                            }else {echo $row["Ordering"];}
                                        echo "</td>";
                                        //End Category Order
                                        //Start Category Visibility
                                        echo "<td>";
                                            if ($row["Visibility"] == 1) {
                                                echo "<span class='badge rounded-pill bg-danger'>". "Hidden" ."</span>";
                                            }else {echo "<span class='badge rounded-pill bg-success'>". "Visible" ."</span>";}
                                        echo "</td>";
                                        //End Category Visibility
                                        //Start Category Comments
                                        echo "<td>";
                                            if ($row["Allow_comments"] == 1) {
                                                echo "<span class='badge rounded-pill bg-danger'>" . "Disabled" . "</span>";
                                            }else {echo "<span class='badge rounded-pill bg-success'>" . "Allowed" . "</span>";}
                                        echo "</td>";
                                        //End Category Comments
                                        //Start Category Ads
                                        echo "<td>";
                                            if ($row["Allow_ads"] == 1) {
                                                echo "<span class='badge rounded-pill bg-danger'>" . "Disabled" . "</span>";
                                            } else {echo "<span class='badge rounded-pill bg-success'>" . "Allowed" . "</span>";}
                                        echo "</td>";
                                        //End Category Ads
                                        //Start Category Controls
                                        echo "<td>"; //Explained in the "member" page
                                            echo "<a class='btn btn-warning warning-fix mr-2' href='?do=Edit&catId=".$row['ID']."'>" . "Edit" . "</a>";
                                            //echo "<a class='btn btn-danger confirm' href='?do=Delete&catId=".$row["ID"]."'>" . "Delete" . "</a>";

                                            //this is to make sure that the user is going to delete the category has really clicked this button, not just writing get request in the browser tab 
                                            echo "<form class='formFix' method='POST' action='?do=Delete&catId=".$row["ID"]."'>";
                                                echo "<input type='submit' class='btn btn-danger confirm heightFix' value='Delete'>";
                                            echo "</form>";
                                        echo "</td>";
                                        //End Category Controls
                                        echo "</tr>";
                                    }
                                ?>
                        </tbody>
                    </thead>
                </table>
                <div>
                    <a href="?do=Add" class="btn btn-info">Add New Category</a>
                </div>
            </div>
        </div>
    
    <?php
    } else { ?>

        <div class='noDataMsg mt-5'>
            <h4 class="NoComments">404</h4>
            <span>no categories found</span>
            <div class="mt-5"><a href="?do=Add" class="btn btn-info">Add New Category</a></div>
        </div>
    <?php
    }
    } elseif ($do == "Add") { // this is "Add" page 
        
        //this info is going to "Insert" page
    ?>       
            <form action="?do=Insert" class="col-lg-4 col-sm-3" method="POST">
                <h2 class="text-center text-capitalize mb-1">add new Category</h2>
                <!-- Start Name -->
                <div class="mb-3">
                    <label class="form-label">Name</label><span class="asterisk">*</span>

                    <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                </div> 
                <!-- End Name -->
                <!-- Start Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" placeholder="Category Description">
                </div>
                <!-- End Description -->
                <!-- Start Order -->
                <div class="mb-3">
                    <label class="form-label">Order Number</label>
                    <input type="text" name="ordering" class="form-control" placeholder="Category Order">
                </div>
                <!-- End Order -->
                <!-- Start Visibility -->
                <div class="mb-3">
                    <label class="form-label">Category Visibility</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" value="0" checked id="allow_visibility">
                            <label class="form-check-label" for="allow_visibility">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" value="1" id="allow_visibility2">
                            <label class="form-check-label" for="allow_visibility2">No</label>
                        </div>
                </div>
                <!-- End Visibility -->
                <!-- Start Comments -->
                <div class="mb-3">
                    <label class="form-label">Allow Comments</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comments" value="0" checked id="allow_comments1">
                            <label class="form-check-label" for="allow_comments1">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="comments" value="1" id="allow_comments2">
                            <label class="form-check-label" for="allow_comments2">No</label>
                        </div>
                </div>
                <!-- End Comments -->
                <!-- Start Ads -->
                <div class="mb-3">
                    <label class="form-label">Allow Ads</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ads" value="0" checked id="allow_ads1">
                            <label class="form-check-label" for="allow_ads1">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ads" value="1" id="allow_ads2">
                            <label class="form-check-label" for="allow_ads2">No</label>
                        </div>
                </div>
                <!-- End Ads -->
                <!-- Start submit -->
                <div class="mb-3">
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>
                <!-- End submit -->
            </form>
    <?php
    } elseif ($do == "Insert") {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // info from the "add" page from the form
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $ordering    = $_POST['ordering'];
            $visibility  = $_POST['visibility'];
            $comments    = $_POST['comments'];
            $ads         = $_POST['ads'];
            
            if (!empty($name)) { // check if the name input is not empty will execute this code

                // check weather the value that received from the input name is in the DB or not
                $check = checkItem("Name","categories", $name);
                
                // if the value doesn't exists in the Db will execute the code
                if ($check == 0) {
                    
                      // insert received info from the form into the DB
                    $stmt = $db->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_comments, Allow_ads) 
                    VALUES(
                        :DBName,
                        :DBdescription,
                        :DBordering,
                        :DBvisibility,
                        :DBcomments,
                        :DBads
                    )");

                    $stmt->execute(array(
                        'DBName'         => $name,
                        'DBdescription'  => $description,
                        'DBvisibility'   => $visibility,
                        'DBordering'     => $ordering,
                        'DBcomments'     => $comments,
                        'DBads'          => $ads
                    ));

                    echo "<div class='container alert alert-success mt-5'>". $stmt->rowCount() . " Category Added" . "</div>";

                    homeRedirectV4("back");
                } else {
                    echo "<div class='container alert alert-danger mt-5'>" . "This Category Exists" . "</div>";

                    homeRedirectV4("back");
                }
            } else {
                //error of the name that must be exists from the form
                echo "<div class='container alert alert-danger mt-5'>" . "You Must Put A Category Name" . "</div>";
                homeRedirectV4("back");
            }

        } else {
            // in case user didn't come from the POST method as explained in the members.php
            $errorMsg = "You can Not brows this Page directly";
            homeRedirect($errorMsg);
        }

    } elseif ($do == "Edit") { // Edit category page
        
        $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;

        //query that fetch Category info from the DB according to the ID received from $catId
        $stmt = $db->prepare("SELECT * FROM categories WHERE ID = ?");

        $stmt->execute(array($catId));

        $catFetched = $stmt->fetch();

        $rowCount = $stmt->rowCount();

        //make sure that ID already Exists in the DB
        $check = checkItem("ID", "categories", $catId);

        if($check == 1) { ?>
        <div class='container'>
            <h2 class='fs-1 text-center mt-5'>Edit Category</h2>
            <form action="?do=Update" method="POST" class="col-lg-4 col-sm-3">
                <input type="hidden" name="id" value="<?php echo $catFetched['ID']; // this IMPORTANT when you send these data for the "Update" to to insert into the Db this will be according to that ID that will be sent along with the below info ?>">

                <div class="mb-3">
                    <label class="form-label">Category Name</label><span class="required">*</span>
                    <input type="text" class="form-control" name="name" required value="<?php echo $catFetched['Name']?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Category Description</label>
                    <input type="text" class="form-control" name="description" value="<?php echo $catFetched['Description']?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Category Order</label>
                    <input type="text" class="form-control" name="order" value="<?php echo $catFetched['Ordering']?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Category Visibility</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" value="0" id="visibility0" 
                        <?php // if the Visibility in the Db was 0 will echo checked to checked here 
                        if($catFetched['Visibility'] == 0) {echo "checked";}?>>
                        <label for="visibility0" class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibility" value="1" id="visibility1"
                        <?php if($catFetched['Visibility'] == 1) {echo "checked";} ?>>
                        <label for="visibility1" class="form-check-label">No</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category Comments</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="comments" value="0" id="comments0"
                        <?php if($catFetched['Allow_comments'] == 0) {echo "checked";}?>>
                        <label for="comments0" class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="comments" value="1" id="comments1"
                        <?php if($catFetched['Allow_comments'] == 1) {echo "checked";}?>>
                        <label for="comments1" class="form-check-label">No</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category Ads</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ads" value="0" id="ads0"
                        <?php if($catFetched['Allow_ads'] == 0) {echo "checked";}?>>
                        <label for="ads0" class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ads" value="1" id="ads11"
                        <?php if($catFetched['Allow_ads'] == 1) {echo "checked";}?>>
                        <label for="ads11" class="form-check-label">No</label>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>   
    <?php
        } else {
            $errorMsg = "There Is No Such ID";
            homeRedirect($errorMsg);
        }
        ?>
    <?php

    } elseif ($do == "Update") { // this Update page to insert edit exists Category info in the DB
        
        
    //check the method the Date coming from:
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $id         = $_POST['id'];
        $name       = $_POST['name'];
        $description= $_POST['description'];

        //!bug Need to be fixed=> if the input was empty and I edited and save as empty input the result of this input is 0
        $order      = $_POST['order']; 
        $visibility = $_POST['visibility'];
        $comments   = $_POST['comments'];
        $ads = $_POST['ads'];

        //Make sure that there is a value written in the Name input
        if (!empty($name)) {

            //check when you edit that category Name is not exists in the DB
            $check = checkItemUpdateFix("*", "categories", "Name", "ID", $name, $id);

            if ($check == 0) { //make sure the Edited item not matched with an exist category

                //UPDATE `categories` SET `Ordering` = NULL WHERE `categories`.`ID` = 6;
                //INsert incoming Date from the "Edit" page into the Db
                $stmt = $db->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_comments = ?, Allow_ads = ? WHERE ID = ?");
                $stmt->execute(array($name, $description, $order, $visibility, $comments, $ads, $id));

                echo "<div class='container alert alert-success mt-5'>" . $stmt->rowCount() . " Category Updated" . "</div>";

                homeRedirectV4("back");
            } else {
                echo "<div class='container alert alert-danger mt-5'>" . "Category Name Already Exists Please change it" . "</div>";
                homeRedirectV4("back");
            }
        } else {
            echo "<div class='alert alert-danger'>" . "Please Write A Category Name" . "</div>";
            
            homeRedirectV4("back");
        }
    } else {
        $errorMsg = "You Can Not Brows This Page Directly";

        homeRedirect($errorMsg);
    }

    } elseif ($do == "Delete") {
        
        //check and make sure that ID is isset and numeric
        $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0; 

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //check query to be sure if the category Exists in the DB
            $stmt = $db->prepare("SELECT * FROM categories WHERE ID = ?");
            
            $stmt->execute(array($catId));

            $dataFetched = $stmt->fetch();

            $rowCount = $stmt->rowCount();

            if ($rowCount > 0) {
                
                //this is Delete query 
                $stmt = $db->prepare("DELETE FROM categories WHERE ID = :deleted");
                
                $stmt->bindParam(':deleted', $catId);

                $stmt->execute();

                echo "<div class='container alert alert-success mt-5'>" . $stmt->rowCount() . " Category Deleted" . "</div>";

                homeRedirectV4("back");

            } else {
                $errorMsg = "This User Is NOT Exists";

                homeRedirect($errorMsg);
            }
        } else {
            $errorMsg = "Can Not Enter This Directly";
            
            homeRedirect($errorMsg);
        }


    } else {
        $errorMsg = "No Page with this name ". '"' . $_GET['do'] . '"';

        homeRedirect($errorMsg);
    }

    include $templets . "footer.inc.php";
} else {
    
    header("location:index.php");
    exit();
}