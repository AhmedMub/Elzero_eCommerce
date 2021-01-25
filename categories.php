<?php

session_start();

$pageTitle = "Categories";

include "init.php"; ?>

<?php //this is in order for the nav intersect to work?>
<div id="catIntersect"></div>

<section class="headingSec <?php echo $_GET["catname"];?>">
    <div class="container-xxl">
        <div class="heading">
            <h1 class="text-center"><?php echo $_GET["catname"];?></h1>
            <a href="index.php"><span><i class="fas fa-home mr-1"></i><i class="fas fa-chevron-right mr-2"></i></span><span id="navIntersect"><?php echo $_GET["catname"];?></span></a>
        </div>
    </div>
</section>
<section class="items">
        <div class="container-xxl">
            <div class="AllItems_st">
                <div class="row">
                    <?php 
                    $catId = $_GET['pageId'];
                        foreach(fetchItems3($catId) as $item) { ?>

                            <div class="col-lg-2 col-md-4 col-sm-6 mt-4">
                                <div class="card-item-ad">
                                    <a href="items.php?itemId=<?php echo $item['Item_ID']?>" target="_blank"><img src="layout/images/items/bag.jpg" class="card-img-top" alt=""></a>
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="items.php?itemId=<?php echo $item['Item_ID']?>" target="_blank"><?php echo $item["Name"]?></a></h5>
                                        <p class="price"><?php echo $item["Price"]?></p>
                                        <span class="reviews">
                                                <span>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                </span>
                                                <span>(reviews)</span>
                                        </span>
                                        <div class="cardBtn">
                                            <a href="items.php?itemId=<?php echo $item['Item_ID']?>" target="_blank"><button>add to cart</button></a>
                                           <div>
                                                <a href="items.php?itemId=<?php echo $item['Item_ID']?>" target="_blank"><i class="far fa-heart"></i></a>
                                                <a href="items.php?itemId=<?php echo $item['Item_ID']?>" target="_blank"><i class="fas fa-search"></i></a>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>
</section>



<?php include $templets . "footer.inc.php";?>
