<?php
  session_start(); // Démarre une sassion en générant un ID
  require 'functions.php';
  require 'const.php';

  // Objectif : Insertion du user en BDD


  //Récupération des données
  if(count($_POST) != 4
  || empty($_POST["cgu"])
  || empty($_POST["captcha"]){

    die("Exploitation faille xss détectée");
  }

  $captchaPieces = json_decode($_POST["captcha"]);

  for($i = 0; $i < 9; $i++){
    echo '<img src="'.$captchaPieces->$i.'" alt="Captcha image">';
  }

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
