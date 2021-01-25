<?php

ob_start();

session_start();

$pageTitle = "Profile";

include "init.php";

//this page depends on the session[user] if exists which means that user logged in if its not and someone tried to writing the direct link to it, will be directed to the login.php page
if (isset($_SESSION['user'])) {

    $do = isset($_GET['do']) ? $_GET['do'] : "accountSettings";

    //this query to get user information based on the username
    $stmt = $db->prepare("SELECT * FROM users WHERE Username = ?");

    $stmt->execute(array($userSession));

    $userInfo = $stmt->fetch();


?>
<section class="profile_heading">
    <div class="container-xxl">
        <div class="heading">
            <h1 class="text-center">my account</h1>
            <a href="index.php"><span><i class="fas fa-home mr-1"></i><i class="fas fa-chevron-right mr-2"></i></span><span id="navIntersect">my account</span></a>
        </div>
    </div>
</section>
<section class="profile">
    <div class="container">
        <div class="row">
            <div class="offset-sm-1 col-sm-2">
                <div class="left">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="icon"><i class="fas fa-user fa-2x"></i></div>
                        </div>
                        <div class="col-sm-10">
                            <div class="info-user">
                                <h4><?php echo $userInfo['FullName'];?></h4>
                                <span><?php echo $userInfo['Email'];?></span>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="?do=Orders">my orders</a></li>
                        <li class="list-group-item"><a href="?do=Shipping-Addresses">shipping addresses</a></li>
                        <li class="list-group-item"><a href="?do=Recommended">recommended</a></li>
                        <li class="list-group-item"><a href="?do=MyAds">My Ads</a></li>
                        <li class="list-group-item"><a href="?do=createAds">create new ad</a></li>
                        <li class="list-group-item"><a href="?do=Latest-Comments">latest comments</a></li>
                        <li class="list-group-item"><a href="?do=accountSettings">account settings</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="right">
                    <?php
                        if ($do == "accountSettings") {?>
                            
                            <h2>account settings</h2>
                            <div class="info">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="card-body">
                                                <h5 class="card-title">Account Information</h5>
                                                <div class="card-text">
                                                    <p class="text-capitalize">be carful. do not share your information with anyone</p>
                                                    <p class="text-capitalize"><span>username:</span> <span><?php echo $userInfo['Username']?></span></p>
                                                    <p class="text-capitalize"><span>email:</span> <span><?php echo $userInfo['Email']?></span></p>
                                                    <p class="text-capitalize"><span>password:</span> <span>*********</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 text-center">
                                            <a href="#"><button class="mt-3">edit</button></a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php
                        } elseif ($do == "Shipping-Addresses") {?>
                            <h2>shipping addresses</h2>
                            <div class="info">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="card-body">
                                                <h5 class="card-title">your addresses</h5>
                                                <div class="card-text">
                                                    <p class="text-capitalize">there is no addresses</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 text-center">
                                            <a href="#"><button class="mt-3">Add Address</button></a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php
                        } elseif ($do == "Recommended") {?>
                            <h2>Recommended</h2>
                            <div class="info">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="card-body">
                                                <h5 class="card-title">buy it again</h5>
                                                <div class="card-text">
                                                    <p class="text-capitalize">Make sure to buy your groceries and daily needs</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 text-center">
                                            <a href="index.php"><button class="mt-3">buy now</button></a>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php
                        } elseif ($do == "Orders") { ?>
                            <h2>track your orders</h2>
                            <div class="info">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-capitalize">there is no orders</h5>
                                    </div>
                                </div> 
                            </div>
                        <?php    
                        } elseif ($do == "MyAds") {  ?>
                            <div class="row">
                                <h2>my ads</h2>
                               <?php 
                               foreach (fetchItems2("Member_ID", $userInfo['UserID']) as $item) {?>

                                <div class="col-md-3 col-sm-6 mt-4">
                                    <div class="info <?php
                                        if ($item['Approve'] == 1) {
                                            echo 'info-live';
                                        } else {
                                            echo "info-notLive";
                                        }
                                    ?>">
                                        <div class="card card-item-ad">
                                            <img src="layout/images/items/bag.jpg" class="card-img-top" alt="">
                                            <div class="card-body">
                                                <h5 class="card-title"><a href="#"><?php echo $item['Name'];?></a></h5>
                                                <p class="price"><?php echo $item['Price'];?></p>
                                                <span class="reviews">data</span>
                                                <div class="cardBtn">
                                                    <a href="#"><button>add to cart</button></a>
                                                    <div>
                                                        <a href="#"><i class="far fa-eye"></i></a>
                                                        <a href="#"><i class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </div>                                        
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            <?php
                                } 
                        } elseif ($do == "createAds") { ?>

                            <h2>create new ad</h2>
                            <div id="createAddError"><div class="error-wrapper-success">ss</div></div>
                            <div class="info">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="card-body">
                                                <h5 class="card-title">create ad here</h5>
                                                <form action="newItem_validation.php" method="POST" id="createItem"> 
                                                <input type="hidden" name="id" value="<?php echo $userInfo['UserID'] ?>">               
                                                    <div class="mb-3">
                                                        <label class="form-label">Item Name</label><span class="asterisk">*</span>
                                                        <input type="text" name="item-name" class="form-control Item_newName" placeholder="Write Item Name" id="live-title" >
                                                        <span class="validate_newItem"></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Item Description</label><span class="asterisk">*</span>
                                                        <input type="text" name="item-description" class="form-control" placeholder="Write Item Description">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Item Price</label><span class="asterisk">*</span>
                                                        <input type="text" name="item-price" class="form-control" value="$ " id="live-price" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Item Country Of Made</label><span class="asterisk">*</span>
                                                        <input type="text" name="item-madeIn" class="form-control" placeholder="Write Item Price">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Item Status</label><span class="asterisk">*</span>
                                                        <select name="item-status" class="form-select">
                                                            <option value="0" selected>.....</option>
                                                            <option value="1">New Item</option>
                                                            <option value="2">Used Item</option>
                                                            <option value="3">Old</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Category</label><span class="asterisk">*</span>
                                                        <select name="item-category" class="form-select">
                                                            <option value="0" selected>.....</option>
                                                            <?php
                                                                $stmt = $db->prepare("SELECT * FROM categories");
                                                                
                                                                $stmt->execute();

                                                                $catsFetched = $stmt->fetchAll();

                                                                foreach ($catsFetched as $cat) {
                                                                    echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] . "</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="submit" class="btn btn-primary" value="Save">
                                                    </div>
                                                </form> 
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card card-item-ad card-fix-wd">
                                                <img src="layout/images/items/bag.jpg" class="card-img-top" alt="">
                                                <div class="card-body">
                                                    <h5 class="card-title" id="pre-title"></a></h5>
                                                    <p class="price" id="pre-price"></p>
                                                    <span class="reviews">reviews</span>
                                                    <div class="cardBtn">
                                                        <a href="#"><button>add to cart</button></a>
                                                        <div>
                                                            <span><i class="far fa-heart"></i></span>
                                                            <span><i class="fas fa-search"></i></span>
                                                        </div>
                                                    </div>                                        
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div> 
                            </div>

                        <?php
                        } elseif ($do == "Latest-Comments") { ?>
                            <h2>latest comments</h2>
                            <div class="info">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-capitalize">there is no comments</h5>
                                    </div>
                                </div> 
                            </div>
                        <?php
                        } else {
                            $errorMsg = "there is no such page";
                            homeRedirect($errorMsg);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
} else {
    header("location:login.php");
    exit();
}

include $templets . "footer.inc.php";

ob_flush();
?>