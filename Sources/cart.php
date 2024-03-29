<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
  $statusRequired = 1;

  redirectIfNotConnected($statusRequired);
  addToLogVisit("Panier");

  if( isset($_SESSION['error'])) {
		$error = $_SESSION['error'];
		echo '<div class="alert alert-danger" role="alert">';
				echo $error;
		echo "</div>";
		unset($_SESSION['error']);
	}

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "CART WHERE user=:id");
  $queryPrepared -> execute(["id" => $_SESSION['id']]);
  $result = $queryPrepared -> fetchAll();

if (!empty($result)) {
  $listID = [];
  $listQuantity = [];
  foreach ($result as $key => $material) {
    $queryMaterial = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL WHERE id=:id");
    $queryMaterial -> execute(["id" => $material['material']]);
    $resultMaterial = $queryMaterial -> fetch();
    $listID[] = $material['material'];
    $listQuantity[] = $material['quantity'];

    $queryImg = $connection -> prepare("SELECT srcFile, name FROM " .PRE_DB. "IMAGE where id=:id");
    $queryImg -> execute(['id' => $resultMaterial['image']]);
    $path = $queryImg -> fetch();
?>

  <div class="row-material">
    <div class="image-material">
      <img src="<?php echo $path[0]; ?>" alt="<?php echo $path[1]; ?>">
    </div>

    <div class="info-material">
      <h4><?php echo $resultMaterial['name']; ?></h4>
      <h5>Quantité demandée :<?php echo $material['quantity']; ?></h5>
      <h5>Total <?php echo ($resultMaterial['price'] * $material['quantity'] / 100); ?>€</h5><br>
    </div>
  </div>


<?php

  }
  $_SESSION['listID'] = serialize($listID);
  $_SESSION['listQuantity'] = serialize($listQuantity);
  echo '<a href="core/paiement.php">Acheter</a>';
}else {
  echo "<h2>Votre panier est vide, aller dans le magasin pour le remplir</h2>";
}

include 'templates/footer.php';

?>
