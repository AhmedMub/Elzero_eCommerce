
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle();?></title>
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>main_style.css?var=<?php echo rand(5000, 10000)?>">
    <?php if (basename($_SERVER['PHP_SELF']) == "members.php") { ?>

        <link rel="stylesheet" href="<?php echo $css?>members.css?var=<?php echo rand(1000, 9000)?>">

    <?php }?>
</head>
<body>

    