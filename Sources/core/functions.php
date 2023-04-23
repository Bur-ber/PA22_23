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
