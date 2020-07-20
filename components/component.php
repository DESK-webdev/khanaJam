<?php
    class components{
        public function div_login(){
            
        }

        public function div_signup(){

        }

    }

    class plates{
        public function plate_food_bc_1($gdata=""){
            if($gdata){
                $data=json_decode($gdata);
            }
                echo '<div class="overall-box">
                        <div class="top-food">
                            <div class="plate food-1">
                                <img alt="Food-1" src="/assets/header.jpg" />
                                <div class="overlay-details">
                                    <div class="food details">
                                        <h4>Food</h4>
                                        <h4>Rate</h4>
                                        <h4>Rating 1</h4>
                                    </div>
                                    <div class="cart">
                                        <button class="bag-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                            Add to Cart
                                        </button>
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
?>