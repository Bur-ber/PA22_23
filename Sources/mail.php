<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  //include 'templates/header.php'; 
  

  if(!isConnected()){
    header("Location:login.php");

  }else{
    include 'templates/header.php'; 
    $connect = connectDB();
    $prepare = $connect-> query("SELECT * FROM ".PRE_DB."user");
    $users = $prepare->fetchAll();
    foreach($users as $index => $user){
      if($user['id'] != $_SESSION['id']){
      ?>
      <a href="message.php?id=<?= $user['id'];?>">
        <p><?= $user['pseudo']; ?></p>
      </a>
      <?php 
      }

    } 
  }
  ?>
<?php include 'templates/footer.php'; ?>
