<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
	$statusRequired = 2;

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
?>

<h1>Création d'évènement</h1>

<form class="event" action="core/addEvent.php" method="post">
  <div class="place">
    <label for="place-select" class="form-label">Lieu de déroulement</label>
    <select name="place-select" id="place-select">
        <option value="0">Sur place</option>
        <option value="1">Evènement exterieure</option>
    </select>
    <input id="place" type="text" name="place" class="form-control" placeholder="Lieu de l'évènement" hidden>
  </div>

  <label for="name" class="form-label">Nom de l'évènement</label>
  <input type="text" name="name" class="form-control" placeholder="Nom de l'évènement">

  <label for="desc" class="form-label">Description de l'évènement</label>
  <input type="text" name="desc" class="form-control" placeholder="Description de l'évènement">

  <div class="nbr_space">
    <label for="nbr_space-select" class="form-label">Nombre de participant</label>
    <select name="nbr_space-select" id="nbr_space-select">
        <option value="0">Illimité</option>
        <option value="1">Limité</option>
    </select>
    <input id="nbr_space" type="number" name="nbr_space" class="form-control" hidden>
  </div>

  <div class="price">
    <label for="price-select" class="form-label">Prix de l'évènement</label>
    <select name="price-select" id="price-select">
        <option value="0">Gratuit</option>
        <option value="1">Payant</option>
    </select>
    <input id="price" type="number" name="price" class="form-control" hidden>
  </div>

  <label for="on_register-select" class="form-label">Sur inscription</label>
  <select name="on_register-select" id="on_register-select">
      <option value="0">Non</option>
      <option value="1">Oui</option>
  </select><br>

  <div id="register" hidden>
    <label for="register" class="form-label">Date de début des inscription</label>
    <input type="date" name="register" class="form-control">
  </div>

  <label for="start" class="form-label">Date de début de l'évènement</label>
  <input type="date" name="start" class="form-control">

  <label for="end" class="form-label">Date de fin de l'évènement</label>
  <input type="date" name="end" class="form-control">

  <button type="submit" name="button">Ajouter l'évènement</button>
</form>


<?php include "templates/footer.php"; ?>

<script>
  const placeSelect = document.getElementById('place-select');
  const placeInput = document.getElementById('place');
  placeInput.value = "Sur place, en salle de Livry-Gargan";
  const nbr_spaceSelect = document.getElementById('nbr_space-select');
  const nbr_spaceInput = document.getElementById('nbr_space');
  nbr_spaceInput.value = 0;
  const priceSelect = document.getElementById('price-select');
  const priceInput = document.getElementById('price');
  priceInput.value = 0;
  const on_registerSelect = document.getElementById('on_register-select');
  const registerInput = document.getElementById("register");

  placeSelect.addEventListener('change', (event) => {
    const placeValue = event.target.value;

    if (placeValue == 0) {
      placeInput.setAttribute('hidden', '');
      placeInput.value = "Sur place, en salle de Livry-Gargan";
    }else {
      placeInput.removeAttribute('hidden');
      placeInput.value = "";
    }
  });

  nbr_spaceSelect.addEventListener('change', (event) => {
    const nbr_spaceValue = event.target.value;

    if (nbr_spaceValue == 0) {
      nbr_spaceInput.setAttribute('hidden', '');
      nbr_spaceInput.value = 0;
    }else {
      nbr_spaceInput.removeAttribute('hidden');
    }
  });

  priceSelect.addEventListener('change', (event) => {
    const priceValue = event.target.value;

    if (priceValue == 0) {
      priceInput.setAttribute('hidden', '');
      priceInput.value = 0;
    }else {
      priceInput.removeAttribute('hidden');
    }
  });

  on_registerSelect.addEventListener('change', (event) => {
    const registerValue = event.target.value;

    if (registerValue == 0) {
      registerInput.setAttribute('hidden', '');
    }else {
      registerInput.removeAttribute('hidden');
    }
  });
</script>
