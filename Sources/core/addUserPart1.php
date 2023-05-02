<?php
session_start(); // Démarre une session en générant un ID
require 'functions.php';
require 'const.php';

// Objectif : Insertion du user en BDD


//Récupération des données
if(count($_POST) != 7
|| !isset($_POST["gender"])
|| empty($_POST["firstname"])
|| empty($_POST["lastname"])
|| empty($_POST["mail"])
|| empty($_POST["pwd"])
|| empty($_POST["pwdConfirm"])
|| empty($_POST["birthday"])){

  die("Exploitation faille xss détectée");
}

//Nettoyage des données

cleanByTrimAndUcword($_POST["firstname"]);
cleanLastname($_POST["lastname"]);
cleanByTrimAndLow($_POST["mail"]);

$listOfErrors = [];
//Vérification des données
$listOfGenders = [0, 1, 2];
if (!in_array($_POST["gender"], $listOfGenders)){
  $listOfErrors[] = "Ce genre n'existe pas";
}

if (strlen($_POST["firstname"]) < 2){
  $listOfErrors[] = "Le prénom doit faire plus de 2 charactères";
}

if (strlen($_POST["lastname"]) < 2){
  $listOfErrors[] = "Le nom doit faire plus de 2 charactères";
}

if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
  $listOfErrors[] = "L'email est incorrect";
}else{
  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT id FROM ".PRE_DB."user WHERE mail=:mail");
  $queryPrepared -> execute(["mail" => $_POST["mail"]]);
  $result = $queryPrepared -> fetch();
  if (!empty($result)) {
    $listOfErrors[] = "L'email est déjà utilisé";
  }
}


if(strlen($_POST["pwd"]) < 8 || !preg_match("#[0-9]#", $_POST["pwd"]) || !preg_match("#[a-z]#", $_POST["pwd"]) || !preg_match("#[A-Z]#", $_POST["pwd"])){
  $listOfErrors[] = "Format du mot de passe incorrect";
}

if ($_POST["pwd"] != $_POST["pwdConfirm"]){
  $listOfErrors[] = "Mot de passe de confirmation incorrecte";
}

// entre 13 et 90 ans
// birthday == chaine de caractere

$dateExploded = explode("-", $_POST["birthday"]); // Divise la chaine avec le séparateur désigné (dans un array)
if (!checkdate($dateExploded[1], $dateExploded[2], $dateExploded[0])){ // Vérifie que la date est correcte
  $listOfErrors[] = "Date de naissance incorrecte";
} else {
  $birthSecond = strtotime($_POST["birthday"]); // Convertit un format de date en sec
  $age = (time() - $birthSecond)/3600/24/365.26;
  if($age < 13 || $age > 90){
    $listOfErrors[] = "Age non compris entre 13 et 90 ans";
  }
}


if(empty($listOfErrors)){
  //Si OK
  // --> Insertion en BDD
  // Si on arrive pas à se connecter alors on fait un die avec erreur sql
  $queryPrepared = $connection -> prepare("INSERT INTO ".PRE_DB."user (firstname, lastname, mail, gender, birthday, pwd) 
  VALUES (:firstname, :lastname, :mail, :gender, :birthday, :pwd)");

  // Start Request
  $queryPrepared -> execute([
    "firstname" => $_POST["firstname"],
    "lastname" => $_POST["lastname"],
    "mail" => $_POST["mail"],
    "gender" => $_POST["gender"],
    "birthday" => $_POST["birthday"],
    "pwd" => password_hash($_POST["pwd"], PASSWORD_DEFAULT)
  ]);

  // header login.php
  $_SESSION['mail'] = $_POST['mail'];
  header("Location: ../registerPart2.php");

} else {
//Si NOK
// --> Redirection sur le register avec message d'erreurs
  $_SESSION["errors"] = serialize($listOfErrors); // Transforme le tableau en chaine de caractères
  header("Location: ../register.php"); // Redirige vers la page spécifié
}
