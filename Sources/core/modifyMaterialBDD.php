<?php
  session_start();
  require 'const.php';
  require 'functions.php';
	$statusRequired = 3;

	redirectIfNotConnected($statusRequired);
	$listOfMaterial = unserialize($_SESSION['material']);
  unset($_SESSION['material']);
  $connection= connectDB();

  $listOfErrors = [];

  if (empty($_POST)) {
    $listOfErrors[] = "Aucun objet n'a été sélectionner";
  }

  if (!empty($_POST['name'])) {
    cleanByTrimAndUcword($_POST['name']);
    if (strlen($_POST['name']) < 5) {
      $listOfErrors[] = "Le nom est trop court";
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET name = :name WHERE id=:id");
      $queryModify -> execute(["name" => $_POST["name"], "id" => $listOfMaterial[$_POST['key']]["id"]]);
    }
  }

  if (!empty($_POST['brand'])) {
    cleanByTrimAndUpper($_POST['brand']);
    if (strlen($_POST['brand']) < 2) {
      $listOfErrors[] = "Le nom de marque est trop court";
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET brand = :brand WHERE id=:id");
      $queryModify -> execute(["brand" => $_POST["brand"], "id" => $listOfMaterial[$_POST['key']]["id"]]);
    }
  }

  if (!empty($_POST['desc'])) {
    trim($_POST['desc']);
    if (strlen($_POST['desc']) < 2) {
      $listOfErrors[] = "La description est trop courte";
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET desc = :desc WHERE id=:id");
      $queryModify -> execute(["desc" => $_POST["desc"], "id" => $listOfMaterial[$_POST['key']]["id"]]);
    }
  }

  if (!empty($_POST['img'])) {
    $imagePath = $listOfMaterial[$_POST['key']]['image'];
    unlink($imagePath);
    if(file_put_contents($imagePath, file_get_contents($_POST['img'])) == false){
      $listOfErrors[] = "L'image n'a pas pu être chargée";
    }
  }

  if (!empty($_POST['price'])) {
    if ($_POST['price'] <= 0) {
      $listOfErrors[] = "Le prix est incorrect";
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET price = :price WHERE id=:id");
      $queryModify -> execute(["price" => $_POST["price"], "id" => $listOfMaterial[$_POST['key']]["id"]]);
    }
  }

  if (!empty($_POST['instock'])) {
    if ($_POST['instock'] < 0) {
      $listOfErrors[] = "Le nombre d'objet en stock est incorrect";
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "MATERIAL SET instock = :instock WHERE id=:id");
      $queryModify -> execute(["instock" => $_POST["instock"], "id" => $listOfMaterial[$_POST['key']]["id"]]);
    }
  }

if (!empty($listOfErrors)) {
  $_SESSION['errors'] = serialize($listOfErrors);
  header("Location: ../modifyMaterial.php");
}

$queryLog = $connection -> prepare("INSERT INTO " .PRE_DB. "LOG(action, user, type) VALUES (:action, :user, :type)");
$queryLog -> execute(["action" => "à modifier un article du magasin.", "user" => $_SESSION['id'], "type" => "Modification article"]);
header("Location: ../shop.php");
