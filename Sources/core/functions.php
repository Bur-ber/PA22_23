<?php

/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
*/

function cleanLastname(&$lastname){ // Pour les noms de famille
  $lastname = strtoupper(trim($lastname));
}

function cleanByTrimAndUcword(&$name){ // Principalement pour les prénoms et noms des objets
  $name = ucwords(strtolower(trim($name)));
}

function cleanByTrimAndUpper(&$name){ // Principalement pour le nom des marques
  $name = strtoupper(trim($name));
}

function cleanByTrimAndLow(&$string){ // Principalement pour les adresses mails
  $string = strtolower(trim($string));
}

function connectDB(){
  try {
    $connection = new PDO(DSN_DB, USER_DB, PWD_DB);
  } catch (Exception $e) {
    die("Erreur SQL". $e -> getMessage());
  }
  return $connection;
}

function isConnected(){

  if(!empty($_SESSION['id']) && !empty($_SESSION['login']) && $_SESSION['login'] == 1){

    $connect = connectDB();
    $queryPrepared = $connect -> prepare('SELECT id FROM '.PRE_DB.'USER WHERE id=:id');
    $queryPrepared -> execute(['id' => $_SESSION['id']]);
    $result = $queryPrepared -> fetch();

    if (!empty($result)){
      return true;
    }
  }

  return false;
}

function redirectIfNotConnected($status)
{
  if(!isConnected()){
    header("Location: login.php");
  }
  redirectIfNotAuthorized($status);
}

function redirectIfNotAuthorized($status){
  if ($_SESSION['status'] < $status){
    header("Location: index.php");
  }
}

function post_exist($post_id): bool{

  $pdo = connectDB();

  $request = $pdo->prepare('SELECT * FROM '.PRE_DB.'forumposts WHERE id = :id_field');

  $request->execute([
    'id_field' => $post_id
  ]);

  return $request->rowCount() == 1;

}

function get_post($post_id){
  $pdo = connectDB();

  $request = $pdo->prepare("SELECT ".PRE_DB."forumposts.title, ".PRE_DB."forumposts.id as post_id, ".PRE_DB."forumposts.message, ".PRE_DB."forumposts.last_answered, ".PRE_DB."user.mail  FROM ".PRE_DB."forumposts
  INNER JOIN ".PRE_DB."user ON ".PRE_DB."user.id = ".PRE_DB."forumposts.user_id  WHERE ".PRE_DB."forumposts.id = :id_field ORDER BY last_answered DESC");

  $request->execute([
    'id_field' => $post_id
  ]);

  return $request->fetch();
}

function get_answers($post_id){

    // on se connecte à notre base de données
    $connect = connectDB();

    // on prépare notre requête
    $request = $connect->prepare('SELECT author, message, answerDate, user_id  FROM '.PRE_DB.'forumanswers WHERE corresponding_post = :post ORDER BY answerDate DESC');

    $request->execute([
      'post' => $post_id,
    ]);

    return $request->fetchAll();
}

function create_post($title, $message){

  $pdo = connectDB();

  $request = $pdo->prepare('INSERT INTO '.PRE_DB.'forumposts (title, message, last_answered, user_id) VALUES(:title, :message, now(), :user_id)');

  // TODO : modifier "el batardo" par $_SESSION['mail'] pour obtenir l'utilisateur souhaité
  $request->execute([
    'title' => $title,
    'message' => $message,
    'user_id' => $_SESSION['id']
  ]);

}


function create_comment_for_post($post, $comment){

  $pdo = connectDB();

  $request = $pdo->prepare('INSERT INTO '.PRE_DB.'forumanswers (author, message, answerDate, corresponding_post) VALUES(:author, :message, now(), :corresponding_post)');

  // TODO : modifier "el batardo" par $_SESSION['mail'] pour obtenir l'utilisateur souhaité
  $request->execute([
    'author' => $_SESSION['mail'],
    'message' => $comment,
    'corresponding_post' => $post
  ]);

}


function is_answer_owner($response_user_id): bool {

  return $response_user_id == $_SESSION['id'];

}

function is_admin(){
  return isset($_SESSION) && $_SESSION['status'] == 4;
}

function del_post($post){

  $pdo = connectDB();

	$queryPrepared = $pdo->prepare("DELETE FROM " .PRE_DB. "forumposts WHERE id=:id");
	$queryPrepared->execute(["id" => $post]);

}
