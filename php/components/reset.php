<?php
     $conn=new PDO("sqlite:db");
     $conn->query("delete from login_info;");
     $conn->query("delete from user_info;");
     $conn->query("delete from cks;");
     $conn->query("delete from food_local;");
     // $conn->query("delete from food_global;");
     $conn->query("delete from orders;");
     $conn->query("delete from hotel;");
     $count=json_decode(file_get_contents("count"));
     $count->h=0;
     $count->s=0;
     file_put_contents("count",json_encode($count));
?>