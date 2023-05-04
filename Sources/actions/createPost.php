<?php
session_start();
require('../core/const.php');
require('../core/functions.php');   
$errors = [];
if(isset($_POST)){
   if(count($_POST) != 2 || (!isset($_POST["title"]) || !isset($_POST["message"]))){
   die("Exploitation faille xss détectée");
   }

   if($_POST['title'] == ""){
      $errors['title'] = "Le titre doit être rempli";
   }
   if($_POST['message'] == ""){
      $errors['message'] = "Le message doit être rempli";
   }
   if(!empty($errors)){
      $_SESSION['errors'] = serialize($errors);
      header("Location: ../createPostForm.php");
      die();
       
   } else {
      create_post($_POST['title'], $_POST['message']);
      $_SESSION['success'] = "Votre post a été créé.";
      header("Location: ../forumIndex.php");
   }
}
echo "Il n'y a rien à voir ici";