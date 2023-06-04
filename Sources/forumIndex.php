<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';

  if(!isConnected()){
    header("Location:index.php");
  }

  include 'templates/header.php';


  if(isset($_GET['post']) && post_exist($_GET['post'])){
	include('forum/readPost.php');
  }
  else {
	include('forum/listPosts.php');
   }

   include 'templates/footer.php';
