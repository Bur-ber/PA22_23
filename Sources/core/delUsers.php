<?php
	session_start();
	require "const.php";
	require "functions.php";
	$statusRequired = 4;

	redirectIfNotConnected($statusRequired);

	$connect = connectDB();
	$queryPrepared = $connect->prepare("DELETE FROM " .PRE_DB. "USER WHERE id=:id");
	$queryPrepared->execute(["id" => $_GET['id']]);

	header("Location: ../users.php");
