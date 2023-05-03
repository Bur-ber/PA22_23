<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  $statusRequired = 1;

  // Verifier que l'id users existe et les 2 get sont présents
  redirectIfNotConnected($statusRequired)


  if ((empty($_GET['idMaterial']) || gettype($_GET['idMaterial']) != 'integer') || (empty($_GET['quantity'] || gettype($_GET['quantity']) != 'integer'))) {
    header("Location: ../shop.php");
  }elseif ($_GET['idMaterial'] <= 0 || $_GET['quantity'] <= 0) {
    $_SESSION['error'] = "L'idMaterial ou la quantité est invalide, inférieur ou égal à 0 est impossible";
    header("Location: ../shop.php");
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("INSERT INTO " .PRE_DB. "CART(material, user, quantity) VALUES (:material, :user, :quantity)");
  $queryPrepared -> execute([
    "material" => $_GET['idMaterial'],
    "user" => $_SESSION['id'],
    "quantity" => $_GET['quantity']
  ]);
