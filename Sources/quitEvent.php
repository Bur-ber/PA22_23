<?php
session_start();
require 'core/const.php';
require 'core/functions.php';
$connect = connectDB();
$queryPrepared = $connect->prepare("DELETE FROM " .PRE_DB. "JOIN  WHERE user=:id");
$queryPrepared->execute(["id" => $_SESSION['id']]);


header("Location:../readEvent.php?id=$_GET['id']");