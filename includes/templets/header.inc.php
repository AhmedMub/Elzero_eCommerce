<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle();?></title>
    <link rel="shortcut icon" href="layout/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> <?php //*this is for Rating only?>
    <link rel="stylesheet" href="<?php echo $css;?>fontawesome-stars.css">
    <link rel="stylesheet" href="<?php echo $css;?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>blueimp-gallery.min.css?var=<?php echo rand(5000, 10000);?>">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/src/assets/sass/glide.core.css">
    <link rel="stylesheet" href="<?php echo $css;?>main_style.css?var=<?php echo rand(5000, 10000);?>">
    

    <?php 
    // these to display separate css files for each main page I have, so if I'm in the members.php the members.css and main_style.css only going to work and etc.. 
    if (basename($_SERVER['PHP_SELF']) == "profile.php") { ?>
        
        <link rel="stylesheet" href="<?php echo $css;?>profile.css?var=<?php echo rand(1000, 9000);?>">
    <?php
     } elseif (basename($_SERVER['PHP_SELF']) == "categories.php") { ?>
       
        <link rel="stylesheet" href="<?php echo $css;?>categories.css?var=<?php echo rand(1000, 9000);?>">
     <?php
     } elseif (basename($_SERVER['PHP_SELF']) == "items.php") { ?>

        <link rel="stylesheet" href="<?php echo $css;?>items.css?var=<?php echo rand(1000, 9000);?>">
    <?php
     } elseif (basename($_SERVER['PHP_SELF']) == "login.php") {?>

        <link rel="stylesheet" href="<?php echo $css;?>login.css?var=<?php echo rand(5000, 10000);?>">
    <?php
     }?>

    <!-- Carusal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
     
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Langar&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
     <?php 
        /*
 ===============================================================================
    ----------------------------> Start Navbar <-------------------------
===============================================================================
        */
        //check if the username status is Activated or not
        
     ?>
     <section class="header">
        <div class="Upper-Bar">
            <div class="container-xxl">
                <div class="bar-info disabled-in-profile" id="UpperBar">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="left-side-social-icons">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <?php

                                if (isset($_SESSION['user'])) {

                                    $userStatus = userStatus($_SESSION['user']);

                                    if ($userStatus !== 0) {
                                        echo "<h1 class='text-capitalize hOneRed'>" . "your account not yet activated" . "</h1>";
                                    } else {
                                        echo "<h1 class='text-capitalize'>" . "Welcome " . $_SESSION['user'] . " to Donald store!" . "</h1>";
                                    }
                                }
                                ?>   
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="right-side text-capitalize">
                                <a href="#">Call us: 123-456-7890</a>
                                <a href="#">contact us</a>
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-uppercase" href="#" id="currencydropdown" data-bs-toggle="dropdown" aria-expanded="false">usd</a>
                                    <ul id="testing" class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="currencydropdown">
                                        <li><a class="dropdown-item text-uppercase" href="#">eur</a></li>
                                        <li><a class="dropdown-item text-uppercase" href="#">egp</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-uppercase" href="#" id="currencydropdown" data-bs-toggle="dropdown" aria-expanded="false"><img class="dropdown-image" src="layout/images/eng.png" alt="flag"> eng</a>
                                    <ul class="dropdown-menu" aria-labelledby="currencydropdown">
                                        <li><a class="dropdown-item text-uppercase" href="#"><img class="dropdown-image" src="layout/images/ar.png" alt="flag"> ar</a></li>
                                        <li><a class="dropdown-item text-uppercase" href="#"><img class="dropdown-image" src="layout/images/de.png" alt="flag"> de</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <nav class="navbar navbar-expand-lg navbar-light" id="navscroll">
                <div class="container-xxl" >
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <!--  -->
                    <a class="navbar-brand logo" href="index.php"><img src="layout/images/logo.png" alt="logo"></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto mb-2 mb-lg-0 text-uppercase">
                            <?php
                                // this a new way of retrieving data from another page
                                //the Get request will have the category Id and name in the link
                                foreach(fetchCats() as $cat) {
                                    echo "<li class='nav-item forActive'>";
                                        echo "<a class='nav-link mr-2' aria-current='page' href='categories.php?pageId=".$cat["ID"]."&catname=".str_replace(' ','',$cat["Name"])."'>" . $cat["Name"] . "</a>";
                                    echo "</li>";
                                }
                            ?>
                           
                        </ul>
                        <ul class="navbar-nav mb-2 mb-lg-0 text-uppercase">
                            <li class="nav-item mr-4">
                                <?php
                                //this is if the $_SESSION['user] is exists will get all that info this is in the init.php
                                    if ($userSession) { ?>
                                        <div class="dropdown session-user">
                                            <a class="dropdown-toggle text-uppercase" href="#" id="currencydropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class='far fa-smile mr-1'></i> <?php echo $userSession;?></a>
                                            <ul class="dropdown-menu" aria-labelledby="currencydropdown">
                                                <li>
                                                    <a class="dropdown-item text-uppercase" href="profile.php?do=accountSettings">Edit profile</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-uppercase" href="logout.php">logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                <?php
                                    } else {?>
                                    <a id="loginOut" href='#' class='nav-link logClick' aria-current='page'><i class='far fa-user mr-2'></i> login / signup</a>
                                <?php       
                                    }
                                ?>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#"><i class="fas fa-search mr-2"></i> search</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            </div>
    </section>
    <?php 
        /*
===============================================================================
    ----------------------------> End Navbar <-------------------------
===============================================================================
        */
        include "login.php";
     ?>
