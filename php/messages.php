<?php
    session_start();
    include "components/main.php";
    include 'components/dataset.php';
    include 'components/component.php';
    $account=new accounts;
    $logged=1;
    if(!($account->all_check())){
      $logged=0;
      die("please login");
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Font Awesome Import Start -->
    <link
      crossorigin="anonymous"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      rel="stylesheet"
    />
    <!-- Font Awesome Import End -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/message.css" />
    <title>Messages</title>
  </head>
  <body>
    <?php
        include 'navbar.php';
    ?>
    <div class="message-container" id="message-box">
      <div class="message-whole-box">
        <div class="message-receiver-details">
          <span>
            <img src="/assets/user.png" alt="" />
            <h4 class="name">Receiver.Name</h4>
          </span>
        </div>
        <div class="message-actual-box">
          <div class="message-sent-box">
            <div class="message-text">Hello baby</div>
            <div class="message-status-box">Seen</div>
          </div>
          <div class="message-received-box">
            <div class="message-text">
              Hello darling Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Cum obcaecati excepturi ipsum ullam. Suscipit possimus esse
              veritatis ratione similique harum totam tempore non culpa ea minus
              quas, iure deserunt maxime?
            </div>
            <div class="message-status-box">Seen</div>
          </div>
          <div class="message-received-box">
            <div class="message-text">
              Hello darling Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Cum obcaecati excepturi ipsum ullam. Suscipit possimus esse
              veritatis ratione similique harum totam tempore non culpa ea minus
              quas, iure deserunt maxime?
            </div>
            <div class="message-status-box">Seen</div>
          </div>
          <div class="message-received-box">
            <div class="message-text">
              Hello darling Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Cum obcaecati excepturi ipsum ullam. Suscipit possimus esse
              veritatis ratione similique harum totam tempore non culpa ea minus
              quas, iure deserunt maxime?
            </div>
            <div class="message-status-box">Seen</div>
          </div>
        </div>
        <div class="message-sending-box">
          <form action="" method="post">
            <textarea
              name=""
              id=""
              placeholder="AaBb..."
              class="tex-box"
            ></textarea>
            <button type="submit" class="button">Send</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
