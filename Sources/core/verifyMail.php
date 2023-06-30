<?php
	session_start();
	require 'const.php';
	require 'functions.php';

  $connection= connectDB();
  $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET verified_mail = 1 WHERE id=:id");
  $queryModify -> execute(["id" => $_GET['id']);

  header("Location: account.php");
