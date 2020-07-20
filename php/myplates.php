<?php
    session_start();
    include 'components/main.php';
    $account=new accounts;
    $logged=1;
    if(($logged=$account->all_check())==0){
        die("please login");
      header('Location: signin.php');
      exit(0);
    }
    include 'components/dataset.php';
    include 'components/component.php';
    $table=new recents($account->sql);
    $getdata=new getdata($account->sql);
    if($_GET['order']){
        $orderid=$account->sql_filter($_GET['order']);
            $ackcase="";
            switch ($_GET['action']) {
                case 'cancel':
                    $status=5;
                break;
                case 'drop':
                    $status=4;
                break;
                case 'sure':
                    $status=2;
                break;
                case 'unpaid':
                    $status=3;
                break;
                case 'success':
                    $status=6;
                break;
                case 'ok':
                    $status="status+1";
                    $ackcase="and 0=status%2 and status>1";
                break;
                default:
                    $status="status";
                break;
            }
            $affected_row=$account->sql->query("update orders set status=$status where id='$orderid' 
                                    and (substr(food,1,4)='".$_SESSION['public_id']."' 
                                    or by='".$_SESSION['user_s']."') $ackcase;")->rowCount();
            if($affected_row){
                echo $affected_row." got affected";
            }
            else{
                echo "status cant be set";
            }
    }
    if($_SESSION['public_id'][0]=="h"){
        $list=$getdata->getdata_parent_orders();
    }
    else{
        $list=$getdata->getdata_child_orders();
    }
    $pending=array();
    $recent=array();
    while($tmp=$list->fetchObject()){
        if($tmp->status<=5){
            array_push($pending,$tmp);
        }
        else{
            array_push($recent,$tmp);
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Font Awesome Import Start -->
        <link crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" rel="stylesheet"/>
        <!-- Font Awesome Import End -->
        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>My Plates</title>
        <link rel="stylesheet" href="/css/style.css">
        <link href="/css/myplates.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/css/navbar.css">
        <link rel="stylesheet" href="/css/footer.css">
    </head>
    <body>
    <?php include 'navbar.php'; ?>
        <div class="my-plate-container">
            <i class="fas fa-concierge-bell">
                <h3>My Recents</h3>
            </i>
            <div class="search-body">
                <h3>Search Food && Hotel</h3>
                <div class="search">
                    <input class="Search" id="" name="Search-foods-hotels" placeholder="Type here . . . " type="text"/>
                    <button class="button" type="submit">Search</button>
                </div>
            </div>
            <hr/>
            <div class="all-tranisition-table">
            <?php if($_SESSION['public_id'][0]=="h"){ ?>
                    <h3>Pending-order hotel</h3>
            <div class="pending-order">
                <?=$table->filter();?>
                <table>
                    <tr>
                        <th>customer</th>
                        <th>order time</th>
                        <th>coming time</th>
                        <th>date</th>
                        <th>Food Name</th>
                        <th>Quantitiy</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                        <?php
                            for($i=0;$pending[$i];$i++){
                                echo $table->row_parent($pending[$i]);
                            }
                        ?>
                </table>
            </div>
            <h3>other orders hotel</h3>
            <div class="Completed-order">
                <?=$table->filter();?>
                    <table>
                        <tr>
                            <th>customer</th>
                            <th>order time</th>
                            <th>coming time</th>
                            <th>date</th>
                            <th>Food Name</th>
                            <th>Quantitiy</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                        <?php
                            for($i=0;$recent[$i];$i++){
                                echo $table->row_parent($recent[$i]);
                            }
                        ?>
                    </table>
            </div>
            <?php }
                else{ ?>
            <h3>Pending-order customer</h3>
            <div class="pending-order">
                <?=$table->filter();?>
                <table>
                    <tr>
                        <th>Hotel</th>
                        <th>order time</th>
                        <th>coming time</th>
                        <th>date</th>
                        <th>Food Name</th>
                        <th>Quantitiy</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                        <?php
                            for($i=0;$pending[$i];$i++){
                                echo $table->row_child($pending[$i]);
                            }
                        ?>
                </table>
            </div>
            <hr/>
            <h3>other orders customer</h3>
            <div class="Completed-order">
                <?=$table->filter();?>
                    <table>
                        <tr>
                            <th>Hotel</th>
                            <th>order time</th>
                            <th>coming time</th>
                            <th>date</th>
                            <th>Food Name</th>
                            <th>Quantitiy</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                        <?php
                            for($i=0;$recent[$i];$i++){
                                echo $table->row_child($recent[$i]);
                            }
                        ?>
                    </table>
            </div>
            <?php } ?>
        </div>
    <?php 
        include 'footer.html';
        $account->sql->query("update orders set status=1 where substr(food,1,4)='".$_SESSION['public_id']."' and status=0;");
    ?>