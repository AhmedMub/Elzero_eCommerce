<?php

ob_start();

session_start();

$pageTitle = "Items";

include "init.php";

    //check the request because it must has an item id
    $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;


    //display approved item info in here
    $stmt = $db->prepare("SELECT 
                                    I.*, C.Name AS categoryName, U.Username AS userUsername 
                                FROM 
                                    `items` I 
                                INNER JOIN 
                                    `categories` C 
                                ON 
                                    C.ID = I.Cat_ID 
                                INNER JOIN 
                                    `users` U 
                                ON 
                                    U.UserID = I.Member_ID

                                WHERE 
                                    I.Item_ID = ?
                                AND 
                                    I.Approve = 1
                                ");
    
    $stmt->execute(array($itemId));

    $itemInfo = $stmt->fetch();

    $rowCheck = $stmt->rowCount();

    //check if the itemId is in the DB
    if ($rowCheck != 0) { // if the item exists in the Db the info will be displayed as below?>

       
       <section class="item-info">
       <div class="item-overlay dis-none"></div>
            <div class="container-xxl">
                <div class="row">

                <!-- ============================================ Start All Info Wrapper -->
                    <div class="col-xl-10">
                        <div class="all-info-wrapper">
                            <!-- ============================================ start itemInfo -->
                            <div class="item-info-cont">
                                <div class="row g-0">
                                    <div class="col-lg-6 col-sm">
                                        <div class="item-img">
                                            <div class="zoomWrapper">
                                                <div id="mainImg">
                                                    <a href="layout/images/items/product-1.jpg">
                                                        <img src="layout/images/items/product-1.jpg">
                                                    </a>
                                                </div>

                                                <div id="galleryImgs">
                                                    <a href="layout/images/items/product-1.jpg" 
                                                        class="active">
                                                        <img src="layout/images/items/product-1.jpg"/>
                                                    </a>
                                                    <a href="layout/images/items/product-1_2.jpg">
                                                        <img src="layout/images/items/product-1_2.jpg"/>
                                                    </a>
                                                    <a href="layout/images/items/product-1_3.jpg"> 
                                                        <img src="layout/images/items/product-1_3.jpg"/>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm">
                                        <div class="each-item-info">
                                            <div class="itemCatInfo">
                                                <a href="categories.php?pageId=<?php echo $itemInfo['Cat_ID'] . '&catname=' . $itemInfo['categoryName'];?>" class="mr-1"><i class="fas fa-home"></i></a>
                                                <span class="mr-1"><i class="fas fa-chevron-right"></i></span>
                                                <a href="categories.php?pageId=<?php echo $itemInfo['Cat_ID'] . '&catname=' . $itemInfo['categoryName'];?>" class="mr-1"><?php echo $itemInfo['categoryName']?></a>
                                                <span class="mr-1"><i class="fas fa-chevron-right"></i></span>
                                                <span>details</span>
                                            </div>
                                            <h2><?php echo $itemInfo['Name']?></h2>
                                            <div class="itemMadInfo">
                                                <span>sku: </span>
                                                <span>1612043</span>
                                                <span>made in: </span>
                                                <span><?php echo $itemInfo['Country_Made'];?></span>
                                            </div>
                                            <p class="price"><?php echo $itemInfo['Price'];?></p>
                                            <div class="reviews">
                                            <span class="itemRate" data-itemrate="<?php echo calcItemAverageRevs($itemId);?>">
                                                
                                            </span>
                                            <span>(<?php echo countRev($itemId) . " reviews";?>)</span>
                                            </div>
                                            <p class="overview"><?php echo $itemInfo['Item_Overview']?></p>
                                            <div class="item-clrs">
                                                colors:
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                            <div class="item-sizes">
                                                sizes:
                                                <span>s</span>
                                                <span>l</span>
                                                <span>xl</span>
                                                <span>2xl</span>
                                                <a href="#">size guide</a>
                                            </div>
                                            <div class="product-form">
                                                <div class="input-group">
                                                    <span>qta:</span>
                                                    <button  class="cart-qty-btn minus"><i class="fas fa-minus"></i></button>
                                                    <input type="number" name="qta" value="1">
                                                    <button class="cart-qty-btn plus"><i class="fas fa-plus"></i></button>
                                                    <button class="cartBtn"><i class="fas fa-cart-plus"></i> add to cart</button>
                                                </div>
                                            </div>
                                            <div class="input-group wish-compare">
                                                <div class="socialIcons">
                                                    <a href="#"><span><i class="fab fa-facebook-f"></i></span></a>
                                                    <a href="#"><span><i class="fab fa-twitter"></i></span></a>
                                                    <a href="#"><span><i class="fab fa-youtube"></i></span></a>
                                                </div>
                                                <a href="#" class="wishList"><i class="far fa-heart"></i><span> add to wish list</span></a>
                                                <a href="#" class="compare"><i class="fas fa-random"></i></i><span>add to compare</span></a>
                                            </div>
                                            <div class="product-disc">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">description</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">shipping&returns</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">reviews</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                        <p>
                                                            <?php echo $itemInfo['Description']?>
                                                        </p>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                        <h4>free shipping</h4>
                                                        <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a></p>
                                                    </div>
                                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                    <div class="ifNoRev">
                                                        <p>there is no reviews yet!</p>
                                                    </div>
                                                    <div class="all-cm">
                                                        <a href="#" class="see-all-cm"><i class="far fa-comment-alt fa-lg mr-1"></i> see all comments</a>
                                                        <span class="hr"></span>
                                                    </div>
                                                    <?php
                                                        $latestComments = getLatestWebAll($itemId);
                                                        foreach ($latestComments as $comment) {?>
                                                            <div class="comment">
                                                                <div class="row g-0">
                                                                    <div class="col-2">
                                                                        <div class="commenter">
                                                                            <a href="#"><img src="layout/images/commenter1.png" alt=""></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-10">
                                                                        <div class="commenter-rev">
                                                                            <div class="cm-heading">
                                                                                <div class="row">
                                                                                    <div class="col-8">
                                                                                        <div class="cm-h">
                                                                                            <h5>
                                                                                                <?php echo $comment['user_name'];?>
                                                                                            </h5>
                                                                                            <span>
                                                                                                <?php echo $comment['comment_date'];?>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="cm-rev">
                                                                                            <span class="itemRating" data-rate="<?php echo $comment['ratings'];?>">  
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <p>
                                                                                <?php echo $comment['comment'];?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <span class="hr"></span>
                                                            </div>
                                                        <?php
                                                        } 
                                                            if (isset($_SESSION['user'])) { ?>
                                                            <div class="add-comment">
                                                                <div id="successOrFail-MSG"></div>
                                                                <h3>add review</h3>
                                                                <p>Your email address will not be published. Required fields are marked *</p>
                                                                <form action="comments.php" method="POST" id="Add-New-Rev">
                                                                    <input type="hidden" name="itemId" value="<?php echo $itemInfo['Item_ID'];?>">
                                                                    <input type="hidden" name='RevUser' value="<?php echo $_SESSION['user'];?>">
                                                                    <div class="mb-3">
                                                                        <span class="text-capitalize">your rating:</span>
                                                                        <select id="per-rate" name="rating" required>
                                                                            <option value="1"><i class="far fa-star"></i></option>
                                                                            <option value="2"><i class="far fa-star"></i></option>
                                                                            <option value="3"><i class="far fa-star"></i></option>
                                                                            <option value="4"><i class="far fa-star"></i></option>
                                                                            <option value="5"><i class="far fa-star"></i></option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <textarea class="form-control" placeholder="Your Comment *" name="per_comment" cols="30" rows="10" required></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <button type="submit" class="sumitRev">
                                                                        submit
                                                                        <i class="fas fa-long-arrow-alt-right ml-1"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        <?php   
                                                        } else {?>
                                                            <div class="want-add-rev">
                                                            <a href="#" class="logClick">
                                                                add a review?
                                                                <button>login!<i class="fas fa-sign-in-alt ml-1"></i></button>
                                                            </a>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================ end itemInfo -->
                            <!-- ============================================ start featured items -->
                           <div class="featured-item">
                           
                                <h2>featured items</h2>

                                <div class="myProducts">
                                    <div class="glide__track" data-glide-el="track">
                                        <ul class="glide__slides">
                                            <?php 
                                                foreach(getLatestWeb("*", "items", "Item_ID", 10) as $item) { ?>
                                                    <li class="glide__slide">
                                                        <div class="card-item-ad">
                                                            <div class="card-image">
                                                                <a href="#">
                                                                    <img src="layout/images/items/bag.jpg" class="card-img-top" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="card-title"><a href="items.php?itemId=<?php echo $item['Item_ID']?>" target="_blank"><?php echo $item["Name"]?></a></h5>
                                                                <p class="price"><?php echo $item["Price"]?></p>
                                                                <div class="reviews">
                                                                    <span class="itemRate" data-itemrate="<?php echo calcItemAverageRevs($item["Item_ID"]);?>">
                                                                    </span>
                                                                    <span>(<?php echo countRev($item["Item_ID"]) . " reviews";?>)</span>
                                                                </div>
                                                                <div class="cardBtn">
                                                                    <a href="#"><button>add to cart</button></a>
                                                                    <div>
                                                                        <a href="#"><i class="far fa-heart"></i></a>
                                                                        <a href="#"><i class="fas fa-search"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                           </div>
                        <!-- ============================================ end featured items -->       
                        </div>
                    </div>
                    <!-- ============================================ end All Info Wrapper -->
                    <!-- ============================================ Start aside info -->
                    <aside class="col-xl-2 aside">
                        <!-- ============================================ Start payment info -->
                        <div class="aside-info">
                           <div class="delivery-Info">
                                <div class="dev-info-each">
                                    <span class="icon-del-info"><i class="fas fa-shield-alt fa-2x"></i></span>
                                    <div class="icon-del-info">
                                        <h5>secured payment</h5>
                                        <p>we ensure secure payment</p>
                                    </div>
                                </div>
                                <div class="dev-info-each">
                                    <span class="icon-del-info"><i class="fas fa-shipping-fast fa-2x"></i></span>
                                    <span class="icon-del-info">
                                        <h5>free shipping</h5>
                                        <p>On all US orders above $99</p>
                                    </span>
                                </div>
                                <div class="dev-info-each">
                                    <span class="icon-del-info"><i class="fas fa-hand-holding-usd fa-2x"></i></span>
                                    <span class="icon-del-info">
                                        <h5>money back guarantee</h5>
                                        <p>Any back within 30 days</p>
                                    </span>
                                </div>
                           </div>
                           <!-- ============================================ start offer sale -->
                           <div class="sticky-aside">
                           <div class="sti-tst">
                                <div class="sale-offer">
                                    <p class="sale-date">12-20<sup>th</sup> july</p>
                                    <div class="sale-info">
                                        <h3>ultimate sale</h3>
                                        <h2>up to 70%</h2>
                                        <p>discount selected items</p>
                                        <a href="#">shop now<i class="fas fa-long-arrow-alt-right ml-1"></i></a>
                                    </div>
                                </div>
                                <!-- ============================================ end offer sale -->
                                <!-- ============================================ start featured items -->
                                <div class="aside-featured">
                                    <div class="aside-fe-items">
                                        <h4>our featured</h4>
                                        <div class="glide-aside-fe">
                                            <div class="glide__track" data-glide-el="track">
                                                <ul class="glide__slides">
                                                    <li class="glide__slide">
                                                        <?php 
                                                        foreach (getLatestAsideOne("*","items", "Item_ID", 3) as $item) {?>

                                                        <div class="item-cont-aside">
                                                            <figure class="asi-img">
                                                                <a href="#">
                                                                    <img src="layout/images/items/aside-item.jpg" alt="asideItem">
                                                                </a>
                                                            </figure>
                                                            <div class="asi-info">
                                                                <h5><?php echo $item['Name']?></h5>
                                                                <p class="aside-price"><?php echo $item['Price']?></p>
                                                                <div class="aside-rev">
                                                                    <div class="reviews">
                                                                        <span class="itemRate" data-itemrate="<?php echo calcItemAverageRevs($item["Item_ID"]);?>">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php   
                                                        }
                                                        ?>
                                                    </li>
                                                    <li class="glide__slide">
                                                        <?php 
                                                        foreach (getLatestAsideTwo("*","items", "Item_ID", 3) as $item) {?>

                                                        <div class="item-cont-aside">
                                                            <figure class="asi-img">
                                                                <a href="#">
                                                                    <img src="layout/images/items/aside-item.jpg" alt="asideItem">
                                                                </a>
                                                            </figure>
                                                            <div class="asi-info">
                                                                <h5><?php echo $item['Name']?></h5>
                                                                <p class="aside-price"><?php echo $item['Price']?></p>
                                                                <p class="aside-rev">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i> 
                                                                    <i class="fas fa-star"></i> 
                                                                    <i class="fas fa-star"></i> 
                                                                    <i class="far fa-star"></i>  
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php   
                                                        }
                                                        ?>
                                                    </li>
                                                    <li class="glide__slide">
                                                        <?php 
                                                        foreach (getLatestAsideThree("*","items", "Item_ID", 3) as $item) {?>

                                                        <div class="item-cont-aside">
                                                            <figure class="asi-img">
                                                                <a href="#">
                                                                    <img src="layout/images/items/aside-item.jpg" alt="asideItem">
                                                                </a>
                                                            </figure>
                                                            <div class="asi-info">
                                                                <h5><?php echo $item['Name']?></h5>
                                                                <p class="aside-price"><?php echo $item['Price']?></p>
                                                                <p class="aside-rev">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i> 
                                                                    <i class="fas fa-star"></i> 
                                                                    <i class="fas fa-star"></i> 
                                                                    <i class="far fa-star"></i>  
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php   
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="glide__arrows" data-glide-el="controls">
                                                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                                                    <i class="fas fa-angle-left"></i>
                                                </button>
                                                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                                                    <i class="fas fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- ============================================ End featured items -->
                        </div>
                        <div class="side-ctrl-open visible-icn">
                            <span><i class="fas fa-align-right"></i></span>
                        </div>
                        <div class="side-ctrl-close dis-none">
                            <span><i class="fas fa-times"></i></span>
                        </div>
                        <!-- ============================================ end payment info -->
                    </aside>
                    <!-- ============================================ end aside info -->
                </div>
            </div>
            <div id="itemsIntersect"></div>
       </section>

       <!-- The Gallery as lightbox dialog-->
        <div
        id="blueimp-gallery"
        class="blueimp-gallery blueimp-gallery-controls"
        aria-label="image gallery"
        aria-modal="true"
        role="dialog">
            <div class="slides" aria-live="polite"></div>
            <h3 class="title"></h3>
            <a
                class="prev"
                aria-controls="blueimp-gallery"
                aria-label="previous slide"
                aria-keyshortcuts="ArrowLeft"
            ></a>
            <a
                class="next"
                aria-controls="blueimp-gallery"
                aria-label="next slide"
                aria-keyshortcuts="ArrowRight"
            ></a>
            <a
                class="close"
                aria-controls="blueimp-gallery"
                aria-label="close"
                aria-keyshortcuts="Escape"
            ></a>
            <a
                class="play-pause"
                aria-controls="blueimp-gallery"
                aria-label="play slideshow"
                aria-keyshortcuts="Space"
                aria-pressed="false"
                role="button"
            ></a>
            <ol class="indicator"></ol>
        </div>


    <?php
    } else {
        $msg = "there is no such item id";
        homeRedirect($msg);
    }


include $templets . "footer.inc.php"; 

ob_flush();
?>
