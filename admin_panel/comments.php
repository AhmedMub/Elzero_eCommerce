<?php
/* --------------------------------------
=========================================
Page Name - comments.php

This page to manage all users comments => [Edit && Delete && Approve] comments
=========================================
---------------------------------------*/

session_start();//Start the user session

$pageTitle = "Comments";

//make sure that session exists
if (isset($_SESSION['username'])) {

    include "init.php";

        $do = isset($_GET['do']) ? $_GET['do'] : "Manage";
        
        echo "<section class='container'>";

            if ($do == "Manage") {
                
                //query of display all comments from the DB into the table below
                $stmt = $db->prepare("SELECT cm.*, I.Name AS Item_Name, U.Username
                                    FROM `comments` cm
                                    INNER JOIN
                                    `items` I
                                    ON
                                    cm.item_Id = I.Item_ID
                                    INNER JOIN
                                    `users` U
                                    ON
                                    cm.user_Id = U.UserID");
                $stmt->execute();

                $commentsFetched = $stmt->fetchAll();

                if (!empty($commentsFetched)) { //this will show up if there is no comments in the DB to be displayed?>

                    <h2 class="text-center fs-1 mt-4 mb-4">Manage Comments</h2>
                    <table class="table text-center">
                        <thead class="table-warning">
                            <tr>
                                <th>#</th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>User</th>
                                <th>Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($commentsFetched as $comment) {
                                    echo "<tr>";
                                        echo "<th scope='row'>" . $comment['comment_Id'] . "</th>";
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
                                        echo "<td>" . $comment['Username'] . "</td>";
                                        echo "<td>";
                                            echo "<a class='btn btn-warning' href='?do=Edit&comId=".$comment['comment_Id']."'>" . "Edit" . "</a>";
                                            echo "<a class='btn btn-danger mr-2 ml-2 confirm' href='?do=Delete&comId=".$comment['comment_Id']."'>" . "Delete" . "</a>";
                                            if ($comment['status'] == 0) {
                                                echo "<a class='btn btn-info' href='?do=Approve&comId=".$comment['comment_Id']."'>" . "Approve" . "</a>";
                                            } else {
                                                echo "<a class='btn btn-primary' href='?do=Disapprove&comId=".$comment['comment_Id']."'>" . "Disapprove" . "</a>";
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
                        <span>no comments found</span>
                    </div>
                <?php
                }
            } elseif ($do == "Edit") {//Edit page
                
                //check of the comment ID
                $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

                //query to get all info to that related comment Id
                $stmt = $db->prepare("SELECT * FROM comments WHERE comment_Id = ?");

                $stmt->execute(array($comId));

                $comFetched = $stmt->fetch();

                //check to make sure that comment exists in the DB
                $check = checkItem("comment_Id", "comments", $comId);
                
                if ($check != 0) {?>
                    <h2 class="text-center fs-1 mt-4 mb-4">Edit Comments</h2>

                    <form action="?do=Update" method="POST" class="col-lg-4 col-sm-3">
                        <input type="hidden" name="id" value="<?php echo $comFetched['comment_Id']?>">

                        <div class="mb-3">
                            <label class="form-label">Edit Comment</label><span class="asterisk">*</span>
                            <textarea class="form-control" name="comment" required rows="3"><?php echo $comFetched['comment']?></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                <?php
                } else {
                    $errorMsg = "There Is No Such Comment";
                    homeRedirect($errorMsg);
                }

            } elseif ($do == "Update") { //Update the DB with info received from the Form as above
                
                if ($_SERVER['REQUEST_METHOD'] == "POST") {

                    echo "<h2 class='text-center fs-1 mt-4 mb-4'>" . "Update Comments" . "</h2>";

                    //putting received info into vars
                    $id         = $_POST['id'];
                    $comment    = $_POST['comment'];
                
                    //Update query to the DB
                    $stmt = $db->prepare("UPDATE comments SET comment = ? WHERE comment_Id = ?");

                    $stmt->execute(array($comment, $id));

                    echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Comment Updated" . "</div>";

                    homeRedirectV4("back");  

                } else {
                    $errorMsg = "You Can Not Browse This Page Directly";
                    homeRedirect($errorMsg);
                }               

            } elseif ($do == "Delete") {
                
                echo "<h2 class='text-center fs-1 mt-4 mb-4'>" . "Delete Comments" . "</h2>";

                //check from coming request
                $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

                //Delete query
                $check = checkItem("comment_Id", "comments", $comId);

                if ($check != 0) {//to make sure the comment exists before execute the query
                    
                    $stmt = $db->prepare("DELETE FROM comments WHERE comment_Id = :delete");

                    $stmt->bindParam(':delete', $comId);

                    $stmt->execute();

                    echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Comment Deleted" . "</div>";

                    homeRedirectV4("back");
                } else {
                    $errorMsg = "There Is No Such User";
                    homeRedirect($errorMsg);
                }
                

            } elseif ($do == "Approve") {
                
                echo "<h2 class='text-center fs-1 mt-4 mb-4'>" . "Approve Comments" . "</h2>";
                
                //checking the incoming Id
                $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

                $check = checkItem("comment_Id", "comments", $comId);

                //to make sure comment already exists in the DB
                if ($check != 0) {

                    //Update query
                    $stmt = $db->prepare("UPDATE comments SET status = 1 WHERE comment_Id = ?");

                    $stmt->execute(array($comId));

                    echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Comment Approved" . "</div>";

                    homeRedirectV4("back");
                } else {
                    $errorMsg = "There Is No Such Comment";

                    homeRedirect($errorMsg);
                }

            } elseif ($do == "Disapprove") {
                
                echo "<h2 class='text-center fs-1 mt-4 mb-4'>" . "Disapprove Comments" . "</h2>";
                
                //checking the incoming Id
                $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

                $check = checkItem("comment_Id", "comments", $comId);

                //to make sure comment already exists in the DB
                if ($check != 0) {

                    //Update query
                    $stmt = $db->prepare("UPDATE comments SET status = 0 WHERE comment_Id = ?");

                    $stmt->execute(array($comId));

                    echo "<div class='alert alert-success mt-5'>" . $stmt->rowCount() . " Comment Disapproved" . "</div>";

                    homeRedirectV4("back");
                } else {
                    $errorMsg = "There Is No Such Comment";

                    homeRedirect($errorMsg);
                }
            } else {
                $errorMsg = "No Such Page Exists";

                homeRedirect($errorMsg);
            }
        
        echo "</section>";

    include $templets . "footer.inc.php";
} else {
    header("location:index.php");
    exit();
}