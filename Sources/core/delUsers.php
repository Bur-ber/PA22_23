<?php
	session_start();
	require "const.php";
	require "functions.php";


	redirectIfNotConnected();

	$connect = connectDB();
	$queryPrepared = $connect->prepare("DELETE FROM KF20R6U8_user WHERE id=:id");
	$queryPrepared->execute(["id"=>$_GET['id']]);

	header("Location: ../users.php");