<?php
include 'admin_panel/connect.php';
include "includes/funcs/functions.php";

//Check for the request method
if (isset($_SERVER['REQUEST_METHOD']) == "POST") {

    //get request method in here 
    if (isset($_POST['comment']) == "newReview") {

        //put incoming info intro vars
        $commentedUser  = $_POST['RevUser'];
        $itemId         = $_POST['itemId'];
        $comment        = filter_var($_POST['per_comment'], FILTER_SANITIZE_STRING);
        $rating         = $_POST['rating'];

        $commentErrors = array();

        $checkUser = checkUser($commentedUser);

        //check if the user is activated before add comments
        if ($checkUser == 1) {
            
            if (!empty($comment)) {
                //here will add error for user that already have a comment with the same item id
                //check if the user has a review with the same item, to prevent user to have duplicated comments with same item
                //*REMEMBER that if the user is not active can NOT add a comment, this is an extra SECURITY
                
                $stmt = $db->prepare("SELECT COUNT(comment) 
                FROM 
                    comments 
                WHERE 
                    item_Id = ? 
                AND 
                user_name = ?");

                $stmt->execute(array($itemId, $commentedUser));

                $result = $stmt->fetchColumn();

                if ($result == 1) {

                $commentErrors[] = "<div class='failed-MSG-CM'>you already reviewed this item. allowed one review on each item for valid purchase <strong>ONLY</strong></div>";
                }
            } else {
                $commentErrors[] = "<div class='failed-MSG-CM'>please write a valid comment</div>";
            }

        } else {
            //this won't display unless if there is a hacking in some kind
            $commentedUser[] = "<div class='failed-MSG-CM'>sorry you have not been activated yet</div>";
            
        }

        if (!empty($commentErrors)) {

            //here to send the errors that exists in the array
            foreach ($commentErrors as $error) {
                echo $error;
            }
        } else {

            //insert the new comment to the DB
            $stmt = $db->prepare("INSERT INTO comments(comment, ratings, item_Id, user_name, comment_date)
                                    VALUES(
                                        :zcomment,
                                        :zratings,
                                        :zitem_Id,
                                        :zuser_name,
                                        now() )");
            $stmt->execute(array(
                'zcomment'      => $comment,
                'zratings'      => $rating,
                'zitem_Id'      => $itemId,
                'zuser_name'    => $commentedUser
            ));


            echo "<div class='success-MSG-CM'>" . "AWESOME!. review will be subjected to approval first. thanks have a nice time" . "</div>";
        }
    }
}
