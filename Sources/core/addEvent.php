<?php
  session_start();
  require 'const.php';
  require 'functions.php';

  $listOfErrors = [];

  if (!empty($_POST['place'])
  && !empty($_POST['desc'])
  && !empty($_POST['start'])
  && !empty($_POST['end'])
  && !empty($_POST['name'])
  && $_POST['nbr_space'] >= 0
  && $_POST['price'] >= 0
  && $_POST['on_register-select'] >= 0
) {

    cleanByTrimAndUcword($_POST['name']);
    if (strlen($_POST['name']) < 2) {
      $listOfErrors[] = "Nom de l'évènement trop court";
    }

    if ($_POST['nbr_space'] < 0) {
      $listOfErrors[] = "Nombre de place incorrecte";
    }

    if ($_POST['price'] < 0) {
      $listOfErrors[] = "Prix incorrect";
    }

    if ($_POST['on_register-select'] != 0 && $_POST['on_register-select'] != 1) {
      $listOfErrors[] = "Valeur sur inscription incorrecte";
    }elseif ($_POST['on_register-select'] == 0) {
      $_POST['register'] = date("y-m-d");
    }

    $place = trim($_POST['place']);
    if (strlen($place) < 2) {
      $listOfErrors[] = "Nom du lieu trop court";
    }

    $desc = trim($_POST['desc']);
    if (strlen($desc) < 2) {
      $listOfErrors[] = "Description trop courte";
    }

    $dateRegister = explode("-", $_POST['register']);
    $dateStart = explode("-", $_POST['start']);
    $dateEnd = explode("-", $_POST['end']);
    if (!checkdate($dateRegister[1], $dateRegister[2], $dateRegister[0]) || !checkdate($dateStart[1], $dateStart[2], $dateStart[0]) || !checkdate($dateEnd[1], $dateEnd[2], $dateEnd[0])){
      $listOfErrors[] = "L'une des dates est incorrecte";
    }
    if ($_POST['end'] < date("d-m-y") || strtotime("+7 day", strtotime($_POST['register'])) < date("d-m-y")) {
      $listOfErrors[] = "L'évènement ne peut être passé";
    } elseif ($_POST['end'] < $_POST['start']) {
      $listOfErrors[] = "La date de fin est antérieure à celle du début";
    }elseif ($_POST['end'] < $_POST['register'] || $_POST['start'] < strtotime("+7 day", strtotime($_POST['register']))) {
      $listOfErrors[] = "La date d'inscription ne peut être futur au autres dates";
    }
  }else {
    $listOfErrors[] = "L'une des valeurs est manquante";
  }




  if (!empty($listOfErrors)) {
    $_SESSION['errors'] = serialize($listOfErrors);
    header("Location: ../newEvent.php");
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("INSERT INTO ". PRE_DB ."EVENT(place, description, register_start, start_date, end_date, name, nbr_space, price, on_register) VALUES (:place, :description, :register_start, :start_date, :end_date, :name, :nbr_space, :price, :on_register)");
  $queryPrepared -> execute(['place' => $place, 'description' => $desc, 'register_start' => $_POST['register'], 'start_date' => $_POST['start'], 'end_date' => $_POST['end'], 'name' => $_POST['name'], 'nbr_space' => $_POST['nbr_space'], 'price' => $_POST['price'], 'on_register' => $_POST['on_register-select']]);
  $_SESSION['optEvent'] = $_POST;
  $file = fopen('mail/event/chosen.txt', 'r');
  sendNews('Nouvel événement à ne pas manquer !', fread($file, 1), 'event');
  fclose($file);
  header("Location: ../event.php");
