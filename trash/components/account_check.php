<?php
session_start();
include "../../api/login.php";
include '../../api/dataset.php';
$account=new accounts;
    if($_GET['action']=="login"){
        if($_GET['id'] && $_GET['password']){
            $data['name']=$_GET['id'];
            $data['password']=$_GET["password"];
            $data['checkbox']=$_GET["checkbox"];
            $response=$account->login(json_encode($data));
            for($i=0;$i<$response->self_count;$i++){
                switch ($response->data[$i]->name) {
                    case 'correct':
                        if($response->data[$i]->boolean=="0"){
                            echo $response->data[$i]->data."<br>";
                        }
                        break;
                    case 'logged':
                        if($response->data[$i]->boolean=="1"){
                            echo $response->data[$i]->data."<br>";
                        }
                        break;
                    case 'remember':
                        if($response->data[$i]->boolean=="1"){
                            echo $response->data[$i]->data."<br>";
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
            header("Location: /php/profile.php");
            exit(0);
        }
       else{
            echo "something wrong";
        }
    }
    else if($_GET['action']=="signup"){
        $account->signup(json_encode($_GET));
    }
?>