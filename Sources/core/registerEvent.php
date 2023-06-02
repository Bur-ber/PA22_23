<?php
  session_start();
  require 'const.php';
  require 'functions.php';
  $status = 1

  redirectIfNotConnected($status);

  if (empty($_GET['event'])) {
    header("Location: ../event.php");
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("INSERT INTO ". PRE_DB ."JOIN(user, event) VALUES (:user, :event)");
  $queryPrepared -> execute(['user' => $_SESSION['id'], 'event' => $_GET['event']]);

  header("Location: ../event.php");
