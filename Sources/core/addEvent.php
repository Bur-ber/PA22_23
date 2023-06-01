<?php
  session_start();
  require 'const.php';
  require 'functions.php';

  $listOfErrors = []

  if (!empty($_POST['place'])
  && !empty($_POST['desc'])
  && !empty($_POST['register'])
  && !empty($_POST['start'])
  && !empty($_POST['end'])) {

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
    if ($_POST['end'] < date("d-m-y") || $_POST['register'] + 7 < date("d-m-y")) {
      $listOfErrors[] = "L'évènement ne peut être passé";
    } elseif ($_POST['end'] < $_POST['start']) {
      $listOfErrors[] = "La date de fin est antérieure à celle du début";
    }elseif ($_POST['end'] < $_POST['register'] || $_POST['start'] < $_POST['register'] + 7) {
      $listOfErrors[] = "La date d'inscription ne peut être antérieure au autres dates";
    }
  }else {
    $listOfErrors[] = "L'une des valeurs est manquante";
  }


  if (!empty($listOfErrors)) {
    $_SESSION['errors'] = serialize($listOfErrors);
    header("Location: ../newEvent.php");
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("INSERT INTO ". PRE_DB ."EVENT(place, description, register_start, start_date, end_date) VALUES (:place, :description, :register_start, :start_date, :end_date)");
  $queryPrepared -> execute(['place' => $place, 'description' => $desc, 'register_start' => $_POST['register'], 'start_date' => $_POST['start'], 'end_date' => $_POST['end']]);
  header("Location: ../event.php");
