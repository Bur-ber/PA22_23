<?php
  session_start(); // Démarre une sassion en générant un ID
  require 'functions.php';
  require 'const.php';

  // Objectif : Insertion du user en BDD

  //Récupération des données
  if(count($_POST) < 2 || count($_POST) > 4
  || empty($_POST["cgu"])
  || empty($_POST["listPieces"])){

    die("Exploitation faille xss détectée");
  }

  $captchaPieces = json_decode($_POST["listPieces"]);
  $rightOrder = unserialize($_SESSION['rightOrder']);

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


  if ($samePath == 9) {
    $connection = connectDB();
    $queryPrepared = $connection -> prepare("UPDATE " .PRE_DB. "USER SET event=:event, shop=:shop WHERE mail=:mail");

    // Start Request
    $queryPrepared -> execute([
      "event" => $_POST["event"],
      "shop" => $_POST["shop"],
      "mail" => $_SESSION['mail']
    ]);

    $piecesPath = glob('images/forCaptcha/captchaPieces/*.jpg');
    foreach ($piecesPath as $piece){
      unlink($piece);
    }
    header("Location: ../login.php");
  } else {
    header("Location: ../captcha.php");
  }
