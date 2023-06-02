<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';


if(!isConnected()){
    header("Location:index.php");
  }
  
  include 'templates/header.php'; 

	//include('event/readEvent.php');
  include('event/listEvents.php');
  


 include 'templates/footer.php';
