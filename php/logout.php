<?php
// include 'include.php';
    session_start();
    // $conn=sql_connect("../sql1");
    // $query=mysqli_query($conn,"update ".$_SESSION['type']."_bio set status='offline'
    //                                     where id='".$_SESSION['id']."';");
    // if(!$query) {die(mysqli_error($conn));}
    if(isset($_COOKIE['user_c'])){ ////here
        setcookie("user_c","",time()-3600,"/");
        unset($_COOKIE['user_c']);
        }
    session_unset();
    session_destroy();
    header("Location: /php/");
?>