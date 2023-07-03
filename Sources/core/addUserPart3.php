<?php
  session_start(); // Démarre une sassion en générant un ID
  require 'functions.php';
  require 'const.php';

  // Objectif : Insertion du user en BDD

  //Récupération des données
  if(empty($_POST["cgu"])){
    $listOfErrors[] = "Les CGUs doivent être lues et acceptés";
  }

  $captchaPieces = json_decode($_POST["listPieces"]);
  $rightOrder = unserialize($_SESSION['rightOrder']);

  if (!empty($_POST["event"])) {
    $event = 1;
  }else {
    $event = 0;
  }
  if (!empty($_POST["shop"])) {
    $shop = 1;
  }else {
    $shop = 0;
  }

  $samePath = 0;
  foreach ($rightOrder as $index => $value) {
    if ($index - 3 < 0) {
      if(strcmp("http://193.70.41.26/images/forCaptcha/captchaPieces/" . $value, $captchaPieces[$index * 3]->src) == 0){
        $samePath++;
      }
    }else if ($index - 6 < 0){
      if(strcmp("http://193.70.41.26/images/forCaptcha/captchaPieces/" . $value, $captchaPieces[(($index * 3) % 9) + 1]->src) == 0){
        $samePath++;
      }
    }else {
      if(strcmp("http://193.70.41.26/images/forCaptcha/captchaPieces/" . $value, $captchaPieces[(($index * 3) % 9) + 2]->src) == 0){
        $samePath++;
      }
    }
  }


  if ($samePath != 9) {
    $listOfErrors[] = "Captcha incorrect";
  }

  if (!empty($listOfErrors)) {
    $_SESSION["errors"] = serialize($listOfErrors);
    header("Location: ../registerPart3.php");
  }else {
    $connection = connectDB();
    $queryPrepared = $connection -> prepare("UPDATE " .PRE_DB. "USER SET event=:event, shop=:shop WHERE mail=:mail");

    // Start Request
    $queryPrepared -> execute([
      "event" => $event,
      "shop" => $post,
      "mail" => $_SESSION['mail']
    ]);

    $queryGetID = $connection -> prepare("SELECT id FROM" .PRE_DB. "USER WHERE mail = :mail");
    $queryGetID -> execute(["mail" => $_SESSION['mail']]);
    $result = $queryGetID -> fetch();

    $queryLog = $connection -> prepare("INSERT INTO " .PRE_DB. "LOG(action, user, type) VALUES (:action, :user, :type)");
    $queryLog -> execute(["action" => "à créer son profil.", "user" => $result['id'], "type" => "Création profil"]);

    $piecesPath = glob('../images/forCaptcha/captchaPieces/*.jpg');
    foreach ($piecesPath as $piece){
      unlink($piece);
    }
    header("Location: ../login.php");
  }
