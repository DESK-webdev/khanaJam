<?php
try{
    session_start();
     include "components/main.php";
     include "components/component.php";
     $account=new accounts;
     $logged=1;
     $add=0;
     if(!($account->all_check())){
       $logged=0;
       die("please login");
     }
     if($_SESSION['public_id'][0]!="h" || $_SESSION['public_id']=="pending"){
         die("not hotel");
     }
     if($_GET['data']=="1"){
        $add=1;
        $putdata=new putdata;
        $message=$putdata->localfood(json_encode($_GET));
     }
        $list=$account->sql->query("select id,name from food_global;");
        $form=new getform;
}
catch(Throwable $e){
    var_dump($e);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/add-food.css">
    <title>Add Food</title>
</head>
<body>
<?php if($add){ ?>
    <h1><?=$message?></h1>
    <?="add another food:"?>
<?php }  ?>
    <div class="add-food-container">
        <div class="text-section">
            <h1>Add New Food</h1>
        </div>
        <div class="form-section">
            <?php $form->getform_addfood($list); ?>
        </div>
    </div>
</body>
</html>