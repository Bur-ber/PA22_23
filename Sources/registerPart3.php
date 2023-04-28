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
    <li class="page-item active" aria-current="page">
      <span class="page-link">1</span>
    </li>
    <li class="page-item disabled"><a class="page-link" href="#">2</a></li>
    <li class="page-item disabled"><a class="page-link" href="#">3</a></li>
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
		foreach ($piecesPath as $piece):
		?>
		<div class="col-md-4">
        <img src="<?php echo $piece; ?>" alt="Captcha piece">
			</div>
    <?php endforeach; ?>
		</div>
	</div>

	<div class="col-md-4">
		<div class="captcha-destination">
		</div>
	</div>

	<div class="col-md-4">
		<div class="captcha-image">
			<img src="<?php echo $_SESSION['image']; ?>" alt="Captcha image">
		</div>
	</div>
</div>

  <button type="submit" class="btn btn-primary">Terminer l'inscription</button>
</form>

<?php include 'templates/footer.php'; ?>
