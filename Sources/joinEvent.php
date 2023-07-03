<?php
session_start();
require 'core/const.php';
require 'core/functions.php';
$connect = connectDB();
$queryPrepared = $connection->prepare("INSERT INTO ".PRE_DB."JOIN(user, event) VALUES (:user, :event)");
$queryPrepared->execute([
    "user" => $_SESSION['id'],
    "event" => $_GET['id']
]);
header("Location:../readEvent.php?id=$_GET['id']");