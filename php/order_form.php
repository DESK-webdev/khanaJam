<?php
    session_start();
    include "components/main.php";
    include 'components/dataset.php';
    include 'components/component.php';
    $account=new accounts;
    $getdata=new getdata;
    $logged=1;
    if(!($account->all_check())){
      $logged=0;
      die("please login");
    }
    if(!$_GET['food_id']){
        // die("no food selected");
    }
    else{
        if($_GET['confirm']=="confirmed"){ 
            $putdata=new putdata;
            $response=$putdata->order(json_encode($_GET));
        }
        $food=$getdata->getdata_list_food("food_local.id",$_GET['food_id'])->fetchObject();  
    }
    $similar=$getdata->getdata_list_food("food_global.category","%$food->category%");
    $plate=new plates;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Font Awesome Import Start -->
        <link crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" rel="stylesheet"/>
        <!-- Font Awesome Import End -->
        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="/css/style.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/css/navbar.css">
        <title>Order Form | KhanaJam</title>
    </head>
    <body>
        <!-- order-form starts -->
        <?php include 'navbar.php'; ?>
        <div class="order-container">
            <h2>Order Food</h2>
            <div class="actual-order-container">
                <!-- Product work starts-->
                  <?php $plate->plate_food_bc_1($food); ?>
                <!-- Product work ends -->
                <div class="order-form" id="order-form">
                <?php
                    if($response){
                        $i=0;
                        while($response[$i]){
                            echo $response[$i]."<br>";
                            $i++;
                        }
                    }
                ?>
                    <form action="" method="GET">
                        <input type="hidden" name="confirm" value="confirmed">
                        <input type="hidden" name="food_id" value="<?=$food->foodid?>">
                        <span>
                            <label for="time to arrive">Ready food in</label>
                            <input name="time" type="time" value="<?=date("H:i",time());?>" required/>
                            <output id="time">0</output>
                            &nbsp; Minutes
                        </span>
                        <br/>
                        <!-- <span>
                            <label for="No. of Plates">No of Plates</label>
                            <input max="10" min="0" name="quantity" oninput="plates.value = this.value" step="1" type="range" value="0"/>
                            <output id="plates">0</output>
                            &nbsp; Plates
                        </span> -->
                        <span>
                            <label for="quantity">Quantitiy</label>
                            <select id="" name="quantity" required>
                                <option value="0.5">Half</option>
                                <option value="1">Full</option>
                            </select>
                        </span>

                        <span>
                            <button class="button" type="submit">
                                Add to cart
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </span>
                    </form>
                    <button class="button cancel">
                        Cancel
                        <i class="far fa-window-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <hr/>
        <div class="body-food-sction">
            <h3>More Foods Like this</h3>
            <!-- How food is displayed section for grid works -->
            <div class="food-grid-display">
                <!-- Product work starts-->
                <?php
                    while($arg=$similar->fetchObject()){
                        $plate->plate_food_bc_1($arg);
                    }
                ?>
                <!-- Product work ends -->
            </div>
            <input class="button" type="button" value="Browse all foods!">
            <hr>
        </div>
        <!-- order-form ends -->
    </body>
</html>
