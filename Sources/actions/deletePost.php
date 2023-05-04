<?php
session_start();
require('../core/const.php');
require('../core/functions.php');   
$errors = [];
if(isset($_POST)){
   if (count($_POST) != 1 || (empty($_POST["post_id"]))){
      die("Exploitation faille xss détectée");
   }

   if(post_exist($_POST["post_id"]) && is_admin()){
      del_post($_POST["post_id"]);
   }

   $_SESSION['success'] = "Le post a été supprimé.";
   header("Location: ../forumIndex.php");
   
}
echo "Il n'y a rien à voir ici";