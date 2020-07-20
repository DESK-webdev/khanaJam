<?php
session_start();
    include 'login.php';
    $account=new accounts;
    if($account->all_check()){
        echo "already logged";
        die();
    }
    if($_GET['user'] && $_GET['password']){
        $id=$account->login();
        if($id!=-1 && $id){
            $account->session_create($id);
            echo "logged in<br>";
            if($_GET['checkbox']){
                $cookie=$account->cookie_create($id);
                setcookie("user_c",$cookie,time()+86400*30,"/");
                echo "remembered";
            }
        }
    }
    else{
        echo "dont send blank";
    }
?>