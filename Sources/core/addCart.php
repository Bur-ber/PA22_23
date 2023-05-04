<?php
  session_start();
  require 'const.php';
  require 'functions.php';

  // Verifier que l'id users existe et les 2 get sont présents


  if (empty($_GET['idMaterial']) || empty($_GET['quantity'])) {
    $_SESSION['error'] = "Une erreur s'est glissée quelque part";
    header("Location: ../shop.php");
  }elseif ($_GET['idMaterial'] <= 0 || $_GET['quantity'] <= 0) {
    $_SESSION['error'] = "L'idMaterial ou la quantité est invalide, inférieur ou égal à 0 est impossible";
    header("Location: ../shop.php");
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("INSERT INTO " .PRE_DB. "CART(material, user, quantity) VALUES (:material, :user, :quantity)");
  $queryPrepared -> execute([
    "material" => intval($_GET['idMaterial']),
    "user" => $_SESSION['id'],
    "quantity" => intval($_GET['quantity'])
  ]);

  header("Location: ../shop.php");
