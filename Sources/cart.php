<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
  $statusRequired = 1;

  redirectIfNotConnected($statusRequired);

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "CART WHERE user=:id");
  $queryPrepared -> execute(["id" => $_SESSION['id']]);
  $result = $queryPrepared -> fetchAll();

if (!empty($result)) {
  foreach ($result as $key => $material) {
    $queryMaterial = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL WHERE id=:id");
    $queryMaterial -> execute(["id" => $material['id']]);
    $resultMaterial = $queryMaterial -> fetch();

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
      <h5>Quantité demandée :<?php echo $result['quantity']; ?></h5>
      <h5>Total<?php echo ($resultMaterial['price'] * $result['quantity'] / 100); ?>€</h5><br>
    </div>
  </div>




<?php
  }
}else {
  echo "<h2>Votre panier est vide, aller dans le magasin pour le remplir</h2>";
}

include 'templates/footer.php';
