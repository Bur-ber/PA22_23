<?php
  session_start();
  require 'core/const.php';
  require 'core/functions.php';
  include 'templates/header.php';
	$statusRequired = 3;

	redirectIfNotConnected($statusRequired);
?>



<div class="container">
<h1>Ajouter du matériel</h1>
<h3>Pour augmenter le stock d'un produit ou modifier son prix, entrez le nom exact de celui-ci</h3>
</div>

<?php
  if(!empty($_POST['image']) && !empty($_POST['name']) && !empty($_POST['brand']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['instock'])){

    cleanByTrimAndUcword($_POST['name']);
    cleanByTrimAndUpper($_POST['brand']);

    if(gettype($_POST['price']) == 'double'){ // SI le prix est un double, on suppose qu'il est en € et on le convertit en centimes
      $price = intval($_POST['price'] * 100);
    }else{
      $price = $_POST['price'];
    }

    $instock = intval($_POST['instock']);

    $connect = connectDB();
		$queryPrepared = $connect->prepare("SELECT id FROM ". PRE_DB ."MATERIAL WHERE name=:name");
		$queryPrepared->execute(["name"=>$_POST['name']]);
    $result = $queryPrepared->fetch();

    if(empty($result)){
      if ($price > 0 || $instock > 0) {
        $imagePath = 'images/material/'.$_POST['name'].'.jpg';
        if(file_put_contents($imagePath, file_get_contents($_POST['image'])) !== false){
          $queryInsertImg = $connect -> prepare("INSERT INTO ". PRE_DB ."IMAGE(name, srcFile, type) VALUES (:name, :srcFile, :type)");
          $queryInsertImg -> execute(["name" => $_POST['name'], "srcFile" => $imagePath, "type" => "material"]);

          $querySelectImgID = $connect->prepare("SELECT id FROM ". PRE_DB ."IMAGE WHERE name=:name");
          $querySelectImgID -> execute(["name" => $_POST['name']]);
          $resultImgID = $querySelectImgID -> fetch();

          $queryInsertMaterial = $connect -> prepare("INSERT INTO ". PRE_DB ."MATERIAL(brand, name, description, image, price, instock) VALUES (:brand, :name, :description, :image, :price, :instock)");
          $queryInsertMaterial -> execute(["brand" => $_POST['brand'], "name" => $_POST['name'], "description" => $_POST['description'], "image" => $resultImgID[0], "price" => $price, "instock" => $instock]);
          header("Location: shop.php");
        } else {
          echo "L'image n'as pas pu être chargée";
        }
      } else {
        echo "Valeur de prix ou de nombre à ajouter incorrect";
      }
    }else{
      // Si l'objet existe déjà, simplement augmenter la valeur instock (et prix)
      if ($price > 0) {
        $queryModify = $connect -> prepare("UPDATE ". PRE_DB ."MATERIAL SET price = :price, instock = instock + :instock WHERE id = :id");
        $queryModify -> execute(["price" => $price, "instock" => $instock, "id" => $result[0]]);
        header("Location: shop.php");
      }else {
        echo "Valeur de prix incorrect";
      }

    }

    // Si la conversion en image a echouer "reload" la page
    // conversion en image via url file_put_contents($img, file_get_contents($url));
  }

 ?>


<form action="newMaterial.php" method="POST">
	<input type="url" name="image" placeholder="URL de l'image" required="required">
	<input type="text" name="name" placeholder="Nom de l'objet" required="required">
	<input type="text" name="brand" placeholder="Marque de l'objet" required="required">
	<input type="text" name="description" placeholder="Description de l'objet" required="required">
	<input type="number" name="price" placeholder="Prix de l'objet en centimes à l'unité" required="required">
	<input type="number" name="instock" placeholder="Nombre d'objet" required="required">

	<button>Ajouter l'objet</button>
</form>






<?php include 'templates/footer.php';?>
