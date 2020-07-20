<?php
// session_start();
include_once "main.php";
include_once 'dataset.php';
    if($_GET['action']=="login"){
        if($_GET['id'] && $_GET['password']){
            $data['phone']=$_GET['id'];
            $data['password']=$_GET["password"];
            $data['checkbox']=$_GET["checkbox"];
            $response=$account->login(json_encode($data));
            for($i=0;$i<$response->self_count;$i++){
                switch ($response->data[$i]->name) {
                    case 'correct':
                        if($response->data[$i]->boolean=="0"){
                            $error->message=$response->data[$i]->data;
                        }
                        else{
                            $logged=1;
                        }
                        break;
                    case 'logged':
                        // if($response->data[$i]->boolean=="1"){
                        //     $error->message=$response->data[$i]->data."<br>";
                        // }
                        $logged=1;
                        break;
                    case 'remember':
                        // if($response->data[$i]->boolean=="1"){
                        //     $error->message=$response->data[$i]->data."<br>";
                        // }
                        $logged=1;
                        break;
                    default:
                            $error->message="something unexpected happened";
                        break;
                }
            }
            if($logged){
                header("Location: /php/profile.php");
                exit(0);
            }
        }
       else{
            $error->message="enter both id and password";
        }
    }
    else if($_GET['action']=="signup"){
        if($_GET['u_phone']){
            $error->message=$account->signup(json_encode($_GET));
        }
    }
?>