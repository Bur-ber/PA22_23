<?php
	session_start();
	require 'core/const.php';
	require 'core/functions.php';
  include 'templates/header.php'; ?>

	<?php
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

  <nav aria-label="...">
  <ul class="pagination pagination-lg">
    <li class="page-item"><a class="page-link" href="register.php">1</a></li>
    <li class="page-item active" aria-current="page">
      <span class="page-link">2</span>
    </li>
    <li class="page-item disabled"><a class="page-link" href="#">3</a></li>
  </ul>
</nav>

<form action="core/addUserPart2.php" method="POST">

  <div class="mb-3">
		<label for="address" class="form-label">Votre adresse</label>
    	<input type="text" name="address" class="form-control" id="address" placeholder="Adresse">
	</div>

	<div class="mb-3">
		<label for="complement" class="form-label">Complément d'adresse</label>
    	<input type="text" name="complement" class="form-control" id="complement" placeholder="Apt, suite, unité, nom de l'entreprise (facultatif)">
	</div>

	<div class="mb-3">
		<label for="postal" class="form-label">Code Postal</label>
    	<input type="text" name="postal" class="form-control" id="postal">
	</div>

	<div class="mb-3">
		<label for="city" class="form-label">Ville</label>
    	<input type="text" name="city" class="form-control" id="city">
	</div>

  <button type="submit" class="btn btn-primary">Page suivante</button>
</form>

<?php include 'templates/footer.php'; ?>
