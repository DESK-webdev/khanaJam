<?php
    class main_class{
        public $sql;
        public function sql_connect(){
            $conn=mysqli_connect("127.0.0.1","root","","test");
            if(!$conn){echo '{"error":"0.1"}';return -1;}
            else{return $conn;}
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
        public function file_push($file,$json){
            $djson=array();
            if(($tmp=file_get_contents($file))){
                $djson=json_decode($tmp);
                unset($tmp);
            }
            array_push($djson,$json);
            file_put_contents($file,json_encode($djson));
        }
        public function file_has($file,$key,$txt){
            $saved_user=json_decode(file_get_contents($file));
            $i=0;
            while($tmp=json_decode($saved_user[$i])){
                if($tmp->$key==$txt){
                    return $tmp;
                }
                $i++;
            }
            return 0;
        }
    }

    class sessions extends main_class{
        public $session;
        public function sessions(){
            //$this->sql=$this->sql_connect();
        }
        public function cookie_isvalid(){  ////return positive id on true
            $cookie=$this->sql_filter($_COOKIE['user_c']);
            // $qry=mysqli_query($this->sql,"select u_id from cks where b_cookie='".$cookie."';");
            // if(!$qry){ echo " error 1.1".mysqli_error($this->sql);return -1;}
            // $data=mysqli_fetch_all($qry);
            // if($data[0][0]){
            //     return $data[0][0];
            // }
            $file=json_decode(file_get_contents("users")); 
            if($file->$cookie){
                return $file->$cookie;
            }
            else{
                // echo "something error 1.1";
                return 0;
            }
        }

        public function session_isvalid(){
            $this->session=$_SESSION['user_s'];
            // $qry=mysqli_query($this->sql,"select u_id from sns where b_session='".$this->session."'");
            // if(!$qry){ echo " error 1.2";return -1;}
            // if($data[0][0]){
            //     return $data[0][0];
            // }
            // else{
            //     echo "something error 1.2";
            //     return 0;
            // }
        }

        public function session_create($m_id){
            $this->session=hash("md5",$_SERVER['HTTP_USER_AGENT'].
                                        $_SERVER['REMOTE_ADDR'].
                                        $_SERVER['REMOTE_PORT'].
                                        time().rand(3,3));
            // $qry=mysqli_query($this->sql,"insert into sns values('".$m_id."','".$this->session."');");
            // if(!$qry){echo "error 1.3";return -1;}
            $_SESSION['id']=$m_id;
            $_SESSION['user_s']=$this->session;
            return 1;
        }

        public function cookie_create($m_id){
            $cookie=hash("md5",$_SERVER['HTTP_USER_AGENT'].
                                $_SERVER['REMOTE_ADDR'].
                                $_SERVER['REMOTE_PORT'].
                                time().rand(3,3));
            // $qry=mysqli_query($this->sql,"insert into cks values('".$m_id."','".$cookie."');");
            // if(!$qry){echo "error 1.4";return -1;}
            // else{ return $cookie; }
            return $cookie;
        }

        public function all_check(){
            if($_SESSION['user_s'] || $_COOKIE['user_c']){
                $u_id=$_SESSION['id'];
                if(!$_SESSION['user_s']){
                    $u_id=$this->cookie_isvalid();
                    if($u_id!=-1 && $u_id){
                        $this->session_create($u_id);
                    }
                }
                return $u_id;
            }
            return 0;
        }
    }

    class accounts extends sessions{
        public function accounts(){
            // $this->sql=$this->sql_connect();
        }

        public function login($get_data){
            if($data=json_decode($get_data)){
                $tmp=new dataset;
                $user=$this->sql_filter($data->name);
            //$password=hash("md5",$_GET['password']);
                $password=$data->password;
                // $qry=mysqli_query($this->sql,"select id from test_login 
                //                                 where name='".$user."' and  
                //                                 password='".$password."';");
                // if(!$qry){echo " error 2.1";return -1;}
                // $data=mysqli_fetch_all($qry);
                // if($data[0][0]){
                //     return $data[0][0];
                // }
                $saved_user=json_decode(file_get_contents("users"));
                $i=0;
                $id=0;
                while($saved_user[$i]){
                    $saved_user_1=json_decode($saved_user[$i]);
                    if(($user==$saved_user_1->phone) && ($password==$saved_user_1->password)){
                        $id=$saved_user_1->id;
                    }
                    $i++;
                }
                if($id=='0'){
                    die("incorrect password");
                    $tmp->push("correct","0","0","incorrect crediantials");
                    return $tmp;
                }
                else{
                    $this->session_create($id);
                    $tmp->push("logged","1","0","you are logged in now");
                    //echo "logged in<br>";
                    $remember=0;
                    if($data->checkbox=="true"){
                        $cookie=$this->cookie_create($id);
                        setcookie("user_c",$cookie,time()+86400*30,"/");
                        $file=json_decode(file_get_contents("users"));
                        $file->$cookie=$id;
                        file_put_contents("users",json_encode($file));
                        $tmp->push("remember","1","0","browser saved");
                    }
                    return $tmp;
                }
                return '';
            }
        }

        public function signup($gdata){
            if($this->all_check()){
                header("Location: /php/profile.php");
                exit(0);
            }
            $user=new dataset_signup_1(json_decode($gdata)); 
            $user->filter();
            if($this->file_has("example_user.txt","phone",$user->phone)){
                die("already registered");
            }
            $user->id=hash("md5",$gdata.time());
            $this->file_push("example_user.txt",json_encode($user));
            $this->file_push("users",json_encode(array('phone'=>$user->phone,'password'=>$user->password,'id'=>$user->id)));
            $this->session_create($user->id);
            header("Location: /php/profile.php");
            exit(0);
        }
    }
    class getdata extends main_class{
        public function getdata(){
            
        }

        public function getdata_profile($gid){
            return $this->file_has("components/example_user.txt","id",$gid);
        }
    }
?>