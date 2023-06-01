<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

?>

<div class="container">
  <h1>Modifier mon profil</h1>
  <h2>Inutile de remplir les champs que vous ne voulez pas modifier</h2>
</div>

<?php
  $connection = connectDB();
  $queryForm = $connection -> prepare("SELECT * FROM ".PRE_DB."USER WHERE id = :id");
  $queryForm -> execute(["id" => $_SESSION["id"]]);
  $form = $queryForm -> fetch();
  if( !empty($_POST['gender'])
  || !empty($_POST['firstname'])
  || !empty($_POST['lastname'])
  || !empty($_POST['mail'])
  || !empty($_POST['pwd'])
  || !empty($_POST['altPwd'])
  || !empty($_POST['altPwdConfirm'])
  || !empty($_POST['birthday'])
  || !empty($_POST['address'])
  || !empty($_POST['complement'])
  || !empty($_POST['postal'])
  || !empty($_POST['city'])
  || !empty($_POST['event'])
  || !empty($_POST['shop']))
  {
    if (!empty($_POST['gender'])) {
      $listOfGenders = [0, 1, 2];
      if (!in_array($_POST["gender"], $listOfGenders)){
        echo "Genre incorrect";
      }else {
        $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET gender = :gender WHERE id=:id");
        $queryModify -> execute(["gender" => $_POST['gender'], "id" => $_SESSION["id"]]);
      }
    }
    if (!empty($_POST['firstname'])) {
      cleanByTrimAndUcword($_POST['firstname']);
      if (strlen($_POST["firstname"]) < 2) {
        echo "Prénom trop court.";
      }else {
        $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET firstname = :firstname WHERE id=:id");
        $queryModify -> execute(["firstname" => $_POST["firstname"], "id" => $_SESSION["id"]]);
      }
    }
    if (!empty($_POST['lastname'])) {
      cleanLastname($_POST['lastname']);
      if (strlen($_POST["lastname"]) < 2) {
        echo "Nom trop court.";
      }else {
        $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET lastname = :lastname WHERE id=:id");
        $queryModify -> execute(["lastname" => $_POST["lastname"], "id" => $_SESSION["id"]]);
      }
    }
    if (!empty($_POST['mail'])) {
      cleanByTrimAndLow($_POST["mail"]);
      if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
        echo "L'email est incorrect";
      }else{
        $queryPrepared = $connection -> prepare("SELECT id FROM ".PRE_DB."USER WHERE mail=:mail");
        $queryPrepared -> execute(["mail" => $_POST["mail"]]);
        $result = $queryPrepared -> fetch();
        if (!empty($result)) {
          echo "L'email est déjà utilisé";
        } else {
          $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET mail = :mail WHERE id=:id");
          $queryModify -> execute(["mail" => $_POST["mail"], "id" => $_SESSION["id"]]);
        }
      }
    }
    if (!empty($_POST['pwd']) && !empty($_POST['altPwd']) && !empty($_POST['altPwdConfirm'])) {
      if (password_verify($_POST["pwd"], $Format['pwd'])) {
        if (strlen($_POST['altPwd']) < 8 || !preg_match("#[0-9]#", $_POST['altPwd']) || !preg_match("#[a-z]#", $_POST['altPwd']) || !preg_match("#[A-Z]#", $_POST['altPwd'])) {
          echo "Format du mot de passe incorrect";
        } else {
          if ($_POST['altPwd'] != $_POST['altPwdConfirm']){
            echo "Mot de passe de confirmation incorrect";
          }else {
            if (password_verify($_POST["altPwd"], $result['pwd'])) {
              echo "Le nouveau mot de passe doit être différent de l'ancien";
            }else {
              $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET pwd = :pwd WHERE id=:id");
              $queryModify -> execute(["pwd" => password_hash($_POST["altPwd"], PASSWORD_DEFAULT), "id" => $_SESSION["id"]]);
            }
          }
        }
      }else {
        echo "Ancien mot de passe incorrect";
      }
    }elseif ((!empty($_POST['pwd']) && !empty($_POST['altPwd'])) || (!empty($_POST['pwd']) && !empty($_POST['altPwdConfirm'])) || (!empty($_POST['altPwd']) && !empty($_POST['altPwdConfirm']))) {
      echo "Il manque un ou des mot de passe";
    }elseif (!empty($_POST['pwd']) || !empty($_POST['altPwd']) || !empty($_POST['altPwdConfirm'])) {
      echo "Il manque un ou des mot de passe";
    }
    if (!empty($_POST['birthday'])) {
      $dateExploded = explode("-", $_POST["birthday"]); // Divise la chaine avec le séparateur désigné (dans un array)
      if (!checkdate($dateExploded[1], $dateExploded[2], $dateExploded[0])){ // Vérifie que la date est correcte
        echo "Date de naissance incorrecte";
      } else {
        $birthSecond = strtotime($_POST["birthday"]); // Convertit un format de date en sec
        $age = (time() - $birthSecond)/3600/24/365.26;
        if($age < 13 || $age > 90){
          echo "Age non compris entre 13 et 90 ans";
        }else {
          $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET birthday = :birthday WHERE id=:id");
          $queryModify -> execute(["birthday" => $_POST['birthday'], "id" => $_SESSION["id"]]);
        }
      }
    }
    if (!empty($_POST['address'])) {
      cleanByTrimAndLow($_POST['address']);
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET address = :address WHERE id=:id");
      $queryModify -> execute(["address" => $_POST['address'], "id" => $_SESSION["id"]]);
    }

    $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET complement = :complement WHERE id=:id");
    $queryModify -> execute(["complement" => $_POST['complement'], "id" => $_SESSION["id"]]);

    if (!empty($_POST['postal'])) {
      if(strlen($_POST['postal']) != 5){
        echo "Code postale incorrect";
      }else {
        $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET postal = :postal WHERE id=:id");
        $queryModify -> execute(["postal" => $_POST['postal'], "id" => $_SESSION["id"]]);
      }
    }
    if (!empty($_POST['city'])) {
      cleanByTrimAndUcword($_POST['city']);
      if(strlen($_POST['city']) < 1){
        echo "Nom de ville trop court";
      }else {
        $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET city = :city WHERE id=:id");
        $queryModify -> execute(["city" => $_POST['city'], "id" => $_SESSION["id"]]);
      }
    }
    if (!empty($_POST['event'])) {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET event = :event WHERE id=:id");
      $queryModify -> execute(["event" => 1, "id" => $_SESSION["id"]]);
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET event = :event WHERE id=:id");
      $queryModify -> execute(["event" => 0, "id" => $_SESSION["id"]]);
    }
    if (!empty($_POST['shop'])) {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET shop = :shop WHERE id=:id");
      $queryModify -> execute(["shop" => 1, "id" => $_SESSION["id"]]);
    }else {
      $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET shop = :shop WHERE id=:id");
      $queryModify -> execute(["shop" => 0, "id" => $_SESSION["id"]]);
    }
    $queryModify = $connection -> prepare("UPDATE " .PRE_DB. "USER SET updated_at = :timestamp WHERE id=:id");
    $queryModify -> execute(["timestamp" => time() + 7200, "id" => $_SESSION["id"]]);
  }

  $queryLog = $connection -> prepare("INSERT INTO " .PRE_DB. "LOG(action, user, type) VALUES (:action, :user, :type)");
  $queryLog -> execute(["action" => "à modifier un à plusieurs éléments de son profil.", "user" => $_SESSION["id"], "type" => "Modification profil"]);

