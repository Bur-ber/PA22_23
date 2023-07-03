<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

  addToLogVisit("Informations Evénements");

  $getid = $_GET['id'];
  $event = getEvent($getid);
  foreach ($event as $index => $eventDetails){
    $eventName = $eventDetails['name'];
    $eventStart = $eventDetails['start_date'];
    $eventDescription = $eventDetails['description'];
    $eventPlace = $eventDetails['place'];
  }
?>
<div>
  <h1><?=ucwords($eventName)?></h1>
  <h3>A lieu le <?=$eventStart?></h3>
  <h3><img src="../Resources/images/position.png" alt="position_sign" width="30" height="30"><?=ucwords($eventPlace)?></h3>
  <p><?=$eventDescription?></p>
</div>
<?php if(hasJoined($_SESSION['id'])){
  ?><a href="quitEvent.php">Se désinscrire</a>
  <?php
}else{ ?>
  <a href="joinEvent.php">S'inscrire</a>
  <?php
}

 ?>


<?php include 'templates/footer.php'; ?>
