<?php
    session_start();
    include 'components/component.php';
    include 'components/main.php';
    $account=new accounts;
    $logged=0;
    if(($account->all_check())>0){
      $logged=1;
    }
    if($_GET['food_id']){
        $getdata=new getdata;
        $food=$getdata->getdata_food($_GET['food_id']);
        if(!$food){
            $food->name="food not found";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Font Awesome Import Start -->
    <link crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" rel="stylesheet"/>
    <!-- Font Awesome Import End -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/food-profile.css">
    <title>Food Profile</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="food-profile-container">
        <div class="food-description-section">
            <div class="food-description-section-left">
                <img src="/assets/header.jpg" alt="">
                <h4>
                    <i class="fas fa-hotel"></i><a href="<?=$food->hotelid?>"><?=$food->hotelname?></a>
                </h4>
                <h4>
                    <i class="fas fa-map-marked"></i><?=$food->location?>
                </h4>
            </div>
            <div class="food-description-section-left">
                <h4>
                    <i class="fas fa-pizza-slice"></i><?=$food->name." ".$food->parentname?>
                </h4>
                <h4>
                    <i class="fas fa-star"></i><?=$food->rating?>
                </h4>
                <h4>
                    category:<?=$food->category?>
                </h4>
                <h4>
                    price:<?=$food->price?></h4>
                <h4>
                    ready in <?=$food->ready_time?> minutes
                </h4>
                <h4>
                    food id=<?=$food->id?>
                </h4>
                <h4>
                    <?=($food->id)?"<a href=\"order_form.php?food_id=$food->id\">
                                    <button class=\"bag-btn order\" >
                                        <i class=\"fas fa-shopping-cart\"></i>
                                            Order Now
                                    </button>
                                    </a>":""?>
                </h4>
                <p><?=$food->bio?></p>
            </div>
        </div>
        <hr>
        <div class="search-body">
            <h3>Search Foods & hotels</h3>
            <div class="search">
                <input class="Search" id="" name="Search-foods-hotels" placeholder="Search Hotels and Foods" type="text">
                <button class="button" type="submit">Search</button>
            </div>
        </div>
        <hr>
        <div class="customer-review-section">
            <div class="post-rating">
            <form action="" method="post">
                <span class="rating">
                    <label for="time to arrive"><h4>Rate it: </h4></label>
                    <input max="5" min="0" name="time to arrive" oninput="rating.value = this.value" step="0.5" type="range" value="0"/>
                    &nbsp;
                    <output id="rating"> 0 </output>
                    &nbsp;     <i class="fas fa-star"></i>
                </span>
                <span class="review">
                    <textarea name="" placeholder="Enter your Review" id="" cols="30" rows="10"></textarea>
                    <button type="submit" class="button">Post</button>
                </span>
            </form>
            </div>
        </div>
        <hr>
        <div class="previous-reviews-section">
            <div class="text-section">
                <h1>User Reviews</h1>
            </div>
            <div class="Review-and-provider">
                <div class="user">
                    <img alt="" src="/assets/user.png"/>
                    <h4 >Receiver.Name</h4>
                </div>
                    <h5>Given Rating</h5>
                                               
        
                <div class="review-text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, veniam odit praesentium quaerat ut illo, eos nostrum modi accusamus, natus quas. Aliquam officiis quos architecto optio. Autem vel repellendus quis.</p>
                </div>
            </div>  
            </div>
        </div>
    </div>
</body>
</html>