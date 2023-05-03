<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';

  if (empty($_SESSION['listID']) || empty($_SESSION['listQuantity'])) {
    header("Location: ../shop.php")
  }

  $listID = unserialize($_SESSION['listID']);
  $listQuantity = unserialize($_SESSION['listQuantity']);


  if(gettype($listID == 'array'){ // Si listID est un tableau ça vient du panier
    if (count($listID) == count($listQuantity)) {
      unset($_SESSION['listID']);
      unset($_SESSION['listQuantity']);
      header("Location: ../cart.php");
    }
    // Quand BDD de materiel modifier, retirer produit du panier du USER
    $connection = connectDB();
    foreach ($listID as $index => $ID) { // Boucle qui vérifie les quantités avant de modifier la BDD
      $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL WHERE id=:id");
      $queryPrepared -> execute(["id" => $ID]);
      $result = $queryPrepared -> fetch();
      if ($result['instock'] < $listQuantity[$index]) {
        $_SESSION['error'] = "L'une des quantité (". $result['name'] .") est erronée, modifier la ou attendez un restockage";
        unset($_SESSION['listID']);
        unset($_SESSION['listQuantity']);
        header("Location: ../cart.php");
      }
    }
    foreach ($listID as $index => $ID) { // Réduit la quantité en stock et retire l'élément de la BDD du panier
      $queryPrepared = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET instock = instock - :instock WHERE id=:id");
      $queryPrepared -> execute([
        "instock" => $listQuantity[$index],
        "id" => $ID
      ]);
      $queryDeleteFrCart = $connection -> prepare("DELETE FROM" .PRE_DB. "CART WHERE material=:material AND user=:user");
      $queryDeleteFrCart -> execute([
        "material" => $ID,
        "id" => $_SESSION['id']
      ]);
    }
    unset($_SESSION['listID']);
    unset($_SESSION['listQuantity']);
    header("Location: ../thanks.php");

  }
  // Rien ne s'éxécutera ici si listID est un Tableau
  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL WHERE id=:id");
  $queryPrepared -> execute(["id" => $listID]);
  $result = $queryPrepared -> fetch();
  if ($result['instock'] < intval($listQuantity)) {
    $_SESSION['error'] = "La quantité est erronée, modifier la ou attendez un restockage";
    unset($_SESSION['listID']);
    unset($_SESSION['listQuantity']);
    header("Location: ../material". $listID .".php");
  }
  $queryPrepared = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET instock = instock - :instock WHERE id=:id");
  $queryPrepared -> execute([
    "instock" => $listQuantity,
    "id" => $listID
  ]);
  
  // Rediriger page de remerciements quand tout fini
  unset($_SESSION['listID']);
  unset($_SESSION['listQuantity']);
  header("Location: ../thanks.php");
