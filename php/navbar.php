<?php
    function nav($logged){
        if(!$logged){
            echo '<a href="#">Hotels</a>
                <a href="#">Foods</a>
                <a href="signin.php">Login</a>';
        }
        else{
            echo '<a href="#">Hotels</a>
                <a href="#">Foods</a>
                <a href="messages.php">messages</a>
                <a href="myplates.php">myplates</a>
                <a href="profile.php">Profile</a>
                <a href="logout.php">logout</a>';
        }
    }
?>

<nav class="navbar">
    <div class="main-logo">
        <a href="/php/">KhanaJam</a>
    </div>
    <div class="Further-pages-navbar page-links">
<?php
     nav($logged);   
?>
<div class="nightmode">
            <i class="far fa-moon"></i>
        </div>
    </div>
    <div class="hamburger">
        <i class="fas fa-list-ul"></i>
    </div>
</nav>