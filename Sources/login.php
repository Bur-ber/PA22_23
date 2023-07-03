<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  addToLogVisit("Connexion");


if( !empty($_POST['mail']) && !empty($_POST['pwd'])){

  cleanByTrimAndLow($_POST['mail']);

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT id, pwd, status FROM " .PRE_DB. "USER WHERE mail=:mail");
  $queryPrepared -> execute(["mail" => $_POST['mail']]);
  $result = $queryPrepared -> fetch();

  if (!empty($result['pwd']) && password_verify($_POST["pwd"], $result['pwd'])) {
    if ($result['status'] != 0) {
      $_SESSION['mail'] = $_POST['mail'];
      $_SESSION['status'] = $result['status'];
      $_SESSION['id'] = $result['id'];
      $_SESSION['login'] = 1;
      $queryLogin = $connection -> prepare("UPDATE " .PRE_DB. "USER SET last_connection = :timestamp WHERE id=:id");
      //$queryLogin -> execute(["timestamp" => time(), "id" => $_SESSION['id']]);
      header("Location: index.php");
    }else {
      echo "Vous avez été banni, vous ne pouvez plus vous connecter";
    }
  }else {
    echo "L'email ou le mot de passe est incorrect";
  }
}
include 'templates/header.php';
?>

<div class="container">
  <h1>Se connecter</h1>
</div>

<form  action="login.php" method="POST">
<div class="mb-3" >
  <label for="mail" class="form-label">Votre email</label>
    <input type="email" name="mail" class="form-control" id="mail">
</div>

<div class="mb-3">
  <label for="pwd" class="form-label">Votre mot de passe </label>
    <input type="password" name="pwd" class="form-control" id="pwd">
</div>

<button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<a class="btn btn-danger" href="register.php">Pas encore inscrit ?</a>

<?php include 'templates/footer.php'?>
