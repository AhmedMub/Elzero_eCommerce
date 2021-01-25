<?php
//ob_start(); => this is a fix for Errors like "header already sent" and some header errors as well, But I commented it out because I didn't have these issues
session_start();
$pageTitle = "Dashboard"; // in Osama put in inside the the session like right after the include
if (isset($_SESSION['username'])) {
    include "init.php";

    $userslimit = 5; // limit of the users displayed in dashboard
    $itemsLimit = 5;// limit of the Items displayed in dashboard
    $usersCommentsLimit = 4;// limit of users comments displayed in dashboard
    $itemsCommentsLimit = 4;// limit of Items comments displayed in dashboard

    //when you called the function I selected all because I will specify which column should be displayed
    $latestUsers = getLatestNoAdmin("*", "users", "UserID", $userslimit); // this to display latest 5 users from the DB
    $latestItems = getLatest("*", "items", "Item_ID", $itemsLimit); // this to display latest 5 items added from the DB

    //query for to show related Comments to the Users
    $stmt = $db->prepare("SELECT cm.*, U.Username
                        FROM 
                            `comments` cm
                        INNER JOIN
                            `users` U
                        ON
                            cm.user_name = U.Username
                        ORDER BY 
                            `comment_Id` DESC 
                        LIMIT $usersCommentsLimit");

    $stmt->execute();

    $usersCommentsFetched = $stmt->fetchAll();

     //query for to show related Comments to the Items
     $stmt2 = $db->prepare("SELECT cm.*, I.Name
                        FROM 
                            `comments` cm
                        INNER JOIN
                            `items` I
                        ON
                            cm.item_Id = I.Item_ID
                        ORDER BY 
                            `comment_Id` DESC 
                        LIMIT $itemsCommentsLimit");

    $stmt2->execute();

    $itemsCommentsFetched = $stmt2->fetchAll();
    
    ?>
<!--
    =====================================================================
                    ========> Start Totals <========
    =====================================================================
-->
    <section class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="card mt-5 mb-3 text-center my-bg-1">
                    <div class="row g-0 mt-4">
                        <div class="col-md-5 text-capitalize">
                            <div class="icon">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                            <h5 class="card-title text-capitalize">total members</h5>
                            <span class="fs-1"><a href="members.php"><?php echo countItems("UserID", "users");?></a></span><?php // this have a $_GET[''] request?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card mt-5 mb-3 text-center my-bg-1">
                    <div class="row g-0 mt-4">
                        <div class="col-md-5 text-capitalize">
                            <div class="icon">
                                <i class="fas fa-user-check fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize">pending members</h5>
                                <span class="fs-1"><a href="members.php?do=Manage&page=Pending"><?php echo countItemsV2("RegStatus", "users", 0);// You can use checkItems() function Elzero used it, but I developed the countItemsV2() Function?></a></span><?php // this have a $_GET[''] request?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card mt-5 mb-3 text-center my-bg-1">
                    <div class="row g-0 mt-4">
                        <div class="col-md-5 text-capitalize">
                            <div class="icon">
                                <i class="fas fa-tags fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize">total items</h5>
                                <span class="fs-1"><a href="items.php">
                                    <?php
                                        echo countItems("Item_ID", "items");
                                    ?>
                                </a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card mt-5 mb-3 text-center my-bg-1">
                    <div class="row g-0 mt-4">
                        <div class="col-md-5 text-capitalize">
                            <div class="icon">
                                <i class="fas fa-comment-dots fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize">total comments</h5>
                                <span class="fs-1"><a href="comments.php">
                                    <?php
                                        echo countItems("comment_Id", "comments");
                                    ?>
                                </a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--
    =====================================================================
                    ========> End Totals <========
    =====================================================================
-->
<!--
    =====================================================================
           ========> Start latest users && Items <========
    =====================================================================
-->
        <div class="row">
            <div class="col-sm-6">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <div class="card">
                            <h2 class="accordion-header" id="headingOne">
                                <div class="card-header text-capitalize accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fas fa-users fa-lg mr-2"></i>latest registered users</div>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="card-body accordion-body">
                                    <h3 class="card-title text-capitalize"><?php if (!empty($latestUsers)) {
                                        echo "latest $userslimit users registered";
                                    } else {
                                        echo "there is no users to registered";
                                    }
                                    ?></h3>
                                    <p class="card-text"><?php
                                    // when I called the function above of the page I selected all from the Db and here in the foreach() I will extract the username ONLY from data fetched using the function to display only the username AND I can show any column like email or fullname
                                        foreach($latestUsers as $user) {
                                            // All these below Explained in the "members" page inside "manage"
                                            echo "<ul class='list-group pointer'>";
                                                echo "<li class='list-group-item d-flex justify-content-between align-items-center list-group-item-action'>";
                                                echo $user['Username'];
                                                    echo "<span>";
                                                        if ($user["RegStatus"] == 0) {
                                                            echo "<a class='mr-2' href='members.php?do=Activate&userId=". $user["UserID"] ."'>";
                                                                echo "<button class='btn btn-outline-primary text-capitalize'>". "activate" ."</button>";
                                                            echo "</a>";
                                                        }
                                                        echo "<a href='members.php?do=Edit&userId=". $user["UserID"] ."'>";
                                                            echo "<button class='btn btn-outline-warning text-capitalize'>". "edit" ."</button>";
                                                        echo "</a>";
                                                    echo "</span>";
                                                echo "</li>";
                                            echo "</ul>";
                                        }?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="accordion" id="secondeAccording">
                    <div class="accordion-item">
                        <div class="card">
                            <h2 class="accordion-header" id="headingTwo">
                                <div class="card-header text-capitalize accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <i class="fas fa-tag fa-lg mr-2"></i>latest items</div>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#secondeAccording">
                                <div class="card-body accordion-body">
                                    <h3 class="card-title text-capitalize"><?php if (!empty($latestItems)) {
                                        echo "latest $itemsLimit users registered";
                                    } else {
                                        echo "no items recorded";
                                    }
                                    ?></h3>
                                    <p class="card-text"><?php

                                    foreach($latestItems as $item) {
                                        echo "<ul class='list-group pointer'>";
                                            echo "<li class='list-group-item d-flex justify-content-between align-items-center list-group-item-action'>";
                                                echo $item['Name'];
                                                echo "<span>";
                                                    if ($item['Approve'] == 0) {
                                                        echo "<form action='items.php?do=Approve&itemId=".$item['Item_ID']."' class='formFix' method='POST'>";
                                                            echo "<input type='submit' class='btn btn-outline-primary heightFix mr-2' value='Approve'>";
                                                        echo "</form>";
                                                    }
                                                    echo "<a href='items.php?do=Edit&itemId=".$item['Item_ID']."' class='btn btn-outline-warning'>" . "Edit" . "</a>";
                                                echo "</span>";
                                            echo "</li>";
                                        echo "</ul>";  
                                    }?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--
    =====================================================================
           ========> End latest users && Items <========
    =====================================================================
-->
<!--
    =====================================================================
           ========> Start Users && Items Comments <========
    =====================================================================
-->
        <div class="row mt-2">
        <!-- ========> Start Users Comments <======== -->
            <div class="col-sm-6">
                <div class="accordion" id="commentAccordionOne">
                    <div class="accordion-item">
                        <div class="card">
                            <h2 class="accordion-header" id="headingOne">
                                <div class="card-header text-capitalize accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#commentCollapseOne" aria-expanded="true" aria-controls="commentCollapseOne">
                                <i class="fas fa-comments fa-lg mr-2"></i>latest users comments</div>
                            </h2>
                            <div id="commentCollapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#commentAccordionOne">
                                <div class="card-body accordion-body">
                                    <h3 class="card-title text-capitalize"><?php if (!empty($usersCommentsFetched)) {
                                        echo "latest $usersCommentsLimit users registered";
                                    } else {
                                        echo "no comments recorded";
                                    }
                                    ?></h3>
                                    <?php
                                    // when I called the function above of the page I selected all from the Db and here in the foreach() I will extract the username ONLY from data fetched using the function to display only the username AND I can show any column like email or fullname
                                    foreach($usersCommentsFetched as $comment) {
                                        // All these below Explained in the "members" page inside "manage"
                                        echo "<div class='border-bottom border-primary'>";
                                        echo "<div class='mb-3 mt-3'>";
                                        echo "<h5 class='card-title fs-5'>" . $comment['Username'] . "</h5>";
                                        
                                        echo "<p class='card-text'>" . $comment['comment'] . "</p>";

                                        echo "<a class='btn btn-outline-warning' href='comments.php?do=Edit&comId=".$comment['comment_Id']."'>" . "Edit" . "</a>";
                                        echo "<a class='btn btn-outline-danger mr-1 ml-1 confirm' href='comments.php?do=Delete&comId=".$comment['comment_Id']."'>" . "Delete" . "</a>";
                                        if ($comment['status'] == 0) {
                                            echo "<a class='btn btn-outline-info' href='comments.php?do=Activate&comId=".$comment['comment_Id']."'>" . "Activate" . "</a>";
                                        } else {
                                            echo "<a class='btn btn-outline-primary' href='comments.php?do=Disapprove&comId=".$comment['comment_Id']."'>" . "Disapprove" . "</a>";
                                        }
                                        echo "</div>";
                                        echo "</div>";
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========> End Users Comments <======== -->
            <!-- ========> Start Items Comments <======== -->
            <div class="col-sm-6">
            <div class="accordion" id="commentAccordionTwo">
                    <div class="accordion-item">
                        <div class="card">
                            <h2 class="accordion-header" id="headingOne">
                                <div class="card-header text-capitalize accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#commentCollapseTwo" aria-expanded="true" aria-controls="commentCollapseTwo">
                                <i class="fas fa-comment-alt fa-lg mr-2"></i>latest Items comments</div>
                            </h2>
                            <div id="commentCollapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#commentAccordionTwo">
                                <div class="card-body accordion-body">
                                    <h3 class="card-title text-capitalize"><?php if (!empty($itemsCommentsFetched)) {
                                            echo "latest $itemsCommentsLimit users registered";
                                        } else {
                                            echo "no comments recorded";
                                        }
                                        ?>
                                    </h3>
                                    <?php
                                    // when I called the function above of the page I selected all from the Db and here in the foreach() I will extract the username ONLY from data fetched using the function to display only the username AND I can show any column like email or fullname
                                    foreach($itemsCommentsFetched as $item) {
                                        // All these below Explained in the "members" page inside "manage"
                                        echo "<div class='border-bottom border-primary'>";
                                            echo "<div class='mb-3 mt-3'>";
                                                echo "<h5 class='card-title fs-5'>" . $item['Name'] . "</h5>";
                                                
                                                echo "<p class='card-text'>" . $item['comment'] . "</p>";

                                                echo "<a class='btn btn-outline-warning' href='comments.php?do=Edit&comId=".$item['comment_Id']."'>" . "Edit" . "</a>";
                                                echo "<a class='btn btn-outline-danger mr-1 ml-1 confirm' href='comments.php?do=Delete&comId=".$item['comment_Id']."'>" . "Delete" . "</a>";
                                            echo "</div>";
                                        echo "</div>";
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- ========> End Items Comments <======== -->
<!--
    =====================================================================
           ========> End Users && Items Comments <========
    =====================================================================
-->                
    </section>

<!--
    =====================================================================
                    ========> End Dashboard <========
    =====================================================================
-->

    <?php
    include $templets . "footer.inc.php";
} else {
    header('location: index.php');
    exit();
}

//ob_flush(); this is regarding to the issue explained in top of the page