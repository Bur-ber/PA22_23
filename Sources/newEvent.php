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

  <label for="desc" class="form-label">Description de l'évènement</label>
  <input type="text" name="desc" class="form-control" placeholder="Description de l'évènement">

  <label for="register" class="form-label">Date de début des inscription</label>
  <input type="date" name="register" class="form-control">

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

  placeSelect.addEventListener('change', (event) => {
    const placeValue = event.target.value;

    if (placeValue == 0) {
      placeInput.setAttribute('hidden', '');
      placeInput.value = "Sur place, en salle de Livry-Gargan";
    }else {
      placeInput.removeAttribute('hidden');
    }
  });
</script>
