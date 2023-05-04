<?php

session_start();

require '../core/const.php';
require '../core/functions.php';

if (!isset($_POST)){
    http_response_code(405);
    exit();
}


$errors = [];

if(count($_POST) != 2 || (empty($_POST["post_id"]) || !isset($_POST["comment"]))){
  die("Exploitation faille xss détectée");
}

if(!post_exist($_POST['post_id'])){
    $errors['post'] = "Le poste n'existe pas";
}

if($_POST['comment'] == ""){
    $errors['comment'] = "Le commentaire doit être rempli";
}

if(!empty($errors)){
    $_SESSION['errors'] = serialize($errors);
} else {
    create_comment_for_post($_POST['post_id'], $_POST['comment']);
    $_SESSION['success'] = "Votre commentaire a bien été ajouté.";
}

header('Location: ../forumIndex.php?post='. $_POST['post_id']);

