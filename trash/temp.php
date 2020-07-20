<?php
    // $conn=mysqli_connect("127.0.0.1","root","","201922food");
    // if(!$conn){echo '{"error":"0.1"}';return -1;}
    // $data=array();
    // $i=0;
    // do{
        // $qry=mysqli_query($conn,"select name,phone_number,public_id from hotel;");
        // $data=mysqli_fetch_all($qry);
        // while($data[$i]){
        //     $tmp->name=$data[$i][0];
        //     $tmp->phone=$data[$i][1];
        //     $tmp->id=$data[$i][2];
        //     $response[$i]=$tmp;
        //     $i++;
        // }
    // }while($i<=3);
    // file_put_contents("example_user.txt",json_encode($data));
    // print_r($response);
    // $all_users=json_decode(file_get_contents("example_user.txt"));
    class a{
        public function __construct(){
            echo "hello";
        }
        public function __destruct(){
            echo "bye";
        }
    }
    $a=new a;
?>