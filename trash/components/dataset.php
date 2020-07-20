<?php
class users_file{
    public $cookie;
    public $id;
}
    class data{
        public $name;
        public $boolean;
        public $type;
        public $data;
    }
    class dataset{
        public $self_count=0;
        public $data = array();
        public $child;
        public function push($name='',$boolean=0,$type='',$data=''){
            array_push($this->data,new data);
            $this->data[$this->self_count]->name=$name;
            $this->data[$this->self_count]->boolean=$boolean;
            $this->data[$this->self_count]->type=$type;
            $this->data[$this->self_count]->data=$data;
            $this->self_count++;
        }
    }
    class dataset_profile{
        public $name;
        public $phone;
        public $id;
        public $session_id;
        public $cookie;
        private $set=array("name","phone","id","session_id","cookie");
        public function push($name="",$phone="",$id="",$session_id="",$cookie=""){
            $this->$set[0]=$name;
            $this->$set[1]=$phone;
            $this->$set[2]=$id; 
            $this->$set[3]=$session_id;
            $this->$set[4]=$cookie;
        }
        public function __destruct(){
            $i=0;
            while($set[$i]){
                if($this->$set[$i]==""){
                    unset($this->$set[$i]);
                }
                $i++;
            }
            unset($set);
        }
    }
    class dataset_sessions extends dataset_profile{
        
        // public function push($session_id="",$cookie=""){

        // }
    }
    class dataset_signup_1 extends main_class{
        public $fname;
        public $lname;
        public $phone;
        public $password;
        public $type;
        public $id;
        public function dataset_signup_1($gdata=""){
            $this->fname=$gdata->u_fname;
            $this->lname=$gdata->u_lname;
            $this->password=$gdata->u_password;
            $this->phone=$gdata->u_phone;
            $this->type=$gdata->u_type;
            unset($this->sql);
        }
        public function filter(){
            $this->fname=$this->sql_filter($this->fname);
            $this->lname=$this->sql_filter($this->lname);
            $this->password=$this->sql_filter($this->password);
            $this->phone=$this->sql_filter($this->phone);
            $this->type=$this->sql_filter($this->type);
        }
    }
?>
