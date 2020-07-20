<?php
    session_start();
    include_once 'components/main.php';
    include_once 'components/dataset.php';
    $error=new errors;
    $account=new accounts;
    $logged=0;
    if(($account->all_check())>0){
        header('Location: index.php');
        exit(0);
    }
    include 'components/basic_account.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Font Awesome Import Start -->
        <link crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" rel="stylesheet"/>
        <!-- Font Awesome Import End -->
        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="../css/signin.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/css/navbar.css">
        <link rel="stylesheet" href="/css/footer.css">
        <script src="../js/account.js"></script>
        <title>Khanajam | User Signin</title>
    </head>
    <body>
        <?php
            include "navbar.php";
        ?>
        <div class="user-container">
        <?php if($_GET['action']!="signup"){ ?>
            <div class="login" style="display:flex;">
                <div class="login-right">
                    <div class="upper-text-section">
                        <h2>Hello, There!</h2>
                        <p>Login with registered account.</p>
                    </div>
                    <div class="social-media-login-sction">
                        <button class="button">
                            <i class="fab fa-facebook-square"></i>
                            <h3>Login With Facebook</h3>
                        </button>
                        <button class="button">
                            <i class="fab fa-google"></i>
                            <h3>Login With Google</h3>
                        </button>
                    </div>
                    <div class="middle-horizontal-section"></div>
                    <form action="signin.php" method="get">
                    <div class="fields-section">
                        <input type="hidden" name="action" value="login"/>
                        <div class="id-password">
                            <input id="u_name" name="id" placeholder="Phone Number +97798....." type="tel" value="<?=$_GET['phone']?>" required/>
                            <input id="u_password" name="password" placeholder="Password" type="password" required/>
                            <?=$error->message?>
                        </div>
                        <span class="RememberMe">
                            <input id="rememberme" name="checkbox" type="checkbox" value="true"/>
                            <label for="RememberMe!">Remember Me!</label>
                        </span>
                        <button class="button" type="submit">Log In</button>
                    </div>
                    </form>
                    <div class="lower-section">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
                <div class="login-left">
                    <div class="Text-writing">
                        <h2>Don't Have A acount?</h2>
                        <p>
                            Make In Ease!
                        </p>
                    </div>
                    <div class="login-Account-link">
                        <a href="signin.php?action=signup">
                            <button class="button login-Account-link-button" type="submit">
                                Create Account
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php   } 
                else{
            ?>
                <div class="signup">
            <div class="signup-right">
            <div class="Text-writing">
                <h2>Already Have A acount!</h2>
                <p>
                Login In Ease!
                </p>
            </div> 
            <div class="Create-Account-link">
                <button class="button Create-Account-link-button" type="submit">
                <a href="/php/signin.php">Login</a>
                </button>
            </div>
            </div>
            <div class="signup-left">
            <div class="upper-text-section">
                <h2>Hello, There!</h2>
                <p>Sign Up for an account.</p>
            </div>
            <div class="middle-horizontal-section"></div>
            <form action="signin.php" method="GET">
            <div class="fields-section">
                <input type="hidden" name="action" value="signup">
                <div class="id-password">
                    <input
                    id="u_phone"
                    name="u_phone"
                    placeholder="Enter your Phone Number"
                    type="tel"
                    />
                    <input
                    id="u_name"
                    name="u_fname"
                    placeholder="First Name"
                    type="text"
                    />
                    <input
                    id="u_lname"
                    name="u_lname"
                    placeholder="Last Name"
                    type="text"
                    />
                    <input
                    id="u_password"
                    name="u_password"
                    placeholder="Enter Password"
                    type="password"
                    />
                    <input
                    id="u_cpassword"
                    name="u_cpassword"
                    placeholder="Confirm Password"
                    type="password"
                    />
                    <div class="partof">
                        <h4>I am: </h4>
                    <input id="customer" name="u_type" type="radio" value="customer" />Customer
                    <br />
                    <input id="Hotel" name="u_type" type="radio" value="hotel" />Hotel
                    
                    </div>
                </div>    
                
                <span class="privacy-click">
                <input id="privacy-click" name="" type="checkbox" />
                <label for="privacy-click">
                    I agree to the
                    <a href="#">
                    Privacy & Policy
                    </a>
                </label>
                </span>
                <?=$error->message;?>
                <button class="button" type="submit">Sign Up</button>
            </div>
            </form>
            <div class="lower-section"></div>
            </div>
        </div>
            <?php } ?>
        </div>
        <?php
            include 'footer.html';
        ?>
    </body>
    <script src="../js/script.js"></script>
</html>
