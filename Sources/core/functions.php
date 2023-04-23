<?php

function cleanLastname(&$lastname){
  $lastname = strtoupper(trim($lastname));
}

function cleanByTrimAndUcword(&$name){
  $name = ucwords(strtolower(trim($name)));
}

function cleanByTrimAndLow(&$string){
  $string = strtolower(trim($string));
}

function connectDB(){
  try {
    $connection = new PDO(DSN_DB, USER_DB, PWD_DB);
  } catch (Exception $e) {
    die("Erreur SQL". $e -> getMessage());
  }
  return $connection;
}

function isConnected(){

  if(!empty($_SESSION['email']) && !empty($_SESSION['login']) && $_SESSION['login'] == 1){

    $connect = connectDB();
    $queryPrepared = $connect -> prepare('SELECT id FROM ' .PRE_DB. 'user WHERE mail=:email');
    $queryPrepared -> execute(['email'=> $_SESSION['email']]);
    $result = $queryPrepared -> fetch();

    if (!empty($result)){
      return true;
    }
  }

  return false;
}

function redirectIfNotConnected(){
  if(!isConnected()){
    header("Location: login.php");
  }
}
