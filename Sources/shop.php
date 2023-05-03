<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
  $connection = connectDB();
  $queryPrepared = $connection -> prepare("SELECT * FROM " .PRE_DB. "MATERIAL");
  $queryPrepared -> execute();
  $result = $queryPrepared -> fetchAll();
?>

<div class="shop">
  <?php
    $result;
    foreach ($result as $row) {
      $queryForRow = $connection -> prepare("SELECT srcFile, name FROM " .PRE_DB. "IMAGE where id=:id");
      $queryForRow -> execute(['id' => $row['id']]);
      $path = $queryForRow -> fetch();
      ?>


      <div class="material">
        <a href="material.php?id=<?php echo $row['id']; ?>">
          <div class="image">
            <img src="<?php echo $path[0]; ?>" alt="<?php echo $path[1]; ?>" max-height="269px" max-width="269px">
          </div>
          <div class="description">
            <h4><?php echo $row['name']; ?></h4>
            <h5><?php echo ($row['price']/100); ?>€/Unité</h5><br>
            <h5>En stock :<?php echo $row['instock']; ?></h5>
          </div>
        </a>
      </div>

    <?php } ?>

    <?php if(isConnected() && $_SESSION['statut'] > 2){ ?>
      <div class="addMaterial">
        <a href="newMaterial.php">
          <span>Ajouter un produit</span>
        </a>
      </div>

    <?php } ?>

</div>



<?php include 'templates/footer.php'; ?>
