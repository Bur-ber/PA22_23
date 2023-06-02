<?php
  session_start();
  require 'const.php';
  require 'functions.php';
	$statusRequired = 2;

	redirectIfNotConnected($statusRequired);

  // Supprimer l'event de la table event et de la table join ou id == event

  if (empty($_POST['event'])) {
    header("Location: ../deleteEvent.php");
  }

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("DELETE FROM ". PRE_DB ."EVENT WHERE id=:id");
  $queryPrepared -> execute(['id' => $_POST['event']]);

  $queryPrepared = $connection -> prepare("DELETE FROM ". PRE_DB ."JOIN WHERE event=:id");
  $queryPrepared -> execute(['id' => $_POST['event']]);

  header("Location: ../event.php");
