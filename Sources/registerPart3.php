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
    <li class="page-item active" aria-current="page">
      <span class="page-link">1</span>
    </li>
    <li class="page-item disabled"><a class="page-link" href="#">2</a></li>
    <li class="page-item disabled"><a class="page-link" href="#">3</a></li>
  </ul>
</nav>

<form action="core/addUserPart3.php" method="POST">

  <div class="mb-3">
    	<input type="checkbox" name="event" id="event">

		<label for="event" class="form-label">J'accepte de recevoir un mail à la création d'un nouvel événement</label>
	</div>

  <div class="mb-3">
    	<input type="checkbox" name="shop" id="shop">

		<label for="shop" class="form-label">J'accepte de recevoir un mail à l'ajout d'un nouvel élément dans le magasin</label>
	</div>

  <div class="mb-3">
    	<input type="checkbox" name="cgu" id="cgu">

		<label for="cgu" class="form-label">J'accepte les CGUs </label>
	</div>

  <div class="mb-3">
		<img src="captcha.php">
		<input type="text" name="captcha" required="required" placeholder="captcha">
	</div>

  <button type="submit" class="btn btn-primary">Page Suivante</button>
</form>

<?php include 'templates/footer.php'; ?>
