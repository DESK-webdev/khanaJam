<?php
  session_start();
  include 'components/component.php';
  include 'components/main.php';
  $account=new accounts;
  $logged=0;
  if(($account->all_check())>0){
    $logged=1;
  }
  $plate=new plates;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" rel="stylesheet"/>                                                                                        <!-- Google Fonts End -->
        <link href="/css/style.css" rel="stylesheet"/>
        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link rel="stylesheet" href="/css/navbar.css">
        <link rel="stylesheet" href="/css/footer.css">
        <title>KhanaJam | Home</title>
    </head>
<body>
<?php
  include 'navbar.php';
?>
<div class="container">
  <div class="upper-body">
    <div class="upper-body-left">
      <h2>Welcome to KhanaJam</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem in odio earum </p>
      <input type="button" value="Learn More" class="button">
    </div>
    <!-- <div class="upper-body-right">
      <img src="#" alt="right in to the fit" height="60px" width="60px">
    </div> -->
  </div>
  <div class="search-body">
    <h3>Search Foods & hotels</h3>
    <div class="search">
      <input type="text" name="Search-foods-hotels" placeholder="Search Hotels and Foods" id="" class="Search">
      <button type="submit" class="button">Search</button>
    </div>
  </div>
  <hr>
  <div class="body-food-sction">
    <h3>Top Sales of the week.</h3>
    <div class="food-grid-display">
      <?php
        for($i=0;$i<=3;$i++){
          $plate->plate_food_bc_1();
        }
      ?>
    </div>
    <input type="button" value="Browse all foods!" class="button">
    <hr>
    <div class="body-hotel-sction">
      <h3>Top Hotels of the Week.</h3>
      <div class="hotel-grid-display">
      <?php
        for($i=0;$i<=3;$i++){
          $plate->plate_hotel_bc_1();
        }
      ?>
      </div>
      <input type="button" value="Browse all Hotels!" class="button">
  </div>
</div>

  <!-- End of Main Body HTMl -->

  <!-- Import Footer.html  (Since this is same in all document,  a seperate html file has been made for this)-->
<?php
  include 'footer.html';
?>
    </body>
<script src="../js/script.js"></script>
<script src="../js/account.js"></script>
</html>
</html>
