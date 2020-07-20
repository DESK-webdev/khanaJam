<?php
    class components{
        public function div_login(){
            
        }

        public function div_signup(){

        }

    }

    class plates{
        public function plate_food_bc_1($food=""){
            // if($gdata){
            //     $data=json_decode($gdata);
            // }
                echo '<div class="overall-box">
                <div class="top-food">
                    <div class="plate food-1">
                        <img alt="Food-1" src="/assets/header.jpg"/>
                        <div class="overlay-details overlay-details-up">
                            <div class="food details">
                                <h4>'.$food->foodname.'</h4>
                                <h4>'.$food->rating.'</h4>
                            </div>
                            <div class="cart">
                                <a href="order_form.php?food_id='.$food->foodid.'">
                                    <button class="bag-btn order" >
                                        <i class="fas fa-shopping-cart"></i>
                                            Order Now
                                    </button>
                                </a>
                             <a href="food.php?food_id='.$food->foodid.'">
                                <button class="bag-btn view" data-id="1">
                                    <i class="fas fa-info-circle"></i>
                                    view-more
                                </button>
                             </a>
                            </div>
                        </div>
                        <div class="overlay-details overlay-details-down">
                            <div class="food details">
                                <h4><a href="profile.php?who='.$food->hotelid.'">'.$food->hotelname.'</a></h4>
                                <p>'.$food->location.'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        public function plate_hotel_bc_1($gdata=""){   ///gdata is object
            echo '<div class="overall-box">    
                    <div class="top-hotel">
                      <div class="plate  hotel-1">
                        <img src="/assets/hotel.jpg" alt="hotel-1">
                        <div class="overlay-details">
                          <div class="hotel details">
                            <h4>Address</h4>
                            <h4>Contact</h4>
                            <h4>Rating 1</h4>
                          </div>
                          <div class="cart">
                            <button class="bag-btn">
                              <i class="fas fa-utensils"></i>
                              Know more!
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>   
                </div>';
        }
    }
    class recents{
        public $status;
        public function recents(){
            $this->status=array("not seen","seen","pending","ok","unpaid","ok","dropped by hotel","ok","calcelled by customer","ok","paid","ok","success","ok");
        }
        public function row_child($data){
            if($data->status%2==1 && $data->status>1){
                $status=$data->status-1;
                $buttons=$this->status[$status]."(seen)";
            }
            if($data->status<=2){
                $buttons.=" <a href='myplates.php?action=cancel&order=$data->orderid'>cancel</a>";
            }
            if($data->status==6 || $data->status==4 || $data->status==10){
                $buttons.=" <a href='myplates.php?action=ok&order=$data->orderid'>ok</a>";
                $buttons.=" <a href='message.php?who=$data->hotelid'>message</a>";
            }
            if($data->status==5){
                $buttons.=" <a href='myplates.php?action=paid&order=$data->orderid'>paid</a>";
            }
            return ('   
                        <tr>
                            <td><a href="profile.php?who='.$data->hotelid.'">'.$data->hotelname.'</td>
                            <td>'.date("h-m a",$data->ordertime).'</td>
                            <td>'.date("h-m a",$data->comingtime).'</td>
                            <td>'.date("y-m-d",$data->ordertime).'</td>
                            <td>'.$data->foodname.'</td>
                            <td>'.$data->quantity.'</td>
                            <td>'.$data->price.'</td>
                            <td>
                                <div class="status">
                                '.$buttons.'
                                </div>
                            </td>
                        </tr>');
        }
        public function row_parent($data){
            if($data->status%2==1 && $data->status>1){
                $status=$data->status-1;
                $buttons=$this->status[$status]."(seen)";
            }
            if($data->status<=1){
                $buttons.=" <a href='myplates.php?action=sure&order=$data->orderid'>sure</a>";
                $buttons.=" <a href='myplates.php?action=drop&order=$data->orderid'>not available</a>";
            }
            if($data->status==2){
                $buttons.=" <a href='myplates.php?action=unpaid&order=$data->orderid'>unpaid</a>";
                $buttons.=" <a href='myplates.php?action=success&order=$data->orderid'>success</a>";
            }
            if($data->status==8){
                $buttons.=" <a href='myplates.php?action=ok&order=$data->orderid'>ok</a>";
                $buttons.=" <a href='message.php?who=$data->customerid'>message</a>";
            }
            return ('   
                        <tr>
                            <td><a href="profile.php?who='.$data->customerid.'">'.$data->customername.'</td>
                            <td>'.date("h-m a",$data->ordertime).'</td>
                            <td>'.date("h-m a",$data->comingtime).'</td>
                            <td>'.date("y-m-d",$data->ordertime).'</td>
                            <td>'.$data->foodname.'</td>
                            <td>'.$data->quantity.'</td>
                            <td>'.$data->price.'</td>
                            <td>
                                <div class="status">
                                '.$buttons.'
                                </div>
                            </td>
                        </tr>');
        }
        public function filter(){
            return('
                        <span>
                            <div class="filter">
                                <i class="fas fa-sort-amount-down-alt" title="Filter by"></i>
                                <select class="button" id="filter by" name="">
                                    <option class="button" value="date">By Date</option>
                                    <option class="button" value="hotel">By Hotel</option>
                                </select>
                            </div>
                        </span>');
        }
    }
    class getform{
            public function getform_addfood($list){
                echo '<form action="" method="GET">
                <span>
                    <input type="hidden" name="data" value="1">
                    <label for="GlobalFood">Food Category</label>
                    <select name="global" id="">';
                        while($show=$list->fetch(PDO::FETCH_OBJ)){
                            echo "<option value='$show->id'>".main_class::sql_dfilter($show->name)."</option>";
                        }
                echo '</select>
                </span>
                <input type="text" name="name" placeholder="enter its varity(like veg,buff)" id="">
                    <span>                
                        <input type="number" name="price" placeholder="Price Per Plate" id="time-price" min="0">
                        <input type="number" name="time" placeholder="Normal Time to Cook" id="time-price" min="5">
                    </span>
                    <span>
                        <label for="ImageofFood">Sample Image of Food:</label>
                        <input type="image" id="image" src="/assets/file-image-regular.svg" alt="">
                    </span>
                <textarea name="bio" placeholder="Enter Description" id="" cols="30" rows="10"></textarea>
                <button type="submit" class="button">Sumbit</button>
            </form>';
            }
            public function getform_hotel($user){
                echo '<form action="" method="GET" style="display: flex; flex-direction:column;">
                <span class="no-label">
                    <input type="hidden" name="data" value="1">
                  <input type="text" name="name" id="kyc-hotelname" placeholder="Enter Hotel Name">
                  <input type="text" name="location" id="kyc-address" placeholder="Location">
                  <input type="text" name="manager" id="kyc-Manager-Name" placeholder="Manager Name" value="'.$user->fname." ".$user->lname.'">
                </span>
                  <span>
                      Established In:
                      <input type="date" name="established" id="kyc-Establised-in" placeholder="Established In">
                  </span>
                 <span>
                  Opening Time:
                  <input type="time" name="open_time" id="kyc-opening-time" placeholder="Opening Time">
                 </span>
                <span>
                  Closing Time:
                  <input type="time" name="close_time" id="kyc-closing-time" placeholder="Closing Time">
                </span>
                <span>
                  Header Image:
                  
                      <input type="image" src="/assets/file-image-regular.svg" alt="Input Header Image" placeholder="Header Image">
                  </span>
                  <textarea name="bio" id="" cols="30" rows="10" placeholder="Description"></textarea>
                  <span class="down-bottoms">
                      <a href="profile.php">Skip</a>
                      <button type="submit" class="button">Sumbit</button>
                  </span>
              </form>';
            }
    }
?>