<?php
	session_start();
	require 'core/const.php';
	require 'core/functions.php';
  include 'templates/header.php';
  date_default_timezone_set('Europe/Paris');

  $statusRequired = 1;
  redirectIfNotConnected($statusRequired);

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "USER WHERE id=:id");
  $queryPrepared -> execute(["id" => $_SESSION["id"]]);
  $result = $queryPrepared -> fetch();
?>

<div class="profile-picture">

</div>

<div class="data">
  <div class="gender">
    Genre :
    <?php if($result['gender'] == 0){
      echo "Monsieur.";
    }elseif($result['gender'] == 1){
      echo "Madame.";
    }else {
      echo "Autre.";
    } ?>
  </div>
  <div class="firstname">
    Prénom :
    <?php echo $result['firstname']; ?>
  </div>
  <div class="lastname">
    Nom :
    <?php echo $result['lastname']; ?>
  </div>
  <div class="birthday">
    Date d'anniversaire :
    <?php echo date("d/m/Y", strtotime($result['birthday'])); ?>
  </div>
  <div class="mail">
    E-mail :
    <?php echo $result['mail']; ?>
  </div>
  <div class="address">
    Adresse :
    <?php echo $result['address']; ?>
  </div>
  <?php if($result['complement'] != null){ ?>
    <div class="complement">
      Complément d'adresse :
      <?php echo $result['complement']; ?>
    </div>
  <?php } ?>
  <div class="postal">
    Code Postal :
    <?php echo $result['postal']; ?>
  </div>
  <div class="city">
    Ville :
    <?php echo $result['city']; ?>
  </div>
  <div class="mail-verified">
    Email vérifié :
    <?php if ($result['verified_mail']) {
    	echo "Oui";
    }else {
    	echo 'Non <br>
			<a href="core/sendVerifMail.php">Envoyer un mail de vérification</a>';
    }?>
  </div>
  <div class="event">
    Alerte mail lors d'un nouvel événement :
    <?php if($result['event'] == 0){
      echo "Désactivée.";
    }else {
      echo "Activée.";
    } ?>
  </div>
  <div class="shop">
    Alerte mail lors d'un nouvel objet dans le magasin :
    <?php if($result['shop'] == 0){
      echo "Désactivée.";
    }else {
      echo "Activée.";
    } ?>
  </div>
</div>

<div class="other">
  <div class="last-connection">
    Date de dernière connexion :
    <?php if ($result['last_connection'] != null) {
    	echo date("d/m/Y \a G:i", strtotime($result['last_connection']));
    } ?>
  </div>
  <div class="last-modif">
    Date de dernière modification :
    <?php if ($result['updated_at'] != null) {
    	echo date("d/m/Y \a G:i", strtotime($result['updated_at']));
    } ?>
  </div>
  <div class="created-at">
    Date de création :
    <?php if ($result['created_at'] != null) {
    	echo date("d/m/Y", strtotime($result['created_at']));
    } ?>
  </div>
</div>

<div class="modify-button">
  <a href="modifyAccount.php">Modifier mon profil</a>
</div>

<div class="export-button">
  <a href="core\ProfileToPDF.php">Exporter mes informations</a>
</div>


<?php include 'templates/footer.php'; ?>
