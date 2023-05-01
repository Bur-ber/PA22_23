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

  if(!empty($_SESSION['mail']) && !empty($_SESSION['login']) && $_SESSION['login'] == 1){

    $connect = connectDB();
    $queryPrepared = $connect -> prepare('SELECT id FROM ' .PRE_DB. 'USER WHERE mail=:mail');
    $queryPrepared -> execute(['mail'=> $_SESSION['mail']]);
    $result = $queryPrepared -> fetch();

    if (!empty($result)){
      return true;
    }
  }

  return false;
}

function redirectIfNotConnected($status){
  if(!isConnected()){
    header("Location: login.php");
  }
  redirectIfNotAuthorized($status);
}

function redirectIfNotAuthorized($status){
  $queryPrepared = $connect -> prepare('SELECT status FROM ' .PRE_DB. 'USER WHERE mail=:mail');
  $queryPrepared -> execute(['mail'=> $_SESSION['mail']]);
  $result = $queryPrepared -> fetch();

  if ($result['id'] < $status){
    header("Location: index.php");
  }
}
