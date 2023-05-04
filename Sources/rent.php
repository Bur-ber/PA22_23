<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';

  if (empty($_GET['idMaterial']) || empty($_GET['quantity'])) {
    header("Location: shop.php");
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
    <span><?php echo ($result['price'] / 100) / 25; ?> €/Unité/Semaine</span>
  </div>

  <label for="week-select">Nombre de semaine de location :</label>

<select name="week" id="week-select">
    <option value="">Choisissez une valeur</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5 et +</option>
</select>

<h5 class="price-final"></h5>

<?php
  // Afficher le prix * la quantité et le bouton payer
  $_SESSION['listID'] = serialize($_GET['idMaterial']);
  $_SESSION['listQuantity'] = serialize($_GET['quantity']);

  ?>
  <a class="btn btn-danger" href="core/rentBDD.php?week=">Payer</a>


<?php include 'templates/footer.php'; ?>

<script>
  // Récupérer le menu déroulant et le prix final
  const weekSelect = document.getElementById('week-select');
  const priceFinal = document.querySelector('.price-final');
  const rentLink = document.querySelector('a[href^="core/rentBDD.php"]');

  // Écouter l'événement de changement sur le menu déroulant
  weekSelect.addEventListener('change', (event) => {
    // Mettre à jour le prix final avec la nouvelle valeur de la semaine
    const weekValue = event.target.value;
    const newPrice = ((<?php echo $result['price']; ?> * <?php echo $_GET['quantity']; ?> * weekValue) / 100) / 25;
    priceFinal.textContent = "Prix final : " + newPrice + "€/Semaine";

    rentLink.addEventListener('click', (event) => {
      // Mettre à jour la valeur de la quantité dans le lien "Louer directement"
      rentLink.href += weekValue;
    });
  });
</script>
