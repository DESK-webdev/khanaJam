<?php
include 'dataset.php';
header("Access-Control-Allow-Origin:*");
$response=array();
$response_count=0;
    session_start();
    include 'login.php';
    $account=new accounts;
    $response[$response_count]=new dataset;
    if($logged=$account->all_check()){
        $response[$response_count]->push("logged","1","0","already logged in");
        $response_count++;
    }
    else if($_GET['for']=="login" && !$logged){
        if($_GET['data']){
            $response[$response_count]=$account->login($_GET['data']);
        }
        else{
            $response[$response_count]->push("corrupt","1","0","somthing error in data transmission");
        }
    }
    echo json_encode($response[0]);
?>