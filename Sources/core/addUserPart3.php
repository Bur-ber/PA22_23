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
