<?php
session_start(); // Démarre une sassion en générant un ID
require 'functions.php';
require 'const.php';

// Objectif : Insertion du user en BDD


//Récupération des données
if(count($_POST) != 4
|| empty($_POST["address"])
|| empty($_POST["postal"])
|| empty($_POST["city"])){

  die("Exploitation faille xss détectée");
}

cleanByTrimAndLow($_POST['address']);
cleanByTrimAndUcword($_POST['city']);

$listOfErrors = [];

if(strlen($_POST['postal']) != 5){
  $listOfErrors[] = "Code postale incorrect";
}

if(strlen($_POST['city']) < 1){ // Y a une ville en France avec une seule lettre...
  $listOfErrors[] = "Nom de ville trop court";
}

if(empty($listOfErrors)){
//Si OK
// --> Insertion en BDD

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("UPDATE " .PRE_DB. "USER SET address=:address, complement=:complement, postal=:postal, city=:city WHERE mail=:mail");

// Start Request
  $queryPrepared -> execute([
    "address" => $_POST["address"],
    "complement" => $_POST["complement"],
    "postal" => $_POST["postal"],
    "city" => $_POST["city"],
    "mail" => $_SESSION['mail']
  ]);

  header("Location: ../captcha.php");

} else {
//Si NOK
// --> Redirection sur le register avec message d'erreurs
  $_SESSION["errors"] = serialize($listOfErrors); // Transforme le tableau en chaine de caractères
  header("Location: ../registerPart2.php"); // Redirige vers la page spécifié
}
