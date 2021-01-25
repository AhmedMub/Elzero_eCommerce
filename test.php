<?php
include 'admin_panel/connect.php';


/*
 1- write a query for each rating number to get total people review for exact rate
 2- put all queries into vars so you can get the sum of them all
 3- write query to get total people have reviewed that item so you can divide by total numbers mentioned in (2)
 */

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

    $theItemAverage = $SumOfItem / $sumRevs;
    return round($theItemAverage);
}

 echo calcItemAverageRevs(15);


