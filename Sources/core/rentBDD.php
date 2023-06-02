<?php
  session_start();
  require 'const.php';
  require 'functions.php';

  if (empty($_SESSION['listID']) || empty($_SESSION['listQuantity']) || empty($_GET['week'])) {
    unset($_SESSION['listID']);
    unset($_SESSION['listQuantity']);
    header("Location: ../shop.php");
  }

  $listID = unserialize($_SESSION['listID']);
  $listQuantity = unserialize($_SESSION['listQuantity']);
  $week = intval($_GET['week']);

  if ($week < 0 || $week > 5) {
    header("Location: ../rent.php?idMaterial=". $listID ."&quantity=". $listQuantity);
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("INSERT INTO " .PRE_DB. "RENT(user, material, quantity, time) VALUES (:user, :material, :quantity, :time)");
  $queryPrepared -> execute(["user" => $_SESSION['id'],
  "material" => $listID,
  "quantity" => $listQuantity,
  "time" => $week;
  ]);

  unset($_SESSION['listID']);
  unset($_SESSION['listQuantity']);

  $queryLog = $connection -> prepare("INSERT INTO " .PRE_DB. "LOG(action, user, type) VALUES (:action, :user, :type)");
  $queryLog -> execute(["action" => "à louer un à plusieurs article pour ". $week ."semaines.", "user" => $_SESSION['id'], "type" => "Location"]);

  header("Location: ../thanks.php");
