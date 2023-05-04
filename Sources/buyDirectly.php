<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

  if (empty($_GET['idMaterial']) || empty($_GET['quantity'])) {
    header("Location: shop.php");
  } else if(empty($_SESSION['id'])){
    header("Location: login.php");
  } elseif ($_GET['quantity'] <= 0) {
    header("Location: material.php?id=" . $_GET['idMaterial']);
  }

  // Vérifier que quantity est bien inférieur ou égal à instock sinon faille xss ;-;
  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL WHERE id=:id");
  $queryPrepared -> execute(["id" => $_GET['idMaterial']]);
  $result = $queryPrepared -> fetch();

  if ($_GET['quantity'] > $result['instock']) {
    header("Location: material.php?id=" . $_GET['idMaterial']);
  }

  // Afficher l'image, la quantité, le prix à l'unité
  $queryImg = $connection -> prepare("SELECT srcFile, name FROM " .PRE_DB. "IMAGE where id=:id");
  $queryImg -> execute(['id' => $result['id']]);
  $path = $queryImg -> fetch();
?>

  <div class="recap">
    <img src="<?php echo $path[0]; ?>" alt="<?php echo $path[1]; ?>"><br>
    <span>Quantité : <?php echo $_GET['quantity']; ?></span><br>
    <span><?php echo $result['price'] / 100; ?> €/Unité</span>
  </div>

<?php
  // Afficher le prix * la quantité et le bouton payer
  echo "Prix final : " . ($result['price'] * $_GET['quantity']) / 100 . "€";
  $_SESSION['listID'] = serialize($_GET['idMaterial']);
  $_SESSION['listQuantity'] = serialize($_GET['quantity']);

  ?>
  <a class="btn btn-danger" href="core/paiement.php">Payer</a>


<?php include 'templates/footer.php'; ?>
