<?php
	session_start();
	require 'core/const.php';
	require 'core/functions.php';
  	include 'templates/header.php'; 
  	addToLogVisit("Inscription pt.1");
  ?>
  

  <div class="container">
<h1>S'inscrire</h1>

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

<form action="core/addUserPart1.php" method="POST">

	<div class="mb-3">
    		<label><input type="radio" name="gender" value="0" checked="checked">Mr.</label>
    		<label><input type="radio" name="gender" value="1">Mme.</label>
    		<label><input type="radio" name="gender" value="2">Autre</label>
	</div>


	<div class="mb-3">
		<label for="firstname" class="form-label">Votre prénom</label>
    	<input type="text" name="firstname" class="form-control" id="firstname" placeholder="John">
	</div>

	<div class="mb-3">
		<label for="lastname" class="form-label">Votre nom</label>
    	<input type="text" name="lastname" class="form-control" id="lastname" placeholder="Doe">
	</div>

	<div class="mb-3">
		<label for="mail" class="form-label">Votre email</label>
    	<input type="email" name="mail" class="form-control" id="mail">
	</div>

	<div class="mb-3">
		<label for="pwd" class="form-label">Votre mot de passe </label>
    	<input type="password" name="pwd" class="form-control" id="pwd">
	</div>

	<div class="mb-3">
		<label for="pwdConfirm" class="form-label">Confirmation </label>
    	<input type="password" name="pwdConfirm" class="form-control" id="pwdConfirm">
	</div>

	<div class="mb-3">
		<label for="birthday" class="form-label">Date de naissance </label>
    	<input type="date" name="birthday" class="form-control" id="birthday">
	</div>

  <button type="submit" class="btn btn-primary">Page Suivante</button>
</form>


<?php include 'templates/footer.php'; ?>
