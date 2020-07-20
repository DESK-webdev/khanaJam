<?php
     session_start();
     include "components/main.php";
     include 'components/component.php';
     $account=new accounts;
     $logged=1;
     if(!($account->all_check())){
       $logged=0;
       die("please login");
     }
     if($_SESSION['public_id']!="pending" && $_SESSION['public_id'][0]!="h"){
         die("not hotel a".$_SESSION['public_id']);
     }
     else if($_SESSION['public_id'][0]=="h"){
         die("hotel already registered");
     }
     $submit=0;
     if($_GET['data']=="1"){
         $message=$account->hotel_form(json_encode($_GET));
        $submit=1;
     }
     else{
        $data=new getdata;
        if(!($user=$data->getdata_profile($_SESSION['public_id']))){
            die("something wrong");
        }
        $form=new getform;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/kyc-form.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <title>KhanaJam | KYC Form</title>
</head>
<body>
<?php include 'navbar.php'; ?>
    <!-- This form is displayed after a hotel creates account. But for customer such details wont be asked, there willl be edit section where the same information can be changed and modified. there is also skip bubtton, if clicked skip the information wont be updated of this page but the details of the previous page will be updated.-->
<div class="form-container">
    <h3>Fill More Information</h3>
    <div class="kyc-form">
        <?php
            if(!$submit){
                $form->getform_hotel($user);
            }
            else{
                echo "<p>".$message."</p>";
            } 
            
        ?>
    </div>
    <h5>The information collected won't be shared with anyone.</h5>
</div>
</body>
</html>