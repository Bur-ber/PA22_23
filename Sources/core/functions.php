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

// ----------- FORUM FUNCTIONS -----------
function post_exist($post_id): bool{
  $pdo = connectDB();
  $request = $pdo->prepare('SELECT * FROM '.PRE_DB.'POST WHERE id = :id_field');
  
  $request->execute([
    'id_field' => $post_id
  ]);

  return $request->rowCount() == 1;

}

function get_post($post_id){
  $pdo = connectDB();
  $request = $pdo->prepare("SELECT ".PRE_DB."POST.title, ".PRE_DB."POST.id as post_id, ".PRE_DB."POST.message, ".PRE_DB."POST.created_at, ".PRE_DB."user.mail  FROM ".PRE_DB."POST 
  INNER JOIN ".PRE_DB."USER ON ".PRE_DB."USER.id = ".PRE_DB."POST.user_id  WHERE ".PRE_DB."POST.id = :id_field ORDER BY created_at DESC");
  
  $request->execute([
    'id_field' => $post_id
  ]);

  return $request->fetch();
}

function get_answers($post_id){
    $connect = connectDB();
    $request = $connect->prepare('SELECT author, message, commented_at, user_id  FROM '.PRE_DB.'comment WHERE corresponding_post = :post ORDER BY commented_at DESC');

    $request->execute([
      'post' => $post_id,
    ]);

    return $request->fetchAll();
}

function create_post($title, $message){
  $pdo = connectDB();
  $request = $pdo->prepare('INSERT INTO '.PRE_DB.'POST (title, message, created_at, user_id) VALUES(:title, :message, now(), :user_id)');
  
  // TODO : modifier "el batardo" par $_SESSION['mail'] pour obtenir l'utilisateur souhaité
  $request->execute([
    'title' => $title,
    'message' => $message,
    'user_id' => $_SESSION['id']
  ]);
}


function create_comment_for_post($post, $comment){
  $pdo = connectDB();
  $request = $pdo->prepare('INSERT INTO '.PRE_DB.'COMMENT (author, message, commented_at, corresponding_post) VALUES(:author, :message, now(), :corresponding_post)');
 
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

// ----------- END FORUM FUNCTIONS -----------

// ------------  MP FUNCTIONS ----------------
function get_receiver($getid){
  $connection = connectDB();
    $getuser = $connection->prepare("SELECT * FROM ".PRE_DB."USER WHERE id = :id");
    $getuser->bindValue(':id', $getid, PDO::PARAM_INT);
    $getuser->execute();
    return $getuser;

}


function send_message($message, $getid){
    $connect = connectDB();
    $request = $connect->prepare('INSERT INTO '.PRE_DB.'message (message, sender, receiver, sent_at) VALUES(:message, :sender, :receiver, now())');
    $request->execute([
      'message' => $message,
      'sender' => $_SESSION['id'],
      'receiver' => $getid
    ]);

}

function get_message($getid){
  $connect = connectDB();
  $request = $connect->prepare('SELECT * FROM '.PRE_DB.'message WHERE (sender = :sender AND receiver = :receiver) OR (sender = :receiver AND receiver = :sender) ORDER BY sent_at ASC');
  $request->execute([
    'sender' => $_SESSION['id'],
    'receiver' => $getid
  ]);
  //$request->execute(array($_SESSION['id'], $getid, $getid, $_SESSION['id']));
  $messages = $request->fetchAll();
  return $messages;

}

function get_time($time){
  sscanf($time, "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde);
  $correctTime= $jour.'-'.$mois.'-'.$annee.' '.$heure.':'.$minute;
  return $correctTime;

}
function get_mail($getid){
  $connect = connectDB();
  $request = $connect->prepare('SELECT mail FROM '.PRE_DB.'USER WHERE id=?' );
  $request->execute(array($getid));
  $result = $request->fetch();
  return $result;
}

// ------------  MP FUNCTIONS END ----------------


function is_admin(){
  return isset($_SESSION) && $_SESSION['status'] == 4;
}

function is_mod(){
  return isset($_SESSION) && $_SESSION['status'] == 3;
}

function del_POST($post){
  
  $pdo = connectDB();

	$queryPrepared = $pdo->prepare("DELETE FROM " .PRE_DB. "POST WHERE id=:id");
	$queryPrepared->execute(["id" => $post]);

}
