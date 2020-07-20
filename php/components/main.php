<?php
    class main_class{
        public $sql;
        public function sql_connect($file){
            $conn=new PDO("sqlite:components/$file");
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        public function sql_filter($raw){
            $proceed=str_replace(array("'","\"","/","\\",";"),
                                    array("&qot",'&dqot',"&bsh","&fsh","&coln")
                                    ,$raw);
            return $proceed;
        }
        public function sql_dfilter($raw){
            $proceed=str_replace(array("&qot",'&dqot',"&bsh","&fsh","&coln"),
                                    array("'","\"","/","\\",";")
                                    ,$raw);
            return $proceed;
        }
    }

    class sessions extends main_class{
        public $session;
        public function sessions($sql=""){
            if($sql){
                $this->sql=$sql; 
             }
             else{
                 $this->sql=$this->sql_connect("db");
             }
        }
        public function cookie_isvalid(){  ////return positive id on true
            $cookie=$this->sql_filter($_COOKIE['user_c']);
            return $this->sql->query("select cks.db_id,cks.type,user_info.public_id from cks
                                        inner join user_info on user_info.db_id=cks.db_id 
                                        where cks.user_cookie='".$cookie."' and  
                                        cks.expire_time>".time().";")->fetchObject();
        }

        public function session_isvalid(){
            if(!($_SESSION['user_s']) && (!($_SESSION['public_id']) || $_SESSION['public_id']!="pending")){
                return 0;
            }
            $this->session=$_SESSION['user_s'];
            return 1;
        }

        public function session_create($p_id,$m_id){
            // $this->session=hash("md5",$_SERVER['HTTP_USER_AGENT'].
            //                             $_SERVER['REMOTE_ADDR'].
            //                             $_SERVER['REMOTE_PORT'].
            //                             $m_id.time().rand(3,3));
            $_SESSION['public_id']=$p_id;
            $_SESSION['user_s']=$m_id;
            $this->session=$m_id;
            return 1;
        }

        public function cookie_create($m_id){
            $cookie=hash("md5",$_SERVER['HTTP_USER_AGENT'].
                                $_SERVER['REMOTE_ADDR'].
                                $_SERVER['REMOTE_PORT'].
                                time().rand(3,3));
            return $cookie;
        }

        public function cookie_store($data){
            $this->sql->query("insert into cks values('$data->cookie','$data->db_id',".time().",".(time()+(86400*30)).",'browser','$data->type');");
        }
        public function all_check(){
            if($_SESSION || $_COOKIE['user_c']){
                if(!$this->session_isvalid()){ ///here
                    $user=$this->cookie_isvalid();
                    if($user){
                        $this->session_create($user->public_id,$user->db_id);
                    }
                }
                return 1;
            }
            return 0;
        }
    }

    class accounts extends sessions{
        public function accounts($sql=""){
            if($sql){
                $this->sql=$sql; 
             }
             else{
                 $this->sql=$this->sql_connect("db");
             }
        }

        function hotelid($sn){
            switch(strlen($sn)){
                case 1:
                    return "h00".$sn;
                break;
                case 2:
                    return "h0".$sn;
                break;
                case 3:
                    return "h".$sn;
                break;
                default:
                    return 0;
                break;
            }
       }
       function studentid($sn){
            switch(strlen($sn)){
                case 1:
                    return "s00".$sn;
                break;
                case 2:
                    return "s0".$sn;
                break;
                case 3:
                    return "s".$sn;
                break;
                default:
                    return 0;
                break;
            }
        }

        public function user_exist($number){
            return $this->sql->query("select 1 from login_info where phone='$number';")->fetchColumn();
        }
        public function login($get_data){
            if($data=json_decode($get_data)){
                $tmp=new dataset;
                $phone=$this->sql_filter($data->phone);
            //$password=hash("md5",$_GET['password']);
                $password=$data->password;
                $user=$this->sql->query("select login_info.db_id,user_info.type,user_info.public_id from login_info 
                                            inner join user_info on user_info.db_id=login_info.db_id 
                                            where login_info.phone='$phone' and login_info.password='$password';")->fetchObject();
                if(!$user){
                    $tmp->push("correct","0","0","incorrect crediantials");
                    return $tmp;
                }
                else{
                    $this->session_create($user->public_id,$user->db_id);
                    $tmp->push("logged","1","0","you are logged in now");
                    $remember=0;
                    if($data->checkbox=="true"){
                        $user->cookie=$this->cookie_create($user->public_id);
                        if(setcookie("user_c",$user->cookie,time()+86400*30,"/")){
                            $this->cookie_store($user);
                        }
                        $tmp->push("remember","1","0","browser saved");
                    }
                    return $tmp;
                }
                return '';
            }
        }

        public function signup($gdata){
            $user=new dataset_signup_1(json_decode($gdata)); 
            $user->filter();
            if($this->user_exist($user->phone)){
                return "phone already registered";
            }
            $count=0;
                if($user->type=="hotel"){
                    // $count->h++;
                    $user->public_id="pending";
                }
                else{
                    if($count=json_decode(file_get_contents("components/count"))){    ////to count users
                        $count->s++;
                        $user->public_id=$this->studentid($count->s);
                        file_put_contents("components/count",json_encode($count));
                    }
                }
            $this->sql->query("insert into login_info values('$user->phone','$user->password','$user->db_id');");
            $this->sql->query("insert into user_info values('$user->db_id','$user->fname','$user->lname','$user->phone','$user->type','$user->public_id');");
            $this->session_create($user->public_id,$user->db_id); ////here
            header("Location: /php/profile.php");
            exit(0);
        }
        public function hotel_form($gdata){
            $user=json_decode($gdata);
            $user->phone="914148108";
            if($count=json_decode(file_get_contents("components/count"))){    ////to count users
                $count->h++;
                $user->public_id=$this->hotelid($count->h);
                file_put_contents("components/count",json_encode($count));
            }
            $this->sql->query("insert into hotel values('".$_SESSION['db_id']."',
                                                        '".$this->sql_filter($user->name)."',
                                                        '".$this->sql_filter($user->location)."',
                                                        '".$this->sql_filter($user->manager)."',
                                                        '".$this->sql_filter($user->established)."',
                                                        '".$this->sql_filter($user->open_time)."',
                                                        '".$this->sql_filter($user->close_time)."',
                                                        '',
                                                        '".$this->sql_filter($user->bio)."',
                                                        '".$this->sql_filter($user->phone)."',
                                                        '".$this->sql_filter($user->public_id)."');");
            if($this->sql->errorCode()=="0000"){
                $this->sql->query("update user_info set public_id='$user->public_id' where db_id='".$_SESSION['user_s']."';");      
                $_SESSION['public_id']=$user->public_id;
                return $user->name." registered with id ".$user->public_id;
            }
            else{
                return "error adding food";
            }
        }
    }
    class getdata extends main_class{
        public function getdata($sql=""){
            if($sql){
               $this->sql=$sql; 
            }
            else{
                $this->sql=$this->sql_connect("db");
            }
        }

        public function getdata_profile($gid){ 
            return $this->sql->query("select * from user_info where db_id='$gid' or public_id='$gid';")->fetchObject();
        } 
        
        public function getdata_food($gid){
            $id=$this->sql_filter($gid);
            return $this->sql->query("select food_local.*,
                                        food_global.name as parentname,
                                        food_global.category as category,
                                        hotel.public_id as hotelid,
                                        hotel.name as hotelname,
                                        hotel.location from food_local
                                        inner join food_global on substr(food_local.id,5,4)=food_global.id 
                                        inner join hotel on substr(food_local.id,1,4)=hotel.public_id
                                        where food_local.id ='$id';")->fetchObject();
        }
        public function gatdata_globalfood($gid){
            $id=$this->sql_filter($gid);
            return $this->sql->query("select * from food_global where id='$id';")->fetchObject();
        }
        public function getdata_list_food($with,$as="random"){
            $fas=$this->sql_filter($as);
            return $this->sql->query("select food_local.id as foodid,
                                food_local.name || ' ' || food_global.name as foodname,
                                food_local.rating,
                                food_global.category,
                                hotel.public_id as hotelid,
                                hotel.name as hotelname,
                                hotel.location from food_local
                                inner join food_global on food_global.id=substr(food_local.id,5,4) 
                                inner join hotel on hotel.public_id=substr(food_local.id,1,4)
                                where $with like '$fas';");
        }
        public function getdata_child_orders(){
            return $this->sql->query('select hotel.name as hotelname,
                                        hotel.public_id as hotelid,
                                        food_local.name || " " || food_global.name as foodname,
                                        food_local.id as foodid,
                                        food_local.price,
                                        orders.quantity,
                                        orders.time_now as ordertime,
                                        orders.time_coming as comingtime,
                                        orders.id as orderid,
                                        orders.status  from orders
                                        inner join hotel on hotel.public_id=substr(orders.food,1,4)
                                        inner join food_local on food_local.id=orders.food
                                        inner join food_global on food_global.id=substr(orders.food,5,4)
                                        where orders.by=\''.$_SESSION['user_s'].'\'
                                        order by orders.time_coming desc;');
        }
        public function getdata_parent_orders(){
            return $this->sql->query('select food_local.name || " " || food_global.name as foodname,
                                        food_local.id as foodid,
                                        food_local.price,
                                        orders.quantity,
                                        orders.time_now as ordertime,
                                        orders.time_coming as comingtime,
                                        orders.id as orderid,
                                        orders.status,
                                        user_info.fname || " " || user_info.lname as customername,
                                        user_info.public_id as customerid  from orders
                                        inner join food_local on food_local.id=orders.food
                                        inner join food_global on food_global.id=substr(orders.food,5,4)
                                        inner join user_info on user_info.db_id=orders.by
                                        where substr(orders.food,1,4)=\''.$_SESSION['public_id'].'\'
                                        order by orders.time_coming desc;');
        }
    }
    class putdata extends main_class{
        public function putdata($sql=""){
            if($sql){
                $this->sql=$sql; 
             }
             else{
                 $this->sql=$this->sql_connect("db");
             }
        }
        public function foodid($sn){
            switch(strlen($sn)){
                case 1:
                    return "f00".$sn;
                break;
                case 2:
                    return "f0".$sn;
                break;
                case 3:
                    return "f".$sn;
                break;
                default:
                    return 0;
                break;
            }
       }
       public function local_foodid($init,$sn){
        switch(strlen($sn)){
            case 1:
                return $init."0".$sn;
            break;
            case 2:
                return $init.$sn;
            break;
            default:
                return 0;
            break;
        }
       }
        public function order($gdata=""){
            if($gdata){
                $response=array();
                $data=json_decode($gdata);
                $data->time=strtotime($data->time);
                $data->timenow=time();
                if($data->time<($data->timenow+3500)){
                    $data->time=$data->time+3600;
                    array_push($response,"1 hour added to order time");
                }
                $data->orderid=$data->time.$_SESSION['public_id'];
                $this->sql->query("insert into orders values('".$_SESSION['user_s']."',
                                                            '".$this->sql_filter($data->food_id)."',
                                                            '".$this->sql_filter($data->quantity)."',
                                                            '".$data->timenow."',
                                                            '".$data->time."',
                                                            '".$data->orderid."',
                                                            0);");
                array_push($response,"food ordered (id:$data->orderid) success");
                return $response;
            }
            return 0;
        }
        public function globalfood($gdata=""){
            if($gdata){
                $data=json_decode($gdata);
                if($data->name && $data->category && $data->description){
                    $offset=json_decode(file_get_contents("components/count"));
                    $offset->f++;
                    $query=$this->sql->query("insert into food_global values('".$this->foodid($offset->f)."',
                                                                                '".$this->sql_filter($data->name)."',
                                                                                '".$this->sql_filter($data->category)."',
                                                                                '',
                                                                                '".$this->sql_filter($data->description)."');");
                    file_put_contents("components/count",json_encode($offset));
                }
                else{
                    throw new Exception("error inserting");
                }
            }
        }
        public function localfood($gdata=""){
            if($gdata){
                $data=json_decode($gdata);
                if($data->name && $data->global && $data->price && $data->time){
                    $id=$this->sql->query("select food_global.id as globalid,
                                            hotel.public_id as hotelid
                                            from food_global 
                                            inner join hotel
                                            where food_global.id='".$this->sql_filter($data->global)."' 
                                            and hotel.public_id='".$_SESSION['public_id']."';")->fetchObject();   
                    $id->count=$this->sql->query("select max(offset_count) as count from food_local
                                                    where id like '".$id->hotelid.$id->globalid."%';")->fetchColumn();
                    $id->count++;
                    if(!($foodid=$this->local_foodid($id->hotelid.$id->globalid,$id->count))){
                        return "error id";
                    }
                    $this->sql->query("insert into food_local values('".$foodid."',
                                                                        '".$this->sql_filter($data->name)."',
                                                                        ".$this->sql_filter($data->price).",
                                                                        ".$this->sql_filter($data->time).",
                                                                        '',
                                                                        '".$this->sql_filter($data->bio)."',
                                                                        0,
                                                                        $id->count);");
                    if($this->sql->errorCode()=="0000"){
                        return $data->name." added successfully with food id ".$foodid;
                    }
                    else{
                        return "error adding food";
                    }
                }
                else{
                    throw new Exception("error inserting");
                }
            }
        }
    }

?>