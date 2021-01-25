<?php
session_start();

$pageTitle = "Home";
include "init.php"; //All files included in the Initialize file
?>

<?php //this is in order for the nav intersect to work?>
<div id="indexIntersect"></div>

<section class="main">
    <div id="shopCarousal" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#shopCarousal" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#shopCarousal" data-bs-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="layout/images/slider1.jpg" class="d-block w-100" alt="slider1">
                <div class="carousel-caption d-none d-md-block">
                    <span class="text-uppercase" id="spanIntersect">new collection</span>
                    <h2 class="text-uppercase">shop women's 2020</h2>
                    <span class="text-capitalize">ineternational delivery from just $99.00</span>
                    <a class="navbtn d-md-block" href="#"><button class="myBtn">shop woman</button></a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="layout/images/slider2.png" class="d-block w-100" alt="slider2">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-uppercase">brand lookbook 2020</h2>
                    <span class="text-capitalize">ineternational delivery from just $99.00</span>
                    <a class="navbtntwo navbtn d-md-block" href="#"><button class="myBtn slidetwobtn">discover more <i class="fas fa-long-arrow-alt-right ml-1"></i></button></a>
                </div>
            </div>
        </div>
    </div>
    <div id="navIntersecting"></div>
</section>
<section class="deals">
    <div>deals section</div>
</section>
<?php include $templets . "footer.inc.php"?>