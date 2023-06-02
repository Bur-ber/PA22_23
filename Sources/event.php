<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB."EVENT");
  $queryPrepared -> execute();
  $result = $queryPrepared -> fetchAll();

  if (empty($result)) {
    echo "Aucun évènement disponible";
  }else {
    foreach ($result as $key => $value) {
      $queryGuest = $connection -> prepare("SELECT count(user) FROM ". PRE_DB."JOIN WHERE event=:id");
      $queryGuest -> execute(['id' => $value['id']]);
      $nbGuest = $queryGuest -> fetch();
      ?>

      <div class="event">
        <div class="name">
          <span><?php echo $value['name']; ?></span>
        </div>
        <div class="place">
          <span>L'évènement aura lieu : <?php echo $value['place']; ?></span>
        </div>
        <div class="date">
          <?php if ($value['start_date'] == $value['end_date']) { ?>
            <span>L'évènement aura lieu le : <?php echo $value['start_date']; ?></span>
          <?php }else { ?>
            <span>L'évènement aura lieu du : <?php echo $value['start_date']; ?> au <?php echo $value['end_date']; ?></span>
          <?php } ?>
        </div>
        <div class="description">
          <span>Description : <br> <?php echo $value['description']; ?></span>
        </div>
        <div class="guest">
          <span>Nombre de participant actuel : <br> <?php echo $nbGuest[0]; if ($value['nbr_space'] != 0) {
            echo "sur " . $value['nbr_space'];
          } ?></span>
        </div>
        <div class="price">
          <span>Prix d'inscription : <?php if ($value['price'] == 0) {
            echo "Gratuit";
          }else {
            echo $value['price'] . '€ (à payer sur place)';
          } ?></span>
        </div>
        <?php if ($value['on_register'] == 0) {
          echo "<button>Aucune inscription nécessaire</button>";
        }else {
          if (strtotime("+7 day", strtotime($value['register'])) < date("d-m-y")) {
            echo "<a href='core/registerEvent.php?event=".$value['id']."'>S'inscrire</a>";
          }else{
          echo "<button>Inscription terminé</button>";
          }
        } ?>
      </div>

      <?php
    }
  }

 if(isConnected() && $_SESSION['status'] > 1){ ?>
  <div class="addEvent">
    <a href="newEvent.php">
      <span>Ajouter un évènement</span>
    </a>
  </div>
   <div class="deleteEvent">
     <a href="deleteEvent.php">
       <span>Supprimer un évènement</span>
     </a>
   </div>

<?php }

<?php include 'templates/footer.php'; ?>
