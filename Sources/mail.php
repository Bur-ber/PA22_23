<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
  addToLogVisit("Messagerie");
  $connect = connectDB();
  $prepare = $connect-> query("SELECT * FROM ".PRE_DB."USER");
  $users = $prepare->fetchAll();
  foreach($users as $index => $user){
    if($user['id'] != $_SESSION['id']){
    ?>
    <a href="message.php?id=<?= $user['id'];?>">
      <p><?= $user['mail']; ?></p>
    </a>
    <?php
    }

  }

  include 'templates/footer.php'; ?>
