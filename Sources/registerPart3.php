<?php
	session_start();
	require 'core/const.php';
	require 'core/functions.php';
  include 'templates/header.php'; ?>

<?php
if( isset($_SESSION['image'])) {
	$image = $_SESSION['image'];
  $pieces = unserialize($_SESSION['pieces']);
}
 ?>

 <nav aria-label="...">
  <ul class="pagination pagination-lg">
    <li class="page-item"><a class="page-link" href="register.php">1</a></li>
    <li class="page-item"><a class="page-link" href="registerPart2.php">2</a></li>
    <li class="page-item active">
			<span class="page-link">3</span>
		</li>
  </ul>
</nav>

<form action="core/addUserPart3.php" method="POST">

<div class="row justify-content-center">

  <div class="md-3">
    	<input type="checkbox" name="event" id="event">

		<label for="event" class="form-label">J'accepte de recevoir un mail à la création d'un nouvel événement</label>
	</div>

  <div class="md-3">
    	<input type="checkbox" name="shop" id="shop">

		<label for="shop" class="form-label">J'accepte de recevoir un mail à l'ajout d'un nouvel élément dans le magasin</label>
	</div>

  <div class="md-3">
    	<input type="checkbox" name="cgu" id="cgu">

		<label for="cgu" class="form-label">J'accepte les CGUs </label>
	</div>

  <div class="col-md-4">
		<div class="row captcha-piece">
    <?php
		$piecesPath = glob('images/forCaptcha/captchaPieces/*.jpg');
		foreach ($piecesPath as $index => $piece):
		?>
		<div class="col-md-4">
        <img src="<?php echo $piece; ?>" data-index="<?php echo $index; ?>" alt="Captcha piece">
			</div>
    <?php endforeach; ?>
		</div>
	</div>

	<div class="col-md-4">
		<div class="row captcha-destination">
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
		</div>
  	<input type="hidden" name="images_list" value="">
	</div>

	<div class="col-md-4">
		<div class="captcha-image">
			<img src="<?php echo $_SESSION['image']; ?>" alt="Captcha image">
		</div>
	</div>
</div>

  <button type="submit" class="btn btn-primary">Terminer l'inscription</button>
</form>
<script type="text/javascript" src="core/captcha.js">
	const imagesListInput = document.querySelector('input[name="images_list"]');

  // Stockage de l'objet JSONifié dans l'input caché
  imagesListInput.value = JSON.stringify(imagesList);
</script>
<?php include 'templates/footer.php'; ?>
