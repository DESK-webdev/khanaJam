<?php
    // try{
        // $note=json_decode(file_get_contents("notification_set"));
        // $a=0;
        // echo str_replace(array("\$name$","\$rating$"),array("veg momo","5"),$note->$a);
        // $conn=new SQLite3("db");
        // print_r($_SERVER);
        $conn=new PDO("sqlite:db");
        // if(!$_GET['error']){
        //     header('Location: '.$_SERVER['PHP_SELF']."?error=1");
        // }
        // print_r($_SERVER);
        // $conn->query("insert into user_info values('a','a','a');");
        // $conn->query("drop table orders;");
        // $conn->query("create table food_local (id varchar(10),name varchar(30),price smallint,ready_time tinyint,image varchar(30),bio varchar(200),rating tinyint,offset_count tinyint);");
        // $conn->query("create table food_global (id varchar(10),name varchar(30),category varchar(10),image varchar(30),bio varchar(200));");
        // $conn->query("create table cks (user_cookie varchar(33),db_id varchar(33),set_time long,expire_time long,cookied_browser varchar(100),type varchar(5));");
        // print_r($conn->query("select db_id,type from cks where expire_time>".time())->fetchAll());
        // echo time();
        // $conn->query("create table user_info (db_id varchar(33),fname varchar(10),lname varchar(10),phone varchar(10),type varchar(5),public_id varchar(5));");
        // $conn->query("create table sks (session_id varchar(33),db_id varchar(33),created_time long,used_browser varchar(100),type varchar(5));");
        // $conn->query("delete from login_info;");
        // $conn->query("create table orders (by varchar(4),food varchar(10),quantity tinyint,time_now long,time_coming long,id varchar(33),status tinyint);");
        // $a=$conn->query("select * from food_global;");
        print_r($conn->query("update orders set status=1 where substr(food,5,4)='f002'")->rowCount());
    // }
    // catch(Thorwable $e){
    //     print_r($e); 
    // }
?>