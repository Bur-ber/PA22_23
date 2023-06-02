<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
	$statusRequired = 3;

	redirectIfNotConnected($statusRequired);

  if( isset($_SESSION['errors'])) {
		$listOfErrors = unserialize($_SESSION['errors']);
		echo '<div class="alert alert-danger" role="alert">';
		foreach( $listOfErrors as $error){
				echo "<li>".$error;
		}
		echo "</div>";
		unset($_SESSION['errors']);
	}

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB ."MATERIAL");
  $queryPrepared -> execute();
  $result = $queryPrepared -> fetchAll();
  $queryImg = $connection -> prepare("SELECT id, srcFile FROM ". PRE_DB ."IMAGE");
  $queryImg-> execute();
  $resultImg = $queryImg -> fetchAll();

?>



<select name="object" id="object-select">
    <option value="">Choisissez un objet</option>
    <?php foreach ($result as $key => $value):
      foreach ($resultImg as $keyImg => $valueImg) {
        if($value['image'] == $valueImg['id']){
          $result[$key]['image'] = $valueImg['srcFile'];
        }
      }?>
      <option value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
    <?php endforeach; ?>
</select>

<form id="object" action="core/modifyMaterialBDD.php" method="POST">

		<label for="name" class="form-label">Nom de l'objet</label>
    <input type="text" name="name" class="form-control" placeholder="Remplir pour changer le nom">
    <p id="name"></p>

		<label for="brand" class="form-label">Nom de la marque</label>
    <input type="text" name="brand" class="form-control" placeholder="Remplir pour changer la marque">
    <p id="brand"></p>

		<label for="desc" class="form-label">Description de l'objet</label>
    <input type="text" name="desc" class="form-control" placeholder="Remplir pour changer la description">
    <p id="desc"></p>

		<label for="img" class="form-label">Image de l'objet</label>
    <input type="url" name="img" class="form-control" placeholder="Remplir pour changer l'image (Insérez une URL)">
    <p>Image actuel : <img src="" id="img"></p>

		<label for="price" class="form-label">Prix de l'objet <span>Avertissement : Le prix doit impérativement être en centimes (multiplié le prix en euro par 100)</span></label>
    <input type="number" name="price" class="form-control" placeholder="Remplir pour changer le prix">
    <p id="price"></p>

		<label for="instock" class="form-label">Nombre en stock de l'objet <span>Avertissement : Changer le nombre changera directement le nombre en stock, ça n'est pas un retrait ou un ajout au nombre actuel</span></label>
    <input type="number" name="instock" class="form-control" placeholder="Remplir pour changer le nombre en stock">
    <p id="instock"></p>

    <input type="number" name="key" value="" id="key" hidden>

    <button type="submit" name="button">Valider les informations</button>
</form>

<?php
  $_SESSION['material'] = serialize($result);
  include 'templates/footer.php';
?>

<script>
  var objectTab = <?php echo json_encode($result);?>;
  const objectSelect = document.getElementById('object-select');
  const objectName = document.getElementById('name');
  const objectBrand = document.getElementById('brand');
  const objectDesc = document.getElementById('desc');
  const objectImg = document.getElementById('img');
  const objectPrice = document.getElementById('price');
  const objectInstock = document.getElementById('instock');
  const objectKey = document.getElementById('key');


  // Écouter l'événement de changement sur le menu déroulant
  objectSelect.addEventListener('change', (event) => {
    const objectKey = event.target.value;
    objectName.textContent = "Nom actuel : " + objectTab[objectKey]['name'];
    objectBrand.textContent = "Marque actuel : " + objectTab[objectKey]['brand'];
    objectDesc.textContent = "Description actuel : " + objectTab[objectKey]['description'];
    objectImg.src = objectTab[objectKey]['image'];
    objectPrice.textContent = "Prix actuel : " + objectTab[objectKey]['price'] / 100 + "€/Unité";
    objectInstock.textContent = "Stock actuel : " + objectTab[objectKey]['instock'];
    objectKey.value = objectKey;

  });
</script>