?>

  <form action="modifyAccount.php" method="POST">

  	<div class="mb-3">
      		<label><input type="radio" name="gender" value="0" <?php if ($form['gender'] == 0) echo "checked='checked'"; ?>>Mr.</label>
      		<label><input type="radio" name="gender" value="1" <?php if ($form['gender'] == 1) echo "checked='checked'"; ?>>Mme.</label>
      		<label><input type="radio" name="gender" value="2" <?php if ($form['gender'] == 2) echo "checked='checked'"; ?>>Autre</label>
  	</div>

  	<div class="mb-3">
  		<label for="firstname" class="form-label">Votre prénom</label>
      	<input type="text" name="firstname" class="form-control" id="firstname" placeholder="<?php echo $form['firstname']; ?>">
  	</div>

  	<div class="mb-3">
  		<label for="lastname" class="form-label">Votre nom</label>
      	<input type="text" name="lastname" class="form-control" id="lastname" placeholder="<?php echo $form['lastname']; ?>">
  	</div>

  	<div class="mb-3">
  		<label for="mail" class="form-label">Votre email</label>
      	<input type="email" name="mail" class="form-control" id="mail" placeholder="<?php echo $form['mail']; ?>">
  	</div>

    <div class="mb-3 new-pwd">
    	<div class="last-pwd">
    		<label for="pwd" class="form-label">Votre ancien mot de passe </label>
        	<input type="password" name="pwd" class="form-control" id="pwd">
    	</div>

      <div class="new-pdw">
    		<label for="altPwd" class="form-label">Votre nouveau mot de passe </label>
        	<input type="password" name="altPwd" class="form-control" id="altPwd">
    	</div>

      <div class="new-pdw-confirm">
    		<label for="altPwdConfirm" class="form-label">Confirmation du nouveau mot de passe </label>
        	<input type="password" name="altPwdConfirm" class="form-control" id="altPwdConfirm">
    	</div>
    </div>

  	<div class="mb-3">
  		<label for="birthday" class="form-label">Date de naissance </label>
      	<input type="date" name="birthday" class="form-control" id="birthday">
  	</div>

    <div class="mb-3">
  		<label for="address" class="form-label">Votre adresse</label>
      	<input type="text" name="address" class="form-control" id="address" placeholder="<?php echo $form['address']; ?>">
  	</div>

  	<div class="mb-3">
  		<label for="complement" class="form-label">Complément d'adresse</label>
      	<input type="text" name="complement" class="form-control" id="complement" placeholder="<?php echo $form['complement']; ?>">
  	</div>

  	<div class="mb-3">
  		<label for="postal" class="form-label">Code Postal</label>
      	<input type="text" name="postal" class="form-control" id="postal" placeholder="<?php echo $form['postal']; ?>">
  	</div>

  	<div class="mb-3">
  		<label for="city" class="form-label">Ville</label>
      	<input type="text" name="city" class="form-control" id="city" placeholder="<?php echo $form['city']; ?>">
  	</div>

    <div class="md-3">
      	<input type="checkbox" name="event" id="event" <?php if ($form['event'] == 1) echo "checked='checked'"; ?>>

  		<label for="event" class="form-label">J'accepte de recevoir un mail à la création d'un nouvel événement</label>
  	</div>

    <div class="md-3">
      	<input type="checkbox" name="shop" id="shop" <?php if ($form['shop'] == 1) echo "checked='checked'"; ?>>

  		<label for="shop" class="form-label">J'accepte de recevoir un mail à l'ajout d'un nouvel élément dans le magasin</label>
  	</div>

    <button type="submit" class="btn btn-primary">Modifier les infos</button>
  </form>

  <a class="btn btn-danger" href="account.php">Retour au profil</a>

<?php include 'templates/footer.php'; ?>
