
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle();?></title>
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>main_style.css?var=<?php echo rand(5000, 10000);?>">
    <?php 
    // these to display separate css files for each main page I have, so if I'm in the members.php the members.css and main_style.css only going to work and etc.. 
    if (basename($_SERVER['PHP_SELF']) == "members.php") { ?>
        
        <link rel="stylesheet" href="<?php echo $css;?>members.css?var=<?php echo rand(1000, 9000);?>">
    <?php
     } elseif (basename($_SERVER['PHP_SELF']) == "categories.php") { ?>
       
        <link rel="stylesheet" href="<?php echo $css;?>categories.css?var=<?php echo rand(1000, 9000);?>">
     <?php
     } elseif (basename($_SERVER['PHP_SELF']) == "items.php") { ?>

        <link rel="stylesheet" href="<?php echo $css;?>items.css?var=<?php echo rand(1000, 9000);?>">
    <?php
     } ?>
     
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Langar&display=swap" rel="stylesheet">
</head>
<body>

    