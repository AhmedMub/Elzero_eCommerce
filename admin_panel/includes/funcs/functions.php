<?php 
/*
    This is will working with pages according to an exist Variable
*/
// each page name will be in the title according to user active page 
function getTitle() {
    
    global $pageTitle;

    if (isset($pageTitle)) {

        echo $pageTitle;
    } else {
        echo "Default";
    }
}