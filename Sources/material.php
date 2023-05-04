<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

  if (empty($_GET['id'])) {
    header("Location: shop.php");
  }


  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL WHERE id=:id");
  $queryPrepared -> execute(["id" => $_GET['id']]);
  $result = $queryPrepared -> fetch();

  if (empty($result)) {
    header("Location: shop.php");
  }

  $queryImg = $connection -> prepare("SELECT srcFile, name FROM " .PRE_DB. "IMAGE where id=:id");
  $queryImg -> execute(['id' => $result['id']]);
  $path = $queryImg -> fetch();
?>

<div class="image-material">
  <img src="<?php echo $path[0]; ?>" alt="<?php echo $path[1]; ?>">
</div>

<div class="info-material">
  <h4><?php echo $result['name']; ?></h4>
  <h5><?php echo ($result['price']/100); ?>€/Unité</h5><br>
  <h5>En stock :<?php echo $result['instock']; ?></h5>
</div>

<div class="button-material">
  <input type="number" min="0" max="<?php echo $result['instock']; ?>" name="quantity" value="0">
  <a class="btn btn-danger" href="core/addCart.php?idMaterial=<?php echo $result['id']; ?>&quantity=">Ajouter au panier</a>
  <a class="btn btn-danger" href="buyDirectly.php?idMaterial=<?php echo $result['id']; ?>&quantity=">Acheter directement</a>
</div>

<div class="desc-material">
  <p><?php echo $result['description']; ?></p>
</div>


<?php include 'templates/footer.php'; ?>

<script>
  // Récupérer l'input de quantité
  const quantityInput = document.querySelector('input[name="quantity"]');

  // Récupérer les liens "Ajouter au panier" et "Acheter directement"
  const addCartLink = document.querySelector('a[href^="core/addCart.php"]');
  const buyDirectlyLink = document.querySelector('a[href^="buyDirectly.php"]');

  // Écouter l'événement de clic sur les liens
  addCartLink.addEventListener('click', (event) => {
    // Mettre à jour la valeur de la quantité dans le lien "Ajouter au panier"
    addCartLink.href += quantityInput.value;
  });

  buyDirectlyLink.addEventListener('click', (event) => {
    // Mettre à jour la valeur de la quantité dans le lien "Acheter directement"
    buyDirectlyLink.href += quantityInput.value;
  });
</script>
