<?php
	session_start();
	require "const.php";
	require "functions.php";
	$statusRequired = 4;

	redirectIfNotConnected($statusRequired);

	$connect = connectDB();
	$queryPrepared = $connect->prepare("UPDATE ".PRE_DB."USER SET status = 0  WHERE id=:id ");
	$queryPrepared->execute(["id" => $_GET['id']]);

	header("Location: ../adminPanel.php");