<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
	$statusRequired = 2;

	redirectIfNotConnected($statusRequired);

  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM ". PRE_DB."EVENT");
  $queryPrepared -> execute();
  $result = $queryPrepared -> fetchAll();

  ?>

  <form class="event" action="core/deleteEventBDD.php" method="post">
    <label for="event">Choisissez un évènement à supprimer <span>Attention, cette action est irréversible</span></label>
    <select name="event" id="event-select">
        <option value="">Choisissez un évènement</option>
        <?php foreach ($result as $key => $value):?>
          <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="button">Valider la suppression</button>
  </form>

<?php include 'templates/footer.php'; ?>
