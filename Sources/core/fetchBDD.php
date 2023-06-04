<?php
  session_start();
  require 'const.php';
  require 'functions.php';

  if (isset($_POST['input'])) {
    $connection = connectDB();

    $queryProfil = $connection -> query("SELECT id, firstname, lastname FROM ". PRE_DB ."USER WHERE firstname LIKE '{$_POST['input']}%' OR lastname LIKE '{$_POST['input']}%' LIMIT 3", PDO::FETCH_ASSOC);
    $resultProfil = $queryProfil -> fetchAll();

    $queryMaterial = $connection -> query("SELECT id, name FROM ". PRE_DB ."MATERIAL WHERE name LIKE '{$_POST['input']}%' LIMIT 3", PDO::FETCH_ASSOC);
    $resultMaterial = $queryMaterial -> fetchAll();

    $queryEvent = $connection -> query("SELECT name FROM ". PRE_DB ."EVENT WHERE name LIKE '{$_POST['input']}%' LIMIT 3", PDO::FETCH_ASSOC);
    $resultEvent = $queryEvent -> fetchAll();

    $queryPost = $connection -> query("SELECT id, title FROM ". PRE_DB ."POST WHERE title LIKE '{$_POST['input']}%' LIMIT 3", PDO::FETCH_ASSOC);
    $resultPost = $queryPost -> fetchAll();

    if (count($resultProfil) > 0) {
      // Lien pour envoyer un message à la personne
      foreach ($resultProfil as $key => $value) {
      ?>
        <a href="message.php?id=<?php echo $value['id']; ?>">Ecrire à : <?php echo $value['firstname'] .' '. $value['lastname']; ?></a>
      <?php
      }
    }
    if (count($resultMaterial) > 0) {
      // Lien vers la page de l'objet
      foreach ($resultMaterial as $key => $value) {
      ?>
        <a href="material.php?id=<?php echo $value['id']; ?>">Page de l'objet : <?php echo $value['name']; ?></a>
      <?php
      }
    }
    if (count($resultEvent) > 0) {
      // Lien vers la page des évènements
      foreach ($resultEvent as $key => $value) {
      ?>
        <a href="event.php">Evènements : <?php echo $value['name']; ?></a>
      <?php
      }
    }
    if (count($resultPost) > 0) {
      // Lien vers la page des évènements
      foreach ($resultPost as $key => $value) {
      ?>
        <a href="forumIndex.php?post=<?php echo $value['id']; ?>">Lien du post : <?php echo $value['title']; ?></a>
      <?php
      }
    }
    if (count($resultProfil) == 0 && count($resultMaterial) == 0 && count($resultEvent) == 0 && count($resultPost) == 0) {
      echo "<h6>Aucune donnée trouvée</h6>";
    }


  }
