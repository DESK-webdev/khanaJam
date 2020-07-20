<?php
 session_start();
  include "components/main.php";
  include 'components/dataset.php';
  include 'components/component.php';
  $account=new accounts;
  $logged=1;
  if(!($account->all_check())){
    $logged=0;
    die("please login");
  }
  $data=new getdata;
  $own=0;
  $who=0;
  $as_customer=0;
  if($_GET['who']){
    if($_GET['who']==$_SESSION['public_id']){
      $as_customer=1;
      $own=1;
    }
    $who=$_GET['who'];
  }
  else{
    $own=1;
    $who=$_SESSION['public_id'];
  }
  if(!($user=$data->getdata_profile($who))){
    die("something wrong");
  }
  $plate=new plates;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Font Awesome Import Start -->
    <link
      crossorigin="anonymous"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      rel="stylesheet"
    />
    <!-- Font Awesome Import End -->
    
    <link href="/css/profile.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/profile.css">
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KhanaJam | <?=$user->fname." ".$user->lname;?></title>
  </head>
  <body>
  <?php
    include 'navbar.php';
  ?>
    <div class="profile-container">
      <div class="profile-upper-box">
        <div class="profile-image-box" id="<?=$user->type;?>">
          <!-- Here id is either customer or hotel, there is css like #customer or #hotel, so use variable like that -->
          <img alt="$(profile.name) Image" src="/assets/hotel.jpg" />
        </div>
        <div class="profile-details-box" id="<?=$user->type;?>">
          <div class="profile-details-box-left">
            <ul>
              <li>
                <i class="far fa-user"></i>
                <?=$user->fname." ".$user->lname;?>
              </li>
              <li>
                <i class="fas fa-phone-alt"></i>
                <?=$user->phone;?>
              </li>
              <li>Other Details</li>
        <?= $_SESSION['public_id']=="pending"?"register hotel:<a href='hotel_form.php'>register</a>":"public id=".$_SESSION['public_id']; ?>
            </ul>
          </div>
          <div class="profile-details-box-right">
            <span class="message-edit">
            <?php
                if($own && !$as_customer){
                  echo '<div class="edit">
                          <a>
                            <i class="fas fa-user-edit">Edit</i>
                          </a>
                        </div>';
                }
                else{
                  if($as_customer){
                    echo "its what customer sees.<br><a href=\"profile.php\">goto main profile</a>";
                  }
                  echo '<div class="message">
                          <a>
                            <i class="far fa-envelope">Message</i>
                          </a>
                        </div>';
                }
              ?>
            </span>
          </div>
        </div>
      </div>
      <div class="profile-next-upper-box">
        <div class="Food-display-section-1">
          <?=($user->type[0]=="h")?"<h3>Top Sell of the Week</h3>":"<h3>Last Ordered Foods</h3>"; ?>
          <div class="food-grid-display">
            <?php
            if($food=$data->getdata_list_food("food_local.id","%".$who."%")){
              while($arg=$food->fetchObject()){
                $plate->plate_food_bc_1($arg);
              }
            }
            ?>
          </div>
        </div>
        <div class="Food-display-section-1">
        <?=($user->type[0]=="h")?"<h3>Top Sell of the anytime</h3>":"<h3>Last Ordered Foods</h3>"; ?>
          <div class="food-grid-display">
            <?php
              for($i=0;$i<=3;$i++){
                $plate->plate_food_bc_1();
              }
      ?>
          </div>
        </div>
               <!-- Start of Tranisition table -->
              
      <div class="all-transition">
        <h3>All Your Tranisitions</h3>
        <div class="all-tranisition-table">
          <table>
            <tr>
              <th>S.N</th>
              <th>TimeStamp</th>
              <th>Food Name</th>
              <th>Hotel</th>
              <th>Total Price</th>
              <th>Status</th>
            </tr>
            <tr>
              <td> 1
              <td>2019-05-06 / 12:55:26</td>
              <td>Pizza</td>
              <td>Bibek Hotel And Restaurant</td>
              <td>Rs. 2000</td>
              <td> Completed</td>
            </tr>
            <tr>
                <td> 1
                <td>2019-05-06 / 12:55:26</td>
                <td>Pizza</td>
                <td>Bibek Hotel And Restaurant</td>
                <td>Rs. 2000</td>
                <td> 
                    Completed</td>
              </tr>
              <tr>
                <td> 1
                <td>2019-05-06 / 12:55:26</td>
                <td>Pizza</td>
                <td>Bibek Hotel And Restaurant</td>
                <td>Rs. 2000</td>
                <td> Completed</td>
              </tr>
              <tr>
                <td> 1
                <td>2019-05-06 / 12:55:26</td>
                <td>Pizza</td>
                <td>Bibek Hotel And Restaurant</td>
                <td>Rs. 2000</td>
                <td> Completed</td>
              </tr>
          </table>
        </div>
      </div>
      </div>
    </div>
    <?php
      include 'footer.html';
    ?>
  </body>
</html>
